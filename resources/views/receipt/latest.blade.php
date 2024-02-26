@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <div>
                    <button class="btn btn-outline-primary" style="transition:0.8s;"data-bs-toggle="modal" data-bs-target="#createReceiptModal">
                        <span><i class="bi bi-plus"></i>Add New Receipt</span>
                    </button>

                    <button class="btn btn-outline-success" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                        <span><i class="bi bi-plus"></i>Supplier</span>
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

        @include('layout.create-receipt-modal')
        @include('layout.create-supplier-modal')

        <div class="mt-3 pb-1 px-3">
            @forelse ($receipts as $receipt)
                <a href="{{ route('receipt.form', $receipt->id) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col">
                            <span class="bold">Rceipt SI: &nbsp</span>{{ $receipt->si_or_no }}
                        </div>
                        <div class="col">
                            <span class="bold">Project ID: &nbsp</span>{{ Str::limit($receipt->project->project_id, 14) }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry By: &nbsp</span>{{ $receipt->user->username }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry Date: &nbsp</span>{{ $receipt->created_at->diffForHumans() }}
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

        <div class="mt-1">
            {{ $receipts->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="mt-3 pt-2 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('on.receipt') }}" class="text-decoration-none fst-italic">/Receipt for On-Going Projects</a>

            <a href="{{ route('supplier') }}" class="text-decoration-none fst-italic">/Supplier list</a>
        </div>

       
@endsection

