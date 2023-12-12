<x-base2>

    <x-slot name="content">
        <div class="py-2 mt-2">
            <i class="fs-4 bi-wallet"></i> <span class="fs-4 d-sm-inline">Payroll Page</span>
        </div>
        <main class="mx-auto margin p-2" style="width:350px;">
            <div class="d-grid gap-3">
                <div class="row">
                    <a href="{{ url('/staff/payroll/latest') }}" class="btn btn-dark p-3">Latest Payroll Entries</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/payroll/new') }}" class="btn btn-dark p-3">New Payroll Entry</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/payroll/on-going') }}" class="btn btn-dark p-3">Payroll for On-Going Projects</a>
                </div>
            </div>
        </main>
    </x-slot>

    </x-base2>


