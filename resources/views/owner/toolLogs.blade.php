@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Tools | All Tools</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-end gap-2">
                <form action="" method="GET" class="">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table table-responsive mt-3 px-2">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <td><span class="bold">Property</span></td>
                        <td><span class="bold">Tool&nbspName</span></td>
                        <td><span class="bold">Status</span></td>
                        <td><span class="bold">Whereabout</span></td>
                        <td><span class="bold">Updated&nbspAt</span></td>
                        <td><span class="bold">Updated&nbspBy</span></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($toolLogs as $log) 
                            <tr>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->toolLog->tool_type }}">{{ Str::limit($log->toolLog->tool_type, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->toolLog->tool_name }}">{{ Str::limit($log->toolLog->tool_name, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->status }}">{{ Str::limit($log->status, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->whereabout }}">{{ Str::limit($log->whereabout, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->updated_at }}">{{ Str::limit($log->updated_at->format('Y-m-d H:i:s'), 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->user->username }}">{{ Str::limit($log->user->username, 8) }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-1 float-end">
            {{ $toolLogs->links('vendor.pagination.bootstrap-4') }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
@endsection

