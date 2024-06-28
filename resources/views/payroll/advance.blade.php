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
                            <select class="form-select px-2 mb-3" name="user_id" id="user_id">
                                <option value="">Select a laborer</option>
                                @foreach($laborers as $laborer)
                                    <option value="{{ $laborer->id }}" {{ old('user_id') == $laborer->id ? 'selected' : '' }}>
                                        {{ $laborer->lname }}, {{ $laborer->fname }}, {{ $laborer->mname }}
                                    </option>
                                @endforeach
                            </select>
    
                            <label for=""><span class="bold">Advance Amount :</span></label>
                            <input type="number" id="amount" class="form-control" name="amount" placeholder="Enter Amount" value="{{ old('amount', $laborer->amount) }}">
                            @error('amount')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                    </form>
                    
                    @if ($errors->any())
                    <script>
                        $(document).ready(function() {
                            $('#createAdvanceModal').modal('show');
                        });
                    </script>
                @endif
                    
            </div>
        </div>
    </div>
</div>

<script>
            function storeInputValues() {
                sessionStorage.setItem('user_id', document.getElementById('lname').user_id);
                sessionStorage.setItem('amount', document.getElementById('amount').value);
            }
        
            // Function to retrieve and populate input values when modal is shown
            function populateInputValues() {
                document.getElementById('user_id').value = sessionStorage.getItem('user_id');
                document.getElementById('amount').value = sessionStorage.getItem('amount');
            }
        </script>