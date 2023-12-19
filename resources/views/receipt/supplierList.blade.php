@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-receipt"></i> <span class=" d-sm-inline">Receipt | Supplier List</span>
    </div>

    <div class="py-2 mt-3">
        <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary text-decoration-none px-3">
                    <i class="bi-backspace"> back</i>
                </a>

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

    @include('layout.create-supplier-modal')

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

    <div class="mt-3 pb-3">
    </div>
    

@endsection