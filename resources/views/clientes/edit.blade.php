<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente - COBLIST</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* FAIXA SUPERIOR (igual novo cliente) */
        .navbar {
            background: #c5cae9;
            color: #4a148c;
            padding: 12px 20px;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar img {
            height: 30px;
        }

        /* BOTÃO VOLTAR PEQUENO */
        .back-small {
            position: absolute;
            top: 70px;
            left: 20px;
            background: #2196F3;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }

        .container {
            max-width: 450px;
            margin: 80px auto;
            padding: 25px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <!-- FAIXA SUPERIOR -->
    <div class="navbar">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        COBLIST
    </div>

    <!-- BOTÃO VOLTAR -->
    <a href="{{ route('clientes.index') }}" class="back-small">← Voltar</a>

    <div class="container">
        <h1>Editar Cliente</h1>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nome">Nome</label>
            <input type="text" name="nome" value="{{ old('nome', $cliente->nome) }}" required>

            <label for="cpf">CPF</label>
            <input type="text" name="cpf" value="{{ old('cpf', $cliente->cpf) }}" required>

            <label for="data">Data</label>
            <input type="date" name="data" value="{{ old('data', $cliente->data) }}">

            <label for="valor">Valor</label>
            <input type="text" name="valor" value="{{ old('valor', $cliente->valor) }}" required>

            <label for="fase">Fase</label>
            <input type="text" name="fase" value="{{ old('fase', $cliente->fase) }}" required>

            <label for="ho">H.O</label>
            <input type="text" name="ho" value="{{ old('ho', $cliente->ho) }}" required>

            <label for="credor">Credor</label>
            <select name="credor" required>
                <option value="COBMAIS" {{ $cliente->credor == 'COBMAIS' ? 'selected' : '' }}>COBMAIS</option>
                <option value="BONUSCRED" {{ $cliente->credor == 'BONUSCRED' ? 'selected' : '' }}>BONUSCRED</option>
            </select>

            <label for="colchao">Colchão</label>
            <select name="colchao" required>
                <option value="sim" {{ $cliente->colchao == 'sim' ? 'selected' : '' }}>Sim</option>
                <option value="nao" {{ $cliente->colchao == 'nao' ? 'selected' : '' }}>Não</option>
            </select>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>

</body>
</html>