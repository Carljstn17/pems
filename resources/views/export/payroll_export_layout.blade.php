<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <p colspan="10">G.B. GASPAR ARCHITECTURAL DESIGN SERVICES</p>
    <p colspan="10">PAYROLL</p>
    <p colspan="10">{{ $batch->created_at->format('M-d-Y') }}</p>
    <p></p>
    <table>
        <thead>
            <tr>
                <th colspan="2"><b>Project Title</b></th>
                <td>{{ $batch->project->project_dsc }}</td>
            </tr>
            <tr>
                <th colspan="2"><b>Owner</b></th>
                <td>{{ $batch->project->client }}</td>
            </tr>
            <tr>
                <th colspan="2"><b>Location</b></th>
                <td>{{ $batch->project->location }}</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th><b>NO.</b></th>
                <th><b>NAME</b></th>
                <th><b>RATE/DAY</b></th>
                <th><b>DAYS</b></th>
                <th><b>OT-HOUR</b></th>
                <th><b>OT-TOTAL</b></th>
                <th><b>SALARY</b></th>
                <th><b>ADVANCE</b></th>
                <th><b>NET $</b></th>
                <td><b>SIGNATURE</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($payrolls as $index => $payroll)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payroll->name }}</td>
                    <td>{{ number_format($payroll->rate_per_day, 2) }}</td>
                    <td>{{ $payroll->no_of_days }}</td>
                    <td>{{ number_format($payroll->ot_hour, 2) }}</td>
                    <td>{{ number_format($payroll->ot_amount, 2) }}</td>
                    <td>{{ number_format($payroll->salary, 2) }}</td>
                    <td>{{ number_format($payroll->advance_amount, 2) }}</td>
                    <td>{{ number_format($payroll->net_amount, 2) }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td class="bold">TOTAL:</td>
                <td colspan="4"></td>
                <td>{{ number_format($batch->total_salary, 2) }}</td>
                <td>{{ number_format($batch->total_advance, 2) }}</td>
                <td>{{ number_format($batch->total_net, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    
</body>
</html>
