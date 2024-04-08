@extends('layout.laborer')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-speedometer2"></i> <span class="d-sm-inline fs-5 head">Dashboard</span>
    </div>

    <div class="mt-3 border border-subtle rounded">
        <div class="px-4 py-2 border-bottom">
            <span class="d-sm-inline fs-6 pe-2">Announcements</span><i class="fs-5 bi-megaphone"></i> 
        </div>
        <div style="height:100px" class="py-2 px-4">
            @if ($advanceRequest)
                <p class="fs-6">Your Advance Request of "{{ $advanceRequest->amount }}" about "{{ $advanceRequest->text }}" is Accepted. Kindly wait for your payroll.</p>
                <!-- Display other attributes as needed -->
            @else
                <p>No advance request found.</p>
            @endif
        </div>
    </div>
@endsection