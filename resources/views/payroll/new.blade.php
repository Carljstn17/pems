@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2 mb-3">
            <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | New Entry</span>
        </div>
        
        <form action="/action_page.php" method="post" class="pb-5">

            <div class="">
                <select name="project_id" id="project_id" class="form-select col col-md-2 col-sm-6 mb-1">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->project_id }}
                            <span>&nbsp;|&nbsp; {{ $project->project_dsc }}</span>
                        </option>
                    @endforeach
                </select>
            </div>

            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="col-md-2">NAME</th>
                        <th>RATE PER DAY</th>
                        <th>NO. OF DAYS</th>
                        <th>OT</th>
                        <th>OT TOTAL</th>
                        <th>AMOUNT</th>
                        <th>ADVANCES</th>
                        <th>NET AMOUNT</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <select class="form-select no-border px-2" name="selectedLaborer[]" value="{{ old('selectedLaborer') }}">
                                @foreach($laborers as $laborer)
                                    <option value="{{ $laborer->id }}">
                                        {{ Str::limit($laborer->name, 14) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" class="form-control no-border" name="rate_per_day[]" oninput="calculateAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="no_of_days[]" oninput="calculateAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="ot[]"></td>
                        <td><input type="number" class="form-control no-border" name="ot_total[]"></td>
                        <td><input type="number" class="form-control no-border" name="amount[]" readonly></td>
                        <td><input type="number" class="form-control no-border" name="advances[]" oninput="updateNetAmount(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="form-control no-border" name="net_amount[]" readonly></td>
                    </tr>
                </tbody>
        
                <tfoot> 
                    <tr>
                        <td colspan="2"><strong>TOTAL</strong></td>
                        <td><input type="text" class="form-control no-border" id="totalRate" name="totalRate" readonly></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control no-border" id="totalAmount" name="totalAmount" readonly></td>
                        <td><input type="text" class="form-control no-border" id="totalAdvance" name="totalAdvance" readonly></td>
                        <td><input type="text" class="form-control no-border" id="totalNetAmount" name="totalNetAmount" readonly></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" onclick="addRow()">+ Add Row</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger justify-content-end" onclick="clearForm()">Clear</button>
            </div>    
        
        </form>



        <!-- The form remains the same -->

<script>
       for (var i = 0; i < 9; i++) {
                addRow();
            }
            function addRow() {
        var table = document.getElementById("dataTable");
        var newRow = table.getElementsByTagName('tbody')[0].insertRow(-1);
        
        var cellNum = newRow.insertCell(0);
        cellNum.innerHTML = table.rows.length;
        
        var cellName = newRow.insertCell(1);
        cellName.innerHTML = `<select class="form-select no-border px-2" name="selectedLaborer[]" value="{{ old('selectedLaborer') }}">
                                @foreach($laborers as $laborer)
                                    <option value="{{ $laborer->id }}">
                                        {{ Str::limit($laborer->name, 14) }}
                                    </option>
                                @endforeach
                            </select>`;
        
        var cellRate = newRow.insertCell(2);
        cellRate.innerHTML = '<input type="number" class="form-control no-border" name="rate_per_day[]" oninput="calculateAmount(this.parentElement.parentElement)">';
        
        var cellDays = newRow.insertCell(3);
        cellDays.innerHTML = '<input type="number" class="form-control no-border" name="no_of_days[]" oninput="calculateAmount(this.parentElement.parentElement)">';
        
        var cellOT = newRow.insertCell(4);
        cellOT.innerHTML = '<input type="number" class="form-control no-border" name="ot[]" oninput="calculateOTTotal(this.parentElement.parentElement)">';
        
        var cellOTTotal = newRow.insertCell(5);
        cellOTTotal.innerHTML = '<input type="number" class="form-control no-border" name="ot_total[]" readonly>';
        
        var cellAmount = newRow.insertCell(6);
        cellAmount.innerHTML = '<input type="number" class="form-control no-border" name="amount[]" readonly>';
        
        var cellAdvances = newRow.insertCell(7);
        cellAdvances.innerHTML = '<input type="number" class="form-control no-border" name="advances[]" oninput="updateNetAmount(this.parentElement.parentElement)">';
        
        var cellNetAmount = newRow.insertCell(8);
        cellNetAmount.innerHTML = '<input type="number" class="form-control no-border" name="net_amount[]" readonly>';

        updateTotalAmount();
    }

    function calculateAmount(row) {
        var ratePerDay = row.querySelector('[name="rate_per_day[]"]').value;
        var noOfDays = row.querySelector('[name="no_of_days[]"]').value;
        var amountField = row.querySelector('[name="amount[]"]');

        var amount = ratePerDay * noOfDays;
        amountField.value = amount.toFixed(2);

        updateTotalAmount();
    }

    // function calculateOTTotal(row) {
    //     var ot = row.querySelector('[name="ot[]"]').value;
    //     var otTotalField = row.querySelector('[name="ot_total[]"]');
        
    //     var otTotal = ot * 1.5; // Assuming OT Total is 1.5 times OT
    //     otTotalField.value = otTotal.toFixed(2);

    //     updateTotalAmount();
    // }

    function updateNetAmount(row) {
        var amount = parseFloat(row.querySelector('[name="amount[]"]').value) || 0;
        var advances = parseFloat(row.querySelector('[name="advances[]"]').value) || 0;
        var netAmountField = row.querySelector('[name="net_amount[]"]');
        
        var netAmount = amount - advances;
        netAmountField.value = netAmount.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        var totalAmountField = document.getElementById("totalAmount");
        var amountFields = document.getElementsByName("amount[]");

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
        var advanceFields = document.getElementsByName("advances[]");

        var totalAdvance = Array.from(advanceFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

        totalAdvanceField.value = totalAdvance.toFixed(2);
    }

    function updateTotalNetAmount() {
        var totalNetAmountField = document.getElementById("totalNetAmount");
        var netAmountFields = document.getElementsByName("net_amount[]");

        var totalNetAmount = Array.from(netAmountFields).reduce(function (acc, field) {
            return acc + (parseFloat(field.value) || 0);
        }, 0);

        totalNetAmountField.value = totalNetAmount.toFixed(2);
    }

    function clearForm() {
        var inputs = document.querySelectorAll('input[name^="name[]"], input[name^="rate_per_day[]"], input[name^="no_of_days[]"], input[name^="ot[]"], input[name^="ot_total[]"], input[name^="amount[]"], input[name^="advances[]"], input[name^="net_amount[]"]');
        inputs.forEach(function (input) {
            input.value = '';
        });

        document.getElementById("totalRate").value = '';
        document.getElementById("totalAmount").value = '';
        document.getElementById("totalAdvance").value = '';
        document.getElementById("totalNetAmount").value = '';
    }
</script>

@endsection


