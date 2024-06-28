@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">SI-No.</span></th>
                        <th scope="col"><span class="bold text-nowrap">Project Description</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receipts as $receipt)
                    <tr data-url="{{ route('receipt.form', $receipt->id) }}" class="clickable-row">
                        <td><span class="text-nowrap">{{ $receipt->si_or_no }}</span></td>
                        <td><span class="text-nowrap">{{ $receipt->project->project_dsc }}</span></td>
                        <td>
                            <span class="text-nowrap">
                               {{ optional($receipt->user)->username }}
                            </span>
                        </td>
                        <td><span class="text-nowrap">{{ $receipt->created_at->diffForHumans() }}</span></td>
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
        
        <div class="px-3 d-flex justify-content-between">
            <a href="{{ route('on.receipt') }}" class="text-decoration-none text-secondary fst-italic">/Receipt for On-Going Projects</a>

            <a href="{{ route('supplier') }}" class="text-decoration-none text-secondary fst-italic">/Supplier list</a>
        </div>

       
@endsection

