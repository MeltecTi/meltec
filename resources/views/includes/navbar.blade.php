<header>
    <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="{{ url('/') }}" class="navbar-brand p-0 d-flex ">
            <div class="col w-25" style="max-width: 25%; margin: 20px 0;">
                <img src="{{ asset('img/logos/Meltec.gif') }}" alt="Logo Meltec" class="img-fluid p-3">
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">

                @foreach ($menus as $key => $item)
                    @if ($item['parent'] != 0)
                    @break
                @endif
                @include('partials.menu-item', ['item' => $item])
            @endforeach

        </div>
    </div>
</nav>
</header>
