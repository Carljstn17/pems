@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Payroll | Latest Entries</span>
        </div>

        <div class="p-2 mt-3">
            <a href="" class="link-dark text-decoration-none">
                <div class="row bg-white p-4 d-flex justify-content-center rounded-2 border">
                    <div class="col">
                        Project ID:
                    </div>
                    <div class="col">
                        Project Description:
                    </div>
                    <div class="col">
                        Date Started:
                    </div>
                    <div class="col">
                        Date Created:
                    </div>
                </div>
            </a>

            {{-- Layout with backend
            @forelse ($allPayrolls as $allpayroll)
                <a href="{{ url('/staff/payroll/all-ongoing', $allPayroll->id) }}" class="link-dark text-decoration-none">
                    <div class="row bg-white p-4 d-flex justify-content-center rounded-2 border">
                        <div class="col">
                            Project ID:
                        </div>
                        <div class="col">
                            Project Description:
                        </div>
                        <div class="col">
                            Date Started:
                        </div>
                        <div class="col">
                            Date Created:
                        </div>
                    </div>
                </a>
            @empty
            <p>No Latest Payrolls yet.</p>
            @endforelse --}}
        </div>               
       
@endsection


