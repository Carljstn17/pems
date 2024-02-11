@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2 border-bottom border-subtle pb-3">
        <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Concern | All</span>
    </div>
    
    <div class="p-2 mt-3">
        @forelse ($concerns as $concern)
                <a href="{{ route('concern.notif', $concern->id) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col">
                            <span class="bold">Status: &nbsp</span>{{ $concern->status }}
                        </div>
                        <div class="col">
                            <span class="bold">Concern ID: &nbsp</span>{{ $concern->id }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry By: &nbsp</span>{{ $concern->user->username }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry Date: &nbsp</span>{{ $concern->created_at->diffForHumans() }}
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
                {{ $concerns->links('vendor.pagination.bootstrap-4') }}
            </div>
    </div>
@endsection


