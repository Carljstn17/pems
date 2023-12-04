<x-base2>

    <x-slot name="content">
        <div class="container-fluid">
            <div class="py-2">
                <i class="fs-4 bi-person-plus"></i> <span class="fs-4 d-sm-inline">Projects</span>
            </div>
            <main class="mx-auto margin" style="width:400px;">
                <div class="d-grid container gap-3">
                    <div class="row">
                        <a href="{{ url('/staff/ongoing-projects') }}" class="btn btn-dark p-3">On-Going Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/new-projects') }}" class="btn btn-dark p-3">New Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/all-projects') }}" class="btn btn-dark p-3">All Projects</a>
                    </div>
                </div>
            </main>
        </div>
    </x-slot>

    </x-base2>


