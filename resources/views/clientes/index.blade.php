<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pagamentos</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: #e8f0fe;
        }

        h1 { 
            text-align: center; 
            color: #4a148c; /* ROXO */
            font-weight: 600; 
            letter-spacing: 1px; 
            margin-top: 20px;
        }

        .header-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .header-logo img {
            height: 95px; 
            width: auto;
        }

        .container { 
            width: 100%; 
            padding: 20px 40px; 
            box-sizing: border-box;
        }

        table { 
            border-collapse: separate; 
            border-spacing: 0; 
            width: 100%; 
            margin-top: 20px; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }

        th, td { 
            padding: 10px; 
            text-align: left; 
            border-bottom: 1px solid rgba(0,0,0,0.1); 
            font-size: 14px;
        }

        th { 
            background-color: #c5cae9; 
            color: #fff; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }

        tr:nth-child(even){ 
            background-color: #f0f0f0; 
        }

        td { 
            color: #333; 
            background-color: #f9f9f9; 
            border-radius: 5px; 
        }

        a.button, button.button {
            text-decoration: none;
            padding: 6px 12px;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.2s;
        }

        a.button:hover, button.button:hover { opacity: 0.85; }

        .edit { background-color: #2196f3; }
        .delete { background-color: #f44336; }
        .colchao-btn { background-color: #9fa8da; }

        form { display: inline; }

        .totals { 
            text-align: right; 
            margin-top: 15px; 
            font-weight: 600;
            color: #333;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .filters {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filters select {
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    
    <div class="header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <h1>Lista de Pagamentos</h1>

    <div class="container">

        <div class="top-actions">
            <div>
                <a href="{{ route('clientes.create') }}" class="button edit">Novo Cliente</a>
                <a href="{{ route('clientes.colchao') }}" class="button colchao-btn">Acordos Mensais</a>
                <a href="{{ route('clientes.pdf', [
    'credor' => request('credor'),
    'colchao' => request('colchao')
]) }}"
class="button"
style="background-color:#7e57c2;">
    Exportar PDF
</a>
            </div>

            <div class="filters">
                <form method="GET" action="{{ route('clientes.index') }}">
                    <label for="credor">Filtrar por Credor:</label>
                    <select name="credor" id="credor" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="COBMAIS" {{ isset($credorFiltro) && $credorFiltro=='COBMAIS' ? 'selected' : '' }}>COBMAIS</option>
                        <option value="BONUSCRED" {{ isset($credorFiltro) && $credorFiltro=='BONUSCRED' ? 'selected' : '' }}>BONUSCRED</option>
                    </select>
                </form>

                <form method="GET" action="{{ route('clientes.index') }}">
                    <label for="colchao">Filtrar por Colchão:</label>
                    <select name="colchao" id="colchao" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="sim" {{ isset($colchaoFiltro) && $colchaoFiltro=='sim' ? 'selected' : '' }}>Sim</option>
                        <option value="nao" {{ isset($colchaoFiltro) && $colchaoFiltro=='nao' ? 'selected' : '' }}>Não</option>
                    </select>
                </form>

                <a href="{{ route('login') }}" class="button delete">Sair</a>
            </div>
        </div>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Fase (%)</th>
                    <th>H.O</th>
                    <th>Credor</th>
                    <th>Colchão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->cpf }}</td>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->data }}</td>
                        <td>{{ number_format((float)str_replace(',', '.', $cliente->valor), 2, ',', '.') }}</td>
                        <td>{{ number_format((float)$cliente->fase, 2, ',', '.') }}%</td>
                        <td>{{ number_format((float)str_replace(',', '.', $cliente->ho), 2, ',', '.') }}</td>
                        <td>{{ $cliente->credor }}</td>
                        <td>{{ $cliente->colchao }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="button edit">Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button delete" onclick="return confirm('Deseja realmente excluir?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p>Total Valor Bruto: {{ number_format($total_valor, 2, ',', '.') }}</p>
            <p>Total H.O: {{ number_format($total_ho, 2, ',', '.') }}</p>
            @if(!isset($credorFiltro) && !isset($colchaoFiltro))
                <p>Meta HO Restante: {{ number_format($meta_ho_restante, 2, ',', '.') }}</p>
            @endif
        </div>

    </div>

</body>
</html>