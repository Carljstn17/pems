@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline fs-5 head">Payroll | Invalid List</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('owner.payroll') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <form action="{{ route('owner.search.payroll') }}" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">P-Batch</span></th>
                        <th scope="col"><span class="bold text-nowrap">Project Description</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrollBatch as $batches)
                    <tr data-url="{{ route('owner.showPayroll', ['batchId' => $batches->id]) }}" class="clickable-row">
                        <td><span class="text-nowrap">{{ $batches->id }}</span></td>
                        <td><span class="text-nowrap">{{ $batches->project->project_dsc }}</span></td>
                        <td>
                            <span class="text-nowrap">
                                {{ $batches->entry->username }}
                            </span>
                        </td>
                        <td><span class="text-nowrap">{{ $batches->updated_at->diffForHumans() }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center my-5">
                            <i class="bi bi-box"></i>
                            <p class="no-text">No payrolls yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        <div class="px-3 d-flex justify-content-between">

            {{ $payrollBatch->links('vendor.pagination.bootstrap-4') }}
        </div>
 
    @endsection 

