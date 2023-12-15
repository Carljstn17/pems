@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | Latest Entries</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <div>
                    <button class="btn btn-outline-primary" style="transition:0.8s;"data-bs-toggle="modal" data-bs-target="#createReceiptModal">
                        <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Receipt</span>
                        <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add New</span>
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

        <div class="mt-1">
            {{ $receipts->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="mt-3 pt-2 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('on.receipt') }}" class="text-decoration-none">Receipt for On-Going Projects</a>

            <a href="{{ route('supplier') }}" class="text-decoration-none fst-italic">/Supplier list</a>
        </div>

       
@endsection

