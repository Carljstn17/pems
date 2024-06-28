@extends('layout.staff')

    @section('content')
        <Style>
            a {
                cursor: pointer;
            }
        </Style>
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline fs-5 head">Payroll | Latest Entries</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <div>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#projectModal">
                        <span><i class="bi bi-plus"></i> Create New Payroll</span>
                    </button>

                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createAdvanceModal" style="transition:0.8s;">
                        <span class="d-none d-sm-inline"><i class="bi bi-plus"></i> Advance</span>
                    </button>
                    <a href="{{ route('invalidList') }}" class="btn btn-outline-danger">
                        <i class="bi bi-clipboard2-x"></i>
                    </a>
                </div>

                <form action="{{ route('search.payroll') }}" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @include('payroll.advance')

        <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">P-Batch</span></th>
                        <th scope="col"><span class="bold text-nowrap">Project Description</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Status</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrollBatch as $batches)
                    <tr data-url="{{ route('show.payroll', ['batchId' => $batches->id]) }}" class="clickable-row">
                        <td><span class="text-nowrap">{{ $batches->id }}</span></td>
                        <td><span class="text-nowrap">{{ $batches->project->project_dsc }}</span></td>
                        <td>
                            <span class="text-nowrap">
                                {{ $batches->entry->username }}
                            </span>
                        </td>
                        <td><span class="text-nowrap">{{ $batches->status }}</span></td>
                        <td><span class="text-nowrap">{{ $batches->updated_at->diffForHumans() }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center my-5">
                            <i class="bi bi-box"></i>
                            <p class="no-text">No payrolls yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="px-3 d-flex justify-content-between">
            <div class="d-flex justify-content-start gap-3">
                <a href="{{ route('on.payroll') }}" class="text-decoration-none text-secondary fst-italic mt-2">/Payroll for On-Going Projects</a>
                <a href="{{ route('advance') }}" class="text-decoration-none text-secondary fst-italic mt-2">/Advance list</a>
            </div>
            
            {{ $payrollBatch->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">Select Project to Payroll</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="projectForm" method="POST" action="{{ route('submit.project') }}">
                    @csrf
                        <div class="input-group">
                            <label for="project_id" class="input-group-text">Project</label>
                            <select name="project_id" id="project_id" class="form-select" required>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->project_id }}&nbsp;-&nbsp;{{ $project->project_dsc }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" form="projectForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
 
@endsection

