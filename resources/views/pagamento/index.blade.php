@extends ('layouts.main')

@section('title', 'Pagamento')

@section('content')

<div id="venda-create-container" class="col-md-6 offset-md-3" style="margin-left: 15%; width: 70%;">
    <h1><i class="fas fa-shopping-cart" style="margin-right: 10px"></i>Revisão da venda</h1>
    <div class="mt-5 p-3 bg-light border rounded">
        <h5><i class="fas fa-user" style="margin-right: 10px"></i>Dados do cliente</h5>
        <p><strong>Nome:</strong> {{ $cliente->nome }}</p>
        <p><strong>CPF:</strong> {{ $cliente->cpf }}</p>

        <h5 class="mt-5"><i class="fas fa-tag" style="margin-right: 10px"></i>Itens selecionados</h5>
        @foreach($itens as $item)
            <div class="mt-2 p-3 border rounded">
                <p><strong>Nome:</strong> {{ $item['nome'] }}</p>
                <p><strong>Valor:</strong> {{ $item['valor'] }} x {{ $item['quantidade'] }} = {{ $item['valor'] * $item['quantidade'] }}</p>
            </div>
        @endforeach    

        <h5 class="mt-5"><i class="fas fa-credit-card" style="margin-right: 10px"></i>Forma de pagamento</h5>
        <label>Número de parcelas</label>
        <div class="input-group mb-2">
            <input type="number" class="form-control" id="parcelas" name="parcelas" placeholder="Selecione a quantidade de parcelas" min="1">
            <button type="button" id="installmentsBtn" class="btn btn-success btn-sm px-4 py-0">Parcelar</button>
        </div>
        <ul id="parcelasUl" class="list-group mt-4">
        </ul>

        <form id="pagamentoForm" action="/vendas/store" method="POST">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
            <input type="hidden" name="parcelas" id="parcelasInput">
            <input type="hidden" name="itens_adicionados" id="itens_adicionados" value="{{ json_encode($itens) }}">
            <input id="vendaBtnEnabled" type="submit" class="btn btn-success mt-4" value="Registrar venda">
        </form>
    </div>
</div>


