@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-3">
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | Project - 
                @if ($payrolls->isNotEmpty())
                {{ $payrolls->first()->project_id }}
                @else
                @endif</span>   |   
                <span style="color: {{ $batch->remarks === 'valid' ? 'green' : 'red' }}">{{ $batch->remarks }}</span>
        </div>
        
        <div class="d-flex justify-content-between mb-2">
            <div class="input-group"  style="width: 200px;">
                <label for="ot_rate" class="input-group-text"><span class="bold">Payroll Batch</span></label>
                <input type="text" id="otRate" class="form-control ot_rate" name="ot_rate" value="{{ $batch->id }}" readonly>
            </div>    
            <div class="input-group"  style="width: 200px;">
                <label for="ot_rate" class="input-group-text"><span class="bold">OT-RATE</span></label>
                <input type="text" id="otRate" class="form-control ot_rate" name="ot_rate" value="{{ number_format($batch->ot_rate, 2) }}" readonly>
            </div>    
        </div>

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

        @if(Auth::user() && Auth::user()->id == $batch->entry_by)
            <form action="{{ route('updateBatchRemarks', $batch->id) }}" method="post" id="updateRemarksForm">
                @csrf
                @method('PUT')
            
                <button type="button" class="btn btn-danger float-end" onclick="confirmUpdateRemarks()">Incorrect</button>
            </form>
        @endif
        
        <script>
            function confirmUpdateRemarks() {
                var confirmation = confirm("Are you sure you want to update the remarks to 'invalid' for this batch and 'add' for advances?");
        
                if (confirmation) {
                    document.getElementById('updateRemarksForm').submit();
                } else {
                    // Optionally, you can provide feedback to the user that the update was canceled.
                    alert("Update canceled. Remarks remain unchanged.");
                    return false;
                }
            }
        </script>

@endsection


