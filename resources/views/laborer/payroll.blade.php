@extends('layout.laborer')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline fs-5 head">Payroll | Latest Entries</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-end gap-2">
                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
            <table class="table table-hover" id="estimateTable">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">Project-ID</span></th>
                        <th scope="col"><span class="bold text-nowrap">Description</span></th>
                        <th scope="col"><span class="bold text-nowrap">Salary</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payrolls as $payroll)
                        <tr data-url="{{ route('laborer.showPayroll', ['payrollId' => $payroll->id]) }}" class="clickable-row">
                            <td><span class="text-nowrap">{{ Str::limit($payroll->project_id, 15) }}</span></td>
                            <td><span class="text-nowrap">{{ Str::limit($payroll->project_dsc, 25) }}</span></td>                            
                            <td><span class="text-nowrap">{{ number_format($payroll->salary,2) }}</span></td>
                            <td><span class="text-nowrap">{{ \Carbon\Carbon::parse($payroll->created_at)->diffForHumans() }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center my-5">
                                <i class="bi bi-box"></i>
                                <p class="no-text">No estimates yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        
        <div class="px-3 d-flex justify-content-end">
            <a href="{{ route('laborer.advanceList') }}" class="text-decoration-none text-secondary fst-italic mt-2 text-nowrap">/Advance list</a>
            {{ $payrolls->links('vendor.pagination.bootstrap-4') }}
        </div>
 
@endsection

