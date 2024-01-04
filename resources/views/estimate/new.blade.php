<div class="modal fade" id="createEstimateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Your modal header -->
            <div class="modal-header">
                <h5 class="modal-title">Create New Estimate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('estimate.store') }}" method="post" class="p-2">
                @csrf
                <button type="button" class="btn btn-outline-success mb-2" onclick="addRow()">+ Add Row</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><span class="bold">No</span></th>
                            <th><span class="bold">Description</span></th>
                            <th><span class="bold">UOM</span></th>
                            <th><span class="bold">Quantity</span></th>
                            <th><span class="bold">UnitCost</span></th>
                            <th><span class="bold">Amount</span></th>
                            <th><span class="bold">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-1"><input type="text" class="form-control no-border" name="no[]" value="1" readonly></td>
                            <td class="col-md-4"><input type="text" class="form-control no-border" placeholder="item description" name="description[]" required></td>
                            <td><input type="text" class="form-control no-border" placeholder="measure" name="uom[]"></td>
                            <td><input type="number" class="form-control no-border" name="quantity[]" placeholder="0" oninput="calculateAmount(this)" required></td>
                            <td><input type="number" class="form-control no-border" name="unit_cost[]" placeholder="per unit" oninput="calculateAmount(this)" required></td>
                            <td><input type="text" class="form-control no-border" name="amount[]" placeholder="0" readonly></td>
                            <td class="text-center">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total Amount:</strong></td>
                            <td><input type="text" class="form-control no-border" name="total_amount" id="total" readonly></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
        
                <div>
                    <label for=""><span class="bold">Remarks</span></label>
                    <textarea name="remarks" id="remarks"rows="5" class="border border-subtle" style="width:100%;resize:none;" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary float-end">Submit</button>
            </form>
        </div>
    </div>
</div>
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
        <script>
            var rowCount = 1;

            function addRow() {
                rowCount++;

                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control no-border" name="no[]" value="' + rowCount + '" readonly></td>';
                cols += '<td><input type="text" class="form-control no-border" placeholder="item description" name="description[]" required></td>';
                cols += '<td><input type="text" class="form-control no-border" placeholder="measure" name="uom[]"></td>';
                cols += `<td><input type="text" class="form-control no-border" name="quantity[]" placeholder="0" oninput="calculateAmount(this)" required></td>`;
                cols += `<td><input type="text" class="form-control no-border" name="unit_cost[]" placeholder="per unit" oninput="calculateAmount(this)" required></td>`;
                cols += '<td><input type="text" class="form-control no-border" placeholder="0" name="amount[]" readonly></td>';
                cols += `<td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>`;

                newRow.append(cols);
                $("table tbody").append(newRow);
            }

            function removeRow(btn) {
                $(btn).closest("tr").remove();
                updateTotal();
            }

            ///////////////////////////////////////////////////////////////////////////////////////

            function calculateAmount(input) {
                var row = $(input).closest("tr");
                var quantity = parseFloat(row.find("input[name='quantity[]']").val()) || 0;
                var unitCost = parseFloat(row.find("input[name='unit_cost[]']").val()) || 0;
                var amount = quantity * unitCost;

                row.find("input[name='amount[]']").val(formatNumber(amount));
                updateTotal();
            }

            ////////////////////////////////////////////////////////////////////////////////////////

            function updateTotal() {
                var total = 0;

                $("input[name='amount[]']").each(function () {
                    var amount = parseFloat($(this).val().replace(/,/g, '')) || 0;
                    total += amount;
                });

                $("input[name='total_amount']").val(formatNumber(total));

                // Update the total cell in the footer
                $("#total").val(formatNumber(total));
            }

            function formatNumber(number) {
                return number.toLocaleString();
            }

            // Update total on page load
            $(document).ready(function () {
                updateTotal();
            });
        </script>

