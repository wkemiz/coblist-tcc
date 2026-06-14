<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório COBLIST</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            color: #4a148c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #c5cae9;
            color: white;
            border: 1px solid #ddd;
            padding: 8px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .totais {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>COBLIST - Relatório de Clientes</h1>

    <table>
        <thead>
            <tr>
                <th>CPF</th>
                <th>Nome</th>
                <th>Valor</th>
                <th>H.O</th>
                <th>Credor</th>
                <th>Colchão</th>
            </tr>
        </thead>

        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->cpf }}</td>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->valor }}</td>
                <td>{{ $cliente->ho }}</td>
                <td>{{ $cliente->credor }}</td>
                <td>{{ $cliente->colchao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totais">
        <p>Total Valor Bruto: {{ number_format($total_valor, 2, ',', '.') }}</p>
        <p>Total H.O: {{ number_format($total_ho, 2, ',', '.') }}</p>
    </div>

</body>
</html>