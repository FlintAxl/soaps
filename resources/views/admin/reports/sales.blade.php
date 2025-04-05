@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Reports</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Date Range Filter</h3>
        </div>
        <div class="card-body">
            <form id="dateRangeForm">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Daily Sales</h3>
                </div>
                <div class="card-body">
                    <canvas id="salesBarChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Product Sales Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="productPieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   
   $(document).ready(function() {
        // Set default dates (last 30 days)
        const endDate = new Date();
        const startDate = new Date();
        startDate.setDate(startDate.getDate() - 30);
        
        // Format dates as YYYY-MM-DD
        $('#start_date').val(formatDate(startDate));
        $('#end_date').val(formatDate(endDate));
        
        // Load initial data
        loadChartData();
        
        // Form submission handler
        $('#dateRangeForm').on('submit', function(e) {
            e.preventDefault();
            loadChartData();
        });
    });
    
    // Helper function to format date as YYYY-MM-DD
    function formatDate(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
    
    let salesBarChart, productPieChart;
    
    function loadChartData() {
        const formData = $('#dateRangeForm').serialize();
        
        $.ajax({
            url: "{{ route('admin.reports.sales-data') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                updateBarChart(response.dailySales);
                updatePieChart(response.productSales);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error loading chart data');
            }
        });
    }
    
    function updateBarChart(data) {
        const ctx = document.getElementById('salesBarChart').getContext('2d');
        const labels = data.map(item => item.date);
        const values = data.map(item => item.total);
        
        if (salesBarChart) {
            salesBarChart.destroy();
        }
        
        salesBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales (₱)',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    function updatePieChart(data) {
        const ctx = document.getElementById('productPieChart').getContext('2d');
        const labels = data.map(item => item.product_name);
        const values = data.map(item => item.total_sales);
        
        // Generate colors dynamically
        const backgroundColors = labels.map((_, i) => {
            const hue = (i * 137.508) % 360; // Golden angle approximation
            return `hsl(${hue}, 70%, 60%)`;
        });
        
        if (productPieChart) {
            productPieChart.destroy();
        }
        
        productPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: backgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ₱${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush