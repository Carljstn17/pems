<div>
    <p colspan="6">G.B. GASPAR ARCHITECTURAL DESIGN SERVICES</p>
    <p colspan="6">{{ $estimates->first()->project->location }}</p>
    <p colspan="6">{{ $user->contact }}</p>
    <p colspan="6">{{ $user->email }}</p>
    <p colspan="6">Purchase Order</p>
    <table>
        <thead>
            <tr>
                <td colspan="4"></td>
                <td>PO No.</td>
                <td>{{ $estimates->first()->group_id }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>PO Date</td>
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
            <th><b>No</b></th>
            <th><b>Quantity</b></th>
            <th><b>Unit</b></th>
            <th><b>Description</b></th>
            <th><b>Unit Cost</b></th>
            <th><b>Amount</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($estimates as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><span>{{ number_format($data->quantity, 2, ',') }}</span></td>
                <td>{{ isset($data->uom) ? $data->uom : '' }}</td>
                <td>{{ isset($data->description) ? $data->description : '' }}</td>
                <td><span>{{ number_format($data->unit_cost, 2, ',') }}</span></td>
                <td><span>{{ number_format($data->getAmount(), 2, ',') }}</span></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"></td> <!-- Add empty cells to span all columns -->
        </tr>
        <tr>
            <td colspan="4"></td>
            <td ><strong>Total Amount:</strong></td>
            <td>
                <span >{{ number_format($data->totalAmount($estimates), 2, ',') }}</span>    
            </td>
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
