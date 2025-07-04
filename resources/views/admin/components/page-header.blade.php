<div class="row mb-3">
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 fw-bold">{{ $title }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    {{ $slot }}
                </ol>
            </div>
        </div>
    </div>
</div>
