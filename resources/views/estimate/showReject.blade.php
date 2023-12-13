@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline">Estimate | Rejected Form-view</span>
        </div>
        
        <div class="mx-auto mt-4">
            <div class="">

                    <table class="table table-bordered">
                        <thead>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Status:</span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->status }}</span>
                            </td>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry ID:</span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->group_id }}</span>
                            </td>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry by:</span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->user->username }}</span>
                            </td>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry date: </span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->created_at->diffForHumans() }}</span>
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
            </div>
        </div>

        <script>
            var noFields = document.querySelectorAll('input[name^="no"]');
                noFields.forEach(function (field, index) {
                    field.value = index + 1;
                });

            function confirmSoftDelete(groupId) {
                // Prompt the user for confirmation
                var confirmDelete = window.confirm('Are you sure you want to soft delete estimates with group ID ' + groupId + '?');
                
                if (confirmDelete) {
                    // If confirmed, proceed with the soft deletion
                    $.ajax({
                        url: '/estimates/soft-delete/' + groupId,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.message);

                        },
                        error: function(error) {
                            console.error('Error soft deleting estimates:', error);

                        }
                    });
                }
            }

            var msg = '{{ session('alert') }}';
            var exist = '{{ session()->has('alert') }}';
            
            if (exist) {
                alert(msg);
            }
        </script>
@endsection


