<x-base2>

    <x-slot name="content">
        <div class="py-2 mt-2">
            <i class="fs-4 bi-card-checklist"></i> <span class="fs-4 d-sm-inline">Estimate</span>
        </div>
        <main class="mx-auto margin p-2" style="width:350px;">
            <div class="d-grid gap-3">
                <div class="row">
                    <a href="{{ url('/staff/estimate/latest') }}" class="btn btn-dark p-3">Latest Estimate</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/estimate/new') }}" class="btn btn-dark p-3">New Estimate</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/estimate/old') }}" class="btn btn-dark p-3">Add / Edit Estimate</a>
                </div>
            </div>
        </main>
    </x-slot>

    </x-base2>


