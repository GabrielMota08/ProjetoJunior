@extends ('layouts.main')

@section('title', 'Cadastrar cliente')

@section('content')

    <div id="project-create-container" class="col-md-6 offset-md-3">
        <h1>Cadastre o cliente</h1>
        <form action="/clientes/store" method="POST">
                @csrf
            <div class="form-group mt-2">
                <label for="title">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do cliente">
            </div>
            <div class="form-group mt-2">
                <label for="title">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Cpf do cliente">

                @error('cpf')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" class="btn btn-primary mt-4" value="Cadastrar cliente">
        </form>
    </div>

@endsection
