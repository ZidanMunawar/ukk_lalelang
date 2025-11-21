<!-- ==========Page Header Section Start Here========== -->
<section class="page-header-section style-1 light-version">
    <div class="container">
        <div class="page-header-content">
            <div class="page-header-inner">
                <div class="page-title">
                    <h2>@yield('page_title', 'Page Title')</h2>
                </div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('masyarakat.dashboard') }}">Home</a></li>
                    <li class="active">@yield('breadcrumb_active', 'Current Page')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- ==========Page Header Section Ends Here========== -->
