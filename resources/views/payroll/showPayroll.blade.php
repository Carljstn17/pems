@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-3">
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline fs-5 head">Payroll | Project - 
                {{ $batch->project_id }} |</span>  
                <span class="fs-5 head" style="color: {{ $batch->remarks === 'valid' ? 'green' : 'red' }}">{{ $batch->remarks }}</span>
        </div>
        
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
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($payrolls as $index => $payroll)
                    <tr>      
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payroll->name  }}</td>
                        <td>{{ number_format($payroll->rate_per_day, 2) }}</td>
                        <td>{{ $payroll->no_of_days }}</td>
                        <td>{{ number_format($payroll->ot_hour, 2) }}</td>
                        <td>{{ number_format($payroll->ot_amount, 2) }}</td>
                        <td>{{ number_format($payroll->salary, 2) }}</td>
                        <td>{{ number_format($payroll->advance_amount, 2) }}</td>
                        <td>{{ number_format($payroll->net_amount, 2) }}</td>
                        <td><input type="checkbox" class="form-check-input" name="checklist[]" checked></td>
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
                    <td></td>
                </tr>
            </tfoot>
        </table>

        @if($batch->remarks !== 'invalid')
        @if(Auth::user() && Auth::user()->id == $batch->entry_by)
            <button class="btn btn-danger float-end" type="button" data-bs-toggle="modal" data-bs-target="#updateRemarksModal">
                Incorrect
            </button>
        
            <!-- Modal -->
            <div class="modal fade" id="updateRemarksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to update the remarks to <span class="bold text-danger">'invalid'</span> for this batch <span class="bold">{{ $batch->id }}</span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" onclick="proceedUpdateRemarks()">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        
            <form action="{{ route('staff.updateBatchRemarks', $batch->id) }}" method="post" id="updateRemarksForm">
                @csrf
                @method('PUT')
            </form>

            <a href="{{ route('payroll.export', ['batchId' => $batch->id]) }}" class="btn btn-success float-end me-2">Export Payroll</a>
        @endif
        @else
        <span class="text-danger" >This payroll is invalid.</span>
        @endif
        
        
        <script>
            function proceedUpdateRemarks() {
            document.getElementById('updateRemarksForm').submit();
        }
        </script>

@endsection


