{{-- edit.blade.php --}}
<x-base2>

    <x-slot name="content">
        <div class="py-2 mt-2">
            <i class="fs-4 bi-card-checklist"></i> <span class="fs-4 d-sm-inline">Estimate | Latest Form-edit</span>
        </div>

        <table class="table table-bordered mt-4">
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
        
        <form action="{{ route('estimate.update') }}" method="post">
            @csrf
            @method('patch')

            <table class="table table-bordered">
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
                    @foreach ($estimates as $estimate)
                        <tr>
                            <input type="hidden" name="estimateId[{{ $estimate->id }}]" value="{{ $estimate->id }}">
                            <input type="hidden" name="groupId[]" value="{{ $estimate->group_id }}">
                            <td class="col-width"><input type="text" class="form-control no-border" name="no[]" value="1" readonly></td>
                            <td><input type="text" name="description[{{ $estimate->id }}]" value="{{ $estimate->description }}" class="form-control no-border"></td>
                            <td><input type="text" name="uom[{{ $estimate->id }}]" value="{{ $estimate->uom }}" class="form-control no-border"></td>
                            <td><input type="number" name="quantity[{{ $estimate->id }}]" value="{{ $estimate->quantity }}" class="form-control no-border quantity" oninput="calculateAmount(this)"></td>
                            <td><input type="number" name="unit_cost[{{ $estimate->id }}]" value="{{ $estimate->unit_cost }}" class="form-control no-border unit_cost" oninput="calculateAmount(this)"></td>
                            <td>
                                <input type="text" name="amount[{{ $estimate->id }}]" value="{{ $estimate->getAmount() }}" class="form-control no-border amount" readonly>
                     
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-right"><strong>Total Amount:</strong></td>
                        <td>
                            <input type="text" value="{{ $estimate->totalAmount($estimates) ?? 0  }}" class="no-border total_amount" readonly> 
                        </td>
                    </tr>
                </tfoot>
            </table>

            <button type="submit" class="btn btn-primary float-end" onclick="confirmUpdate()">Save Update</button>
        </form>
    </div>

    <script>
       
        function confirmUpdate() {
            var group_id = "{{ $estimate->group_id }}";
            var isConfirmed = confirm('Are you sure you want to update Group ID ' + group_id + '?');

            if (isConfirmed) {
                document.getElementById('update-form').submit();
            } else {
                alert('Update canceled by user.');
            }
        }

        function calculateAmount(input) {
                var row = $(input).closest("tr");
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var unitCost = parseFloat(row.find('.unit_cost').val()) || 0;
                var amount = quantity * unitCost;

                row.find('.amount').val(formatNumber(amount));
                updateTotal();
            }

            ////////////////////////////////////////////////////////////////////////////////////////

            function updateTotal() {
                var total = 0;

                $('.amount').each(function () {
                    var amount = parseFloat($(this).val().replace(/,/g, '')) || 0;
                    total += amount;
                });

                $('.total_amount').val(formatNumber(total));

                // Update the total cell in the footer
                $(".total_amount").val(formatNumber(total));
            }

            function formatNumber(number) {
                return number.toLocaleString();
            }

            // Update total on page load
            $(document).ready(function () {
                updateTotal();
            });

            var noFields = document.querySelectorAll('input[name^="no"]');
                noFields.forEach(function (field, index) {
                    field.value = index + 1;
                });
    </script>
    
    
    </x-slot>

</x-base2>

