<nav class="navbar px-2 py-3 d-flex justify-content-between justify-content-sm-between justify-content-lg-end">
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="dropdown me-3">
            <span id="notification-icon-estimate" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi-bell"></i>
                <span class="text-danger" id="notification-dot-advance"></span>
            </span>

            <!-- Dropdown menu -->
            <div class="dropdown-menu" style="margin-left:-8rem; max-height: 300px; overflow-y: auto;" aria-labelledby="notification-icon-estimate">
                @php
                    $estimates = \App\Models\Estimate::whereIn('status',['pending', 'rejected'])
                        ->orderBy('updated_at', 'desc')
                        ->with('user')
                        ->get();

                    $uniqueGroupIds = $estimates->pluck('group_id')->unique();

                    $filteredEstimates = collect();

                    foreach ($uniqueGroupIds as $groupId) {
                        $filteredEstimate = $estimates->firstWhere('group_id', $groupId);
                        $filteredEstimates->push($filteredEstimate);
                    }
                @endphp
                <a href="" class="d-flex justify-content-end link-dark text-decoration-none text-secondary">
                    <span class="text-end">see all</span>
                </a>
                @php $count = 0; @endphp
                @forelse ($filteredEstimates as $group_id => $est)
                    @php
                        $firstEstimate = $est->first();
                    @endphp
                    @if ($count < 8)
                        <a href="{{ route('estimate.form', ['group_id' => $est->group_id]) }}" class="card rounded-0 border link-dark text-decoration-none text-secondary">
                            <div class="px-2">
                                <span>{{ $est->group_id }}</span><br>
                                <span>{{ $est->updated_at->diffForHumans() }}</span>
                            </div>
                        </a>
                        @php $count++; @endphp
                    @else
                        @break
                    @endif
                @empty
                    <p class="px-2">empty</p>
                @endforelse
            </div>
        </div>
</nav>
            
        