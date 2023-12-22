<div class="modal fade" id="createOtRateModal" tabindex="-1" aria-labelledby="createOtRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOtRateModalLabel">Add New OT Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="otRateForm" action="{{ route('ot-rate.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="otRate" class="form-label">OT Rate</label>
                        <input type="number" class="form-control" id="otRate" name="ot_rate" step="0.01" value="{{ $latestOtRate }}" required>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="submitOtRateForm()">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function submitOtRateForm() {
        // You can add validation logic here if needed
        var form = document.getElementById('otRateForm');
        form.submit();
    }
</script>
