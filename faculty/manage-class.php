<?php 
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:../index.php');
    exit();
}
?>
document.addEventListener('DOMContentLoaded', function() {
    populateTable(students);
});>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Class || Assignment & Notebook Tracking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin-responsive.css">
    <link rel="stylesheet" href="assets/css/responsive-class.css">
    <style>
      html, body {
        width: 100vw !important;
        min-width: 100vw !important;
        max-width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
        box-sizing: border-box;
        background: #fff;
      }
      .pcoded-main-container, .pcoded-content {
        width: 100vw !important;
        min-width: 100vw !important;
        max-width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box;
      }
    </style>
</head>
<body>
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php');?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="row">
            <div class="col-12">
                <div class="card flat-card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <div>
                                <h4 style="color:#1abc9c; font-weight:600; margin-bottom: 4px;">Manage Class</h4>
                                <p style="color:#666; margin-bottom: 0;">Course: <span style="color:#0097A7;font-weight:600;">Physics 201</span> &nbsp; | &nbsp; Division: <span style="color:#A41E22;font-weight:600;">A</span></p>
                            </div>
                            <div class="d-flex flex-wrap gap-3 stats-container">
                                <div class="stat-box text-center">
                                    <div class="stat-title">Total Students</div>
                                    <div class="stat-value" id="total-students">25</div>
                                </div>
                                <div class="stat-box text-center">
                                    <div class="stat-title">Notebook Submitted</div>
                                    <div class="stat-value" id="notebook-submitted">20</div>
                                </div>
                                <div class="stat-box text-center">
                                    <div class="stat-title">Assignments Submitted</div>
                                    <div class="stat-value" id="assignment-submitted">18</div>
                                </div>
                                <div class="stat-box text-center">
                                    <div class="stat-title">Pending Assignments</div>
                                    <div class="stat-value" id="pending-assignments">7</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <h5 style="color:#0097A7;">Student List</h5>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search students..." style="border-radius:8px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sm" id="students-table">
                                        <thead style="background:#f8f9fa;">
                                            <tr>
                                                <th>Sr No</th>
                                                <th class="sortable" data-sort="name">Student <span class="sort-icon">↕</span></th>
                                                <th class="sortable" data-sort="notebook">Notebook Status <span class="sort-icon">↕</span></th>
                                                <th><input type="checkbox" id="selectAllNotebooks"></th>
                                                <th class="sortable" data-sort="assignment">Assignment Status <span class="sort-icon">↕</span></th>
                                                <th><input type="checkbox" id="selectAllAssignments"></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <nav>
                                    <ul class="pagination justify-content-center" id="students-pagination"></ul>
                                </nav>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button class="btn btn-primary" style="background:#1abc9c; border:none; border-radius:12px; padding:10px 20px;">Export Submissions</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Example student data (replace with PHP from DB)
// Add event listeners for select all checkboxes
document.getElementById('selectAllNotebooks').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.notebook-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

