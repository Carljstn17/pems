@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-chat-left-dots"></i> <span class="fs-5 head d-sm-inline">Concern | All</span>
    </div>
    
    <div class="mt-3 pb-1 px-3">
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">Request ID</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concerns as $concern)
                    <tr data-url="{{ route('concern.notif', $concern->id) }}" class="clickable-row">
                        <td><span class="text-nowrap">{{ $concern->id }}</span></td>
                        <td>
                            <span class="text-nowrap">
                                {{ $concern->user->username }}
                            </span>
                        </td>
                        <td><span class="text-nowrap">{{ $concern->created_at->diffForHumans() }}</span></td>
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
        {{ $concerns->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection


