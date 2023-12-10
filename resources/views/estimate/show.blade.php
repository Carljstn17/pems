<x-base2>

    <x-slot name="content">
        <div class="py-2 mt-2">
            <i class="fs-4 bi-card-checklist"></i> <span class="fs-4 d-sm-inline">Estimate | Latest</span>
        </div>
        
        <div class="mx-auto mt-4">
            <div class="table table-bordered">

                    <table class="table table-bordered">
                        <thead>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry ID:</span>
                            </th>
                            <td>
                                <span>{{ $estimates->first()->group_id }}</span>
                            </td>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry by:</span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->user->username }}</span>
                            </td>
                            <th class="col-md-1">
                                <span class="d-none d-sm-inline">Entry date: </span>
                            </th>
                            <td class="col-md-2">
                                <span>{{ $estimates->first()->created_at->diffForHumans() }}</span>
                            </td>
                        </thead>
                    </table>
 


                <table class="table table-bordered table-rounded mx-auto">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-4">Description</th>
                            <th class="col-md-1">UOM</th>
                            <th class="col-md-1">Quantity</th>
                            <th class="col-md-1">Unit Cost</th>
                            <th class="col-md-1">Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                            @foreach ($estimates as $index => $estimate)
                                <tr>
                                    <td></td>
                                    <td>{{ isset($estimate->description) ? $estimate->description : 'N/A' }}</td>
                                    <td>{{ isset($estimate->uom) ? $estimate->uom : 'N/A' }}</td>
                                    <td><span>{{ number_format($estimate->quantity, 2, '.', ',') }}</span></td>
                                    <td><span>{{ number_format($estimate->unit_cost, 2, '.', ',') }}</span></td>
                                    <td><span>{{ number_format($estimate->amount, 2, '.', ',') }}</span></td>
                                </tr>
                            @endforeach
 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-right"><strong>Total Amount:</strong></td>
                            <td>{{ $estimates->isNotEmpty() ? number_format($estimates->first()->total_amount, 2, '.', ',') : 'N/A' }}</td>
                        </tr>
                    </tfoot>
                </table>   

                <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-primary float-end">Edit</a>

            </div>
        </div>

    </x-slot>

    </x-base2>


