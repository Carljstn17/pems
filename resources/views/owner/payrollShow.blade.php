@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2 mb-4">
        <div class="border-bottom mb-3 d-sm-none">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary text-decoration-none  mb-3">
                <i class="bi-backspace"></i> Back
            </a>
        </div>

        <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | Project -
            @if ($payrolls->isNotEmpty())
                {{ $payrolls->first()->project_id }}
            @else
            @endif
        </span> |
        <span style="color: {{ $batch->remarks === 'valid' ? 'green' : 'red' }}">{{ $batch->remarks }}</span>
    </div>

    <div class="d-flex justify-content-between mb-2 gap-2">
        <div class="input-group" style="width: 200px;">
            <label for="ot_rate" class="input-group-text">
                <span class="d-none d-sm-inline bold">Payroll Batch</span>
                <span class="d-sm-inline d-sm-none bold ">Batch</span>
            </label>
            <input type="text" id="otRate" class="form-control ot_rate" name="ot_rate" value="{{ $batch->id }}"
                readonly>
        </div>
        <div class="input-group" style="width: 200px;">
            <label for="ot_rate" class="input-group-text"><span class="bold">OT-Rate</span></label>
            <input type="text" id="otRate" class="form-control ot_rate" name="ot_rate"
                value="{{ number_format($batch->ot_rate, 2) }}" readonly>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th><span class="bold">NO.</span></th>
                    <th class="col-md-2"><span class="bold">NAME</span></th>
                    <th><span class="bold">RATE/DAY</span></th>
                    <th><span class="bold">DAYS</span></th>
                    <th><span class="bold">OT-HOUR</span></th>
                    <th><span class="bold">OT-TOTAL</span></th>
                    <th><span class="bold">SALARY</span></th>
                    <th><span class="bold">ADVANCE</span></th>
                    <th><span class="bold">NET $</span></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($payrolls as $index => $payroll)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payroll->name }}</td>
                        <td>{{ number_format($payroll->rate_per_day, 2) }}</td>
                        <td>{{ $payroll->no_of_days }}</td>
                        <td>{{ number_format($payroll->ot_hour, 2) }}</td>
                        <td>{{ number_format($payroll->ot_amount, 2) }}</td>
                        <td>{{ number_format($payroll->salary, 2) }}</td>
                        <td>{{ number_format($payroll->advance_amount, 2) }}</td>
                        <td>{{ number_format($payroll->net_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><span class="bold">TOTAL : </span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($batch->total_salary, 2) }}</td>
                    <td>{{ number_format($batch->total_advance, 2) }}</td>
                    <td>{{ number_format($batch->total_net, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to update the remarks to 
                    <span class="bold text-danger">'invalid'</span> 
                     for this batch 
                    <span class="bold">"{{ $batch->id }}"</span> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="updateRemarks()">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('ownerBatchRemarks', $batch->id) }}" method="post" id="updateRemarksForm">
        @csrf
        @method('PUT')
        <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal"
            data-bs-target="#confirmationModal">Incorrect</button>
    </form>

    <script>
        function updateRemarks() {
            document.getElementById('updateRemarksForm').submit();
        }
    </script>
@endsection
