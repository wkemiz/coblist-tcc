<!DOCTYPE html>
<html>
<head>
    <title>Colchão - Acordos Mensais</title>

    <style>
        /* ✔ PADRÃO DO SISTEMA */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: #e8f0fe;
        }

        /* ✔ FAIXA SUPERIOR */
        .header-bar {
            background-color: #c5cae9;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            position: relative;
        }

        .header-bar img {
            height: 35px;
            width: auto;
        }

        .header-bar h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            font-size: 20px;
            color: #4a148c;
            font-weight: 700;
            letter-spacing: 1px;
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
        }

        .edit { background-color: #2196f3; }
        .delete { background-color: #f44336; }

        form { display: inline; }

        .totals { 
            text-align: right; 
            margin-top: 15px; 
            font-weight: 600;
            color: #333;
        }

        /* ✔ TOP BAR FILTROS */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .top-bar form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar label {
            font-size: 14px;
            color: #333;
        }

        .top-bar select {
            padding: 5px 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>

<!-- ✔ FAIXA NOVA -->
<div class="header-bar">
    <img src="{{ asset('images/logo.png') }}" alt="Logo">
    <h1>Colchão - Acordos Mensais</h1>
</div>

<div class="container">

    <!-- ✔ FILTROS -->
    <div class="top-bar">

        <a href="{{ route('clientes.index') }}" class="button edit">
            Voltar para Pagamentos
        </a>

        <form method="GET" action="{{ route('clientes.colchao') }}">

            <label>Credor:</label>
            <select name="credor" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="COBMAIS" {{ request('credor')=='COBMAIS' ? 'selected' : '' }}>COBMAIS</option>
                <option value="BONUSCRED" {{ request('credor')=='BONUSCRED' ? 'selected' : '' }}>BONUSCRED</option>
            </select>

            <label>Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="emdia" {{ request('status')=='emdia' ? 'selected' : '' }}>Em dia</option>
                <option value="vencidos" {{ request('status')=='vencidos' ? 'selected' : '' }}>Vencidos</option>
            </select>

        </form>

    </div>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Valor Bruto</th>
                <th>H.O</th>
                <th>Fase (%)</th>
                <th>Credor</th>
                <th>Próximo Pagamento</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        @foreach($clientes as $cliente)

            @php
                $proximo = \Carbon\Carbon::parse($cliente->data)->addDays(30);
            @endphp

            <tr style="{{ $proximo->isPast() ? 'background-color:#ffd6d6;' : '' }}">

                <td>{{ $cliente->nome }}</td>
                <td>{{ number_format((float)str_replace(',', '.', $cliente->valor), 2, ',', '.') }}</td>
                <td>{{ number_format((float)str_replace(',', '.', $cliente->ho), 2, ',', '.') }}</td>
                <td>{{ number_format((float)$cliente->fase, 2, ',', '.') }}%</td>
                <td>{{ $cliente->credor }}</td>
                <td>{{ $proximo->format('d/m/Y') }}</td>
                <td>{{ $proximo->isPast() ? 'Vencidos' : 'Em dia' }}</td>

                <td>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="button edit">Editar</a>

                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button delete" onclick="return confirm('Deseja realmente excluir?')">
                            Excluir
                        </button>
                    </form>
                </td>

            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Total Valor Bruto: {{ number_format($total_valor, 2, ',', '.') }}</p>
        <p>Total H.O: {{ number_format($total_ho, 2, ',', '.') }}</p>

        @if(!request('credor'))
            <p>Meta HO Restante: {{ number_format($meta_ho_restante, 2, ',', '.') }}</p>
        @endif
    </div>

</div>

</body>
</html>