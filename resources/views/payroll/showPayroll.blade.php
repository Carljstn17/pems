@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-3">
            <div class="d-flex align-items-center">
                <a href="{{ route('latest.payroll') }}" class="text-secondary text-decoration-none btn">
                            <i class="fs-5 bi-backspace"></i>
                </a>
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline fs-5 head">Payroll | Project - 
                {{ $batch->project_id }} |</span>  
                <span class="fs-5 head" style="color: {{ $batch->status === 'valid' ? 'blue' : ($batch->status === 'pending' ? 'green' : 'red') }}">{{ $batch->status }}</span>
            </div>
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
                        <span>{{ $batch->entry->fname }} {{ $batch->entry->mname }} {{ $batch->entry->lname }}</span>
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
        
        <div class="modal fade" id="validModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to accept the remarks of this batch 
                        <span class="bold">"{{ $batch->id }}"</span> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="updateStatusValid()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
        @if($batch->status !== 'invalid')
        @if(Auth::user() && Auth::user()->srole == 1)
            @if($batch->status == 'pending')
            <form action="{{ route('statusValid', $batch->id) }}" method="post" id="statusValidForm">
                @csrf
                @method('PUT')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#validModal">
                    <i class="bi-award link-white"></i>
                    Correct
                </button>
            </form>
            @endif

            @if($batch->status == 'pending')
            <button class="btn btn-danger float-end" type="button" data-bs-toggle="modal" data-bs-target="#updateRemarksModal">
                <i class="bi-award link-white"></i>
                Incorrect
            </button>
            @endif
        
            <form action="{{ route('staff.updateBatchRemarks', $batch->id) }}" method="post" id="updateRemarksForm">
                @csrf
                @method('PUT')
            </form>
        @endif
        @else
        <span class="text-danger" >This payroll is invalid.</span>
        @endif
        
        @if($batch->status == 'valid')
            <a href="{{ route('payroll.export', ['batchId' => $batch->id]) }}" class="btn btn-success float-end me-2">
                <i class="bi-award link-white"></i>
                Export Payroll
            </a>
        @endif
            
        </div>
        
        
        <script>
            function proceedUpdateRemarks() {
            document.getElementById('updateRemarksForm').submit();
        }
        
        function updateStatusValid() {
            document.getElementById('statusValidForm').submit();
        }
        
        </script>

@endsection


