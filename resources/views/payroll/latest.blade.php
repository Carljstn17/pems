@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Payroll | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <div>
                    <a href="{{ url('/staff/payroll/new') }}" class="btn btn-outline-primary" style="transition:0.8s;">
                        <span><i class="bi bi-plus"></i> Create New Payroll</span>
                    </a>

                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createAdvanceModal" style="transition:0.8s;">
                        <span class="d-none d-sm-inline"><i class="bi bi-plus"></i> Advance</span>
                    </button>
                </div>

                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @include('payroll.advance')

        <div class="mt-3 pb-3 px-3 gap-2">
            <a href="" class="link-dark text-decoration-none">
                <div class="row p-4 d-flex justify-content-center rounded-2 border hover3">
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
        
        <div class="mt-3 pt-2 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('on.payroll') }}" class="text-decoration-none fst-italic">/Payroll for On-Going Projects</a>

            <a href="{{ route('advance') }}" class="text-decoration-none fst-italic">/Advance list</a>
        </div>

       
@endsection

