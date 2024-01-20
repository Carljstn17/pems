@extends('layout.laborer')

    @section('content')
            <div class="mt-3">
                <a href="{{ url()->previous() }}" class="link-dark text-decoration-none">
                    <i class="fs-5 bi-backspace"> back</i>
                </a>
            </div>
                <div class="mx-auto mt-4 ">
                    <div class="table-responsive mx-auto">
                    <table class="table table-bordered table-rounded mx-auto">
                        <tbody class="table-light">
                            <tr>
                                <td>
                                    <span class="d-none d-sm-inline">Project ID: {{ $payrolls->project_id }}</span>
                                    <span class="d-sm-inline d-sm-none">PR-ID: {{ $payrolls->project_id }}</span>
                                </td>
                                <td class="narrow-cell">
                                    <span class="d-none d-sm-inline">Batch ID: {{ $payrolls->batch_id }}</span>
                                    <span class="d-sm-inline d-sm-none">B-ID: {{ $payrolls->batch_id }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="narrow-cell">
                                    <span class="d-none d-sm-inline">Created At: {{ \Carbon\Carbon::parse($payrolls->created_at)->format('Y-m-d') }}</span>
                                    <span class="d-sm-inline d-sm-none">{{ \Carbon\Carbon::parse($payrolls->created_at)->format('Y-m-d') }}</span>
                                </td>
                                <td class="narrow-cell">
                                    <span class="d-none d-sm-inline">Entry By: {{ $payrolls->entry_by }}</span>
                                    <span class="d-sm-inline d-sm-none">{{ $payrolls->entry_by }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    
                    <div class="table-responsive mx-auto">
                        <table class="table table-bordered table-rounded mx-auto">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rate per Day</td>
                                    <td>{{ number_format($payrolls->rate_per_day, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>No. of Day</td>
                                    <td>{{ $payrolls->no_of_days }}</td>
                                </tr>
                                <tr>
                                    <td>OT Hour</td>
                                    <td>{{ $payrolls->ot_hour ?? '0.00' }}</td>
                                </tr>
                                <tr>
                                    <td>OT Amount</td>
                                    <td>{{ number_format($payrolls->ot_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Salary</td>
                                    <td>{{ number_format($payrolls->salary, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Advance</td>
                                    <td>-{{ number_format($payrolls->advance_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Net Salary</td>
                                    <td>{{ number_format($payrolls->net_amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
     @endsection