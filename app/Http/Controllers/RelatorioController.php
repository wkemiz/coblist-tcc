<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function pdf()
    {
        $clientes = Cliente::all();

        $total_valor = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->valor);
        });

        $total_ho = $clientes->sum(function ($c) {
            return (float) str_replace(',', '.', $c->ho);
        });

        $pdf = Pdf::loadView('relatorios.pdf', compact(
            'clientes',
            'total_valor',
            'total_ho'
        ));

        return $pdf->download('relatorio-coblist.pdf');
    }
}