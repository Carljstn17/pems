@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <div class="d-flex align-items-center">
            <i class="fs-5 bi-receipt me-2"></i>
            <span class="d-sm-inline">Receipt | Supplier List</span>
        </div>
    </div>

    <div class="pb-2 m-3">
        <div class="d-flex justify-content-between">
            <a href="{{ route('owner.receipt') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                
            <form action="" method="GET" >
                <div class="input-group">
                    <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="px-3 pb-1">
    <table class="mt-3 table table-bordered">
        <thead>
            <tr>
                <th><span class="bold">Date</span></th>
                <th><span class="bold">Supplier</span></th>
                <th><span class="bold">Contact</span></th>
                <th><span class="bold">Address</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $supplier->created_at->format('Y-m-d') }}">{{ $supplier->created_at->format('y-m-d') }}</td>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $supplier->name }}">{{ Str::limit($supplier->name, 8) }}</td>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $supplier->contact }}">{{ Str::limit($supplier->contact, 8) }}</td>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $supplier->address }}">{{ Str::limit($supplier->address, 8) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="mt-3 pb-3 float-end">
        {{ $suppliers->links('vendor.pagination.bootstrap-4') }}
    </div>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection