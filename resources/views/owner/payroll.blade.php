@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Transact | Payroll Entries</span>
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

        @include('payroll.advance')

        <div class="mt-3 pb-1 px-3">
            @forelse ($payrollBatch as $batches)
                <a href="{{ route('owner.showPayroll', ['batchId' => $batches->id]) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col">
                            <span class="bold">Payroll batch: &nbsp</span>{{ $batches->id }}
                        </div>
                        <div class="col">
                            <span class="bold">Project ID: &nbsp</span>{{ $batches->project_id }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry By: &nbsp</span>
                            @php
                            $user = \App\Models\User::find($batches->entry_by);
                            echo $user ? $user->username : 'User not found';
                            @endphp
                        </div>
                        <div class="col">
                            <span class="bold">Created At: &nbsp</span>{{ $batches->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
            <p>No Latest Payrolls yet.</p>
            @endforelse
        </div>
        
        <div class="mt-1">
            {{ $payrollBatch->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="mt-3 border-top border-subtle d-flex justify-content-end">
            <a href="{{ route('advance') }}" class="text-decoration-none fst-italic mt-2">/Advance list</a>
        </div>
 
@endsection

