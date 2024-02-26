@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <div class="d-flex align-items-center">
            <div class="d-sm-none me-2">
                <a href="{{ url()->previous() }}" class="text-secondary text-decoration-none">
                    <i class="bi-backspace"></i>
                </a>
            </div>
            <i class="fs-5 bi-receipt me-2"></i>
            <span class="d-sm-inline">Receipt | Supplier List</span>
        </div>
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

    <div class="mt-3 pb-3 float-end">
        {{ $suppliers->links('vendor.pagination.bootstrap-4') }}
    </div>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection