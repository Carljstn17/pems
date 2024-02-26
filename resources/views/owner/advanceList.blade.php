@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <div class="d-flex align-items-center">
            <div class="d-sm-none me-2">
                <a href="{{ url()->previous() }}" class="text-secondary text-decoration-none">
                    <i class="bi-backspace"></i>
                </a>
            </div>
            <i class="fs-5 bi-wallet me-2"></i> <span class=" d-sm-inline">Payroll | Advance List</span>
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

    <div class="table-responsive">
    <table class="mt-3 table table-bordered">
        <thead>
            <tr>
                <th><span class="bold">Date</span></th>
                <th><span class="bold">Name</span></th>
                <th><span class="bold">Amount</span></th>
                <td><span class="bold">Remark</span></td>
                <td><span class="bold">Payroll&nbspID</span></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($advances as $advance)
                <tr>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $advance->created_at->format('Y-m-d') }}">{{ $advance->created_at->format('y-m-d') }}</td>
                    <td class="text-nowrap" data-toggle="tooltip" title="{{ $advance->name }}">{{ Str::limit($advance->name, 15) }}</td>
                    <td>{{ $advance->amount }}</td>
                    <td style="color: {{ $advance->remarks === 'add' ? 'green' : 'red' }}">{{ $advance->remarks }}</td>
                    <td>{{ $advance->payroll_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="mt-3 pb-3">
    </div>
    
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@endsection