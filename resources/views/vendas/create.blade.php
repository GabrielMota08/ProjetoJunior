@extends ('layouts.main')

@section('title', 'Registrar venda')

@section('content')

<div id="venda-create-container" class="col-md-6 offset-md-3">
    <h1>Registre a venda</h1>

        <form method="GET" action="{{ route('vendas.create') }}">
            <div class="form-group mt-2">
                <label for="cliente_id">Cliente:</label>
                <div class="input-group">
                    <select name="cliente_id" id="cliente_id" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled {{ is_null(request('cliente_id')) ? 'selected' : '' }}>Selecione um cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('clientes.create') }}" class="btn btn-outline-secondary">Não encontrei o cliente</a>
                </div>
            </div>
        </form>
        @if($cliente_selecionado)
            <div class="mt-4 p-3 bg-light border rounded">
                <h5><i class="fas fa-user" style="margin-right: 10px"></i>Dados do cliente</h5>
                <p><strong>Nome:</strong> {{ $cliente_selecionado->nome }}</p>
                <p><strong>CPF:</strong> {{ $cliente_selecionado->cpf }}</p>
            </div>
        @endif

    <form action="/venda/store" method="POST">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ request('cliente_id') }}">
        <input type="submit" class="btn btn-primary mt-4" value="Registrar venda">
    </form>
</div>


<script>
    
</script>

@endsection
