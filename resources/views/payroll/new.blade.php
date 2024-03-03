@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-4">
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | New Entry</span>
        </div>
        
        <form action="{{ route('store.payroll') }}" method="post" class="pb-5">
            @csrf
            <div class="d-flex justify-content-between mb-2">
                <select name="project_id" id="project_id" class="form-select" style="width: 400px;" required>
                    <option value="">Select a project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->project_id }}
                            <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                        </option>
                    @endforeach
                </select>

                    <div class="input-group"  style="width: 200px;">
                        <label for="ot_rate" class="input-group-text"><span class="bold">OT-RATE</span></label>
                        <input type="text" id="otRate" class="form-control ot_rate" name="ot_rate" value="{{ number_format($ot_rate_default_value, 2) }}">
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
                    @foreach($laborers as $laborer)
                    <tr class="laborer-row">      
                        <td>1</td>
                        <td>
                            <input type="hidden" class="user_id" name="user_id[{{ $laborer->id }}]" value="{{ $laborer->id }}">
                            <input type="text" class="form-control no-border" name="name[{{ $laborer->id }}]" value="{{ $laborer->name }}" oninput="calculateAmount(this.parentElement.parentElement)" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control no-border" name="rate_per_day[{{ $laborer->id }}]" value="{{ number_format($laborer->payroll->rate_per_day, 2) }}" oninput="calculateAmount(this.parentElement.parentElement)" {{ isset($laborer->checklist) && !$laborer->checklist ? 'required' : '' }}>
                        </td>
                        <td><input type="number" class="form-control no-border" name="no_of_days[{{ $laborer->id }}]" oninput="calculateAmount(this.parentElement.parentElement)" {{ isset($laborer->checklist) && !$laborer->checklist ? 'required' : '' }}></td>
                        <td><input type="number" class="form-control no-border" name="ot_hour[{{ $laborer->id }}]" oninput="calculateAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="ot_total[{{ $laborer->id }}]" readonly></td>
                        <td><input type="number" class="form-control no-border salary" name="salary[{{ $laborer->id }}]" readonly></td>
                        <td>
                            <input type="text" class="form-control no-border advance_amount" value="{{ number_format(optional($laborer->advances())->amount, 2, '.', ',') }}" name="advance_amount[{{ $laborer->id }}]" data-bs-toggle="modal" data-bs-target="#advancesModal{{ $laborer->id }}" readonly>

                            @include('payroll.advance_modal', ['laborer' => $laborer])
                        </td>
                        <td><input type="number" class="form-control no-border net_salary" name="net_salary[{{ $laborer->id }}]" readonly></td>
                        <td><input type="checkbox" class="form-check-input" name="checklist[{{ $laborer->id }}]" checked onchange="toggleFields(this)"></td>
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
                        <td><input type="text" class="form-control no-border" id="total_salary" name="total_salary" readonly></td>
                        <td><input type="text" class="form-control no-border" id="total_advance" name="total_advance" readonly></td>
                        <td><input type="text" class="form-control no-border" id="total_net" name="total_net" readonly></td>
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
            function toggleFields(checkbox) {
                    let row = checkbox.closest('.laborer-row');
                    let inputs = row.querySelectorAll('.rate, .days, .ot, .ot_total, .salary, .advance_amount, .net_salary');
                    
                    inputs.forEach(input => {
                        if (!checkbox.checked) {
                            input.value = ""; // Clear the value if unchecked
                        }
                    });
                    updateAdvanceAmount();
                    updateTotalNetAmount();
                }
                

            
            document.addEventListener('DOMContentLoaded', function () {
                var allCheckboxes = document.querySelectorAll('.checklist');
                var inputFields = document.querySelectorAll('.advance_amount');
                var total_advanceInput = document.getElementById('total_advance');

                allCheckboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        updateAdvanceAmount();
                        updateTotalNetAmount();
                    });
                });

                function updateAdvanceAmount() {
                    var totalAmount = 0;

                    inputFields.forEach(function (inputField) {
                        var checklistElement = inputField.parentElement.querySelector('.checklist');

                        // Add a check to ensure checklistElement is not null
                        if (checklistElement) {
                            var laborerId = checklistElement.dataset.laborerId;
                            var checkedAmount = 0;

                            allCheckboxes.forEach(function (checkbox) {
                                if (checkbox.checked && checkbox.dataset.laborerId === laborerId) {
                                    checkedAmount += parseFloat(checkbox.dataset.amount);
                                }
                            });

                            inputField.value = isNaN(checkedAmount) ? '0.00' : checkedAmount.toFixed(2);
                            totalAmount += checkedAmount;
                        }
                    });

                    total_advanceInput.value = isNaN(totalAmount) ? '0.00' : totalAmount.toFixed(2);
                }
            });
        </script>

        <script>

    function calculateAmount(row) {
        var userId = row.getElementsByClassName("user_id")[0].value;
        const ratePerDayInput = row.querySelector('[name="rate_per_day['+ userId +']"]');
        const noOfDaysInput = row.querySelector('[name="no_of_days['+ userId +']"]');
        const otRateInput = document.getElementById('otRate');;
        const otHoursInput = row.querySelector('[name="ot_hour['+ userId +']"]');
        const otTotalField = row.querySelector('[name="ot_total['+ userId +']"]');


        const ratePerDay = parseFloat(ratePerDayInput.value) || 0;
        const noOfDays = parseFloat(noOfDaysInput.value) || 0;
        const otRate = parseFloat(otRateInput.value) || 0;
        const otHours = parseFloat(otHoursInput.value) || 0;

        const ratePerHour = ratePerDay / noOfDays;
        const otAmountPerHour = ratePerHour * otRate;
        const otTotal = otAmountPerHour * otHours;

        otTotalField.value = otTotal.toFixed(2);

        // Update the salary including ot_total
        const amountField = row.querySelector('[name="salary['+ userId +']"]');
        const amount = ratePerDay * noOfDays + otTotal;
        amountField.value = amount.toFixed(2);

        updateTotalSalary(userId);
    }



    function updateTotalSalary(userId) {
        const totalAmountField = document.getElementById("total_salary");
        const amountFields = document.getElementsByClassName('salary');

        const totalAmount = Array.from(amountFields).reduce((acc, field) => acc + (parseFloat(field.value) || 0), 0);
        totalAmountField.value = totalAmount.toFixed(2);

        // Update Total Advance
        updatetotal_advance(userId);

        // Update Total Net Amount
        updateTotalNetAmount(userId);
    }
    
    function updatetotal_advance(userId) {
        var total_advanceField = document.getElementById("total_advance");
        var advanceFields = document.getElementsByClassName('advance_amount');

        var total_advance = Array.from(advanceFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

        total_advanceField.value = total_advance.toFixed(2);
    }

    function updateTotalNetAmount(userId) {
        var totalNetAmountField = document.getElementById("total_net");
        var salaryFields = document.getElementsByClassName('salary');
        var advanceFields = document.getElementsByClassName('advance_amount');
        var netAmountFields = document.getElementsByClassName('net_salary');

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
        var inputs = document.querySelectorAll(' input[name^="no_of_days[]"], input[name^="ot[]"], input[name^="ot_total[]"], input[name^="salary[]"], input[name^="advance_amount[]"], input[name^="net_salary[]"], input[name^="ot_hour[]"]');
        inputs.forEach(function (input) {
            input.value = '';
        });

        document.getElementById("totalRate").value = '';
        document.getElementById("total_salary").value = '';
        document.getElementById("total_advance").value = '';
        document.getElementById("total_net").value = '';
    }
    
</script>

@endsection


