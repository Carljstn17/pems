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
                                        <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][name]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][contact]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control no-border" name="suppliers[{{ $i }}][address]">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Submit Supplier</button>
                </form>
            </div>
        </div>
    </div>
</div>
