{{-- edit.blade.php --}}

@extends('layouts.app') {{-- Assuming you have a layout --}}

@section('content')
    <div class="container mt-5">
        <h1>Edit Estimate</h1>
        
        <form action="{{ route('estimates.update', $estimate) }}" method="post">
            @csrf
            @method('put')

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>UOM</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="description" value="{{ old('description', $estimate->description) }}" class="form-control"></td>
                        <td><input type="text" name="uom" value="{{ old('uom', $estimate->uom) }}" class="form-control"></td>
                        <td><input type="number" name="quantity" value="{{ old('quantity', $estimate->quantity) }}" class="form-control" oninput="calculateAmount(this)"></td>
                        <td><input type="number" name="unit_cost" value="{{ old('unit_cost', $estimate->unit_cost) }}" class="form-control" oninput="calculateAmount(this)"></td>
                        <td><input type="text" name="amount" value="{{ old('amount', $estimate->amount) }}" class="form-control" readonly></td>
                        <td><input type="text" name="total_amount" value="{{ old('total_amount', $estimate->group->total_amount) }}" class="form-control" readonly></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Update Estimate</button>
        </form>
    </div>

    <script>
        function calculateAmount(input) {
            var row = $(input).closest("tr");
            var quantity = parseFloat(row.find("input[name='quantity']").val()) || 0;
            var unitCost = parseFloat(row.find("input[name='unit_cost']").val()) || 0;
            var amount = quantity * unitCost;

            row.find("input[name='amount']").val(amount.toFixed(2));

            // Update total_amount
            updateTotalAmount();
        }

        function updateTotalAmount() {
            var quantity = parseFloat($("input[name='quantity']").val()) || 0;
            var unitCost = parseFloat($("input[name='unit_cost']").val()) || 0;
            var totalAmount = quantity * unitCost;

            $("input[name='total_amount']").val(totalAmount.toFixed(2));
        }
    </script>
@endsection
