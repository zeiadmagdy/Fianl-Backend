@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary font-weight-bold">Insights Dashboard</h1>

    <div class="row">
        <!-- User Registrations Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">User Registrations per Month</h5>
                </div>
                <div class="card-body">
                    <canvas id="userRegistrationsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Events Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Top 10 Events</h5>
                </div>
                <div class="card-body">
                    <canvas id="topEventsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Demographics Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">User Demographics</h5>
                </div>
                <div class="card-body">
                    <canvas id="userDemographicsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Event Attendance Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Monthly Event Attendance</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyEventAttendanceChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Events by Category Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Events by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="eventsByCategoryChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- User Registrations by Location Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">User Registrations by Location</h5>
                </div>
                <div class="card-body">
                    <canvas id="userRegistrationsLocationChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Attendees Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Top Attendees</h5>
                </div>
                <div class="card-body">
                    <canvas id="topAttendeesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

    <!-- Subscription Growth Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-light">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Subscription Growth</h5>
                </div>
                <div class="card-body">
                    <canvas id="subscriptionGrowthChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal to display user list -->
    <div class="modal fade" id="userListModal" tabindex="-1" aria-labelledby="userListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userListModalLabel">Attendees of Event <span id="modalEventName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="userList" class="list-group">
                        <!-- User list will be populated here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let userRegistrationsChart;
    let topEventsChart;
    let userDemographicsChart;
    let monthlyEventAttendanceChart;
    let eventsByCategoryChart;
    let userRegistrationsLocationChart;
    let topAttendeesChart;
    let subscriptionGrowthChart;

    // User Registrations Chart
    function createUserRegistrationsChart() {
        const ctx = document.getElementById('userRegistrationsChart').getContext('2d');

        if (userRegistrationsChart) {
            userRegistrationsChart.destroy(); // Destroy previous instance if it exists
        }

        userRegistrationsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthNames),
                datasets: [{
                    label: 'User Registrations per Month',
                    data: @json($userCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { beginAtZero: false, ticks: { color: '#333' } },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: { labels: { color: '#333' } },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var monthIndex = tooltipItem.dataIndex;
                                var userCount = @json($userCounts);
                                return ` ${userCount[monthIndex]} Users`;
                            }
                        }
                    }
                },
                onClick: function(evt, activeElements) {
                    if (activeElements.length > 0) {
                        var clickedIndex = activeElements[0].index;
                        var month = (clickedIndex + 1).toString().padStart(2, '0');
                        var monthName = @json($monthNames)[clickedIndex];
                        fetchUsersForMonth(month, monthName);
                    }
                }
            }
        });
    }

    // Top Events Chart
    function createTopEventsChart() {
        const ctx = document.getElementById('topEventsChart').getContext('2d');

        if (topEventsChart) {
            topEventsChart.destroy(); // Destroy previous instance if it exists
        }

        topEventsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($eventNames),
                datasets: [
                    {
                        label: 'Attendance',
                        data: @json($eventAttendances),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(75, 192, 192, 0.8)',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { 
                        beginAtZero: true, 
                        ticks: { color: '#333' },
                    },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: { labels: { color: '#333' } },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var index = tooltipItem.dataIndex;
                                var attendance = @json($eventAttendances)[index];
                                return `Attendance: ${attendance}`;
                            }
                        }
                    }
                },
                onClick: function(evt, activeElements) {
                    if (activeElements.length > 0) {
                        var clickedIndex = activeElements[0].index;
                        var eventId = @json($eventIds)[clickedIndex]; // Get the event ID
                        fetchEventAttendees(eventId, @json($eventNames)[clickedIndex]); // Show event attendees
                    }
                }
            }
        });
    }

    // User Demographics Chart
    function createUserDemographicsChart() {
        const ctx = document.getElementById('userDemographicsChart').getContext('2d');
        userDemographicsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($demographicLabels),
                datasets: [{
                    data: @json($demographicCounts),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#333'
                        }
                    }
                }
            }
        });
    }

    // Monthly Event Attendance Chart
    function createMonthlyEventAttendanceChart() {
        const ctx = document.getElementById('monthlyEventAttendanceChart').getContext('2d');
        monthlyEventAttendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthNames),
                datasets: [{
                    label: 'Monthly Attendance',
                    data: @json($monthlyAttendanceCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { color: '#333' } },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: {
                        labels: { color: '#333' }
                    }
                },
                onClick: function(evt, activeElements) {
                if (activeElements.length > 0) {
                    var clickedIndex = activeElements[0].index;
                    var month = (clickedIndex + 1).toString().padStart(2, '0');
                    var monthName = @json($monthNames)[clickedIndex];
                    fetchUsersForAttendanceMonth(month, monthName);
                }
            }
            }
        });
    }

    // Events by Category Chart
    function createEventsByCategoryChart() {
        const ctx = document.getElementById('eventsByCategoryChart').getContext('2d');
        eventsByCategoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($categoryNames),
                datasets: [{
                    label: 'Number of Events',
                    data: @json($categoryCounts),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { color: '#333' } },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: {
                        labels: { color: '#333' }
                    }
                }
            }
        });
    }

    // User Registrations by Location Chart
    function createUserRegistrationsLocationChart() {
        const ctx = document.getElementById('userRegistrationsLocationChart').getContext('2d');
        userRegistrationsLocationChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($locationNames),
                datasets: [{
                    label: 'User Registrations',
                    data: @json($locationCounts),
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { color: '#333' } },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: {
                        labels: { color: '#333' }
                    }
                }
            }
        });
    }

    

    // Top Attendees Chart
    function createTopAttendeesChart() {
        const ctx = document.getElementById('topAttendeesChart').getContext('2d');
        topAttendeesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($topAttendeeNames),
                datasets: [{
                    label: 'Attendance Count',
                    data: @json($topAttendeeCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { color: '#333' } },
                    y: { beginAtZero: true, ticks: { color: '#333' } }
                },
                plugins: {
                    legend: {
                        labels: { color: '#333' }
                    }
                }
            }
        });
    }

    // Subscription Growth Chart
