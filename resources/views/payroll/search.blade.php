@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Payroll | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between  border-bottom border-subtle pb-3 gap-2">
                <p class="fs-5">Search Results for "{{ $query }}"</p>

                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3 pb-1 px-3">
            @forelse ($payrollBatch as $batches)
                <a href="{{ route('show.payroll', ['batchId' => $batches->id]) }}" class="link-dark text-decoration-none">
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
            <div class="text-center my-5">
                <i class="bi bi-box"></i>
                <p class="no-text">No receipts yet.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-3 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('on.payroll') }}" class="text-decoration-none fst-italic mt-2">/Payroll for On-Going Projects</a>

            <a href="{{ route('advance') }}" class="text-decoration-none fst-italic mt-2">/Advance list</a>
        </div>
 
@endsection

