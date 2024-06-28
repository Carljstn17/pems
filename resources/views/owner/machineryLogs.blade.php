@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <div class="d-flex align-items-center">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Machinery | Logs</span>
            </div>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between">
                <a href="{{ route('owner.machinery') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                
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
                    <tr>
                        <td><span class="bold">Property</span></td>
                        <td><span class="bold">Status</span></td>
                        <td><span class="bold">Whereabout</span></td>
                        <td><span class="bold">Updated&nbspAt</span></td>
                        <td><span class="bold">Updated&nbspBy</span></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machineryLogs as $log) 
                            <tr>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->machineryLog->machinery_type }}">{{ $log->machineryLog->property }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->status }}">{{ $log->status }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->whereabout }}">{{ $log->whereabout }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->updated_at }}">{{ $log->updated_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $log->user->username }}">{{ $log->user->username }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-1 float-end">
            {{ $machineryLogs->links('vendor.pagination.bootstrap-4') }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
@endsection

