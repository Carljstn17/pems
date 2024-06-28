@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <div class="d-flex align-items-center">
            <a href="{{ route('latest') }}" class="text-secondary text-decoration-none btn">
                        <i class="fs-5 bi-backspace"></i>
            </a>
            <i class="fs-5 bi-card-checklist"></i> <span class=" d-sm-inline fs-5 head">Estimate | Latest Form-view</span>
            </div>
        </div>
        
        <div class="mx-auto mt-4">

            <div class="mt-2">
                <table class="table table-bordered">
                        <thead>
                            <th>
                                <span class="bold">Status:</span>
                            </th>
                            <th>
                                <span class="bold">Entry&nbspID:</span>
                            </th>
                            <th >
                                <span class="bold">Entry&nbspby:</span>
                            </th>
                            <th >
                                <span class="bold">Entry&nbspdate: </span>
                            </th>
                        </thead>
                        <tbody>
                            @php
                                $status = $estimates->first()->status;
                                $colorClass = '';

                                switch ($status) {
                                    case 'accepted':
                                        $colorClass = 'text-primary';
                                        break;
                                    case 'rejected':
                                        $colorClass = 'text-danger';
                                        break;
                                    case 'pending':
                                        $colorClass = 'text-success';
                                        break;
                                    default:
                                        $colorClass = ''; // Default text color
                                        break;
                                }
                            @endphp

                            <td>
                                <span class="{{ $colorClass }}">{{ ucfirst($estimates->first()->status) }}</span>
                            </td>
                            <td >
                                <span>{{ $estimates->first()->group_id }}</span>
                            </td>
                            <td >
                                <span>{{ $estimates->first()->user->fname }} {{ $estimates->first()->user->mname }} {{ $estimates->first()->user->lname }}</span>
                            </td>
                            <td >
                                <span>{{ $estimates->first()->created_at->format('Y-m-d') }}</span>
                            </td>
                        </tbody>
                    </table>
 
                <div class="d-flex justify-content-between mb-3">
                    <div class="input-group"  style="width: 400px;">
                        <label for="Project" class="input-group-text"><span class="bold">Project</span></label>
                        <input type="text" class="form-control " value="{{ $estimates->first()->project->project_id }}">
                    </div>    
                    
                    <div class="input-group"  style="width: 400px;">
                        <label for="title" class="input-group-text"><span class="bold">Title</span></label>
                        <input type="text" class="form-control" value="{{ $estimates->first()->title }}">
                    </div>    
                </div>

                <table class="table table-bordered table-rounded mx-auto">
                    <thead>
                        <tr>
                            <td><Span class="bold">No</Span></td>
                            <td><Span class="bold">Description</Span></td>
                            <td><Span class="bold">UOM</Span></td>
                            <td><Span class="bold">Quantity</Span></td>
                            <td><Span class="bold">Unit&nbspCost</Span></td>
                            <td><Span class="bold">Amount</Span></td>
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
                                    <td><span id="currentTotal">{{ number_format($estimate->getAmount() ?? 0,2) }}</span></td>
                                </tr>
                            @endforeach
 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><strong>Total Amount:</strong></td>
                            <td>
                                <span id="currentTotal">{{ number_format($estimate->totalAmount($estimates) ?? 0,2) }}</span>    
                            </td>
                        </tr>
                    </tfoot>
                </table> 

                <div>
                    <label for=""><span class="bold">Remarks</span></label>
                    <textarea name="remarks" id="remarks"rows="5" class="border border-subtle" style="width:100%;resize:none;" value="" readonly>{{ $estimates->first()->remarks }}</textarea>
                </div>
                
                @if($estimate->status !== 'rejected')
                <div class="d-flex justify-content-end gap-2">
                    @if($estimate->status == 'accepted' && (Auth::user() && Auth::user()->srole == 1))
                        <a href="{{ route('export-estimates', ['group_id' => $group_id]) }}" class="btn btn-success">Export Excel</a>
                    @endif
                    @if($estimate->status == 'accepted')
                        <a href="{{ route('pdf-estimates', ['group_id' => $group_id]) }}" class="btn btn-primary">Export PDF</a>
                    @endif
                   

                    @if($estimate->status == 'pending')
                    <a href="{{ route('estimate.edit', $estimates->first()->group_id) }}" class="btn btn-success float-end px-4">Edit</a>
                    @endif
                @endif
                
                @if($estimate->status == 'pending' && (Auth::user() && Auth::user()->srole == 1))
                <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#acceptModal">
                    <i class="bi-award link-white"></i>
                    Accept
                </button>
                <button class="btn btn-warning float-end mx-2" type="button" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi-award link-white"></i>
                    Reject
                </button>
                </div>
                @endif


            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reject this estimate?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning" onclick="proceedReject()">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="acceptModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to accept this estimate?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="proceedAccept()">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
                
            <form action="{{ route('owner.accept', $group_id) }}" method="post" id="acceptForm" style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="remarks" id="remarksInputAccept">
            </form>
        
            <form action="{{ route('owner.reject', $group_id) }}" method="post" id="rejectForm" style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="remarks" id="remarksInputReject">
            </form>

            </div>
        </div>
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
                        url: '/estimates/softDelete/' + groupId,
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
            
            
                        var noFields = document.querySelectorAll('input[name^="no"]');
                noFields.forEach(function (field, index) {
                    field.value = index + 1;
                });

            var msg = '{{ session('alert') }}';
            var exist = '{{ session()->has('alert') }}';
            
            if (exist) {
                alert(msg);
            }

            function proceedAccept() {
                var remarks = document.getElementById('remarks').value;
                document.getElementById('remarksInputAccept').value = remarks;
                document.getElementById('acceptForm').submit();
            }

            function proceedReject() {
                var remarks = document.getElementById('remarks').value;
                document.getElementById('remarksInputReject').value = remarks;
                document.getElementById('rejectForm').submit();
            }
        </script>

@endsection