<script>
    const parcelas = document.getElementById("parcelas");
    const installmentsBtn = document.getElementById("installmentsBtn");
    const parcelasUl = document.getElementById("parcelasUl");
    const valorTotal = @json($valor_total);
    const form = document.getElementById('pagamentoForm');

    function ultimoDiaMes(date) {
        return new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    }

    form.addEventListener('submit', function(event) {
        const inputs = parcelasUl.querySelectorAll('input');
        let notReady = false;
        let parcelasData = [];

        inputs.forEach(input => {
            input.style.borderColor = '';
        });

        const itens = parcelasUl.querySelectorAll('li');
        itens.forEach(li => {
            const inputs = li.querySelectorAll('input');
            const inputDia = inputs[0];
            const inputValor = li.querySelector('input.w-25');

            let diaValido = true;
            let valorValido = true;

            if (!inputDia.value || inputDia.value.trim() === '' || isNaN(inputDia.value) || parseInt(inputDia.value) < 1 || parseInt(inputDia.value) > parseInt(inputDia.max)) {
                inputDia.style.borderColor = 'red';
                diaValido = false;
                notReady = true;
            }

            if (!inputValor.value || inputValor.value.trim() === '' || isNaN(inputValor.value) || parseFloat(inputValor.value) < 0) {
                inputValor.style.borderColor = 'red';
                valorValido = false;
                notReady = true;
            }

            if (diaValido && valorValido) {
                parcelasData.push({
                    dia: parseInt(inputDia.value),
                    valor: parseFloat(inputValor.value)
                });
            }
        });

        if (notReady) {
            event.preventDefault();
            alert('Por favor, preencha corretamente os dias e valores das parcelas.');
            return;
        }

        document.getElementById('parcelasInput').value = JSON.stringify(parcelasData);
    });

    installmentsBtn.addEventListener('click', () => {
        const parcelasqnt = parseInt(parcelas.value)
        if (parcelasqnt < 1) {
            alert("Selecione um número válido de parcelas.");
            return;
        }

        const valorReal = parseFloat((valorTotal / parcelasqnt).toFixed(2));
        let valores = Array(parcelasqnt).fill(valorReal);

        let diferenca = parseFloat((valorTotal - valores.reduce((a, b) => a + b, 0)).toFixed(2));
        for (let i = 0; diferenca !== 0 && i < parcelasqnt; i++) {
            valores[i] = parseFloat((valores[i] + (diferenca > 0 ? 0.01 : -0.01)).toFixed(2));
            diferenca = parseFloat((valorTotal - valores.reduce((a, b) => a + b, 0)).toFixed(2));
        }

        parcelasUl.innerHTML = '';
        for (let i = 0; i < parcelasqnt; i++) {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';

            const mesAno = new Date();
            mesAno.setMonth(mesAno.getMonth() + i);
            const nomeMes = mesAno.toLocaleString('default', { month: 'long' });
            const ano = mesAno.getFullYear();

            const inputDay = document.createElement('input');
            inputDay.type = 'number';
            inputDay.min = 1;
            inputDay.max = ultimoDiaMes(mesAno);
            inputDay.className = 'form-control';
            inputDay.style.width = '80px';
            inputDay.dataset.index = i;

            const label = document.createElement('span');
            label.textContent = `Parcela ${i + 1}`;
            label.style.width = '100px';
            const label2 = document.createElement('span');
            label2.textContent = `${nomeMes.charAt(0).toUpperCase() + nomeMes.slice(1)} de ${ano}`;

            const input = document.createElement('input');
            input.type = 'number';
            input.min = 0;
            input.step = '0.01';
            input.className = 'form-control w-25';
            input.value = valores[i].toFixed(2);
            input.dataset.index = i;

            if (i === parcelasqnt - 1) {
                input.readOnly = true;
                input.classList.add('bg-secondary-subtle');
            }

            input.addEventListener('input', (e) => {
                const idx = parseInt(e.target.dataset.index);
                let novoValor = parseFloat(e.target.value);

                if (novoValor < 0 || novoValor > valorTotal) {
                    e.target.classList.add('text-danger');
                } else {
                    e.target.classList.remove('text-danger');
                }

                if (novoValor < 0 || novoValor > valorTotal) {
                    alert("Valor inválido");
                    e.target.value = valores[idx].toFixed(2);
                    return;
                }

                valores[idx] = parseFloat(novoValor.toFixed(2));
                const valorDistribuido = valores.slice(0, idx + 1).reduce((a, b) => a + b, 0);
                let restante = parseFloat((valorTotal - valorDistribuido).toFixed(2));
                const qtdRestante = valores.length - (idx + 1);
                let novaParcela = qtdRestante > 0 ? parseFloat((restante / qtdRestante).toFixed(2)) : 0;

                for (let j = idx + 1; j < valores.length; j++) {
                    valores[j] = novaParcela;
                }

                let somaAtual = valores.reduce((a, b) => a + b, 0);
                let diferenca = parseFloat((valorTotal - somaAtual).toFixed(2));
                for (let j = idx + 1; j < valores.length && Math.abs(diferenca) >= 0.01; j++) {
                    valores[j] = parseFloat((valores[j] + (diferenca > 0 ? 0.01 : -0.01)).toFixed(2));
                    diferenca = parseFloat((valorTotal - valores.reduce((a, b) => a + b, 0)).toFixed(2));
                }

                const inputs = parcelasUl.querySelectorAll('input.w-25');
                inputs.forEach((input, k) => {
                    input.value = valores[k].toFixed(2);

                    if (valores[k] < 0) {
                        input.classList.add('text-danger');
                    } else {
                        input.classList.remove('text-danger');
                    }
                });
            });

            li.appendChild(label);
            li.appendChild(inputDay);
            li.appendChild(label2);
            li.appendChild(input);
            parcelasUl.appendChild(li);

        }});

</script>

@endsection