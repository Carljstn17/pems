@extends('layout.laborer')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | Advance List</span>
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
                <th><span class="bold">Name</span></th>
                <th><span class="bold">Amount</span></th>
                <td><span class="bold">Remark</span></td>
                <td><span class="bold">Payroll-ID</span></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($advances as $advance)
                <tr>
                    <td>{{ $advance->created_at->format('Y-m-d') }}</td>
                    <td>{{ $advance->name }}</td>
                    <td>{{ $advance->amount }}</td>
                    <td style="color: {{ $advance->remarks === 'add' ? 'green' : 'red' }}">{{ $advance->remarks }}</td>
                    <td>{{ $advance->payroll_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 pb-3">
    </div>
    

@endsection