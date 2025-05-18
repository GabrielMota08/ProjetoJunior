<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="/css/styles.css" />
    <script src="/js/script.js" defer></script>
</head>
<body>
    <nav>
        <ul>
            <li style="cursor: default; padding-right: 3em; font-size: 20px"><strong><a href="/">Projeto</a></strong></li>
            <li>
                Vendas
                <ul>
                    <li><a href="{{ route('vendas.create') }}">Cadastrar venda</a></li>
                    <li><a href="{{ route('vendas.index') }}">Ver vendas</a></li>
                </ul>
            </li>
            <li><a href="{{ route('clientes.create') }}">Clientes</a></li>
            <li><a href="{{ route('items.create') }}">Itens</a></li>
        </ul>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="text-center mt-5 mb-3">
        <p>ProjetoJunior &copy; 2025</p>
    </footer>
</body>
</html>
