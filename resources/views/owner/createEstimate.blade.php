@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-card-checklist"></i> <span class="fs-5 head d-sm-inline">Estimate | Create Estimate</span>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="pb-2 m-3">
        <form action="{{ route('owner.storeEstimate') }}" method="post" class="p-2">
            @csrf
            <div class="d-flex justify-content-between mb-3">
                    <select name="project_id" id="project_id" class="form-select" style="width: 400px;">
                        <option value="">Select a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->project_id }}
                                <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                            </option>
                        @endforeach
                    </select>
                    
                    <div class="input-group"  style="width: 400px;">
                        <label for="title" class="input-group-text"><span class="bold">Title</span></label>
                        <input type="text" class="form-control" placeholder="Estimate Title" name="title" value="{{ old('title') }}">
                    </div>    
                </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class=" col-md-1"><span class="bold">No</span></th>
                            <th class=" col-md-4"><span class="bold">Description</span></th>
                            <th class=" col-md-1"><span class="bold">UOM</span></th>
                            <th><span class="bold ">Quantity</span></th>
                            <th><span class="bold">UnitCost</span></th>
                            <th><span class="bold">Amount</span></th>
                            <th><span class="bold">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < old('row_count', 1); $i++)
                        <input type="hidden" name="row_count" value="{{ old('row_count', 1) }}">
                            <tr>
                                <td><input type="text" class="form-control no-border" name="no[]" value="{{ $i + 1 }}" readonly></td>
                                <td><input type="text" class="form-control no-border" placeholder="item description" name="description[]" value="{{ old('description.' . $i) }}"></td>
                                <td><input type="text" class="form-control no-border" placeholder="measure" name="uom[]" value="{{ old('uom.' . $i) }}"></td>
                                <td><input type="number" class="form-control no-border" name="quantity[]" placeholder="0" oninput="calculateAmount(this)" value="{{ old('quantity.' . $i) }}" step="any"></td>
                                <td><input type="number" class="form-control no-border" name="unit_cost[]" placeholder="per unit" value="{{ old('unit_cost.' . $i) }}" oninput="calculateAmount(this)"></td>
                                <td><input type="text" class="form-control no-border" name="amount[]" placeholder="0" value="{{ old('amount.' . $i) }}" readonly></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total Amount:</strong></td>
                            <td><input type="text" class="form-control no-border" name="total_amount" id="total" value="{{ old('total_amount') }}" readonly></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-success text-nowrap" onclick="addRow()">+ Add Row</button>
            </div>

            <div>
                <label for=""><span class="bold">Remarks</span></label>
                <textarea name="remarks" id="remarks" rows="5" class="border border-subtle" style="width:100%;resize:none;">{{ old('remarks') }}</textarea>
            </div>
            <button type="submit" class="btn btn-dark float-end text-nowrap">Submit Estimate</button>
        </form>
    </div>

    <script>
        var rowCount = {{ old('row_count', 1) }};

        function addRow() {
    var rowCountInput = $("input[name='row_count']");
    var rowCount = parseInt(rowCountInput.val());
    rowCount++;

    var newRow = $("<tr>");
    var cols = "";

    cols += '<td><input type="text" class="form-control no-border" name="no[]" value="' + rowCount + '" readonly></td>';
    cols += '<td><input type="text" class="form-control no-border" placeholder="item description" name="description[]"></td>';
    cols += '<td><input type="text" class="form-control no-border" placeholder="measure" name="uom[]"></td>';
    cols += '<td><input type="text" class="form-control no-border" name="quantity[]" placeholder="0" oninput="calculateAmount(this)"></td>';
    cols += '<td><input type="text" class="form-control no-border" name="unit_cost[]" placeholder="per unit" oninput="calculateAmount(this)"></td>';
    cols += '<td><input type="text" class="form-control no-border" placeholder="0" name="amount[]" readonly></td>';
    cols += `<td class="text-center">
                <button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="removeRow(this)">
                    <i class="bi bi-x"></i>
                </button>
            </td>`;

    newRow.append(cols);
    $("table tbody").append(newRow);

    // Update the hidden input field with the new rowCount value
    rowCountInput.val(rowCount);
}

        function removeRow(btn) {
            $(btn).closest("tr").remove();
            updateRowCount();
        }

        function calculateAmount(input) {
            var row = $(input).closest("tr");
            var quantity = parseFloat(row.find("input[name='quantity[]']").val()) || 0;
            var unitCost = parseFloat(row.find("input[name='unit_cost[]']").val()) || 0;
            var amount = quantity * unitCost;

            row.find("input[name='amount[]']").val(formatNumber(amount));
            updateTotal();
        }

        function updateTotal() {
            var total = 0;

            $("input[name='amount[]']").each(function () {
                var amount = parseFloat($(this).val().replace(/,/g, '')) || 0;
                total += amount;
            });

            $("input[name='total_amount']").val(formatNumber(total));
        }

        function formatNumber(number) {
            return number.toLocaleString();
        }

        function updateRowCount() {
            $("input[name='row_count']").val(rowCount);
        }

        // Update total on page load
        $(document).ready(function () {
            updateTotal();
        });
    </script>
@endsection
