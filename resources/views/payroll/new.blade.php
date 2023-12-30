@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-3">
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | New Entry</span>
        </div>
        
        <form action="" method="post" class="pb-5">

            <div class="d-flex justify-content-between mb-2">
                <select name="project_id" id="project_id" class="form-select" style="width: 400px;">
                    <option value="">Select a project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->project_id }}
                            <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                        </option>
                    @endforeach
                </select>

                @foreach ($laborers as $laborer)
                    <div class="input-group"  style="width: 200px;">
                        <label for="ot_rate" class="input-group-text"><span class="bold">OT-RATE</span></label>
                        <input type="number" class="form-control ot_rate" name="ot_rate" value="{{ $laborer->payroll->ot_rate }}">
                    </div>    
                    @break
                @endforeach
                
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
                    @foreach($laborers as $laborer)
                    <tr>
                        <td>1</td>
                        <td>
                            <input type="text" class="form-control no-border" value="{{ $laborer->name }}" name="user_id[]{{ $laborer->id }}" oninput="calculateAmount(this.parentElement.parentElement)" readonly>
                        </td>
                        <td><input type="number" class="form-control no-border" name="rate_per_day[]" value="{{ $laborer->payroll->rate_per_day }}" oninput="calculateAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="no_of_days[]" oninput="calculateAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="ot_hour[]"></td>
                        <td><input type="number" class="form-control no-border" name="ot_total[]" readonly></td>
                        <td><input type="number" class="form-control no-border" name="salary[]" readonly></td>
                        <td>
                            <input type="text" class="form-control no-border" value="{{ number_format(optional($laborer->advances())->amount, 2, '.', ',') }}" name="advances_id[]" oninput="updateNetAmount(this.parentElement.parentElement)" data-bs-toggle="modal" data-bs-target="#advancesModal{{ $laborer->id }}" readonly>

                            @include('payroll.advance_modal', ['laborer' => $laborer])
                        </td>
                        <td><input type="number" class="form-control no-border" name="net_amount[]" readonly></td>
                        <td><input type="checkbox" class="form-check-input" name="checklist[]" checked></td>
                    </tr>
                    @endforeach
                </tbody>
        
                <tfoot> 
                    <tr>
                        <td colspan="2" class="text-end"><span class="bold">TOTAL : </span></td>
                        <td><input type="text" class="form-control no-border" id="totalRate" name="totalRate" readonly></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control no-border" id="totalSalary" name="totalSalary" readonly></td>
                        <td><input type="text" class="form-control no-border" id="totalAdvance" name="totalAdvance" readonly></td>
                        <td><input type="text" class="form-control no-border" id="totalNetAmount" name="totalNetAmount" readonly></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between gap-2">
                {{-- <button type="button" class="btn btn-success" onclick="addRow()">+ Add Row</button> --}}
                <button type="button" class="btn btn-danger" onclick="clearForm()">Clear</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>    
        </form>


<script>

    document.addEventListener('DOMContentLoaded', function () {
        var checkboxes = document.getElementsByName('checklist[]');
        var totalAmountInput = document.querySelector('[name="advances_id[]"]');
        
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                updateTotalCheckedAmount();
            });
        });

        function updateTotalCheckedAmount() {
            var totalAmount = 0;

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked && checkbox.hasAttribute('data-amount')) {
                    totalAmount += parseFloat(checkbox.getAttribute('data-amount'));
                }
            });

            totalAmountInput.value = isNaN(totalAmount) ? '0.00' : totalAmount.toFixed(2);

            // Handle remarks
            var remarksInput = document.getElementById('remarksInput'); // Change 'remarksInput' to the actual ID of your remarks input
            var allChecked = Array.from(checkboxes).every(function (checkbox) {
                return !checkbox.checked;
            });

            remarksInput.value = allChecked ? 'add' : 'deducted';
        }
    });

    function calculateAmount(row) {
        const ratePerDay = parseFloat(row.querySelector('[name="rate_per_day[]"]').value) || 0;
        const noOfDays = parseFloat(row.querySelector('[name="no_of_days[]"]').value) || 0;
        const amountField = row.querySelector('[name="salary[]"]');

        const amount = ratePerDay * noOfDays;
        amountField.value = amount.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        const totalAmountField = document.getElementById("totalSalary");
        const amountFields = document.getElementsByName("salary[]");

        const totalAmount = Array.from(amountFields).reduce((acc, field) => acc + (parseFloat(field.value) || 0), 0);
        totalAmountField.value = totalAmount.toFixed(2);

        // Update Total Rate
        const totalRateField = document.getElementById("totalRate");
        const rateFields = document.getElementsByName("rate_per_day[]");

        const totalRate = Array.from(rateFields).reduce((acc, field) => acc + (parseFloat(field.value) || 0), 0);
        totalRateField.value = totalRate.toFixed(2);

        // Update Total Advance
        updateTotalAdvance();

        // Update Total Net Amount
        updateTotalNetAmount();
    }
    
    function updateTotalAdvance() {
        var totalAdvanceField = document.getElementById("totalAdvance");
        var advanceFields = document.getElementsByName("advance_id[]");

        var totalAdvance = Array.from(advanceFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

        totalAdvanceField.value = totalAdvance.toFixed(2);
    }

    function updateTotalNetAmount() {
        var totalNetAmountField = document.getElementById("totalNetAmount");
        var salaryFields = document.getElementsByName("salary[]");
        var advanceFields = document.getElementsByName("advances_id[]");
        var netAmountFields = document.getElementsByName("net_amount[]");

        var totalNetAmount = 0;

        // Iterate through each row
        for (var i = 0; i < salaryFields.length; i++) {
            var salary = parseFloat(salaryFields[i].value) || 0;
            var advance = parseFloat(advanceFields[i].value) || 0;

            // Calculate net amount for each row
            var netAmount = salary - advance;

            // Update net_amount field for each row
            netAmountFields[i].value = netAmount.toFixed(2);

            // Accumulate net amounts for total
            totalNetAmount += netAmount;
        }

        totalNetAmountField.value = totalNetAmount.toFixed(2);
    }

    function clearForm() {
        var inputs = document.querySelectorAll('input[name^="name[]"], input[name^="rate_per_day[]"], input[name^="no_of_days[]"], input[name^="ot[]"], input[name^="ot_total[]"], input[name^="salary[]"], input[name^="advance_id[]"], input[name^="net_amount[]"]');
        inputs.forEach(function (input) {
            input.value = '';
        });

        document.getElementById("totalRate").value = '';
        document.getElementById("totalSalary").value = '';
        document.getElementById("totalAdvance").value = '';
        document.getElementById("totalNetAmount").value = '';
    }
    
</script>

@endsection