function createSubscriptionGrowthChart() {
    const ctx = document.getElementById('subscriptionGrowthChart').getContext('2d');
    subscriptionGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($growthMonths),
            datasets: [{
                label: 'Subscription Growth',
                data: @json($subscriptionCounts),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { ticks: { color: '#333' } },
                y: { beginAtZero: true, ticks: { color: '#333' } }
            },
            plugins: {
                legend: {
                    labels: { color: '#333' }
                }
            }
        }
    });
}

    // Show users for the selected month
    function fetchUsersForMonth(month, monthName) {
        const usersForMonth = @json($usersPerMonth);

        if (usersForMonth[month] && usersForMonth[month].length > 0) {
            $('#userList').empty(); // Clear previous list
            $('#modalEventName').text(monthName); // Set the month name in the modal
            
            // Loop through the users and append to the list
            usersForMonth[month].forEach(user => {
                $('#userList').append(`<li class="list-group-item"><a href="/admin/users/${user.id}">${user.name} (${user.email})</a></li>`);
            });
        } else {
            $('#userList').empty().append('<li class="list-group-item">No users registered in this month.</li>');
        }

        // Show the modal
        $('#userListModal').modal('show');
    }

    // Show attendees for the selected event
    function fetchEventAttendees(eventId, eventName) {
        const users = @json($eventUsers);
        const attendees = users[eventId].map(user => `<li class="list-group-item"><a href="/admin/users/${user.id}">${user.name} (${user.email})</a></li>`).join('');
        
        $('#userList').html(attendees);
        $('#modalEventName').text(eventName); // Set the event name in the modal
        $('#userListModal').modal('show'); // Show the modal
    }

    // Show users for the selected month
function fetchUsersForAttendanceMonth(month, monthName) {
    const usersForMonth = @json($usersPerMonth); // Ensure this is defined in your controller

    if (usersForMonth[month] && usersForMonth[month].length > 0) {
        $('#userList').empty(); // Clear previous list
        $('#modalEventName').text(`Users Registered in ${monthName}`); // Set the month name in the modal
        
        // Loop through the users and append to the list
        usersForMonth[month].forEach(user => {
            $('#userList').append(`<li class="list-group-item"><a href="/admin/users/${user.id}">${user.name} (${user.email})</a></li>`);
        });
    } else {
        $('#userList').empty().append('<li class="list-group-item">No users registered in this month.</li>');
    }

    // Show the modal
    $('#userListModal').modal('show');
}

    // Create the charts on page load
    createUserRegistrationsChart();
    createTopEventsChart();
    createUserDemographicsChart();
    createMonthlyEventAttendanceChart();
    createEventsByCategoryChart();
    createUserRegistrationsLocationChart();
    createTopAttendeesChart();
    createSubscriptionGrowthChart();
</script>
@endsection
