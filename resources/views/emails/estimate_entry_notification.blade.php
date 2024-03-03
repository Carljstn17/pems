@component('mail::message')
<h1 style="text-align: center;">
    # New Estimate Entry
</h1>

@component('mail::table')
| Status | Entry ID | Entry by | Entry date |
|--------|----------|----------|------------|
| {!! $status !!} | {!! $entryId !!} | {!! $entryBy !!} | {!! $entryDate !!} |
@endcomponent

@component('mail::table')
| No | Description | UOM | Quantity | Unit-Cost | Amount |
|----|-------------|-----|----------|-----------|--------|
@foreach($estimates as $estimate)
| {{ $loop->iteration }} | {{ $estimate->description ?? 'N/A' }} | {{ $estimate->uom ?? 'N/A' }} | {{ number_format($estimate->quantity, 2, '.', ',') }} | {{ number_format($estimate->unit_cost, 2, '.', ',') }} | {{ number_format($estimate->getAmount() ?? 0, 2) }} |
@endforeach
@endcomponent

@component('mail::panel')
**Remarks**: {{ $remarks }}
@endcomponent

@component('mail::button', ['url' => route('owner.estimateShow', ['group_id' => $estimate->group_id]), 'color' => 'success'])
            Show Estimate
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