document.getElementById('selectAllAssignments').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.assignment-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// Function to populate table with student data
function populateTable(studentsData) {
    const tbody = document.querySelector('#students-table tbody');
    tbody.innerHTML = '';
    
    studentsData.forEach((student, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${student.name}</td>
            <td>${student.notebook}</td>
            <td>
                <input type="checkbox" class="notebook-checkbox" id="notebook-${student.roll}">
                <label for="notebook-${student.roll}">Notebook ${index + 1}</label>
            </td>
            <td>${student.assignment}</td>
            <td>
                <input type="checkbox" class="assignment-checkbox" id="assignment-${student.roll}">
                <label for="assignment-${student.roll}">Assignment ${index + 1}</label>
            </td>
        `;
        tbody.appendChild(row);
    });
}

const students = [
    {name: 'Alice Johnson', email: 'alice.johnson@example.com', roll: 'U2021001', image: 'https://randomuser.me/api/portraits/women/1.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Bob Lee', email: 'bob.lee@example.com', roll: 'U2021002', image: 'https://randomuser.me/api/portraits/men/2.jpg', notebook: 'Pending', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 8, totalNotebooks: 5, notebooksSubmitted: 4},
    {name: 'Cathy Smith', email: 'cathy.smith@example.com', roll: 'U2021003', image: 'https://randomuser.me/api/portraits/women/3.jpg', notebook: 'Submitted', assignment: 'Pending', totalAssignments: 10, assignmentsSubmitted: 7, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'David Brown', email: 'david.brown@example.com', roll: 'U2021004', image: 'https://randomuser.me/api/portraits/men/4.jpg', notebook: 'Submitted', assignment: 'Overdue', totalAssignments: 10, assignmentsSubmitted: 6, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Eve Adams', email: 'eve.adams@example.com', roll: 'U2021005', image: 'https://randomuser.me/api/portraits/women/5.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Frank Green', email: 'frank.green@example.com', roll: 'U2021006', image: 'https://randomuser.me/api/portraits/men/6.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Grace Lee', email: 'grace.lee@example.com', roll: 'U2021007', image: 'https://randomuser.me/api/portraits/women/7.jpg', notebook: 'Pending', assignment: 'Pending', totalAssignments: 10, assignmentsSubmitted: 5, totalNotebooks: 5, notebooksSubmitted: 3},
    {name: 'Helen White', email: 'helen.white@example.com', roll: 'U2021008', image: 'https://randomuser.me/api/portraits/women/8.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Ian Black', email: 'ian.black@example.com', roll: 'U2021009', image: 'https://randomuser.me/api/portraits/men/9.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Jane Doe', email: 'jane.doe@example.com', roll: 'U2021010', image: 'https://randomuser.me/api/portraits/women/10.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Kevin Smith', email: 'kevin.smith@example.com', roll: 'U2021011', image: 'https://randomuser.me/api/portraits/men/11.jpg', notebook: 'Pending', assignment: 'Pending', totalAssignments: 10, assignmentsSubmitted: 4, totalNotebooks: 5, notebooksSubmitted: 2},
    {name: 'Linda Brown', email: 'linda.brown@example.com', roll: 'U2021012', image: 'https://randomuser.me/api/portraits/women/12.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Mike Lee', email: 'mike.lee@example.com', roll: 'U2021013', image: 'https://randomuser.me/api/portraits/men/13.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Nina White', email: 'nina.white@example.com', roll: 'U2021014', image: 'https://randomuser.me/api/portraits/women/14.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Oscar Black', email: 'oscar.black@example.com', roll: 'U2021015', image: 'https://randomuser.me/api/portraits/men/15.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Paul Doe', email: 'paul.doe@example.com', roll: 'U2021016', image: 'https://randomuser.me/api/portraits/men/16.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Vera Doe', email: 'vera.doe@example.com', roll: 'U2021022', image: 'https://randomuser.me/api/portraits/women/17.jpg', notebook: 'Pending', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 9, totalNotebooks: 5, notebooksSubmitted: 4},
    {name: 'Will Smith', email: 'will.smith@example.com', roll: 'U2021023', image: 'https://randomuser.me/api/portraits/men/18.jpg', notebook: 'Submitted', assignment: 'Pending', totalAssignments: 10, assignmentsSubmitted: 7, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Xena Brown', email: 'xena.brown@example.com', roll: 'U2021024', image: 'https://randomuser.me/api/portraits/women/19.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5},
    {name: 'Yuri Lee', email: 'yuri.lee@example.com', roll: 'U2021025', image: 'https://randomuser.me/api/portraits/men/20.jpg', notebook: 'Submitted', assignment: 'Submitted', totalAssignments: 10, assignmentsSubmitted: 10, totalNotebooks: 5, notebooksSubmitted: 5}
];

const rowsPerPage = 10;
let currentPage = 1;

function renderTable(page) {
    const tbody = document.querySelector('#students-table tbody');
    tbody.innerHTML = '';
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageStudents = students.slice(start, end);
    pageStudents.forEach((student, idx) => {
        tbody.innerHTML += `
            <tr>
                <td style="vertical-align:middle;">${start + idx + 1}</td>
                <td style="vertical-align:middle;">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${student.image}" alt="${student.name}" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;border:2px solid #e3e8ee;">
                        <div>
                            <span style="font-weight:600;color:#102d4a;">${student.name}</span><br>
                            <span style="font-size:0.95em;color:#666;">${student.email}</span><br>
                            <span style="font-size:0.9em;color:#A41E22;">${student.roll}</span>
                        </div>
                    </div>
                </td>               
                <td style="vertical-align:middle;">
                    <span class="badge badge-${student.notebook === 'Submitted' ? 'success' : student.notebook === 'Pending' ? 'warning' : 'secondary'}">${student.notebooksSubmitted}/${student.totalNotebooks} ${student.notebook}</span>
                </td>
                <td style="vertical-align:middle;">
                    <span >Helo</span>
                </td>
                <td style="vertical-align:middle;">
                    <span class="badge badge-${student.assignment === 'Submitted' ? 'success' : student.assignment === 'Pending' ? 'warning' : student.assignment === 'Overdue' ? 'danger' : 'secondary'}">${student.assignmentsSubmitted}/${student.totalAssignments} ${student.assignment}</span>
                </td>
                <td style="vertical-align:middle;">
                    <span >Helo</span>
                </td>
            </tr>
        `;
    });
}

function renderPagination() {
    const totalPages = Math.ceil(students.length / rowsPerPage);
    const pagination = document.getElementById('students-pagination');
    pagination.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#">${i}</a></li>`;
    }
    // Add click event
    Array.from(pagination.querySelectorAll('a')).forEach((a, idx) => {
        a.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = idx + 1;
            renderTable(currentPage);
            renderPagination();
        });
    });
}

