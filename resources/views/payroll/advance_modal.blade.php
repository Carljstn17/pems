<!-- Modal -->
<div class="modal fade" id="advancesModal" tabindex="-1" aria-labelledby="advancesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advancesModalLabel">User Advances</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display user advances here -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Advance Amount</th>
                            <th>Remarks</th>
                            <th>Select</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laborer->advances as $index => $advance)
                            <tr>
                                <td>{{ $advance->created_at->format('Y-m-d') }}</td>
                                <td>{{ $advance->amount }}</td>
                                <td style="color: {{ $advance->remarks === 'add' ? 'green' : 'red' }}">{{ $advance->remarks }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" name="checklist[]" data-amount="{{ $advance->amount }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No advances for this laborer</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
