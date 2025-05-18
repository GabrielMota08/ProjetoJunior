@extends ('layouts.main')

@section('title', 'Registrar venda')

@section('content')

<div id="venda-create-container" class="col-md-6 offset-md-3" style="margin-left: 15%; width: 70%;">
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
        

         <div class="form-group mt-2">
            <label for="items">Adicione os itens:</label>
            <div class="input-group mb-2">
                <select name="item_id" id="item_id" class="form-control">
                    <option value="" disabled selected>Selecione um item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-nome="{{ $item->nome }}" data-valor="{{ $item->valor }}">
                            {{ $item->nome }} - R$ {{ number_format($item->valor, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" min="1">
                <button type="button" id="addItemBtn" class="btn btn-success btn-sm px-4 py-0" style="font-size: 20px">+</button>
                <a href="{{ route('items.create') }}" class="btn btn-outline-secondary">Item não cadastrado</a>
            </div>

            <ul id="lista-itens" class="list-group mt-4">
            </ul>
        </div>

        <div class="form-group mt-4">
            <h2>Valor total: </h2><h5 id="valorTotal"></h5>
        </div>
        <form action="/pagamento" method="GET">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ request('cliente_id') }}">
            <input type="hidden" name="itens_adicionados" id="itens_adicionados">
            <input id="pagamentoBtnEnabled" type="submit" class="btn btn-success mt-4" value="Ir para pagamento" style="display:none">
            <input id="pagamentoBtnDisabled" type="submit" class="btn btn-secondary mt-4" value="Ir para pagamento" disabled>
        </form>
        @endif
</div>

<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>


<script>
    const itemSelect = document.getElementById('item_id');
    const quantidadeInput = document.getElementById('quantidade');
    const addItemBtn = document.getElementById('addItemBtn');
    const listaItens = document.getElementById('lista-itens');
    const hiddenInput = document.getElementById('itens_adicionados');
    const valorTotal = document.getElementById('valorTotal');
    const pagamentoBtnEnabled = document.getElementById('pagamentoBtnEnabled');
    const pagamentoBtnDisabled = document.getElementById('pagamentoBtnDisabled');

    let itensAdicionados = [];

    function atualizarHiddenInput() {
        hiddenInput.value = JSON.stringify(itensAdicionados);
        let valorT = 0;
        itensAdicionados.forEach((item) => valorT += item.valor * item.quantidade);
        valorTotal.innerText = valorT.toFixed(2) + "R$";
        if(itensAdicionados.length === 0){
            pagamentoBtnEnabled.style.display = "none";
            pagamentoBtnDisabled.style.display = "block";
        } else {
            pagamentoBtnEnabled.style.display = "block";
            pagamentoBtnDisabled.style.display = "none";
        }
    }

    function removerItem(index) {
        itensAdicionados.splice(index, 1);
        renderizarLista();
    }

    function renderizarLista() {
        listaItens.innerHTML = '';
        itensAdicionados.forEach((item, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';

            const nomeItem = item.nome;
            const total = (item.valor * item.quantidade).toFixed(2);

            li.innerHTML = `
                ${nomeItem} (Qtd: ${item.quantidade}) - R$ ${total}
                <button type="button" class="btn btn-danger btn-sm" onclick="removerItem(${index})">Remover</button>
            `;

            listaItens.appendChild(li);
        });
        atualizarHiddenInput();
    }

    addItemBtn.addEventListener('click', () => {
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const itemId = itemSelect.value;
        const itemNome = selectedOption.dataset.nome;
        const itemValor = parseFloat(selectedOption.dataset.valor);
        const quantidade = parseInt(quantidadeInput.value);

        if (!itemId || !quantidade || quantidade < 1) {
            alert("Selecione um item válido e uma quantidade maior que 0.");
            return;
        }

        itensAdicionados.push({
            id: itemId,
            nome: itemNome,
            valor: itemValor,
            quantidade: quantidade
        });

        renderizarLista();
        console.log("apagado")
        itemSelect.value = "";  
        quantidadeInput.value = '';
    });

    window.removerItem = removerItem;
</script>

@endsection
