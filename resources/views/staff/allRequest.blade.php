@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 border-bottom border-subtle pb-3">
        <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Advance-Request | All</span>
    </div>
    
    <div class="p-2 mt-3">
        @forelse ($requests as $req)
                <a href="{{ route('request.notif', $req->id) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col">
                            <span class="bold">Status: &nbsp</span>{{ $req->status }}
                        </div>
                        <div class="col">
                            <span class="bold">Request ID: &nbsp</span>{{ $req->id }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry By: &nbsp</span>{{ $req->user->username }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry Date: &nbsp</span>{{ $req->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
            <div class="text-center my-5">
                <i class="bi bi-box"></i>
                <p class="no-text">No receipts yet.</p>
            </div>
            @endforelse

            <div class="mt-1">
                {{ $requests->links('vendor.pagination.bootstrap-4') }}
            </div>
    </div>
@endsection


