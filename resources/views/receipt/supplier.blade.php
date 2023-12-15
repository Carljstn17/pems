@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | Supplier Form</span>
    </div>

    <form method="POST" action="{{ route('supplier.store') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Supplier</th>
                    <th>Contact</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td class="col-md-1">{{ $i }}</td>
                        <td>
                            <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][name]">
                        </td>
                        <td>
                            <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][contact]">
                        </td>
                        <td>
                            <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][address]">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    
        <button type="submit" class="btn btn-primary float-end">Submit</button>
    </form>
@endsection