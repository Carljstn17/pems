<!-- create-supplier-modal.blade.php -->

<div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupplierModalLabel">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('supplier.store') }}">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Supplier</th>
                                <th>Contact</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td class="col-md-1">{{ $i }}</td>
                                    <td>
                                        <input type="text" class="form-control no-border name" name="suppliers[{{ $i }}][name]" value="{{ old('suppliers.' . $i . '.name') }}">
                                        @error('suppliers.' . $i . '.name')
                                            <div class="text-danger px-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control no-border contact" name="suppliers[{{ $i }}][contact]" value="{{ old('suppliers.' . $i . '.contact') }}">
                                        @error('suppliers.' . $i . '.contact')
                                            <div class="text-danger px-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control no-border address" name="suppliers[{{ $i }}][address]" value="{{ old('suppliers.' . $i . '.address') }}">
                                        @error('suppliers.' . $i . '.address')
                                            <div class="text-danger px-2">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            @endfor
                            
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Submit Supplier</button>
                </form>
                @if ($errors->any())
                    <script>
                        $(document).ready(function() {
                            $('#createSupplierModal').modal('show');
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function storeInputValues() {
        sessionStorage.setItem('name', document.getElementsByClassName('name').user_id);
        sessionStorage.setItem('contact', document.getElementsByClassName('contact').value);
        sessionStorage.setItem('address', document.getElementsByClassName('address').value);
    }

    // Function to retrieve and populate input values when modal is shown
    function populateInputValues() {
        document.getElementsByClassName('name').value = sessionStorage.getItem('name');
        document.getElementsByClassName('contact').value = sessionStorage.getItem('contact');
        document.getElementsByClassName('address').value = sessionStorage.getItem('address');
    }
</script>
