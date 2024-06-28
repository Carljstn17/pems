<div>
    <p style="font-weight: bold;">G.B. GASPAR ARCHITECTURAL DESIGN SERVICES</p>
    <center></center>
    <p>{{ $estimates->first()->project->location }}</p>
    <p>{{ $user->contact }}</p>
    <p>{{ $user->email }}</p>
    <p>Purchase Order</p>
    <table>
        <thead>
            <tr>
                <td colspan="4"></td>
                <td style="text-align: right;">PO No.</td>
                <td>{{ $estimates->first()->group_id }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td style="text-align: right;">PO Date</td>
                <td>{{ now()->format('m-d-Y') }}</td>
            </tr>
            <tr>
                <td>Supplier</td>
                <td></td>
            </tr>
            <tr>
                <td>Address</td>
                <td></td>
            </tr>
            <tr>
                <td>Contact No.</td>
                <td></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td></td>
            </tr>
            <tr>
                <td>Ship To</td>
                <td></td>
            </tr>
        </thead>
    </table>
</div>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Description</th>
            <th>Unit Cost</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($estimates as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ number_format($data->quantity, 2, ',') }}</td>
                <td>{{ isset($data->uom) ? $data->uom : '' }}</td>
                <td>{{ isset($data->description) ? $data->description : '' }}</td>
                <td>{{ number_format($data->unit_cost, 2, ',') }}</td>
                <td>{{ number_format($data->getAmount(), 2, ',') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"></td> <!-- Add empty cells to span all columns -->
        </tr>
        <tr>
            <td colspan="4"></td>
            <td>Total Amount:</td>
            <td>{{ number_format($data->totalAmount($estimates), 2, ',') }}</td>
        </tr>

        <tr>
            <td colspan="2">Purpose:</td>
            <td colspan="4">{{ $estimates->first()->remarks }}</td>
        </tr>

        <tr>
            <td colspan="6"></td> <!-- Add empty cells to span all columns -->
        </tr>

        <tr>
            <td colspan="2">Prepared by:</td>
            <td colspan="2"></td>
            <td colspan="2">Approved By:</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td colspan="2"></td>
        </tr>
        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="2">{{ $estimates->first()->user->name }}</td>
            <td colspan="2"></td>
            <td colspan="2">GORDON B. GASPAR</td>
        </tr>
        <tr>
            <td colspan="2">{{ $estimates->first()->user->role }}</td>
            <td colspan="2"></td>
            <td colspan="2">Owner/Manager</td>
        </tr>
    </tfoot>
</table>

