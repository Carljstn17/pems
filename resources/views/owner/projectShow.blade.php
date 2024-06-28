@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <div class="d-flex align-items-center">
            <a href="{{ route('owner.project') }}" class="text-secondary text-decoration-none btn">
                    <i class="bi-backspace"></i>
            </a>
            <i class="fs-5 bi-buildings"></i> <span class="d-sm-inline fs-5 head">Project | {{ $project->project_dsc }}</span>
        </div>
    </div>    
    
    <div class="row mt-3 g-3">
        <div class="col-lg-8 col-12">
            <div class="border py-2 px-4">
                <h6>Daily Data</h6>
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="rounded py-2 px-3">
                <h6>Payroll Batches Data</h6>
                <canvas id="payrollBatchesPieChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="row g-3 mt-3">
        <div class="col-lg-4 col-12">
            <div class="rounded border p-3">
                <h6>Receipts Data</h6>
                <canvas id="receiptsPieChart"></canvas>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="row g-3 mb-3">
                <div class="col-lg-6 col-12">
                    <div class="border p-3">
                        <h6>Weekly Data</h6>
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="border p-3">
                        <h6>Monthly Data</h6>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="border p-3">
                <div class="row mb-2">
                    <div class="col-4"><span class="bold">Project Location:</span></div>
                    <div class="col-8">{{ $project->location }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><span class="bold">Client:</span></div>
                    <div class="col-8">{{ $project->client }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><span class="bold">Contact:</span></div>
                    <div class="col-8">{{ $project->contact }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><span class="bold">Started At:</span></div>
                    <div class="col-8">{{ $project->Date_started }}</div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4"><span class="bold">Staff:</span></div>
                    <div class="col-8">{{ $project->user->fname }} {{ $project->user->mname }} {{ $project->user->lname }}</div>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
    fetch('/analytics')
        .then(response => response.json())
        .then(data => {
            const projectData = data.data.find(item => item.project_name === "{{ $project->project_dsc }}");

            // Daily Chart
            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: Object.keys(projectData.daily.total_salary),
                    datasets: [{
                        label: 'Total Salary',
                        data: Object.values(projectData.daily.total_salary),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }, {
                        label: 'Total Amount',
                        data: Object.values(projectData.daily.total_amount),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.1
                    }]
                }
            });

            // Weekly Chart
            const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: Object.keys(projectData.weekly.total_salary),
                    datasets: [{
                        label: 'Total Salary',
                        data: Object.values(projectData.weekly.total_salary),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }, {
                        label: 'Total Amount',
                        data: Object.values(projectData.weekly.total_amount),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.1
                    }]
                }
            });

            // Monthly Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: Object.keys(projectData.monthly.total_salary),
                    datasets: [{
                        label: 'Total Salary',
                        data: Object.values(projectData.monthly.total_salary),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }, {
                        label: 'Total Amount',
                        data: Object.values(projectData.monthly.total_amount),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        tension: 0.1
                    }]
                }
            });
        });
        
        // pie chart
        fetch('/analytics')
            .then(response => response.json())
            .then(data => {
                const projectData = data.data.find(item => item.project_name === "{{ $project->project_dsc }}");
    
                // Daily Chart and other charts remain the same
    
                // Pie Chart
                const pieCtx = document.getElementById('payrollBatchesPieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: [ 'Pending', 'Valid', 'Invalid'],
                        datasets: [{
                            data: [ {{ $pendingCount }}, {{ $validCount }}, {{ $invalidCount }}, ],
                            backgroundColor: [  'rgba(75, 233, 63, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)' ],
                        }]
                    }
                });
            });
            
        fetch('/analytics')
            .then(response => response.json())
            .then(data => {
                const projectData = data.data.find(item => item.project_name === "{{ $project->project_dsc }}");
    
                // Daily Chart and other charts remain the same
    
                // Pie Chart
                const pieCtx = document.getElementById('receiptsPieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Valid','Invalid'],
                        datasets: [{
                            data: [ {{ $validReceiptCount }} , {{ $invalidReceiptCount }} ],
                            backgroundColor: [ 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)' ],
                        }]
                    }
                });
            });

    </script>
@endsection
