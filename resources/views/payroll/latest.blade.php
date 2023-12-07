<x-base2>

    <x-slot name="content">
        <div class="py-2 mt-2">
            <i class="fs-4 bi-wallet"></i> <span class="fs-4 d-sm-inline">Payroll | Latest Entries</span>
        </div>

        <div class="p-2 mt-3">
            <a href="" class="link-dark text-decoration-none">
                <div class="row bg-white p-4 d-flex justify-content-center rounded-2 border">
                    <div class="col">
                        Payroll ID:
                    </div>
                    <div class="col">
                        Project ID:
                    </div>
                    <div class="col">
                        Entry By:
                    </div>
                    <div class="col">
                        Created At:
                    </div>
                </div>
            </a>

            {{-- Layout with backend
            @forelse ($payrolls as $payroll)
                <a href="{{ url('/staff/show-entry', $payroll->id) }}" class="link-dark text-decoration-none">
                    <div class="row bg-white p-4 d-flex justify-content-center rounded-2 border">
                        <div class="col">
                            Payroll ID:
                        </div>
                        <div class="col">
                            Project ID:
                        </div>
                        <div class="col">
                            Entry By:
                        </div>
                        <div class="col">
                            Created At:
                        </div>
                    </div>
                </a>
            @empty
            <p>No Latest Payrolls yet.</p>
            @endforelse --}}
        </div>               
       
    </x-slot>

    </x-base2>


