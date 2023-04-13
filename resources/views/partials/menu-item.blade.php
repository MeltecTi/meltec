@if ($item['submenu'] == [])
    <a href="{{ url($item['slug']) }}" class="nav-item nav-link">{{ $item['name'] }} </a>
@else
    <div class="nav-item dropdown">
        <a href="{{ url($item['slug']) }}" class="nav-link dropdown-toggle">{{ $item['name'] }} <span
                class="caret"></span></a>
        <div class="dropdown-menu m-0">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <a href="{{ url($item['slug'], [
                        'slug' => $submenu['id'],
                    ]) }}"
                        class="dropdown-item">{{ $submenu['name'] }}
                    </a>
                @else
                    @include('partials.menu-item', ['item' => $submenu])
                @endif
            @endforeach
        </div>
    </div>
@endif