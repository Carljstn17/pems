@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2 mb-4">
        <div class="d-flex align-items-center">
            <div class="d-sm-none me-2">
                <a href="{{ url()->previous() }}" class="text-secondary text-decoration-none">
                    <i class="bi-backspace"></i>
                </a>
            </div>
            <i class="fs-5 bi-wallet me-2"></i> <span class=" d-sm-inline fs-5 head">Payroll | Project -
                {{ $batch->project_id }} |
            </span> 
            <span class="fs-5 head" style="color: {{ $batch->remarks === 'valid' ? 'green' : 'red' }}">{{ $batch->remarks }}</span>
        </div>
    </div>

    <div class="mt-2">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>
                        <span class="bold text-nowrap">Project Description</span>
                    </th>
                    <th>
                        <span class="bold text-nowrap">Entry By:</span>
                    </th>
                    <th >
                        <span class="bold">Date</span>
                    </th>
                    <th >
                        <span class="bold text-nowrap">OT Rate</span>
                    </th>
                </thead>
                <tbody>
                    <td>
                        <span>{{ $batch->project->project_dsc }}</span>
                    </td>
                    <td >
                        <span>{{ $batch->entry->name }}</span>
                    </td>
                    <td >
                        <span>{{ $batch->created_at->format('Y-m-d') }}</span>
                    </td>
                    <td >
                        <span>{{ $batch->ot_rate }}</span>
                    </td>
                </tbody>
            </table>
        </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th><span class="bold">No.</span></th>
                    <th class="col-md-2"><span class="bold">Name</span></th>
                    <th><span class="bold">Rate/day</span></th>
                    <th><span class="bold">Days</span></th>
                    <th><span class="bold text-nowrap">OT Hour</span></th>
                    <th><span class="bold text-nowrap">OT Total</span></th>
                    <th><span class="bold">Salary</span></th>
                    <th><span class="bold">Advance</span></th>
                    <th><span class="bold text-nowrap">Net $</span></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($payrolls as $index => $payroll)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-nowrap" data-toggle="tooltip" title="{{ $payroll->name }}">{{ Str::limit($payroll->name, 20) }}</td>
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

    @if($batch->remarks !== 'invalid')
    <form action="{{ route('ownerBatchRemarks', $batch->id) }}" method="post" id="updateRemarksForm">
        @csrf
        @method('PUT')
        <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal"
            data-bs-target="#confirmationModal">Incorrect</button>
    </form>
    @else
        <span class="text-danger" >This payroll is invalid.</span>
    @endif

    <script>
        function updateRemarks() {
            document.getElementById('updateRemarksForm').submit();
        }
        
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
