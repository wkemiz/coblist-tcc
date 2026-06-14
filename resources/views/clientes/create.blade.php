@extends('layouts.app')

@section('content')

<div style="max-width: 500px; margin: 40px auto; padding: 20px; background:#f9f9f9; border-radius:8px; border:1px solid #ddd;">

    <h2 style="color:#333; margin-bottom:20px;">Novo Cliente</h2>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>CPF</label>
        <input type="text" name="cpf" required>

        <label>Data</label>
        <input type="date" name="data">

        <label>Valor</label>
        <input type="text" name="valor" id="valorInput" required>

        <label>Fase</label>
        <select name="fase" id="fase">
            <option value="0">0%</option>
            <option value="15">15%</option>
            <option value="20">20%</option>
        </select>

        <label>H.O</label>
        <input type="text" name="ho" id="ho" required>

        <label>Credor</label>
        <select name="credor">
            <option value="COBMAIS">COBMAIS</option>
            <option value="BONUSCRED">BONUSCRED</option>
        </select>

        <label>Colchão</label>
        <select name="colchao">
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
        </select>

        <div style="margin-top:15px; display:flex; justify-content:space-between;">
            <button type="submit" style="background:#28a745; color:white; padding:10px; border:none; border-radius:5px;">
                Salvar
            </button>

            <a href="{{ route('clientes.index') }}" style="background:#2196F3; color:white; padding:10px; border-radius:5px; text-decoration:none;">
                Voltar
            </a>
        </div>
    </form>

</div>

<script>
    const faseSelect = document.getElementById('fase');
    const hoInput = document.getElementById('ho');
    const valorInput = document.getElementById('valorInput');

    function atualizarHO() {
        const fase = parseFloat(faseSelect.value);
        const valor = parseFloat(valorInput.value.replace(',', '.')) || 0;

        if (fase === 15 || fase === 20) {
            hoInput.value = (valor * fase / 100).toFixed(2).replace('.', ',');
            hoInput.readOnly = true;
        } else {
            hoInput.readOnly = false;
            hoInput.value = '';
        }
    }

    faseSelect.addEventListener('change', atualizarHO);
    valorInput.addEventListener('input', atualizarHO);

    window.addEventListener('load', atualizarHO);
</script>

@endsection