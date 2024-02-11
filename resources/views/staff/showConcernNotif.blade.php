@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Advance-Request | {{ $concerns->id }}</span>
            </div>
            
            <div class="py-2 mt-3">
                <div class="card">
                    <div class="card-header text-center">
                        <p class="fs-5">Request by: {{ $concerns->user->username }}</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <textarea class="form-control" name="concern" rows="14" style="resize: none"; readonly>{{ $concerns->concern }}</textarea>
                        </div>
                        <div class="float-end">
                            <a href="" class="btn btn-outline-primary"><i class="bi bi-send"></i> Accept Concern</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection


