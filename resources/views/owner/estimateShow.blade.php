@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class=" d-sm-inline">Estimate | Latest Form-view</span>
        </div>
        
        <div class="mx-auto mt-4">

            <div class="mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <th>
                                <span class="d-none d-sm-inline bold">Status:</span>
                            </th>
                            <td>
                                <span>{{ $estimates->first()->status }}</span>
                            </td>
                            <th>
                                <span class="d-none d-sm-inline bold">Entry ID:</span>
                            </th>
                            <td >
                                <span>{{ $estimates->first()->group_id }}</span>
                            </td>
                            <th >
                                <span class="d-none d-sm-inline bold">Entry by:</span>
                            </th>
                            <td >
                                <span>{{ $estimates->first()->user->username }}</span>
                            </td>
                            <th >
                                <span class="d-none d-sm-inline bold">Entry date: </span>
                            </th>
                            <td >
                                <span>{{ $estimates->first()->created_at->format('Y-m-d') }}</span>
                            </td>
                        </thead>
                    </table>
 


                <table class="table table-bordered table-rounded mx-auto">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="col-md-4">Description</th>
                            <th>UOM</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                            @foreach ($estimates as $index => $estimate)
                                <tr>
                                    <td class="col-width"><input type="text" class="form-control no-border" name="no[]" value="1" readonly></td>
                                    <td>{{ isset($estimate->description) ? $estimate->description : 'N/A' }}</td>
                                    <td>{{ isset($estimate->uom) ? $estimate->uom : 'N/A' }}</td>
                                    <td><span>{{ number_format($estimate->quantity, 2, '.', ',') }}</span></td>
                                    <td><span>{{ number_format($estimate->unit_cost, 2, '.', ',') }}</span></td>
                                    <td><span id="currentTotal">{{ $estimate->getAmount() ?? 0 }}</span></td>
                                </tr>
                            @endforeach
 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><strong>Total Amount:</strong></td>
                            <td>
                                <span id="currentTotal">{{ $estimate->totalAmount($estimates) ?? 0 }}</span>    
                            </td>
                        </tr>
                    </tfoot>
                </table>   

                <form action="{{ route('statusAndRemarks', $group_id) }}" method="post">
                    @csrf
                                
                    <div>
                        <label for=""><span class="bold">Remarks</span></label>
                        <textarea name="remarks" id="remarks" rows="5" class="border border-subtle" style="width:100%;resize:none;">{{ $estimates->first()->remarks }}</textarea>
                    </div>
                                
                    <!-- Add a hidden field for the status -->
                    <input type="hidden" name="status_accepted" value="accepted">
                    <input type="hidden" name="status_rejected" value="rejected">
                
                    @if($estimates->first()->status !== 'rejected')
                        <button type="submit" class="btn btn-primary float-end" name="status" value="accepted" onclick="confirmAction('accepted')">Accept</button>
                        <button type="submit" class="btn btn-warning float-end mx-2" name="status" value="rejected" onclick="confirmAction('rejected')">Reject</button>
                    @else
                        <p>This estimate has already been rejected, and the buttons are not available.</p>
                    @endif
                </form>
                

            </div>
        </div>

        <script>
            var noFields = document.querySelectorAll('input[name^="no"]');
                noFields.forEach(function (field, index) {
                    field.value = index + 1;
                });

            var msg = '{{ session('alert') }}';
            var exist = '{{ session()->has('alert') }}';
            
            if (exist) {
                alert(msg);
            }
        </script>

        <script>
            function confirmAction(status) {
                var confirmation = confirm("Are you sure you want to update the status to " + status + "?");

                if (confirmation) {
                    // If user confirms, submit the form
                    document.getElementById('updateForm').elements['status'].value = status;
                    document.getElementById('updateForm').submit();
                }
            }
        </script>

@endsection