// Search functionality
let filteredStudents = [...students];
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    filteredStudents = students.filter(student => 
        student.name.toLowerCase().includes(searchTerm) ||
        student.email.toLowerCase().includes(searchTerm) ||
        student.roll.toLowerCase().includes(searchTerm)
    );
    currentPage = 1;
    renderTable(currentPage);
    renderPagination();
});

// Sorting functionality
let currentSort = { column: '', direction: 'asc' };
document.querySelectorAll('.sortable').forEach(header => {
    header.addEventListener('click', function() {
        const column = this.getAttribute('data-sort');
        
        // Update sort direction
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'asc';
        }

        // Update sort icons
        document.querySelectorAll('.sort-icon').forEach(icon => {
            icon.textContent = '↕';
        });
        this.querySelector('.sort-icon').textContent = currentSort.direction === 'asc' ? '↓' : '↑';

        // Sort the filtered students
        filteredStudents.sort((a, b) => {
            let valueA, valueB;
            if (column === 'name') {
                valueA = a.name;
                valueB = b.name;
            } else if (column === 'notebook') {
                valueA = a.notebook;
                valueB = b.notebook;
            } else if (column === 'assignment') {
                valueA = a.assignment;
                valueB = b.assignment;
            }

            if (valueA < valueB) return currentSort.direction === 'asc' ? -1 : 1;
            if (valueA > valueB) return currentSort.direction === 'asc' ? 1 : -1;
            return 0;
        });

        currentPage = 1;
        renderTable(currentPage);
        renderPagination();
    });
});

// Modified render functions to use filteredStudents instead of students
function renderTable(page) {
    const tbody = document.querySelector('#students-table tbody');
    tbody.innerHTML = '';
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageStudents = filteredStudents.slice(start, end);
    pageStudents.forEach((student, idx) => {
        tbody.innerHTML += `
            <tr>
                <td style="vertical-align:middle;">${start + idx + 1}</td>
                <td style="vertical-align:middle;">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${student.image}" alt="${student.name}" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;border:2px solid #e3e8ee;">
                        <div>
                            <span style="font-weight:600;color:#102d4a;">${student.name}</span><br>
                            <span style="font-size:0.95em;color:#666;">${student.email}</span><br>
                            <span style="font-size:0.9em;color:#A41E22;">${student.roll}</span>
                        </div>
                    </div>
                </td>
                <td style="vertical-align:middle;">
                    <span class="badge badge-${student.notebook === 'Submitted' ? 'success' : student.notebook === 'Pending' ? 'warning' : 'secondary'}">${student.notebooksSubmitted}/${student.totalNotebooks} ${student.notebook}</span>
                </td>
                <td style="vertical-align:middle;">
                    <input type="checkbox" class="notebook-checkbox" id="notebook-${student.roll}" ${student.notebook === 'Submitted' ? 'checked' : ''}>
                </td>
                <td style="vertical-align:middle;">
                    <span class="badge badge-${student.assignment === 'Submitted' ? 'success' : student.assignment === 'Pending' ? 'warning' : student.assignment === 'Overdue' ? 'danger' : 'secondary'}">${student.assignmentsSubmitted}/${student.totalAssignments} ${student.assignment}</span>
                </td>
                <td style="vertical-align:middle;">
                    <input type="checkbox" class="assignment-checkbox" id="assignment-${student.roll}" ${student.assignment === 'Submitted' ? 'checked' : ''}>
                </td>
            </tr>
        `;
    });
}

