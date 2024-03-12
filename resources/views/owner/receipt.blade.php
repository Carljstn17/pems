@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline fs-5 head">Receipt | Latest Entries</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-end gap-2">
                <form action="{{ route('owner.search.receipt') }}" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @include('layout.create-receipt-modal')
        @include('layout.create-supplier-modal')

        <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
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
                    <tr data-url="{{ route('owner.showReceipt', $receipt->id) }}" class="clickable-row">
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
        </div> 

        <div class="px-3 d-flex justify-content-between">
            <a href="{{ route('owner.supplier') }}" class="link-secondary text-decoration-none fst-italic">
                <span class="d-none d-sm-inline text-nowrap">/Advance-list</span>
                <span class="d-sm-inline d-sm-none">/Rejected</span>
            </a>
            {{ $receipts->links('vendor.pagination.bootstrap-4') }}
        </div>

       
@endsection

