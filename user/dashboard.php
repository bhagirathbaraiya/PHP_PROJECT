<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id'])==0)
	{
header('location:../index.php');
}
else{
	?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/css/user-responsive.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ef 0%, #f7f9fb 100%);
            color: #102d4a;
            margin-top: 70px;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto 0 auto;
            padding: 0 16px 32px 16px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }
        .stat-box {
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            padding: 24px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1.5px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(12px);
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .stat-box:focus, .stat-box:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(-2px) scale(1.03);
            outline: 2px solid #0097A7;
        }
        .stat-box .stat-icon {
            color: #0097A7;
            background: rgba(242,247,250,0.7);
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .stat-title {
            color: #222;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .stat-value {
            color: #A41E22;
            font-size: 1.7rem;
            font-weight: 500;
        }
        .stat-info {
            display: flex;
            flex-direction: column;
        }
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
        }
        .chart-card {
            background: rgba(255,255,255,0.18);
            border-radius: 18px;
            padding: 16px 8px 24px 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            border: 1.5px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(12px);
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .chart-card:focus, .chart-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(-2px) scale(1.02);
            outline: 2px solid #0097A7;
        }
        .stat-title.mb-3 {
            margin-bottom: 12px;
        }
        .chart-container {
            min-height: 160px;
            max-width: 340px;
            margin: 0 auto;
            background: rgba(255,255,255,0.22);
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            padding: 8px 0;
        }
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 8px;
        }
        .breadcrumb-item a, .breadcrumb-item {
            color: #0097A7;
            text-decoration: none;
            font-size: 1rem;
        }
        .breadcrumb-item.active {
            color: #A41E22;
        }
        @media (max-width: 991px) {
            .dashboard-container {
                gap: 20px;
            }
            .chart-card {
                max-width: 100%;
            }
            .chart-container {
                max-width: 100%;
            }
        }
        @media (max-width: 767px) {
            .dashboard-container {
                margin-top: 16px;
            }
            .stat-grid, .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        /* Accessibility: Focus outline for keyboard navigation */
        :focus {
            outline: 2px solid #0097A7 !important;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <!-- [ Header ] start -->
    <?php include('include/header.php');?>
    <!-- [ Header ] end -->
    <div class="dashboard-container">
        
        <!-- Stat Boxes -->
        <div class="stat-grid" role="region" aria-label="Statistics Overview">
            <!-- Assignments Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-bottom: 4px; margin-top: 0;">
                <h4 style="margin:0; color:#0097A7; font-weight:700; letter-spacing:1px;">Assignments</h4>
            </div>
            <!-- Assignments Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Assignments: 12">
                <div class="stat-icon"><i class="fas fa-file-alt" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Assignments</div>
                    <div class="stat-value">12</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Assignments: 3">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Assignments</div>
                    <div class="stat-value">3</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Assignments: 8">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Assignments</div>
                    <div class="stat-value">8</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Assignments: 1">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Assignments</div>
                    <div class="stat-value">1</div>
                </div>
            </div>
            <!-- Notebooks Header -->
            <div style="grid-column: 1 / -1; text-align:left; margin-top: 18px; margin-bottom: 4px;">
                <h4 style="margin:0; color:#A41E22; font-weight:700; letter-spacing:1px;">Notebooks</h4>
            </div>
            <!-- Notebook Stat Boxes -->
            <div class="stat-box" tabindex="0" aria-label="Total Notebooks: 10">
                <div class="stat-icon"><i class="fas fa-book" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Total Notebooks</div>
                    <div class="stat-value">10</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Pending Notebooks: 2">
                <div class="stat-icon"><i class="fas fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Pending Notebooks</div>
                    <div class="stat-value">2</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Submitted Notebooks: 7">
                <div class="stat-icon"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Submitted Notebooks</div>
                    <div class="stat-value">7</div>
                </div>
            </div>
            <div class="stat-box" tabindex="0" aria-label="Overdue Notebooks: 1">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
                <div class="stat-info">
                    <div class="stat-title">Overdue Notebooks</div>
                    <div class="stat-value">1</div>
                </div>
            </div>
        </div>
        <!-- Graphs Row -->
        <div class="charts-grid" role="region" aria-label="Charts Overview">
            <div class="chart-card" tabindex="0" aria-label="Assignments Overview Pie Chart">
                <h5 class="stat-title mb-3">Assignments Overview</h5>
                <div id="assignmentPieChart" class="chart-container" aria-label="Assignments Pie Chart"></div>
            </div>
            <div class="chart-card" tabindex="0" aria-label="Notebooks Overview Pie Chart">
                <h5 class="stat-title mb-3">Notebooks Overview</h5>
                <div id="notebookPieChart" class="chart-container" aria-label="Notebooks Pie Chart"></div>
            </div>
            <div class="chart-card" tabindex="0" aria-label="Submission Comparison Bar Chart">
                <h5 class="stat-title mb-3">Submission Comparison</h5>
                <div id="submissionBarChart" class="chart-container" aria-label="Submission Bar Chart"></div>
            </div>
        </div>
    </div>
    <!-- Your Subjects Section -->
    <div class="dashboard-container" style="margin-top: 0;">
        <div style="grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; margin-top: 0;">
            <h4 style="margin:0; color:#102d4a; font-weight:700; letter-spacing:1px;">Your Subjects</h4>
            <button id="toggle-all-graphs-btn" class="toggle-all-graphs-btn" aria-label="Toggle All Graphs" title="Toggle All Graphs">
                <i class="fas fa-chart-pie"></i> <span id="toggle-all-graphs-label">Show All Graphs</span>
            </button>
        </div>
        <div class="subjects-grid" role="region" aria-label="Subjects Overview">
            <!-- Subject cards will be injected here by JS -->
        </div>
    </div>
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
    <script src="../admin/assets/js/plugins/apexcharts.min.js"></script>
<script>
    // Dummy data for graphs
    var assignmentData = {
        total: 12,
        pending: 3,
        submitted: 8,
        overdue: 1
    };
    var notebookData = {
        total: 10,
        pending: 2,
        submitted: 7,
        overdue: 1
    };
    // Dummy data for progress line chart
    var progressData = {
        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        assignments: [2, 4, 8, 12],
        notebooks: [1, 3, 6, 10]
    };
    // Pie Chart for Assignments
    var assignmentPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: [assignmentData.pending, assignmentData.submitted, assignmentData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        accessibility: {
            enabled: true,
            description: 'Pie chart showing assignment status breakdown.'
        }
    };
    var assignmentPieChart = new ApexCharts(document.querySelector("#assignmentPieChart"), assignmentPieOptions);
    assignmentPieChart.render();
    // Pie Chart for Notebooks
    var notebookPieOptions = {
        chart: { type: 'pie', height: 180 },
        series: [notebookData.pending, notebookData.submitted, notebookData.overdue],
        labels: ['Pending', 'Submitted', 'Overdue'],
        colors: ['#F9B600', '#0097A7', '#A41E22'],
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        accessibility: {
            enabled: true,
            description: 'Pie chart showing notebook status breakdown.'
        }
    };
    var notebookPieChart = new ApexCharts(document.querySelector("#notebookPieChart"), notebookPieOptions);
    notebookPieChart.render();
    // Bar Chart for Submission Comparison
    var submissionBarOptions = {
        chart: { type: 'bar', height: 200 },
        series: [
            {
                name: 'Assignments',
                data: [assignmentData.total, assignmentData.pending, assignmentData.submitted, assignmentData.overdue]
            },
            {
                name: 'Notebooks',
                data: [notebookData.total, notebookData.pending, notebookData.submitted, notebookData.overdue]
            }
        ],
        xaxis: {
            categories: ['Total', 'Pending', 'Submitted', 'Overdue'],
            labels: { style: { fontSize: '15px', colors: ['#102d4a'] } }
        },
        legend: {
            show: true,
            fontSize: '15px',
            position: 'bottom',
            labels: { colors: ['#222'] }
        },
        dataLabels: {
            style: { fontSize: '15px', fontWeight: 'bold' }
        },
        colors: ['#0097A7', '#F9B600'],
        accessibility: {
            enabled: true,
            description: 'Bar chart comparing assignment and notebook submissions.'
        }
    };
    var submissionBarChart = new ApexCharts(document.querySelector("#submissionBarChart"), submissionBarOptions);
    submissionBarChart.render();
    
    // Dummy data for subjects
    var subjects = [
        {
            name: 'Mathematics',
            code: 'MATH101',
            faculty: 'Dr. John Doe',
            assignments: { total: 8, completed: 5, pending: 2, due: 1 },
            notebooks:   { total: 6, completed: 4, pending: 1, due: 1 }
        },
        {
            name: 'Science',
            code: 'SCI201',
            faculty: 'Prof. Jane Smith',
            assignments: { total: 5, completed: 3, pending: 1, due: 1 },
            notebooks:   { total: 4, completed: 2, pending: 1, due: 1 }
        },
        {
            name: 'English',
            code: 'ENG301',
            faculty: 'Ms. Emily Clark',
            assignments: { total: 7, completed: 4, pending: 2, due: 1 },
            notebooks:   { total: 5, completed: 3, pending: 1, due: 1 }
        },
        {
            name: 'History',
            code: 'HIST210',
            faculty: 'Dr. Alan Brown',
            assignments: { total: 6, completed: 2, pending: 3, due: 1 },
            notebooks:   { total: 3, completed: 1, pending: 1, due: 1 }
        }
    ];

    // Render subject cards
    var subjectsGrid = document.querySelector('.subjects-grid');
    subjects.forEach(function(subject, idx) {
        var card = document.createElement('div');
        card.className = 'subject-card';
        card.tabIndex = 0;
        card.setAttribute('aria-label', subject.name + ' assignments and notebooks overview');
        card.innerHTML = `
            <div class="subject-title">${subject.name} <span class="subject-code">(${subject.code})</span></div>
            <div class="faculty-name">Faculty: ${subject.faculty}</div>
            <div class="subject-section assignment-section">
                <div class="section-label"><i class='fas fa-file-alt'></i> Assignments</div>
                <div class="subject-stats stats-view" id="assignment-stats-${idx}">
                    <div class="subject-stat total">
                        <span class="stat-label">Total</span>
                        <span class="stat-value">${subject.assignments.total}</span>
                    </div>
                    <div class="subject-stat completed">
                        <span class="stat-label">Completed</span>
                        <span class="stat-value">${subject.assignments.completed}</span>
                    </div>
                    <div class="subject-stat pending">
                        <span class="stat-label">Pending</span>
                        <span class="stat-value">${subject.assignments.pending}</span>
                    </div>
                    <div class="subject-stat due">
                        <span class="stat-label">Due</span>
                        <span class="stat-value">${subject.assignments.due}</span>
                    </div>
                </div>
                <div class="chart-view" id="assignment-chart-${idx}" style="display:none; min-width:180px; min-height:120px;"></div>
            </div>
            <div class="subject-section notebook-section">
                <div class="section-label"><i class='fas fa-book'></i> Notebooks</div>
                <div class="subject-stats stats-view" id="notebook-stats-${idx}">
                    <div class="subject-stat total">
                        <span class="stat-label">Total</span>
                        <span class="stat-value">${subject.notebooks.total}</span>
                    </div>
                    <div class="subject-stat completed">
                        <span class="stat-label">Completed</span>
                        <span class="stat-value">${subject.notebooks.completed}</span>
                    </div>
                    <div class="subject-stat pending">
                        <span class="stat-label">Pending</span>
                        <span class="stat-value">${subject.notebooks.pending}</span>
                    </div>
                    <div class="subject-stat due">
                        <span class="stat-label">Due</span>
                        <span class="stat-value">${subject.notebooks.due}</span>
                    </div>
                </div>
                <div class="chart-view" id="notebook-chart-${idx}" style="display:none; min-width:180px; min-height:120px;"></div>
            </div>
        `;
        subjectsGrid.appendChild(card);
    });

    // Toggle all charts/stat views logic
    var chartInstances = {};
    var allGraphsVisible = false;
    function renderPieChartIfNeeded(idx, type) {
        var chartId = type + '-chart-' + idx;
        var chartDiv = document.getElementById(chartId);
        if (!chartInstances[chartId]) {
            var data = type === 'assignment' ? subjects[idx].assignments : subjects[idx].notebooks;
            var chartOptions = {
                chart: { type: 'pie', height: 140 },
                series: [data.completed, data.pending, data.due],
                labels: ['Completed', 'Pending', 'Due'],
                colors: ['#0097A7', '#F9B600', '#A41E22'],
                legend: {
                    show: true,
                    fontSize: '13px',
                    position: 'bottom',
                    labels: { colors: ['#222'] }
                },
                dataLabels: {
                    style: { fontSize: '13px', fontWeight: 'bold' }
                },
                accessibility: {
                    enabled: true,
                    description: (type.charAt(0).toUpperCase() + type.slice(1)) + ' pie chart for ' + subjects[idx].name
                }
            };
            chartInstances[chartId] = new ApexCharts(chartDiv, chartOptions);
            chartInstances[chartId].render();
        }
    }
    function toggleAllGraphs(showGraphs) {
        subjects.forEach(function(subject, idx) {
            ['assignment', 'notebook'].forEach(function(type) {
                var statsId = type + '-stats-' + idx;
                var chartId = type + '-chart-' + idx;
                var statsDiv = document.getElementById(statsId);
                var chartDiv = document.getElementById(chartId);
                if (showGraphs) {
                    statsDiv.style.display = 'none';
                    chartDiv.style.display = 'block';
                    renderPieChartIfNeeded(idx, type);
                } else {
                    statsDiv.style.display = 'flex';
                    chartDiv.style.display = 'none';
                }
            });
        });
        allGraphsVisible = showGraphs;
        document.getElementById('toggle-all-graphs-label').textContent = showGraphs ? 'Show All Stats' : 'Show All Graphs';
    }
    document.getElementById('toggle-all-graphs-btn').addEventListener('click', function() {
        toggleAllGraphs(!allGraphsVisible);
    });
</script>
<style>
/* Subject Cards Glassmorphism */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    margin-top: 8px;
}
.subject-card {
    background: rgba(255,255,255,0.18);
    border-radius: 18px;
    padding: 22px 20px 18px 20px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    border: 1.5px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(12px);
    transition: box-shadow 0.2s, transform 0.2s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    min-height: 220px;
    margin-bottom: 0;
}
.subject-card:focus, .subject-card:hover {
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    transform: translateY(-2px) scale(1.03);
    outline: 2px solid #0097A7;
}
.subject-title {
    font-size: 1.18rem;
    font-weight: 700;
    color: #0097A7;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
}
.subject-code {
    font-size: 1rem;
    font-weight: 500;
    color: #A41E22;
    margin-left: 4px;
}
.faculty-name {
    font-size: 0.98rem;
    color: #102d4a;
    margin-bottom: 10px;
    font-weight: 500;
}
.subject-section {
    width: 100%;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.13);
    border-radius: 12px;
    padding: 10px 12px 8px 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid rgba(255,255,255,0.18);
}
.subject-section:last-child {
    margin-bottom: 0;
}
.section-label {
    font-size: 1.05rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 7px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.section-label i {
    color: #0097A7;
    font-size: 1.1rem;
}
.subject-stats {
    display: flex;
    gap: 16px;
    width: 100%;
    justify-content: flex-start;
}
.subject-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 56px;
}
.subject-stat .stat-label {
    font-size: 0.93rem;
    color: #222;
    font-weight: 500;
    margin-bottom: 2px;
}
.subject-stat .stat-value {
    font-size: 1.15rem;
    font-weight: 600;
}
.subject-stat.total .stat-value {
    color: #102d4a;
}
.subject-stat.completed .stat-value {
    color: #0097A7;
}
.subject-stat.pending .stat-value {
    color: #F9B600;
}
.subject-stat.due .stat-value {
    color: #A41E22;
}
@media (max-width: 991px) {
    .subjects-grid {
        gap: 16px;
    }
}
@media (max-width: 767px) {
    .subjects-grid {
        grid-template-columns: 1fr;
    }
}
.toggle-all-graphs-btn {
    background: rgba(255,255,255,0.25);
    border: 1px solid rgba(0,151,167,0.18);
    border-radius: 18px;
    cursor: pointer;
    padding: 6px 16px 6px 12px;
    font-size: 1.08rem;
    color: #0097A7;
    transition: background 0.15s, box-shadow 0.15s;
    outline: none;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    display: flex;
    align-items: center;
    gap: 7px;
    font-weight: 600;
}
.toggle-all-graphs-btn:focus, .toggle-all-graphs-btn:hover {
    background: #e0f7fa;
    color: #A41E22;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.toggle-all-graphs-btn i {
    pointer-events: none;
}
.chart-view {
    width: 100%;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.subject-stats {
    transition: display 0.2s;
}
</style>
</body>

</html>
<?php } ?>