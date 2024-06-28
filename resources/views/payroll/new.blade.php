@extends('layout.staff')

    @section('content')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
        <div class="py-2 mt-2 mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('latest.payroll') }}" class="text-secondary text-decoration-none btn">
                            <i class="fs-5 bi-backspace"></i>
                </a>
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline fs-5 head">Payroll | New Entry</span>
            </div>
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
        
        <form action="{{ route('store.payroll') }}" method="post" class="pb-5">
            @csrf
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <div class="input-group"  style="width: 400px;">
                        <label for="ot_rate" class="input-group-text"><span class="bold">Project</span></label>
                        <input type="hidden" name="project_id" value="{{ $projectId }}">
                        <input type="text" class="form-control" value="{{ $project->project_id }} {{ $project->project_dsc }}">
                         @error('project_id')
                                <div class="text-danger px-2 ">{{ $message }}</div>
                        @enderror
                    </div>  
                </div>
                
                <div class="input-group"  style="width: 200px;">
                    <label for="ot_rate" class="input-group-text"><span class="bold">OT-RATE</span></label>
                    <input type="text" id="otRate" class="form-control ot_rate numberInput @error('ot_rate') border-red @enderror" name="ot_rate" value="{{ number_format($ot_rate_default_value, 2) }}">
                    @error('ot_rate')
                            <div class="text-danger px-2 ">{{ $message }}</div>
                    @enderror
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
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <input type="hidden" class="user_id" name="user_id[{{ $laborer->id }}]" value="{{ $laborer->id }}">
                            <input type="text" class="form-control no-border" name="name[{{ $laborer->id }}]" value="{{ $laborer->fname }} {{ $laborer->mname }} {{ $laborer->lname }}" oninput="calculateAmount(this.parentElement.parentElement)" readonly>
                            @error('name')
                                <div class="text-danger px-2">*</div>
                            @enderror
                        </td>
                        <td>
                            <input type="number" class="form-control no-border numberInput  @error('rate_per_day') border-red @enderror" name="rate_per_day[{{ $laborer->id }}]" value="{{ number_format($laborer->payroll->rate_per_day, 2) }}" oninput="calculateAmount(this.parentElement.parentElement)" {{ isset($laborer->checklist) && !$laborer->checklist ? 'required' : '' }}>
                            @error('rate_per_day')
                                <div class="text-danger px-2">*</div>
                            @enderror
                        </td>
                        <td class="text-nowrap">
                            <input type="number" class="form-control no-border d-inline-block days numberInput @error('no_of_days.' . $laborer->id) border-red @enderror" name="no_of_days[{{ $laborer->id }}]" oninput="calculateAmount(this.parentElement.parentElement)" value="{{ old('no_of_days.' . $laborer->id ) }}" {{ isset($laborer->checklist) && !$laborer->checklist ? 'required' : '' }}>
                            @error('no_of_days.' . $laborer->id)
                                <div class="text-danger d-inline-block">*</div>
                            @enderror
                        </td>
                        <td class="d-flex align-items-center ">
                            <input type="number" class="form-control ot no-border me-2 numberInput  @error('ot_hour.' . $laborer->id) border-red @enderror" name="ot_hour[{{ $laborer->id }}]" value="{{ old('ot_hour.' . $laborer->id ) }}" oninput="calculateAmount(this.parentElement.parentElement)">
                            @error('ot_hour.' . $laborer->id)
                                <div class="text-danger px-2">*</div>
                            @enderror
                        </td>
                        <td>
                            <input type="number" class="form-control no-border ot_total" name="ot_total[{{ $laborer->id }}]" value="{{ old('ot_total.' . $laborer->id ) }}" readonly>
                        </td>
                        <td class="text-nowrap">
                            <input type="number" class="form-control no-border salary d-inline-block" name="salary[{{ $laborer->id }}]" value="{{ old('salary.' . $laborer->id ) }}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control no-border advance_amount" value="{{ number_format(optional($laborer->advances())->amount, 2, '.', ',') }}" name="advance_amount[{{ $laborer->id }}]" data-bs-toggle="modal" data-bs-target="#advancesModal{{ $laborer->id }}" readonly>

                            @include('payroll.advance_modal', ['laborer' => $laborer])
                        </td>
                        <td>
                            <input type="number" class="form-control no-border net_amount" name="net_amount[{{ $laborer->id }}]" value="{{ old('net_amount.' . $laborer->id ) }}" readonly>
                        </td>
                        <td><input type="checkbox" class="form-check-input" name="checklist[{{ $laborer->id }}]" {{ old('checklist.' . $laborer->id) ? 'checked' : '' }} {{ $errors->any() ? '' : 'checked' }} onchange="toggleFields(this)"></td>
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
                        <td><input type="text" class="form-control no-border" id="total_salary" name="total_salary" value="{{ old('total_salary') }}" readonly></td>
                        <td><input type="text" class="form-control no-border" id="total_advance" name="total_advance" value="{{ old('total_advance') }}" readonly></td>
                        <td><input type="text" class="form-control no-border" id="total_net" name="total_net" value="{{ old('total_net') }}" readonly></td>
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
                    let inputs = row.querySelectorAll('.rate, .days, .ot, .ot_total, .salary, .advance_amount, .net_amount');
                    
                    inputs.forEach(input => {
                        if (checkbox.checked) {
                            input.removeAttribute('disabled'); // Enable the input
                        } else {
                            input.value = ""; // Clear the value
                            input.setAttribute('disabled', 'disabled'); // Disable the input
                        }
                    });
                    updateTotalSalary()
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
        var netAmountFields = document.getElementsByClassName('net_amount');

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
        var inputs = document.querySelectorAll(' input[name^="no_of_days[]"], input[name^="ot[]"], input[name^="ot_total[]"], input[name^="salary[]"], input[name^="advance_amount[]"], input[name^="net_amount[]"], input[name^="ot_hour[]"]');
        inputs.forEach(function (input) {
            input.value = '';
        });

        document.getElementById("totalRate").value = '';
        document.getElementById("total_salary").value = '';
        document.getElementById("total_advance").value = '';
        document.getElementById("total_net").value = '';
    }
    
    $('.numberInput').on('change keyup', function() {
      // Remove invalid characters
      var sanitized = $(this).val().replace(/[^0-9]/g, '');
      // Update value
      $(this).val(sanitized);
    });
</script>

@endsection


