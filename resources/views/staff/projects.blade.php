<x-base2>

    <x-slot name="content">
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-4 bi-buildings"></i> <span class="fs-4 d-sm-inline">Project Page</span>
            </div>
            <main class="mx-auto margin p-2" style="width:350px;">
                <div class="d-grid gap-3">
                    <div class="row">
                        <a href="{{ url('/staff/ongoing-projects') }}" class="btn btn-dark p-3">On-Going Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/new-projects') }}" class="btn btn-dark p-3">New Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/old-projects') }}" class="btn btn-dark p-3">Old Projects</a>
                    </div>
                </div>
            </main>
        </div>
    </x-slot>

    </x-base2>


