@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-envelope"></i> <span class="head fs-5 d-sm-inline">Advance-Request | All</span>
    </div>
    
    <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">Status</span></th>
                        <th scope="col"><span class="bold text-nowrap">Request ID</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr data-url="{{ route('request.notif', $req->id) }}" class="clickable-row">
                        <td><span class="text-nowrap">{{ $req->status }}</span></td>
                        <td><span class="text-nowrap">{{ $req->id }}</span></td>
                        <td>
                            <span class="text-nowrap">
                                {{ $req->user->username }}
                            </span>
                        </td>
                        <td><span class="text-nowrap">{{ $req->created_at->diffForHumans() }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center my-5">
                            <i class="bi bi-box"></i>
                            <p class="no-text">No request yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
    </div>
    
    <div class="mt-1">
        {{ $requests->links('vendor.pagination.bootstrap-4') }}
    </div>
        
  
    
@endsection


