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
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $project->id }}">
                            Finish Project
                        </button>
                    @endif

                    <div class="modal fade" id="confirmationModal{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to finish this project <span class="bold">"{{ $project->project_id }}"</span> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" onclick="proceedFinishProject('{{ url('finish-project', ['id' => $project->id]) }}')">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                 function proceedFinishProject(route) {
                    window.location.href = route; // Proceed with the route
                }
            </script>
@endsection
