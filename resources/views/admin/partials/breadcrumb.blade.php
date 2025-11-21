<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ $title ?? 'Dashboard' }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/icons/home-outline.svg') }}" width="18" height="18"
                            alt="Home">
                    </a>
                </li>
                @if (isset($items) && is_array($items))
                    @foreach ($items as $item)
                        @if (isset($item['url']))
                            <li class="breadcrumb-item">
                                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                        @endif
                    @endforeach
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                @endif
            </ol>
        </nav>
    </div>
</div>
