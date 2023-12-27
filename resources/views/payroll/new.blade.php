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

                <a class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createOtRateModal" style="transition: 0.8s;">
                    <span class="d-none d-sm-inline"><i class="bi bi-plus"></i> OT Rate</span>
                </a>
            </div>

            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="col-md-2">NAME</th>
                        <th>RATE/   DAY</th>
                        <th>DAYS</th>
                        <th>OT</th>
                        <th>OT TOTAL</th>
                        <th>SALARY</th>
                        <th>ADVANCES</th>
                        <th>NET AMOUNT</th>
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
                        <input type="hidden" class="form-control no-border" name="rate_per_hour[]">
                        <input type="hidden" class="form-control no-border" name="ot_amount_per_hour[]">
                        <td><input type="number" class="form-control no-border" name="ot_hour[]"></td>
                        <td><input type="number" class="form-control no-border" name="ot_total[]" readonly></td>
                        <td><input type="number" class="form-control no-border" name="salary[]" readonly></td>
                        <td>
                            <input type="text" class="form-control no-border" value="{{ number_format(optional($laborer->advances())->amount, 2, '.', ',') }}" name="advances_id[]" oninput="updateNetAmount(this.parentElement.parentElement)" data-bs-toggle="modal" data-bs-target="#advancesModal" readonly>

                            @include('payroll.advance_modal')
                        </td>
                        <td><input type="number" class="form-control no-border" name="net_amount[]" readonly></td>
                        <td><input type="checkbox" class="form-check-input" name="checklist[]" checked></td>
                    </tr>
                    @endforeach
                </tbody>
        
                <tfoot> 
                    <tr>
                        <td colspan="2" class="text-end"><strong>TOTAL : </strong></td>
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

        @include('payroll.create_ot_rate')
        <!-- The form remains the same -->

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
        var ratePerDay = row.querySelector('[name="rate_per_day[]"]').value;
        var noOfDays = row.querySelector('[name="no_of_days[]"]').value;
        var amountField = row.querySelector('[name="salary[]"]');

        var amount = ratePerDay * noOfDays;
        amountField.value = amount.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        var totalAmountField = document.getElementById("totalSalary");
        var amountFields = document.getElementsByName("salary[]");

        var totalAmount = Array.from(amountFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

        totalAmountField.value = totalAmount.toFixed(2);

        // Update Total Rate
        var totalRateField = document.getElementById("totalRate");
        var rateFields = document.getElementsByName("rate_per_day[]");

        var totalRate = Array.from(rateFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

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


