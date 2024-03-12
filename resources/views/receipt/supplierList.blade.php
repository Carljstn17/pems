@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-receipt"></i> <span class=" d-sm-inline head fs-5">Receipt | Supplier List</span>
    </div>

    <div class="pb-2 m-3">
        <div class="d-flex justify-content-between gap-2">
            <div>

                <button class="btn btn-outline-success" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                    <span><i class="bi bi-plus"></i>Supplier</span>
                </button>  
            </div>

            <form action="" method="GET" >
                <div class="input-group">
                    <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                    <button type="submit" class="btn btn-outline-dark">Search</button>
                </div>
            </form>
        </div>
    </div>

    @include('layout.create-supplier-modal')

    <div class="px-3 pb-1">
    <table class="mt-3 table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Supplier</th>
                <th>Contact</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->created_at->format('Y-m-d') }}</td>
                    <td>{{ Str::limit($supplier->name, 20) }}</td>
                    <td>{{ Str::limit($supplier->contact, 10) }}</td>
                    <td>{{ Str::limit($supplier->address, 50) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="mt-3 pb-3">
    </div>
    

@endsection