@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | On-Going Projects</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <div>
                    <button class="btn btn-outline-primary" style="transition:0.8s;"data-bs-toggle="modal" data-bs-target="#createReceiptModal">
                        <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Receipt</span>
                        <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add New</span>
                    </button>

                    <button class="btn btn-outline-success" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                        <span><i class="bi bi-plus"></i>Supplier</span>
                    </button>
                </div>

                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @include('layout.create-receipt-modal')
        @include('layout.create-supplier-modal')

        <div class="mt-3 pb-3 gap-2">
            
            @forelse ($projects as $project)
                <div class="row-container gap-3">
                    <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                        <a href="{{ route('project.receipt', $project->id) }}" class="row text-decoration-none link-dark p-3">
                            <div class="row text-light ">
                                <span class="fs-6 d-none d-sm-inline">ID: {{ $project->project_id }}</span>
                                <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $project->project_id }}</span>
                            </div>
                            <div class="row p-2 text-light mx-auto text-center">
                                <span class="fs-4 d-none d-sm-inline">{{ Str::limit($project->project_dsc, 20) }}</span>
                                <span class="fs-4 d-sm-inline d-sm-none">  {{ Str::limit($project->project_dsc, 15) }}</span>
                            </div>
                            <div class="row text-secondary">
                                <span class="fs-6 d-none d-sm-inline">Date: {{ $project->created_at->diffForHumans() }}</span>
                                <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $project->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center my-5">
                    <i class="bi bi-box"></i>
                    <p class="no-text">No receipt for on-going projects yet.</p>
                </div>
            @endforelse

                {{-- {{ $projects->links() }} --}}
           
        </div>              
        
        <div class="mt-3 pt-2 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('on.receipt') }}" class="text-decoration-none">Receipt for On-Going Projects</a>

            <a href="{{ route('supplier') }}" class="text-decoration-none fst-italic">/Supplier list</a>
        </div>
       
@endsection


