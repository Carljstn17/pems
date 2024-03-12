<nav class="navbar px-2 py-3 d-flex justify-content-end">
    <div class=" d-flex justify-content-end">
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

        <div class="dropdown me-3">
            <span id="notification-icon-advance" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi-chat-left-dots"></i>
                <span class="text-danger" id="notification-dot-advance"></span>
            </span>
        
            <!-- Dropdown menu -->
            <div class="dropdown-menu" style="margin-left:-8rem; max-height: 300px; overflow-y: auto;" aria-labelledby="notification-icon-advance">
                @php
                    $requests = \App\Models\AdvanceRequest::orderBy('created_at', 'desc')->with('user')->get();
                @endphp
                <a href="{{ route('request.allNotif') }}" class="d-flex justify-content-end link-dark text-decoration-none text-secondary">
                    <span class="text-end">see all</span>
                </a>
                @php $count = 0; @endphp
                @forelse ($requests as $req)
                    @if ($count < 8)
                        <a href="{{ route('request.notif', $req->id) }}" class="card rounded-0 border link-dark text-decoration-none text-secondary">
                            <div class="px-2">
                                <span>{{ $req->user->username }}</span><br>
                                <span>{{ $req->created_at->diffForHumans() }}</span>
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

        <div class="dropdown">
            <span id="notification-icon-concern" class="dropdown-toggle position-relative" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi-chat-left-text"></i>
                <span class="red-dot"></span>
            </span>
            
            <!-- Dropdown menu -->
            <div class="dropdown-menu text-secondary" style="margin-left:-8rem; max-height: 300px; overflow-y: auto;" aria-labelledby="notification-icon-concern">
                @php
                    $concerns = \App\Models\Concern::orderBy('created_at', 'desc')->with('user')->get();
                @endphp
                <a href="{{ route('concern.allNotif') }}" class="d-flex justify-content-end link-dark text-decoration-none text-secondary">
                    <span class="text-end">see all</span>
                </a>

                @php $count = 0; @endphp
                @forelse ($concerns as $concern)
                    @if ($count < 8)
                        <a href="{{ route('concern.notif', $concern->id) }}" class="card rounded-0 border link-dark text-decoration-none text-secondary">
                            <div class="px-2">
                                <span>{{ $concern->user->username }}</span><br>
                                <span>{{ $concern->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @else
                        @break
                    @endif
                @empty
                    <p class="px-2">empty</p>
                @endforelse
            </div>
        </div>
    </div>
</nav>
        

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateNotificationDot(count) {
            const dotElement = document.getElementById('notification-dot-advance');
            
            if (count > 0) {
                dotElement.innerText = count;
                dotElement.style.display = 'inline-block'; // Show the dot
            } else {
                dotElement.innerText = '';
                dotElement.style.display = 'none'; // Hide the dot
            }
        }

        function fetchNotifications() {
            axios.get('/notifications')
                .then(response => {
                    const notifications = response.data.notifications;
                    updateNotificationDot(notifications.length);
                })
                .catch(error => {
                    console.error('Error fetching notifications', error);
                });
        }

        fetchNotifications();

        setInterval(fetchNotifications, 60000);

        // Optionally, you can adjust the position of the dot based on your icon's styling
        const iconElement = document.getElementById('notification-icon-advance');
        const dotElement = document.getElementById('notification-dot-advance');

        // Adjust the position of the dot
        const iconPosition = iconElement.getBoundingClientRect();
        const dotPosition = dotElement.getBoundingClientRect();

        const topOffset = iconPosition.top + window.scrollY - dotPosition.height;
        const leftOffset = iconPosition.left + window.scrollX + iconPosition.width - dotPosition.width;

        dotElement.style.position = 'absolute';
        dotElement.style.top = `${topOffset}px`;
        dotElement.style.left = `${leftOffset}px`;
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    