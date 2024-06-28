@extends('layout.laborer')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-speedometer2"></i> <span class="d-sm-inline fs-5 head">Dashboard</span>
    </div>

    <div class="mt-3 border border-subtle rounded">
        <div class="px-4 py-2 border-bottom">
            <span class="d-sm-inline head pe-2">Announcements</span><i class="fs-5 bi-megaphone"></i> 
        </div>
        <div style="height:100%" class="py-2 px-4">
            @if ($advanceRequest)
                <div>Advance Request :</div>
                <div class="fs-6 mb-2 ps-3">Your Advance Request of <span class="text-success fs-6">"{{ $advanceRequest->amount }}"</span> about <span class="text-success fs-6">"{{ $advanceRequest->text }}"</span> is Accepted. This is Accepted by <span class="text-success fs-6">{{ $advanceRequest->accepted->fname }} {{ $advanceRequest->accepted->mname }} {{ $advanceRequest->accepted->lname }}</span>. 
                Kindly wait for your payroll. ( {{ ($advanceRequest->created_at)->format('y-m-d') }} )</div>
                <!-- Display other attributes as needed -->
            @else
                <p>No advance request found.</p>
            @endif
            
            @if ($payrollNotif )
                <div>Payroll :</div>
                <div class="fs-6 mb-2 ps-3">Your have new payroll. Your total Advance is <span class="text-success fs-6">"{{ $payrollNotif->advance_amount }}"</span>. Your total Salary is <span class="text-success fs-6">"{{ $payrollNotif->salary }}"</span>. 
                Your total Net-Salary is <span class="text-success fs-6">"{{ $payrollNotif->net_amount }}"</span>. ( {{ $formattedDate }} ) </div>
            @endif
            
            @if ($advanceNotif)
                <p class="fs-6">Your advance is already payrolled. Your total advance is <span class="text-success fs-6">"{{ $advanceNotif->amount }}"</span>. ( {{ ($advanceNotif->created_at)->format('y-m-d') }} )</p>
            @endif
        </div>
    </div>
@endsection