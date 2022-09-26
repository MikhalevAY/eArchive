<div class="col-menu">
    <a class="logo" href="{{ route('archiveSearch') }}">
        <img src="/storage/{{ $companyLogo }}" alt="" draggable="false">
    </a>

    <div class="menu">
        <ul>
        @foreach($menuItems as $k => $menuItem)
            <li>
                <a class="icon icon-{{ $menuItem->number }} {{ request()->segment(1) == $menuItem->url ? 'active' : '' }}" href="/{{ $menuItem->url }}">
                    <span></span>{{ $menuItem->title }}
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
