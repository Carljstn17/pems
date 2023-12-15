@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 mb-3">
        <i class="fs-5 bi-wallet"></i> <span class=" d-sm-inline">Payroll | Advance Form</span>
    </div>

    <form action="{{ url('/payroll/advances') }}" method="post" class="pb-5" id="advanceForm">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1">NO.</th>
                    <th>NAME</th>
                    <th class="col-md-3">Advance</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <select class="form-select no-border px-2" name="user_id[]">
                                <option value="">Select a laborer</option>
                                @foreach($laborers as $laborer)
                                    <option value="{{ $laborer->id }}">
                                        {{ $laborer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control no-border advance-input" name="amount[]">
                        </td>
                    </tr>
                @endfor
            </tbody>

            <tfoot> 
                <tr>
                    <td colspan="2" class="text-end"><strong>TOTAL Advance:</strong></td>
                    <td>
                        <input type="text" class="form-control no-border" name="totalAdvance" id="totalAdvance" readonly>
                    </td>
                </tr>
            </tfoot>
        </table>

        <button type="submit" class="btn btn-primary float-end">Submit</button>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener to update total whenever advances change
            document.getElementById('advanceForm').addEventListener('input', function () {
                updateTotal();
            });
    
            function updateTotal() {
                var rows = document.querySelectorAll('tbody tr');
                var overallTotal = 0;
    
                rows.forEach(function (row, rowIndex) {
                    var advanceInput = row.querySelector('.advance-input');
                    var userId = document.getElementsByName('user_id[]')[rowIndex].value;
    
                    // Only add the advance to the overall total if a user is selected
                    if (userId !== '') {
                        var rowTotal = parseFloat(advanceInput.value) || 0;
                        overallTotal += rowTotal;
                    }
                });
    
                document.getElementById('totalAdvance').value = overallTotal.toFixed(2);
            }
        });
    </script>

@endsection