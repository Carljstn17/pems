@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | Advance List</span>
    </div>

    <div class="py-2 mt-3">
        <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <a href="{{ url('/staff/payroll/advance') }}" class="btn btn-outline-success" style="transition:0.8s;"">
                    <span><i class="bi bi-plus"></i>Advance</span>
                </a>

            <form action="" method="GET" >
                <div class="input-group">
                    <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Advance Amount</th>
                <td>Remarks</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($advances as $advance)
                <tr>
                    <td>{{ $advance->created_at->format('Y-m-d') }}</td>
                    <td>{{ $advance->name }}</td>
                    <td>{{ $advance->amount }}</td>
                    <td>{{ $advance->payroll_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 pb-3">
    </div>
    

@endsection