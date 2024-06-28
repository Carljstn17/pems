@extends('layout.owner')

@section('content')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
    <div class="py-2 mt-2">
        <div class="d-flex align-items-center">
        <a href="{{ route('owner.estimate') }}" class="text-secondary text-decoration-none btn">
                    <i class="bi-backspace"></i>
        </a>
        <i class="fs-5 bi-card-checklist"></i> <span class="fs-5 head d-sm-inline">Estimate | Create Estimate</span>
        </div>
    </div>
    <div class="pb-2 m-3">
        <form action="{{ route('owner.storeEstimate') }}" method="post" class="p-2">
            @csrf
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <select name="project_id" id="project_id" class="form-select @error('project_id') border-red @enderror" style="width: 400px;">
                        <option value="">Select a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_id }}
                                <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                            </option>
                        @endforeach
                    </select>
                        @error('project_id')
                                <div class="text-danger px-2 ">{{ $message }}</div>
                        @enderror
                </div>
                    
                <div>
                    <div class="input-group"  style="width: 400px;">
                        <label for="title" class="input-group-text"><span class="bold">Title</span></label>
                        <input type="text" class="form-control @error('title') border-red @enderror" placeholder="Estimate Title" name="title" value="{{ old('title') }}">
                    </div>    
                        @error('title')
                                <div class="text-danger px-2">{{ $message }}</div>
                        @enderror
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class=" col-md-4"><span class="bold">Description</span></th>
                            <th><span class="bold">UOM</span></th>
                            <th><span class="bold ">Quantity</span></th>
                            <th><span class="bold">UnitCost</span></th>
                            <th><span class="bold">Amount</span></th>
                            <th><span class="bold">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="row_count" value="{{ old('row_count', 1) }}">
                        @for ($i = 0; $i < old('row_count', 1); $i++)
                            <tr>
                                <td>
                                    <input type="text" class="form-control @error('description.' . $i) border-red @enderror no-border" 
                                    placeholder="item description" name="description[]" value="{{ old('description.' . $i) }}">
                                    @error('description.' . $i)
                                            <div class="text-danger px-2 text-nowrap">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control no-border @error('uom.' . $i) border-red @enderror" 
                                    placeholder="measure" name="uom[]" value="{{ old('uom.' . $i) }}">
                                    @error('uom.' . $i)
                                            <div class="text-danger px-2 text-nowrap">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control no-border qt @error('quantity.' . $i) border-red @enderror" 
                                    name="quantity[]" placeholder="0" oninput="calculateAmount(this)" value="{{ old('quantity.' . $i) }}" 
                                    step="any" maxlength="3">
                                    @error('quantity.' . $i)
                                            <div class="text-danger px-2 text-nowrap">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control no-border uc @error('unit_cost.' . $i) border-red @enderror" 
                                    name="unit_cost[]" placeholder="per unit" value="{{ old('unit_cost.' . $i) }}" oninput="calculateAmount(this)" 
                                    maxlength="5">
                                    @error('unit_cost.' . $i)
                                            <div class="text-danger px-2 text-nowrap">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control no-border @error('amount.' . $i) border-red @enderror" 
                                    name="amount[]" placeholder="0" value="{{ old('amount.' . $i) }}" readonly>
                                    @error('amount.' . $i)
                                            <div class="text-danger px-2 text-nowrap">{{ $message }}</div>
                                    @enderror
                                </td>
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
                            <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                            <td><input type="text" class="form-control no-border" name="total_amount" id="total" value="{{ old('total_amount') }}" readonly></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between">
                @if ($errors->any())
                    <div class="text-danger">All row is required. Delete unused rows*</div>
                @endif
                <button type="button" class="btn btn-success text-nowrap" onclick="addRow()">+ Add Row</button>
            </div>

            <div>
                <label for=""><span class="bold">Remarks</span></label>
                <textarea name="remarks" id="remarks" rows="5" class="border border-subtle @error('remarks') border-red @enderror" style="width:100%;resize:none;">{{ old('remarks') }}</textarea>
                @error('remarks')
                                <div class="text-danger px-2">{{ $message }}</div>
                        @enderror
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
            updateTotal();
        }
        
        function updateRowCount() {
            // Update the row count input value
            var rowCount = 0;
            $("table tbody tr").each(function(index) {
                $(this).find("td:first input").val(index + 1);
                rowCount++;
            });
            $("input[name='row_count']").val(rowCount);
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
        
        $(document).on('keypress', 'input[name="quantity[]"], input[name="unit_cost[]"]', function(event) {
            if (event.key === 'e') {
                event.preventDefault();
            }
        });

    </script>
@endsection
