<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Lista todos os clientes
    public function index(Request $request)
    {
        $credorFiltro = $request->query('credor');
        $colchaoFiltro = $request->query('colchao');

        $query = Cliente::query();

        if ($credorFiltro && in_array($credorFiltro, ['COBMAIS', 'BONUSCRED'])) {
            $query->where('credor', $credorFiltro);
        }

        if ($colchaoFiltro && in_array($colchaoFiltro, ['sim', 'nao'])) {
            $query->where('colchao', $colchaoFiltro);
        }

        $clientes = $query->get();

        $total_valor = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->valor);
        });

        $total_ho = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->ho);
        });

        $meta_ho_restante = (!$credorFiltro && !$colchaoFiltro) ? 9750 - $total_ho : null;

        foreach ($clientes as $c) {
            $c->fase_formatada = number_format((float) $c->fase, 2, ',', '.') . '%';
        }

        return view('clientes.index', compact(
            'clientes',
            'total_valor',
            'total_ho',
            'meta_ho_restante',
            'credorFiltro',
            'colchaoFiltro'
        ));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'valor' => $request->valor ? str_replace(',', '.', $request->valor) : null,
            'ho' => $request->ho ? str_replace(',', '.', $request->ho) : null,
        ]);

        $data = $request->validate([
            'cpf' => 'required|string|unique:clientes,cpf',
            'nome' => 'required|string',
            'data' => 'nullable|date',
            'valor' => 'required|numeric',
            'fase' => 'required|numeric',
            'ho' => 'nullable|numeric',
            'credor' => 'required|string',
            'colchao' => 'required|string',
        ]);

        if (in_array($data['fase'], [15, 20])) {
            $data['ho'] = round($data['valor'] * $data['fase'] / 100, 2);
        }

        Cliente::create($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->merge([
            'valor' => $request->valor ? str_replace(',', '.', $request->valor) : null,
            'ho' => $request->ho ? str_replace(',', '.', $request->ho) : null,
        ]);

        $data = $request->validate([
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'nome' => 'required|string',
            'data' => 'nullable|date',
            'valor' => 'required|numeric',
            'fase' => 'required|numeric',
            'ho' => 'nullable|numeric',
            'credor' => 'required|string',
            'colchao' => 'required|string',
        ]);

        if (in_array($data['fase'], [15, 20])) {
            $data['ho'] = round($data['valor'] * $data['fase'] / 100, 2);
        }

        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function colchao(Request $request)
    {
        $credorFiltro = $request->query('credor');
        $statusFiltro = $request->query('status');

        $query = Cliente::where('colchao', 'sim');

        if ($credorFiltro && in_array($credorFiltro, ['COBMAIS', 'BONUSCRED'])) {
            $query->where('credor', $credorFiltro);
        }

        $clientes = $query->get();

        foreach ($clientes as $c) {
            $proximo = strtotime($c->data . ' +30 days');

            $c->proximo_vencimento = date('d/m/Y', $proximo);

            $c->status_calculado = ($proximo < strtotime(date('Y-m-d')))
                ? 'vencidos'
                : 'emdia';

            $c->status_label = ($proximo < strtotime(date('Y-m-d')))
                ? 'Vencidos'
                : 'Em dia';

            $c->fase_formatada = number_format((float) $c->fase, 2, ',', '.') . '%';
        }

        if ($statusFiltro) {
            $clientes = $clientes->filter(function ($c) use ($statusFiltro) {
                return $c->status_calculado === $statusFiltro;
            })->values();
        }

        $total_valor = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->valor);
        });

        $total_ho = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->ho);
        });

        $meta_ho_restante = (!$credorFiltro) ? 9750 - $total_ho : null;

        return view('colchao.index', compact(
            'clientes',
            'total_valor',
            'total_ho',
            'meta_ho_restante',
            'credorFiltro',
            'statusFiltro'
        ));
    }
    public function exportarPdf(Request $request)
{
    $credorFiltro = $request->query('credor');
    $colchaoFiltro = $request->query('colchao');

    $query = Cliente::query();

    if ($credorFiltro && in_array($credorFiltro, ['COBMAIS', 'BONUSCRED'])) {
        $query->where('credor', $credorFiltro);
    }

    if ($colchaoFiltro && in_array($colchaoFiltro, ['sim', 'nao'])) {
        $query->where('colchao', $colchaoFiltro);
    }

    $clientes = $query->get();

    $total_valor = $clientes->sum(function ($c) {
        return (float) str_replace(',', '.', $c->valor);
    });

    $total_ho = $clientes->sum(function ($c) {
        return (float) str_replace(',', '.', $c->ho);
    });

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'relatorios.pdf',
        compact(
            'clientes',
            'total_valor',
            'total_ho'
        )
    );

    return $pdf->download('relatorio-clientes.pdf');
}
}
