@extends('layouts.main')

@section('title', 'Listagem de venda')

@section('content')

<section style="padding-top: 4em;" class="mx-auto flex justify-center">
    <h1 style="padding-left: 5%">Listagem de vendas</h1>

    <div style="display: flex; flex-direction: row; flex-wrap: wrap; padding-inline: 5%; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ route('vendas.create') }}">
            <button style="background-color: rgb(0, 107, 179); color: white; border: none; padding: 0.5rem; display: flex; align-items: center; border-radius: 8px;">
                <x-jam-write style="width: 25px" /> Registrar venda
            </button>
        </a>

        @foreach($vendas as $venda)
            <div>
                Nome do cliente: $venda->cliente_id
                Produtos da venda: $venda->
                <form action="/venda/{{$venda->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button style="color: white; background-color: rgb(169, 0, 0); border: none; padding: 0.5rem; display: flex; align-items: center; margin-right: 10px; border-radius: 8px;">
                        <x-heroicon-o-trash style="color: white; width: 25px" />
                    </button>
                </form>
            </div>
        @endforeach
        
    </div>
</section>

@endsection
