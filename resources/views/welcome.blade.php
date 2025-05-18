@extends('layouts.main')

@section('title', 'ProjetoJunior')

@section('content')
<div>
    @if(session('msg'))
    <div id="alert-msg" class="alert alert-success mt-3">
        {{ session('msg') }}
    </div>

    <script>
        setTimeout(function() {
            let alert = document.getElementById('alert-msg');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
@endif
    <h1>Controle de vendas</h1>

    <section class="container my-4">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card text-white bg-success h-100">
        <div class="card-body">
          <h2 class="card-title"><i class="fas fa-shopping-cart"></i> Vendas</h2>
          <p class="mt-4">
            <a href="{{ route('vendas.create') }}" class="btn btn-light text-success w-100">Cadastrar venda</a>
          </p>
          <p class="mt-3">
            <a href="{{ route('vendas.index') }}" class="btn btn-light text-success w-100">Ver vendas</a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-primary h-100">
        <div class="card-body">
          <h2 class="card-title"><i class="fas fa-user"></i> Clientes</h2>
          <p class="mt-4">
            <a href="{{ route('clientes.create') }}" class="btn btn-light text-primary w-100">Cadastrar cliente</a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-danger h-100">
        <div class="card-body">
          <h2 class="card-title"><i class="fas fa-tag"></i> Item</h2>
          <p class="mt-4">
            <a href="{{ route('items.create') }}" class="btn btn-light text-danger w-100">Cadastrar item</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
@endsection
