<div class="modal fade" id="createAdvanceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Advance Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form action="{{ url('/payroll/advances') }}" method="post" class="pb-5" id="advanceForm">
                        @csrf
                        <div class="border p-4 rounded mb-3">
                            <label for=""><span class="bold">Name :</span></label>
                            <select class="form-select px-2 mb-3" name="user_id">
                                <option value="">Select a laborer</option>
                                @foreach($laborers as $laborer)
                                    <option value="{{ $laborer->id }}">
                                        {{ $laborer->name }}
                                    </option>
                                @endforeach
                            </select>
    
                            <label for=""><span class="bold">Advance Amount :</span></label>
                            <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                    </form>
                    
            </div>
        </div>
    </div>
</div>