function renderPagination() {
    const totalPages = Math.ceil(filteredStudents.length / rowsPerPage);
    const pagination = document.getElementById('students-pagination');
    pagination.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#">${i}</a></li>`;
    }
    // Add click event
    Array.from(pagination.querySelectorAll('a')).forEach((a, idx) => {
        a.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = idx + 1;
            renderTable(currentPage);
            renderPagination();
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Analytics update
    document.getElementById('total-students').textContent = students.length;
    document.getElementById('notebook-submitted').textContent = students.filter(s => s.notebook === 'Submitted').length;
    document.getElementById('assignment-submitted').textContent = students.filter(s => s.assignment === 'Submitted').length;
    document.getElementById('pending-assignments').textContent = students.filter(s => s.assignment === 'Pending' || s.assignment === 'Overdue').length;
    renderTable(currentPage);
    renderPagination();
});
</script>
<style>
    .stat-box {
        background: rgba(255,255,255,0.18);
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        border: 1.5px solid #e3e8ee;
        min-width: 120px;
        margin: 0 8px;
        padding: 12px 8px;
        display: inline-block;
    }
    .stat-title {
        color: #0097A7;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 2px;
    }
    .stat-value {
        font-size: 1.7rem;
        font-weight: 700;
        color: #1abc9c;
    }
    .sortable {
        cursor: pointer;
        user-select: none;
    }
    .sortable:hover {
        background-color: #f0f0f0;
    }
    .sort-icon {
        display: inline-block;
        margin-left: 5px;
        color: #666;
    }
    #searchInput {
        border: 1px solid #e3e8ee;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }
    #searchInput:focus {
        border-color: #0097A7;
        box-shadow: 0 0 0 0.2rem rgba(0, 151, 167, 0.25);
        outline: none;
    }
    @media (max-width: 991px) {
        .stat-box { min-width: 90px; font-size: 0.95em; }
        .stat-title { font-size: 0.95em; }
        .stat-value { font-size: 1.2rem; }
        .table-responsive { font-size: 0.95em; }
        .d-flex.gap-2 { gap: 6px !important; }
    }
    @media (max-width: 600px) {
        .stat-box { min-width: 70px; font-size: 0.9em; padding: 8px 4px; }
        .stat-title { font-size: 0.9em; }
        .stat-value { font-size: 1rem; }
        .table-responsive { font-size: 0.9em; }
        .d-flex.gap-2 { gap: 4px !important; }
        img.rounded-circle { width: 32px !important; height: 32px !important; }
    }

    /* Custom checkbox styling */
    input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        background: white;
        border: 2px solid #1abc9c;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }

    input[type="checkbox"]:checked {
        background: #1abc9c;
        border-color: #1abc9c;
    }

    input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 14px;
        font-weight: bold;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    input[type="checkbox"]:hover {
        border-color: #16a085;
        box-shadow: 0 0 5px rgba(26, 188, 156, 0.3);
    }

    #selectAllNotebooks,
    #selectAllAssignments {
        margin-right: 8px;
    }

    .notebook-checkbox,
    .assignment-checkbox {
        margin: 0 auto;
        display: block;
    }
</style>
</body>
</html>

