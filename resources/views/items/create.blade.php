@extends ('layouts.main')

@section('title', 'Cadastrar item')

@section('content')

    <div id="project-create-container" class="col-md-6 offset-md-3">
        <h1>Cadastre o item</h1>
        <form action="/items/store" method="POST">
                @csrf
            <div class="form-group mt-2">
                <label for="title">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do item">
            </div>
            <div class="form-group mt-2">
                <label for="title">Valor:</label>
                    <input type="number" class="form-control" id="valor" name="valor" step="0.01" placeholder="Valor do item">
            </div>
            <input type="submit" class="btn btn-primary mt-4" value="Cadastrar Item">
        </form>
    </div>

@endsection