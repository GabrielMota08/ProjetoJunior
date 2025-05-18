@extends('layouts.main')

@section('title', 'Listagem de venda')

@section('content')

<section class="pt-16 mx-auto max-w-7xl px-6">
    <h1 class="text-2xl font-semibold mb-4 text-center">Listagem de vendas</h1>

    <div class="mb-4 text-center">
        <a href="{{ route('vendas.create') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-pen"></i> Registrar venda
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300 rounded">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="py-3 px-4 border border-gray-300">Cliente</th>
                    <th class="py-3 px-4 border border-gray-300">Itens da venda</th>
                    <th class="py-3 px-4 border border-gray-300">Parcelas</th>
                    <th class="py-3 px-4 border border-gray-300">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                <tr class="border-t border-gray-300 hover:bg-gray-100 align-top">
                    <td class="py-3 px-4 border border-gray-300 whitespace-nowrap">
                        {{ $venda->cliente->nome ?? 'Cliente não encontrado' }}
                    </td>
                    <td class="py-3 px-4 border border-gray-300 max-w-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($venda->items as $item)
                            <li>
                                {{ $item->nome }} — Quantidade: {{ $item->pivot->quantidade }} — Preço unitário: R$ {{ number_format($item->pivot->preco_unitario, 2, ',', '.') }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="py-3 px-4 border border-gray-300 max-w-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($venda->parcelas as $parcela)
                            <li>
                                Parcela {{ $parcela->numero }} — Valor: R$ {{ number_format($parcela->valor, 2, ',', '.') }} — Vencimento: {{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }} — Status: {{ $parcela->paga ? 'Paga' : 'Pendente' }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="py-3 px-4 border border-gray-300 whitespace-nowrap">
                        <form action="/vendas/{{$venda->id}}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger d-flex align-items-center gap-1">
                                <i class="fa-solid fa-trash"></i>
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($vendas->isEmpty())
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">Nenhuma venda encontrada.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>

@endsection