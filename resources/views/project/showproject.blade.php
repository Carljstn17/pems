@extends('layout.staff')

    @section('content')
        <div class="">
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
                                <th>
                                    <span class="d-none d-sm-inline">PR ID: {{ $project->project_id }}</span>
                                    <span class="d-sm-inline d-sm-none">Pr-id: {{ $project->project_id }}</span>
                                </th>
                                <th class="narrow-cell">
                                    <span class="d-none d-sm-inline">Date started: {{ $project->Date_started }}</span>
                                    <span class="d-sm-inline d-sm-none">Ds: {{ $project->Date_started }}</span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="d-none d-sm-inline">Location: {{ $project->location }}</span>
                                    <span class="d-sm-inline d-sm-none">Loc: {{ $project->location }}</span>
                                </th>
                                <th class="narrow-cell">
                                    <span class="d-none d-sm-inline">Date created: {{ $project->created_at->format('Y-m-d') }}</span>
                                    <span class="d-sm-inline d-sm-none">Dc: {{ $project->created_at->format('Y-m-d') }}</span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Receipt </td>
                                <td>{{ number_format($totalAmountsReceiptByProject[$project->id] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Total Payroll </td>
                                <td>{{ number_format($totalAmountsPayrollByProject[$project->id] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td>{{ number_format(round($totalAmountByProject, 2), 2) }}</td>
                            </tr>
                            <tr>
                                <td>Contract Price</td>
                                <td>{{ number_format($projectContract, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Difference</td>
                                <td style="{{ $colorStyle }}">-{{ number_format(round($totalAmountAndContractDifference, 2), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                    @if(Auth::user() && Auth::user()->id == $project->user_id)
                        <a href="#" class="btn btn-danger" onclick="confirmFinishProject('{{ url('finish-project', ['id' => $project->id]) }}')">Finish Project</a>
                    @endif
                    
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Other Information</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Client</td>
                                    <td>{{ $project->client }}</td>
                                </tr>
                                <tr>
                                    <td>Contact</td>
                                    <td>{{ $project->contact }}</td>
                                </tr>
                                <tr>
                                    <td>Created by</td>
                                    <td>
                                        @php
                                            $user = \App\Models\User::find($project->user_id);
                                            echo $user ? $user->username : 'User not found';
                                        @endphp
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <script>
                function confirmFinishProject(route) {
                    var confirmation = confirm('Are you sure you want to finish this project?');
        
                    if (confirmation) {
                        window.location.href = route; // Proceed with the route
                    }
                }
            </script>
@endsection
