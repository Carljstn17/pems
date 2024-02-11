@extends('layout.laborer')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Payroll | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-end border-bottom border-subtle pb-3 gap-2">
                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3 pb-1 px-3">
            @forelse ($payrolls as $payroll)
                <a href="{{ route('laborer.showPayroll', ['payrollId' => $payroll->id]) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col-sm-12 mb-2 col-lg-3">
                            <span class="bold">Project: &nbsp</span>{{ Str::limit($payroll->project_id, 15) }}
                        </div>
                        <div class="col-sm-12 mb-2 col-lg-3">
                            <span class="bold">Salary: &nbsp</span>{{ number_format($payroll->salary,2) }}
                        </div>
                        <div class="col-sm-12 mb-2 col-lg-3">
                            <span class="bold">Net $: &nbsp</span>{{ number_format($payroll->net_amount,2) }}
                        </div>
                        <div class="col-sm-12 mb-2 col-lg-3">
                            <span class="bold">Created At: &nbsp</span>{{ \Carbon\Carbon::parse($payroll->created_at)->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
            <p>No Latest Payrolls yet.</p>
            @endforelse
        </div>
        
        <div class="mt-1">
            {{ $payrolls->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="mt-3 border-top border-subtle d-flex justify-content-end">
            <a href="{{ route('laborer.advanceList') }}" class="text-decoration-none fst-italic mt-2">/Advance list</a>
        </div>
 
@endsection

