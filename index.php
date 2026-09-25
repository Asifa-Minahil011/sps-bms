<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SPS·BMS — Business Management System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="sidebar-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="mark">SB</div>
    <div class="word">SPS<span>·</span>BMS</div>
  </div>
  <div class="sidebar-scroll">
    <div class="nav-label">Main</div>
    <div class="nav-item active" data-page="dashboard" onclick="goPage('dashboard')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
      Dashboard
    </div>
    <div class="nav-label">Human Resource</div>
    <div class="nav-item" data-page="index" onclick="goPage('index')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Employees
    </div>
    <div class="nav-item" data-page="employee-detail" onclick="goPage('employee-detail')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M5 17c.7-2 2.4-3 4-3s3.3 1 4 3"/><path d="M14 9h5M14 13h5"/></svg>
      Employee Detail
    </div>
    <div class="nav-item" data-page="profile" onclick="goPage('profile')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4.5 5-6 8-6s6.5 1.5 8 6"/></svg>
      My Profile
    </div>
    <div class="nav-item" data-page="statement" onclick="goPage('statement')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5M9 13h6M9 17h6M9 9h2"/></svg>
      Statement
    </div>
    <div class="nav-label">Modules</div>
    <div class="nav-item disabled" onclick="showToast('Accounting module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8v4h8z"/></svg>
      Accounting
    </div>
    <div class="nav-item disabled" onclick="showToast('Legal module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M5 7l-3 6a3 3 0 0 0 6 0zM19 7l-3 6a3 3 0 0 0 6 0zM5 7h14M8 7l4-3 4 3"/></svg>
      Legal
    </div>
    <div class="nav-item disabled" onclick="showToast('IT module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      IT
    </div>
    <div class="nav-item disabled" onclick="showToast('Services module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.6 1.6 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.6 1.6 0 0 0-1.8-.3 1.6 1.6 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.6 1.6 0 0 0-1-1.5 1.6 1.6 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.6 1.6 0 0 0 .3-1.8 1.6 1.6 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.6 1.6 0 0 0 1.5-1 1.6 1.6 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.6 1.6 0 0 0 1.8.3H9a1.6 1.6 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.6 1.6 0 0 0 1 1.5 1.6 1.6 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.6 1.6 0 0 0-.3 1.8V9a1.6 1.6 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.6 1.6 0 0 0-1.5 1z"/></svg>
      Services
    </div>
    <div class="nav-item disabled" onclick="showToast('Sales module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l2.6 12.4A2 2 0 0 0 9.6 17H19a2 2 0 0 0 2-1.6L22.8 7H6"/><circle cx="9" cy="21" r="1"/><circle cx="18" cy="21" r="1"/></svg>
      Sales
    </div>
    <div class="nav-item disabled" onclick="showToast('Marketing module — sample navigation only')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11v2a1 1 0 0 0 1 1h3l5 4V6l-5 4H4a1 1 0 0 0-1 1z"/><path d="M17 8a5 5 0 0 1 0 8M20 5a9 9 0 0 1 0 14"/></svg>
      Marketing
    </div>
  </div>
</aside>

<div class="content-wrap">
  <header class="topbar">
    <button class="burger" onclick="toggleSidebar()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
    </button>
    <div class="topbar-search">
      <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      <input placeholder="Search employees, modules…" onclick="goPage('index');document.getElementById('empSearch').focus();">
    </div>
    <div class="topbar-right">
      <button class="icon-btn" onclick="showToast('Apps grid (demo)')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
      </button>
      <button class="icon-btn" onclick="showToast('No new notifications')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
        <span class="dot-badge"></span>
      </button>
      <div class="who">
        <button class="who-btn" onclick="toggleWho()">
          <span class="avatar">AM</span>
          <span class="who-info"><div class="nm">Asifa Minahil</div><div class="rl">Developer</div></span>
          <svg width="10" height="10" viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        </button>
        <div class="who-menu" id="whoMenu">
          <button onclick="goPage('profile');toggleWho()">👤 My Profile</button>
          <button onclick="goPage('statement');toggleWho()">🧾 My Statement</button>
          <button onclick="goPage('dashboard');toggleWho()">🏠 Dashboard</button>
          <button onclick="showToast('Signed out (demo)');toggleWho()">↩ Logout</button>
        </div>
      </div>
    </div>
  </header>

  <div class="page-topline">
    <div class="breadcrumb">SPS-BMS <span>›</span> <b id="crumbPage">Dashboard</b></div>
  </div>

  <main>

    <!-- ============ DASHBOARD ============ -->
    <section class="page active" id="page-dashboard">
      <div class="page-head">
        <h1>Welcome to BMS, Asifa</h1>
        <span class="badge badge-accent">Q3 FY2026</span>
      </div>

      <div class="dash-tabs">
        <button class="active" onclick="setDashTab(this,'roles')">Roles</button>
        <button onclick="setDashTab(this,'kpi')">KPI</button>
        <button onclick="setDashTab(this,'psp')">PSP</button>
      </div>

      <div id="dashRoles" class="goal-grid">
        <div class="goal-card"><span class="emoji">📊</span><h3>C1 – Financial Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Financial')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Financial')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>

        <div class="goal-card"><span class="emoji">🤝</span><h3>C2 – Customer Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Customer')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Customer')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>

        <div class="goal-card"><span class="emoji">🧩</span><h3>C2 – Partner Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Partner')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Partner')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>

        <div class="goal-card"><span class="emoji">💰</span><h3>C2 – Industry Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Industry')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Industry')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>

        <div class="goal-card"><span class="emoji">💡</span><h3>C3 – Competencies Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Competencies')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Competencies')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>

        <div class="goal-card"><span class="emoji">🧭</span><h3>C4 – Team Leadership Objectives</h3>
          <div class="goal-links"><a onclick="showToast('Opening Corporate Goals — Team')">👤 Corporate Goals</a><a onclick="showToast('Opening My Goals — Team')">👤 My Goals</a></div>
          <div class="qtag-row"><span class="qtag">Q1</span><span class="qtag">Q2</span><span class="qtag">Q3</span><span class="qtag">Q4</span></div></div>
      </div>

      <div id="dashKpi" style="display:none">
        <div class="card"><h2>KPI Summary — 2026</h2>
          <div class="grid-3">
            <div class="stat"><div class="icowrap" style="background:var(--success-tint);color:var(--success)">✓</div><div><div class="n">92%</div><div class="l">GOAL COMPLETION</div></div></div>
            <div class="stat"><div class="icowrap" style="background:var(--info-tint);color:var(--info)">★</div><div><div class="n">4.6</div><div class="l">AVG SELF-RATING</div></div></div>
            <div class="stat"><div class="icowrap" style="background:var(--accent-tint);color:#a06a12">$</div><div><div class="n">182K</div><div class="l">GROSS MARGIN YTD</div></div></div>
          </div>
        </div>
      </div>
      <div id="dashPsp" style="display:none">
        <div class="card"><h2>Personal Success Plan</h2><p style="color:var(--ink-soft);font-size:13px;margin:0">No PSP items have been submitted for this quarter yet.</p></div>
      </div>

      <p style="text-align:center;color:var(--ink-faint);font-size:11.5px;margin-top:30px;">Software Productivity Strategists, Inc. © Copyright 2026 SPS. All rights reserved.</p>
    </section>

    <!-- ============ INDEX (Employee list) ============ -->
    <section class="page" id="page-index">
      <div class="page-head">
        <div>
          <h1>Human Resource Management</h1>
          <p class="page-subtitle">Manage employees, HR records, onboarding, performance and workforce activity.</p>
        </div>
        <div class="inline-actions">
          <button class="btn" onclick="exportEmployees('csv')">Export CSV</button>
          <button class="btn" onclick="exportEmployees('excel')">Export Excel</button>
          <button class="btn btn-primary" onclick="openAddEmployeeModal()">+ Add New</button>
        </div>
      </div>

      <div class="stat-strip">
        <div class="stat"><div class="icowrap" style="background:var(--brand-tint);color:var(--brand)">👥</div><div><div class="n" id="statTotalEmployees">0</div><div class="l">TOTAL EMPLOYEES</div></div></div>
        <div class="stat"><div class="icowrap" style="background:var(--success-tint);color:var(--success)">●</div><div><div class="n" id="statActiveEmployees">0</div><div class="l">ACTIVE</div></div></div>
        <div class="stat"><div class="icowrap" style="background:var(--accent-tint);color:#a06a12">◐</div><div><div class="n" id="statInternEmployees">0</div><div class="l">INTERN / PROB</div></div></div>
        <div class="stat"><div class="icowrap" style="background:var(--danger-tint);color:var(--danger)">●</div><div><div class="n" id="statHoldEmployees">0</div><div class="l">ON HOLD / INACTIVE</div></div></div>
      </div>

      <div class="card hr-filter-card">
        <div class="search-row advanced-filter-row">
          <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input id="empSearch" placeholder="Search name, email, manager, group, practice…" oninput="filterEmployees()">
          </div>
          <select class="filter-select" id="empDept" onchange="filterEmployees()"><option value="">All Departments</option><option>Technical</option><option>Operations</option><option>Corporate</option><option>Sales</option></select>
          <select class="filter-select" id="empGroup" onchange="filterEmployees()"><option value="">All Groups</option></select>
          <select class="filter-select" id="empPractice" onchange="filterEmployees()"><option value="">All Practices</option></select>
          <select class="filter-select" id="empLocation" onchange="filterEmployees()"><option value="">All Locations</option><option>PK</option><option>US</option><option>Global</option></select>
          <select class="filter-select" id="empType" onchange="filterEmployees()"><option value="">All Types</option><option>Employee</option><option>Contractor</option><option>Service Provider</option></select>
          <select class="filter-select" id="empStatus" onchange="filterEmployees()"><option value="">All Status</option><option>Active</option><option>Inactive</option></select>
          <button class="btn btn-sm" onclick="resetEmployeeFilters()">Reset</button>
        </div>
        <div class="filter-summary"><span id="employeeResultCount">0 employees</span><span>Use the ⋮ action menu for HR workflows.</span></div>
      </div>

      <div class="table-wrap employee-table-wrap">
        <table>
          <thead><tr><th>Name</th><th>Type</th><th>Job Status</th><th>Manager</th><th>Department</th><th>Group</th><th>Practice</th><th>Location</th><th>Mobile No</th><th>Email</th><th>Status</th><th>Action</th></tr></thead>
          <tbody id="empTbody"></tbody>
        </table>
      </div>
    </section>

    <!-- ============ EMPLOYEE DETAIL ============ -->
    <section class="page" id="page-employee-detail">
      <div class="page-head">
        <div>
          <h1>Employee Detail — <span id="edName">Abdul Hameed</span></h1>
          <p class="page-subtitle">Complete HR master record, roles, KPI framework, learning, documents and cost information.</p>
        </div>
        <div class="inline-actions">
          <button class="btn" onclick="goPage('index')">← Back to list</button>
          <button class="btn btn-primary" onclick="saveEmployeeDetails()">Save Employee Details</button>
        </div>
      </div>

      <div class="employee-detail-layout">
        <div class="employee-detail-left">
          <div class="card detail-card">
            <h2>Employee</h2>
            <div class="field-row"><div class="field"><label>Name</label><input id="edField-name"></div><div class="field"><label>Type</label><select id="edField-type"><option>Employee</option><option>Contractor</option><option>Service Provider</option></select></div></div>
            <div class="field-row"><div class="field"><label>Work Status</label><select id="edField-workstatus"><option>Full Time</option><option>Part Time</option><option>Intern</option><option>On Hold</option></select></div><div class="field"><label>Gender</label><select id="edField-gender"><option>Male</option><option>Female</option><option>Other</option></select></div></div>
            <div class="field-row"><div class="field"><label>Email</label><input id="edField-email" type="email"></div><div class="field"><label>Personal Email</label><input id="edField-personalEmail" type="email"></div></div>
            <div class="field-row"><div class="field"><label>Employee CNIC</label><input id="edField-cnic" placeholder="xxxxx-xxxxxxx-x"></div><div class="field"><label>Date of Birth</label><input id="edField-dob" type="date"></div></div>
            <div class="field"><label>Residential Address</label><textarea id="edField-address" rows="2"></textarea></div>
            <div class="field-row"><div class="field"><label>Job Title</label><select id="edField-jobTitle"><option>Developer</option><option>Senior Developer</option><option>Project Manager</option><option>Consultant</option><option>Administrator</option></select></div><div class="field"><label>Business Area</label><input id="edField-businessArea"></div></div>
            <div class="field-row"><div class="field"><label>LinkedIn URL</label><input id="edField-linkedin"></div><div class="field"><label>Office No</label><input id="edField-officeNo"></div></div>
            <div class="field-row"><div class="field"><label>Mobile No</label><input id="edField-mobile"></div><div class="field"><label>Emergency No</label><input id="edField-emergency"></div></div>
            <div class="field-row"><div class="field"><label>Home No</label><input id="edField-homeNo"></div><div class="field"><label>Company</label><select id="edField-company"><option>SPS</option><option>Spinnlabs</option><option>Other</option></select></div></div>
            <div class="field-row"><div class="field"><label>Location</label><select id="edField-loc"><option>PK</option><option>US</option><option>Global</option></select></div><div class="field"><label>Office Location</label><select id="edField-officeLoc"><option>Islamabad</option><option>Remote</option><option>Virginia</option><option>Maryland</option></select></div></div>
            <div class="field-row"><div class="field"><label>Department</label><select id="edField-dept"><option>Operations</option><option>Technical</option><option>Corporate</option><option>Sales</option></select></div><div class="field"><label>Group</label><select id="edField-group"><option>Administrative</option><option>Cloud</option><option>Security</option><option>Spinnlabs</option><option>R &amp; D</option><option>Energy</option></select></div></div>
            <div class="field-row"><div class="field"><label>Practice</label><select id="edField-practice"><option>DevOps</option><option>AppDev</option><option>IAM</option><option>Automation</option><option>Data Science</option><option>Corporate</option></select></div><div class="field"><label>Hire Source</label><select id="edField-hireSource"><option>Referral</option><option>LinkedIn</option><option>Job Board</option><option>University</option><option>Direct</option></select></div></div>
            <div class="field-row"><div class="field"><label>Employee Picture</label><input id="edFile-picture" type="file" accept="image/*" onchange="rememberEmployeeFile('picture',this)"><small class="file-note" id="edFileNote-picture"></small></div><div class="field"><label>Educational Level</label><select id="edField-educationLevel"><option>Bachelors</option><option>Masters</option><option>Doctorate</option><option>Diploma</option><option>Other</option></select></div></div>
            <div class="field-row"><div class="field"><label>Upload Degree</label><input id="edFile-degree" type="file" onchange="rememberEmployeeFile('degree',this)"><small class="file-note" id="edFileNote-degree"></small></div><div class="field"><label>CNIC Front Picture</label><input id="edFile-cnicFront" type="file" accept="image/*" onchange="rememberEmployeeFile('cnicFront',this)"><small class="file-note" id="edFileNote-cnicFront"></small></div></div>
            <div class="field-row"><div class="field"><label>CNIC Back Picture</label><input id="edFile-cnicBack" type="file" accept="image/*" onchange="rememberEmployeeFile('cnicBack',this)"><small class="file-note" id="edFileNote-cnicBack"></small></div><div class="field"><label>Upload Resume</label><input id="edFile-resume" type="file" accept=".pdf,.doc,.docx" onchange="rememberEmployeeFile('resume',this)"><small class="file-note" id="edFileNote-resume"></small></div></div>
            <label class="check-line"><input id="edField-spsCorporate" type="checkbox"> SPS Corporate</label>
          </div>

          <div class="card detail-card">
            <h2>Guardian / Parent Information</h2>
            <div class="field-row"><div class="field"><label>Parent/Guardian Name</label><input id="edField-guardianName"></div><div class="field"><label>Parent/Guardian Contact</label><input id="edField-guardianContact"></div></div>
            <div class="field"><label>Parent/Guardian Address</label><textarea id="edField-guardianAddress" rows="2"></textarea></div>
          </div>

          <div class="card detail-card">
            <h2>Employee Education</h2>
            <div class="field-row"><div class="field"><label>University</label><input id="edField-university"></div><div class="field"><label>Field of Study</label><input id="edField-fieldOfStudy"></div></div>
            <div class="field-row"><div class="field"><label>Passing Year</label><input id="edField-passingYear"></div><div class="field"><label>Course</label><input id="edField-course"></div></div>
            <div class="field"><label>Grade / GPA</label><input id="edField-gpa"></div>
          </div>

          <div class="card detail-card">
            <h2>Supervisor</h2>
            <div class="field-row"><div class="field"><label>Name</label><select id="edField-supName"></select></div><div class="field"><label>Email</label><input id="edField-supEmail" readonly></div></div>
          </div>

          <div class="card detail-card">
            <h2>Learning and Development <button class="btn btn-sm" style="margin-left:auto" onclick="openRecordEditor('learning')">+ Add</button></h2>
            <div class="table-wrap compact-table detail-scroll"><table><thead><tr><th>Sr</th><th>Course Name</th><th>Training Taken</th><th>Test Taken</th><th>Action</th></tr></thead><tbody id="learningBody"></tbody></table></div>
          </div>

          <div class="card detail-card">
            <h2>Attachments <button class="btn btn-sm" style="margin-left:auto" onclick="openRecordEditor('attachment')">+ Add New</button></h2>
            <div class="table-wrap compact-table"><table><thead><tr><th>Sr</th><th>Title</th><th>File</th><th>Action</th></tr></thead><tbody id="attachmentsBody"></tbody></table></div>
          </div>

          <div class="card detail-card">
            <h2>Communication Skills <button class="btn btn-sm" style="margin-left:auto" onclick="openRecordEditor('communication')">+ Add New</button></h2>
            <div class="table-wrap compact-table"><table><thead><tr><th>Sr</th><th>Added By</th><th>Speaking</th><th>Writing</th><th>Listening</th><th>Date</th><th>Action</th></tr></thead><tbody id="communicationBody"></tbody></table></div>
          </div>
        </div>

        <div class="employee-detail-right">
          <div class="card detail-card">
            <div class="employee-role-header"><span>Job Title:</span><span class="badge badge-info" id="edJobTitleBadge">Developer</span></div>
            <div class="mini-section-title">Corporate Roles <button class="text-action" onclick="openRecordEditor('corporateRoles')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>Role</th><th>Level</th><th>Level Title</th><th>Rank</th><th>Action</th></tr></thead><tbody id="corporateRolesBody"></tbody></table></div>

            <div class="mini-section-title">Departmental Roles <button class="text-action" onclick="openRecordEditor('departmentalRoles')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>Role</th><th>Level</th><th>Level Title</th><th>Rank</th><th>Action</th></tr></thead><tbody id="departmentalRolesBody"></tbody></table></div>

            <div class="mini-section-title">Employment History <button class="text-action" onclick="openRecordEditor('employmentHistory')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>Sr</th><th>Start Date</th><th>End Date</th><th>Job Title</th><th>Corp. Role</th><th>Dept. Role</th><th>Func. Role</th><th>Duration</th><th>Action</th></tr></thead><tbody id="employmentHistoryBody"></tbody></table></div>
          </div>

          <div class="card detail-card">
            <h2>Department Attributes</h2>
            <div class="mini-section-title">Customers <button class="text-action" onclick="openRecordEditor('departmentCustomers')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>ID</th><th>Name</th><th>Action</th></tr></thead><tbody id="departmentCustomersBody"></tbody></table></div>
            <div class="mini-section-title">Projects <button class="text-action" onclick="openRecordEditor('projects')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>ID</th><th>Name</th><th>Action</th></tr></thead><tbody id="projectsBody"></tbody></table></div>
            <div class="mini-section-title">Products <button class="text-action" onclick="openRecordEditor('products')">+ Add</button></div>
            <div class="table-wrap compact-table"><table><thead><tr><th>ID</th><th>Name</th><th>Action</th></tr></thead><tbody id="productsBody"></tbody></table></div>
          </div>

          <div class="card detail-card kpi-card">
            <div class="kpi-heading-row"><h2>Comp Framework: KPIs</h2><div class="field kpi-period-field"><label>Period</label><select id="kpiPeriod" onchange="saveKpiPeriod(this.value)"><option>2026 · Q1</option><option>2026 · Q2</option><option>2026 · Q3</option><option>2026 · Q4</option></select></div></div>
            <div class="matrix-section"><div class="mini-section-title">Personal Leadership <button class="text-action" onclick="addKpiRow('personalLeadership')">+ Add</button></div><div class="matrix-scroll"><table class="matrix-table"><thead><tr><th>Leadership Incentive</th><th>% Multiplier</th><th>Practice Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiPersonalLeadershipBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Corporate Leadership — Vendors <button class="text-action" onclick="addKpiRow('vendors')">+ Add</button></div><div class="matrix-scroll matrix-tall"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Vendor Name</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiVendorsBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Products <button class="text-action" onclick="addKpiRow('matrixProducts')">+ Add</button></div><div class="matrix-scroll matrix-tall"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Department</th><th>Group</th><th>Practice</th><th>Vendor</th><th>Product Name</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiProductsBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Services <button class="text-action" onclick="addKpiRow('services')">+ Add</button></div><div class="matrix-scroll"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Department</th><th>Group</th><th>Practice</th><th>Vendor</th><th>Service Name</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiServicesBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Practices <button class="text-action" onclick="addKpiRow('practices')">+ Add</button></div><div class="matrix-scroll matrix-tall"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Department</th><th>Group</th><th>Practice</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiPracticesBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Customers <button class="text-action" onclick="addKpiRow('customers')">+ Add</button></div><div class="matrix-scroll matrix-tall"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Customer Name</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiCustomersBody"></tbody></table></div></div>
            <div class="matrix-section"><div class="mini-section-title">Partners <button class="text-action" onclick="addKpiRow('partners')">+ Add</button></div><div class="matrix-scroll matrix-tall"><table class="matrix-table"><thead><tr><th>Sr No.</th><th>Partner Name</th><th>Practice Multiplier</th><th>% Multiplier</th><th>KPI Target</th><th>KPI Actual</th><th>Bonus Target</th><th>Bonus Actual</th><th>Plan</th><th>Action</th></tr></thead><tbody id="kpiPartnersBody"></tbody></table></div></div>
          </div>
        </div>
      </div>

      <div class="card" id="certifications">
        <h2>Employee Certifications <button class="btn btn-sm" style="margin-left:auto" onclick="openCertificationModal()">+ Add Certification</button></h2>
        <div class="table-wrap"><table><thead><tr><th>Sr</th><th>Vendor</th><th>Group</th><th>Practice</th><th>Product</th><th>Title</th><th>Code</th><th>URL</th><th>Type</th><th>Completed On</th><th>Action</th></tr></thead><tbody id="certTableBody"></tbody></table></div>
      </div>

      <div class="card">
        <h2>Employee Badges <button class="btn btn-sm" style="margin-left:auto" onclick="openRecordEditor('badges')">+ Add Badge</button></h2>
        <div class="table-wrap"><table><thead><tr><th>Sr</th><th>Vendor</th><th>Group</th><th>Practice</th><th>Product</th><th>Title</th><th>URL</th><th>Completed On</th><th>Action</th></tr></thead><tbody id="badgeTableBody"></tbody></table></div>
      </div>

      <div class="card loaded-cost-card">
        <div class="loaded-cost-head"><div><h2>Employee Loaded Cost (Q1 · 2026)</h2><div class="loaded-cost-meta"><b data-employee-name>Abdul Hameed</b><span>·</span><span data-location-label>PK</span></div></div><button class="btn btn-sm" onclick="loadLoadedCost()">↻ Refresh</button></div>
        <p class="helper-text">All inputs are based on annual values. The demo stores the latest values locally for each employee.</p>
        <div class="loaded-cost-grid">
          <label>Base Hourly Rate <span class="money-input"><span>$</span><input id="loadedBase" type="number" step="0.01" min="0" oninput="calculateLoadedCost()"></span></label>
          <label>+ Individual Load <span class="money-input"><span>$</span><input id="loadedIndividual" type="number" step="0.01" min="0" oninput="calculateLoadedCost()"></span></label>
          <label>Practice Load <span class="money-input"><span>$</span><input id="loadedPractice" type="number" step="0.01" min="0" oninput="calculateLoadedCost()"></span></label>
          <label>Loaded Rate <span class="money-input readonly"><span>$</span><input id="loadedRate" readonly></span></label>
          <label>Loaded Rate (Last Year) <span class="money-input"><span>$</span><input id="loadedLastYear" type="number" step="0.01" min="0"></span></label>
        </div>
        <button class="btn btn-primary btn-sm" onclick="saveLoadedCost()">Update Loaded Rate</button>
      </div>
    </section>

    <!-- ============ PROFILE ============ -->
    <section class="page" id="page-profile">
      <div class="page-head"><h1>My Profile</h1></div>

      <div class="profile-head">
        <div class="profile-avatar">AM</div>
        <div>
          <h1>Asifa Minahil</h1>
          <div class="role">Administrative · Developer, Level 2 — Associate</div>
        </div>
        <span class="badge badge-success" style="margin-left:auto">Full-time</span>
      </div>

      <div class="grid-2">
        <div>
          <div class="card">
            <h2>Employee</h2>
            <div class="kv"><span class="k">Location</span><span class="v">PK</span></div>
            <div class="kv"><span class="k">Group</span><span class="v">Administrative</span></div>
            <div class="kv"><span class="k">Date of Hire</span><span class="v">02/01/2010</span></div>
            <div class="kv"><span class="k">Status</span><span class="v">Full-time</span></div>
          </div>

          <div class="card">
            <h2>Contact Information</h2>
            <div class="field-row">
              <div class="field"><label>Mobile No</label><input value="+92 311 8811906"></div>
              <div class="field"><label>Emergency No</label><input placeholder="—"></div>
            </div>
            <div class="field-row">
              <div class="field"><label>Home No</label><input placeholder="—"></div>
              <div class="field"><label>Email</label><input value="abdul.hameed@spsnet.com"></div>
            </div>
          </div>

          <div class="card">
            <h2>Supervisor</h2>
            <div class="field-row">
              <div class="field"><label>Name</label><input value="Hash Malik" readonly></div>
              <div class="field"><label>Email</label><input value="Hash.Malik@spsnet.com" readonly></div>
            </div>
          </div>
        </div>

        <div>
          <div class="card">
            <h2>Resume</h2>
            <div class="field"><label>Upload Resume (doc, docx, pdf)</label><input type="file"></div>
            <div class="field"><label>LinkedIn URL</label><input placeholder="https://linkedin.com/in/…"></div>
          </div>

          <div class="card">
            <h2>Bio</h2>
            <textarea rows="4" placeholder="Tell your team a little about yourself…"></textarea>
            <button class="btn btn-primary btn-sm" style="margin-top:10px" onclick="showToast('Profile updated (demo)')">Update</button>
          </div>

          <div class="card">
            <h2>Certifications <button class="btn btn-sm" style="margin-left:auto" onclick="goPage('employee-detail');setTimeout(()=>document.getElementById('certifications').scrollIntoView({behavior:'smooth',block:'start'}),120)">View in Employee Detail →</button></h2>
            <p style="font-size:12.5px;color:var(--ink-faint);margin:0">No certifications on file.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ STATEMENT ============ -->
    <section class="page" id="page-statement">
      <div class="page-head"><h1>Consultant Statement</h1><button class="btn" onclick="window.print()">🖨 Print</button></div>
      <p style="color:var(--ink-soft);font-size:13px;margin-top:-10px;">Abdul Hameed &nbsp;|&nbsp; Location: PK &nbsp;|&nbsp; Status: Full Time</p>

      <div class="statement-controls">
        <div class="field"><label>Year</label><select><option>2026</option><option>2025</option></select></div>
        <div class="field"><label>Quarter</label><select><option>Q1</option><option selected>Q2</option><option>Q3</option><option>Q4</option></select></div>
        <div class="field"><label>Month</label><select><option>April</option><option selected>May</option><option>June</option></select></div>
        <button class="btn btn-primary" onclick="showToast('Statement refreshed (demo)')">Show</button>
        <label style="display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--ink-soft);"><input type="checkbox"> Validated</label>
      </div>

      <div class="grid-2">
        <div class="card">
          <div class="subhead">Gross Margin Contribution from Services Delivery</div>
          <div class="table-wrap" style="max-height:none;">
            <table><thead><tr><th>Client / Project / Job</th><th>Hours</th><th>Customer Rate</th><th>Revenue / Costs</th></tr></thead>
            <tbody><tr class="empty-row"><td colspan="4">No Record Found</td></tr></tbody></table>
          </div>

          <div class="subhead">Gross Margin Contribution From Sales</div>
          <div class="table-wrap" style="max-height:none;">
            <table><thead><tr><th>Client / Project / Job</th><th>Revenue / Costs</th></tr></thead>
            <tbody><tr class="empty-row"><td colspan="2">No Record Found</td></tr></tbody></table>
          </div>
          <div class="total-row"><span>Total Gross Margin Contribution</span><span class="amt">0.00</span></div>
        </div>

        <div class="card">
          <div class="subhead">Project Owner Bonus</div>
          <div class="kv"><span class="k">Total</span><span class="v mono">0.00</span></div>
          <div class="subhead">Project Owner Overhead</div>
          <div class="kv"><span class="k">Total</span><span class="v mono">0.00</span></div>
          <div class="total-row"><span>Total Bonus</span><span class="amt">0.00</span></div>
          <div class="kv"><span class="k">Consultant Revenue Benefit Multiplier</span><span class="v mono">1.00</span></div>
        </div>
      </div>

      <div class="card">
        <div class="subhead">Cost — Individual Load</div>
        <div class="table-wrap" style="max-height:none;">
          <table><thead><tr><th>Hours</th><th>Individual Rate</th><th>Cost</th></tr></thead>
          <tbody><tr><td>0</td><td class="mono">1.02</td><td class="mono">0.00</td></tr></tbody></table>
        </div>
        <div class="grid-3" style="margin-top:14px;">
          <div><div class="subhead">Travel</div><p style="font-size:12px;color:var(--ink-faint)">No expenses recorded.</p></div>
          <div><div class="subhead">Training</div><p style="font-size:12px;color:var(--ink-faint)">No expenses recorded.</p></div>
          <div><div class="subhead">Others</div><p style="font-size:12px;color:var(--ink-faint)">No expenses recorded.</p></div>
        </div>
        <div class="total-row"><span>Gross Margin</span><span class="amt">0.00</span></div>
      </div>
    </section>


    <!-- ============ EMPLOYEE BLOG ============ -->
    <section class="page" id="page-blog">
      <div class="page-head"><div><h1>Employee Blog</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Internal employee notes and updates</p></div><button class="btn" onclick="goPage('index')">← Back to Employees</button></div>
      <div class="card editor-card">
        <div class="card-toolbar"><div><h2 style="margin:0">Add New</h2><span class="helper-text">Create an internal blog entry. Drafts are stored locally in this demo.</span></div><span class="badge badge-info">Internal</span></div>
        <div class="rich-toolbar">
          <select onchange="editorBlock(this.value);this.selectedIndex=0"><option value="">Format</option><option value="h2">Heading</option><option value="p">Paragraph</option><option value="blockquote">Quote</option></select>
          <button type="button" onclick="editorCommand('bold')"><b>B</b></button><button type="button" onclick="editorCommand('italic')"><i>I</i></button><button type="button" onclick="editorCommand('underline')"><u>U</u></button>
          <span class="toolbar-sep"></span><button type="button" onclick="editorCommand('insertUnorderedList')">• List</button><button type="button" onclick="editorCommand('insertOrderedList')">1. List</button>
          <button type="button" onclick="insertEditorLink()">🔗 Link</button><button type="button" onclick="editorCommand('removeFormat')">Clear</button>
        </div>
        <div id="blogEditor" class="rich-editor" contenteditable="true" data-placeholder="Write an employee update, achievement, note, or announcement..."></div>
        <div class="editor-footer"><span id="blogWordCount" class="helper-text">0 words</span><div class="inline-actions"><button class="btn" onclick="clearBlogEditor()">Clear</button><button class="btn btn-primary" onclick="saveBlogEntry()">Save Entry</button></div></div>
      </div>
      <div class="card"><h2>Recent Entries</h2><div id="blogEntries" class="timeline-list"></div></div>
    </section>

    <!-- ============ FORM A ============ -->
    <section class="page" id="page-form-a">
      <div class="page-head"><div><h1>Form-A</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Employee information verification</p></div><button class="btn" onclick="goPage('index')">← Back</button></div>
      <div class="card form-shell"><h2>Employee Information</h2><div class="grid-3"><div class="field"><label>Employee Name</label><input class="employee-name-input" readonly></div><div class="field"><label>Department</label><input id="formADept" readonly></div><div class="field"><label>Location</label><input id="formALoc" readonly></div></div><div class="field"><label>Current Responsibilities</label><textarea id="formAResponsibilities" rows="5" placeholder="Summarize current responsibilities..."></textarea></div><div class="field"><label>HR Notes</label><textarea id="formANotes" rows="4" placeholder="Add verification notes..."></textarea></div><div class="inline-actions"><button class="btn" onclick="resetStoredForm('formA')">Reset</button><button class="btn btn-primary" onclick="saveSimpleForm('formA')">Save Form-A</button></div></div>
    </section>

    <!-- ============ FORM B ============ -->
    <section class="page" id="page-form-b">
      <div class="page-head"><div><h1>Form-B</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Quarterly employee review</p></div><button class="btn" onclick="goPage('index')">← Back</button></div>
      <div class="card form-shell"><h2>Quarterly Review</h2><div class="grid-3"><div class="field"><label>Year</label><select id="formBYear"><option>2026</option><option>2025</option></select></div><div class="field"><label>Quarter</label><select id="formBQuarter"><option>Q1</option><option>Q2</option><option>Q3</option><option>Q4</option></select></div><div class="field"><label>Overall Rating</label><select id="formBRating"><option>Exceeds Expectations</option><option selected>Meets Expectations</option><option>Needs Development</option></select></div></div><div class="field"><label>Achievements</label><textarea id="formBAchievements" rows="4" placeholder="Key achievements..."></textarea></div><div class="field"><label>Development Priorities</label><textarea id="formBDevelopment" rows="4" placeholder="Development priorities..."></textarea></div><div class="inline-actions"><button class="btn" onclick="resetStoredForm('formB')">Reset</button><button class="btn btn-primary" onclick="saveSimpleForm('formB')">Save Form-B</button></div></div>
    </section>

    <!-- ============ PLANS ============ -->
    <section class="page" id="page-plans">
      <div class="page-head"><div><h1>Planning Form of <span data-employee-name>Abdul Hameed</span></h1><p class="page-subtitle">Annual and quarterly development planning</p></div><button class="btn" onclick="goPage('index')">← Back</button></div>
      <div class="stat-strip"><div class="stat"><div class="icowrap" style="background:var(--brand-tint);color:var(--brand)">▣</div><div><div class="n">1</div><div class="l">ACTIVE PLAN</div></div></div><div class="stat"><div class="icowrap" style="background:var(--success-tint);color:var(--success)">✓</div><div><div class="n">4</div><div class="l">QUARTERS</div></div></div><div class="stat"><div class="icowrap" style="background:var(--info-tint);color:var(--info)">↗</div><div><div class="n">72%</div><div class="l">PLAN PROGRESS</div></div></div></div>
      <div class="card"><div class="table-wrap" style="max-height:none"><table><thead><tr><th>S.No</th><th>Year</th><th>Quarter</th><th>Plans</th><th>Status</th><th>Action</th></tr></thead><tbody><tr><td>1</td><td>2026</td><td>Annual</td><td><span class="badge badge-info">Review</span></td><td><span class="badge badge-success">Initiated</span></td><td><button class="btn btn-sm" onclick="togglePlanWorkspace()">Open Plan</button></td></tr></tbody></table></div></div>
      <div id="planWorkspace" class="card" style="display:none"><h2>2026 Development Plan</h2><div class="grid-3"><div class="field"><label>Business Goal</label><input id="planGoal" value="Improve delivery quality and automation"></div><div class="field"><label>Target Date</label><input id="planDate" type="date" value="2026-12-15"></div><div class="field"><label>Progress</label><input id="planProgress" type="number" min="0" max="100" value="72"></div></div><div class="field"><label>Plan Notes</label><textarea id="planNotes" rows="4">Complete role objectives, improve client communication, and deliver automation initiatives.</textarea></div><button class="btn btn-primary" onclick="savePlan()">Save Plan</button></div>
    </section>

    <!-- ============ PERFORMANCE ============ -->
    <section class="page" id="page-performance">
      <div class="page-head"><div><h1>Performance Data — <span data-employee-name>Abdul Hameed</span></h1><p class="page-subtitle">Revenue, utilization, certifications, communication and potential</p></div><div class="inline-actions"><button class="btn btn-success-soft" onclick="openEmployeeFeature(currentEmployeeName(),'timelive')">TimeLive</button><button class="btn btn-success-soft" onclick="openEmployeeFeature(currentEmployeeName(),'demand')">Demand</button><button class="btn" onclick="goPage('index')">Back</button></div></div>
      <div class="filter-bar"><div class="field"><label>Year</label><select id="performanceYear" onchange="renderPerformanceCharts()"><option>2026</option><option>2025</option><option>2024</option></select></div><button class="btn btn-primary" onclick="renderPerformanceCharts()">Show</button></div>
      <div class="performance-grid"><div class="card chart-card"><h2>Revenue and Margin</h2><canvas id="chartRevenue" height="180"></canvas></div><div class="card chart-card"><h2>Percent Utilization</h2><canvas id="chartUtilization" height="180"></canvas></div><div class="card chart-card"><h2>No. of Certifications</h2><canvas id="chartCerts" height="180"></canvas></div><div class="card chart-card"><h2>Communication Skills</h2><canvas id="chartCommunication" height="180"></canvas></div></div>
      <div class="card section-panel"><div class="panel-title">Skills Matrix</div><div class="skills-matrix"><div><span>JavaScript</span><b>Advanced</b></div><div><span>Cloud / DevOps</span><b>Intermediate</b></div><div><span>Client Communication</span><b>Advanced</b></div><div><span>Leadership</span><b>Developing</b></div></div></div>
      <div class="card section-panel"><div class="panel-title">Performance Monitor</div><div class="choice-grid" id="performanceMonitorChoices"><button onclick="selectChoice(this)"><b>TOO NEW</b><small>Less than six months of employment</small></button><button onclick="selectChoice(this)"><b>MOVE</b><small>Performance or organizational fit requires a move</small></button><button onclick="selectChoice(this)"><b>MONITOR</b><small>Low performance. Consider a performance plan.</small></button><button onclick="selectChoice(this)"><b>DEVELOP IN PLACE</b><small>Solid, valued performer with ability to grow</small></button><button onclick="selectChoice(this)"><b>TOP PERFORMANCE</b><small>Top performer with leadership potential</small></button><button class="selected" onclick="selectChoice(this)"><b>HIGH POTENTIAL</b><small>Highest level of performance and potential</small></button></div></div>
      <div class="card section-panel"><div class="panel-title">Performance Dimensions</div><div class="dimension-grid"><button onclick="selectDimension(this,'Performance')"><b>PERFORMANCE</b><small>What is the employee's performance rating during the last three years?</small></button><button onclick="selectDimension(this,'Ambition')"><b>AMBITION</b><small>What are the employee's current and future goals?</small></button><button onclick="selectDimension(this,'Runway')"><b>RUNWAY</b><small>How capable is the employee to advance to a new role?</small></button><button onclick="selectDimension(this,'Leadership')"><b>LEADERSHIP</b><small>Does the employee demonstrate leadership characteristics?</small></button><button onclick="selectDimension(this,'Agility')"><b>AGILITY</b><small>How flexible and adaptive is the employee and how do they deal with change?</small></button><button onclick="selectDimension(this,'Influence')"><b>INFLUENCE</b><small>Do fellow colleagues and supervisors value the employee's opinion?</small></button></div></div>
      <div class="card section-panel"><div class="panel-title">Employee Potential Assessment</div><div class="choice-grid compact"><button onclick="selectChoice(this)"><b>Critical Role</b><small>Crucial to organizational outcomes</small></button><button onclick="selectChoice(this)"><b>Flight Risk</b><small>Likelihood of leaving the company</small></button><button onclick="selectChoice(this)"><b>Successor</b><small>Ready to step into a key role</small></button><button class="selected" onclick="selectChoice(this)"><b>Hard to fill role</b><small>Scarce or specialized skills</small></button></div></div>
      <div class="card section-panel"><div class="panel-title">Employee Potential Performance</div><div class="nine-box"><button>Risk</button><button>Inconsistent Player</button><button>Average Performer</button><button>Potential Gem</button><button>Core Player</button><button>Solid Performer</button><button>High Potential</button><button>High Performer</button><button class="selected">Star</button></div></div>
    </section>

    <!-- ============ DEMAND ============ -->
    <section class="page" id="page-demand">
      <div class="page-head"><div><h1>Demand &amp; Capacity — <span data-employee-name>Abdul Hameed</span></h1><p class="page-subtitle">Allocation visibility across practices and projects</p></div><button class="btn" onclick="openEmployeeFeature(currentEmployeeName(),'performance')">← Performance</button></div>
      <div class="stat-strip"><div class="stat"><div class="icowrap" style="background:var(--success-tint);color:var(--success)">84%</div><div><div class="n">33.6h</div><div class="l">ALLOCATED / WEEK</div></div></div><div class="stat"><div class="icowrap" style="background:var(--accent-tint);color:#a06a12">6.4</div><div><div class="n">6.4h</div><div class="l">AVAILABLE</div></div></div><div class="stat"><div class="icowrap" style="background:var(--info-tint);color:var(--info)">3</div><div><div class="n">3</div><div class="l">ACTIVE ASSIGNMENTS</div></div></div></div>
      <div class="card"><h2>Practice Demand</h2><div class="table-wrap" style="max-height:none"><table><thead><tr><th>Practice</th><th>Project / Client</th><th>Requested</th><th>Allocated</th><th>Gap</th><th>Priority</th></tr></thead><tbody><tr><td>AppDev</td><td>BMS Modernization</td><td>20h</td><td>20h</td><td><span class="badge badge-success">0h</span></td><td>High</td></tr><tr><td>DevOps</td><td>Cloud Automation</td><td>12h</td><td>8h</td><td><span class="badge badge-accent">4h</span></td><td>Medium</td></tr><tr><td>Internal</td><td>Learning &amp; Development</td><td>5.6h</td><td>5.6h</td><td><span class="badge badge-success">0h</span></td><td>Normal</td></tr></tbody></table></div></div>
    </section>

    <!-- ============ TIMELIVE ============ -->
    <section class="page" id="page-timelive">
      <div class="page-head"><div><h1><span data-employee-name>Abdul Hameed</span> TimeLive Blog</h1><p class="page-subtitle">Time entries, customer activity and partner notes</p></div><button class="btn" onclick="openEmployeeFeature(currentEmployeeName(),'performance')">← Performance</button></div>
      <div class="filter-bar centered"><div class="field"><label>Start Date</label><input type="date" id="tlStart" value="2026-05-04"></div><div class="field"><label>End Date</label><input type="date" id="tlEnd" value="2026-05-08"></div><button class="btn btn-primary" onclick="renderTimeLive()">Show</button></div>
      <div class="card section-panel"><div class="panel-title">TimeLive Blog</div><div class="table-tools"><label>Show <select id="tlPageSize" onchange="renderTimeLive()"><option>5</option><option selected>10</option><option>25</option></select> entries</label><div class="search-box compact"><input id="tlSearch" placeholder="Search" oninput="renderTimeLive()"></div></div><div class="table-wrap" style="max-height:none"><table><thead><tr><th>Sr No.</th><th>Date</th><th>Client Name</th><th>Project Name</th><th>Task Name</th><th>Task Description</th><th>Hours</th></tr></thead><tbody id="timeLiveBody"></tbody></table></div><div id="timeLiveSummary" class="table-summary"></div></div>
      <div class="card section-panel"><div class="panel-title">Customer Blog</div><div class="empty-state compact">No customer blog entries found for the selected period.</div></div>
      <div class="card section-panel"><div class="panel-title">Customer Contact Blog</div><div class="empty-state compact">No Record Found!</div></div>
      <div class="card section-panel"><div class="panel-title">Partner Blog</div><div class="empty-state compact">No Record Found!</div></div>
    </section>

    <!-- ============ WEEKLY PERFORMANCE ============ -->
    <section class="page" id="page-weekly-performance">
      <div class="page-head"><div><h1>Weekly Performance — <span data-employee-name>Abdul Hameed</span></h1><p class="page-subtitle">Operational performance trend for the current quarter</p></div><button class="btn" onclick="goPage('index')">← Back</button></div>
      <div class="card"><h2>Q3 Weekly Scorecard</h2><div id="weeklyRows" class="weekly-list"></div></div>
    </section>

    <!-- ============ ONBOARDING CHECKLIST ============ -->
    <section class="page" id="page-onboarding-checklist">
      <div class="page-head"><div><h1>Onboarding Checklist for <span data-location-label>PK</span> Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Employee documents, orientation and administration</p></div><button class="btn btn-primary" onclick="saveChecklist('onboardingChecklist')">Save Checklist</button></div>
      <div class="card checklist-card"><div class="table-wrap" style="max-height:none"><table class="checklist-table"><thead><tr><th>Sr No.</th><th>Name</th><th>Applicable</th><th>Not Applicable</th><th>Notes</th></tr></thead><tbody id="onboardingChecklistBody"></tbody></table></div></div>
    </section>

    <!-- ============ ONBOARDING PLAN ============ -->
    <section class="page" id="page-onboarding-plan">
      <div class="page-head"><div><h1>Onboarding Plan for <span data-location-label>PK</span> Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Structured HR onboarding workflow</p></div><button class="btn btn-primary" onclick="sendWorkflowEmail('Onboarding Plan')">Send Email</button></div>
      <div class="card plan-table-card"><div class="panel-title centered-title">HR Onboarding</div><div class="table-wrap" style="max-height:none"><table class="workflow-table"><thead><tr><th>Sr No.</th><th>Module</th><th>Task</th><th>Sub Task</th><th>Responsible Party</th></tr></thead><tbody id="onboardingPlanBody"></tbody></table></div></div>
    </section>

    <!-- ============ ONBOARDING STEPS ============ -->
    <section class="page" id="page-onboarding-steps">
      <div class="page-head"><div><h1>Onboarding Steps for Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Best-practice onboarding readiness</p></div><button class="btn btn-primary" onclick="saveChecklist('onboardingSteps')">Save Steps</button></div>
      <div class="card checklist-card"><div class="table-wrap" style="max-height:none"><table class="checklist-table"><thead><tr><th>Sr No.</th><th>Name</th><th>Applied</th><th>Not Applied</th><th>Notes</th></tr></thead><tbody id="onboardingStepsBody"></tbody></table></div></div>
    </section>

    <!-- ============ ORIENTATION PLAN ============ -->
    <section class="page" id="page-orientation-plan">
      <div class="page-head"><div><h1>Orientation Plan for <span data-location-label>PK</span> Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Role-specific orientation schedule</p></div><div class="inline-actions"><button class="btn" onclick="saveOrientationPlan()">Save</button><button class="btn btn-primary" onclick="sendWorkflowEmail('Orientation Plan')">Send Email</button></div></div>
      <div class="card plan-table-card"><div class="panel-title centered-title">Orientation Plan</div><div class="table-wrap" style="max-height:none"><table class="orientation-table"><thead><tr><th>Sr No.</th><th>Training Module</th><th>Day</th><th>Date</th><th>Duration</th><th>Feedback</th></tr></thead><tbody id="orientationPlanBody"></tbody></table></div></div>
    </section>

    <!-- ============ OFFBOARDING CHECKLIST ============ -->
    <section class="page" id="page-offboarding-checklist">
      <div class="page-head"><div><h1>Offboarding Checklist for <span data-location-label>PK</span> Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Controlled account, asset and data closure</p></div><div class="inline-actions"><button class="btn" onclick="setChecklistScope('Accounting')">Accounting</button><button class="btn" onclick="setChecklistScope('HR')">HR</button><button class="btn" onclick="setChecklistScope('Client')">Client</button><button class="btn btn-primary" onclick="setChecklistScope('IT')">IT</button></div></div>
      <div class="card checklist-card"><div class="table-wrap" style="max-height:none"><table class="checklist-table"><thead><tr><th>Name</th><th>Yes</th><th>No</th><th>Not Applicable</th><th>Notes</th></tr></thead><tbody id="offboardingChecklistBody"></tbody></table></div></div>
      <div class="inline-actions end"><button class="btn" onclick="openOffboardingReasons()">Select Offboarding Reasons</button><button class="btn btn-primary" onclick="saveChecklist('offboardingChecklist')">Save Checklist</button></div>
    </section>

    <!-- ============ OFFBOARDING PLAN ============ -->
    <section class="page" id="page-offboarding-plan">
      <div class="page-head"><div><h1>Offboarding Plan for <span data-location-label>PK</span> Employee</h1><p class="page-subtitle"><span data-employee-name>Abdul Hameed</span> · Voluntary termination and closure workflow</p></div><button class="btn btn-primary" onclick="sendWorkflowEmail('Offboarding Plan')">Send Email</button></div>
      <div class="card plan-table-card"><div class="panel-title centered-title">HR Offboarding</div><div class="table-wrap" style="max-height:none"><table class="workflow-table offboarding"><thead><tr><th>Sr No.</th><th>Module</th><th>Task</th><th>Responsible Party</th></tr></thead><tbody id="offboardingPlanBody"></tbody></table></div></div>
    </section>

  </main>

  <footer>SPS-BMS revamp · Velzon-inspired theme · demo data for illustration only</footer>
</div>

<!-- ================= MODAL: Hours Distribution ================= -->
<div class="modal-overlay" id="modalHours">
  <div class="modal">
    <div class="modal-head"><h3>Hours Distribution</h3><button onclick="closeModal('modalHours')">✕</button></div>
    <div class="modal-body" id="hoursTree"></div>
    <div class="modal-foot">
      <span style="font-size:12.5px;color:var(--ink-soft);flex:1;">Total allocated: <b class="mono" id="hoursTotal" style="margin-left:6px;color:var(--ink)">0.0</b></span>
      <button class="btn" onclick="closeModal('modalHours')">Close</button>
      <button class="btn btn-primary" onclick="saveHoursDistribution()">Save</button>
    </div>
  </div>
</div>

<!-- ================= MODAL: HR Talk ================= -->
<div class="modal-overlay" id="modalHRTalk">
  <div class="modal wide">
    <div class="modal-head"><h3>HR Talk — Quarterly Check-in</h3><button onclick="closeModal('modalHRTalk')">✕</button></div>
    <div class="modal-body">
      <div class="hrtalk-toolbar">
        <span><b>B</b></span><span><i>I</i></span><span style="text-decoration:underline">U</span><span>¶</span><span>🔗</span><span>🖼</span><span>▤</span><span>≣</span>
      </div>
      <div class="hrtalk-q">
        <p>What's going well in your role?</p>
        <p>What challenges or obstacles are you facing?</p>
        <p>How are you feeling being an SPS employee?</p>
        <p>Describe your overall experience and any aspects of the company culture or environment that you appreciate.</p>
        <p>On a scale of 1–10, how fulfilled are you? With 1 being the least satisfied and 10 being the most satisfied.</p>
        <p>How would you describe your working relationship with your manager or supervisor? Any specific feedback or suggestions?</p>
        <p>Are there any concerns related to work hours, schedules, or workload that you'd like to address?</p>
        <p>Can you suggest three actionable ideas or improvements that you believe could benefit the company?</p>
        <p>How can we support your professional development?</p>
        <p>What additional support or resources would enhance your job performance and job satisfaction?</p>
        <p>Is there anything else we can provide to make your work experience better?</p>
      </div>
      <textarea id="hrTalkAnswer" class="hrtalk-answer" placeholder="Write your responses here…"></textarea>
    </div>
    <div class="modal-foot">
      <label class="send-check" style="margin-right:auto"><input id="hrTalkSendEmail" type="checkbox"> Send Email</label>
      <button class="btn" onclick="closeModal('modalHRTalk')">Close</button>
      <button class="btn btn-primary" onclick="saveHRTalk()">Save</button>
    </div>
  </div>
</div>


<!-- ================= MODAL: Offboarding Reasons ================= -->
<div class="modal-overlay" id="modalOffboardingReasons"><div class="modal"><div class="modal-head"><h3>Offboarding Reasons</h3><button onclick="closeModal('modalOffboardingReasons')">✕</button></div><div class="modal-body"><div id="offboardingReasonsList" class="reason-list"></div></div><div class="modal-foot"><button class="btn" onclick="closeModal('modalOffboardingReasons')">Close</button><button class="btn btn-primary" onclick="saveOffboardingReasons()">Save</button></div></div></div>

<!-- ================= MODAL: Letter Preview ================= -->
<div class="modal-overlay" id="modalLetter"><div class="modal wide"><div class="modal-head"><h3 id="letterModalTitle">Document Preview</h3><button onclick="closeModal('modalLetter')">✕</button></div><div class="modal-body"><div id="letterPreview" class="letter-preview"></div></div><div class="modal-foot"><button class="btn" onclick="printCurrentLetter()">Print</button><button class="btn" onclick="downloadCurrentLetter()">Download HTML</button><button class="btn btn-primary" onclick="closeModal('modalLetter')">Done</button></div></div></div>

<!-- ================= MODAL: Certification ================= -->
<div class="modal-overlay" id="modalCertification"><div class="modal"><div class="modal-head"><h3 id="certModalTitle">Add Certification</h3><button onclick="closeModal('modalCertification')">✕</button></div><div class="modal-body"><div class="field-row"><div class="field"><label>Vendor</label><input id="certVendor" placeholder="Microsoft, AWS, Cisco..."></div><div class="field"><label>Group</label><input id="certGroup" placeholder="Cloud"></div></div><div class="field-row"><div class="field"><label>Practice</label><input id="certPractice" placeholder="DevOps"></div><div class="field"><label>Product</label><input id="certProduct" placeholder="Azure, AWS, Security..."></div></div><div class="field-row"><div class="field"><label>Title</label><input id="certTitle" placeholder="Certification title"></div><div class="field"><label>Code</label><input id="certCode" placeholder="CERT-001"></div></div><div class="field-row"><div class="field"><label>URL</label><input id="certUrl" type="url" placeholder="https://..."></div><div class="field"><label>Type</label><select id="certType"><option>Certification</option><option>Accreditation</option><option>Training</option></select></div></div><div class="field"><label>Completed On</label><input id="certCompleted" type="date"></div></div><div class="modal-foot"><button class="btn" onclick="closeModal('modalCertification')">Cancel</button><button class="btn btn-primary" onclick="saveCertification()">Save Certification</button></div></div></div>

<!-- ================= MODAL: Add Employee ================= -->
<div class="modal-overlay" id="modalAddEmployee"><div class="modal wide"><div class="modal-head"><h3>Add New Employee</h3><button onclick="closeModal('modalAddEmployee')">✕</button></div><div class="modal-body"><div class="grid-3"><div class="field"><label>Name *</label><input id="newEmpName"></div><div class="field"><label>Type</label><select id="newEmpType"><option>Employee</option><option>Contractor</option><option>Service Provider</option></select></div><div class="field"><label>Job Status</label><select id="newEmpJob"><option>Full time</option><option>Part time</option><option>Intern</option><option>On Hold</option></select></div><div class="field"><label>Manager</label><input id="newEmpManager"></div><div class="field"><label>Department</label><select id="newEmpDept"><option>Technical</option><option>Operations</option><option>Corporate</option><option>Sales</option></select></div><div class="field"><label>Group</label><input id="newEmpGroup"></div><div class="field"><label>Practice</label><input id="newEmpPractice"></div><div class="field"><label>Location</label><select id="newEmpLocation"><option>PK</option><option>US</option><option>Global</option></select></div><div class="field"><label>Mobile</label><input id="newEmpMobile"></div><div class="field"><label>Email *</label><input id="newEmpEmail" type="email"></div><div class="field"><label>Status</label><select id="newEmpStatus"><option>Active</option><option>Inactive</option></select></div></div></div><div class="modal-foot"><button class="btn" onclick="closeModal('modalAddEmployee')">Cancel</button><button class="btn btn-primary" onclick="saveNewEmployee()">Add Employee</button></div></div></div>

<!-- ================= MODAL: Generic Record Editor ================= -->
<div class="modal-overlay" id="modalRecordEditor"><div class="modal wide"><div class="modal-head"><h3 id="recordModalTitle">Add Record</h3><button onclick="closeModal('modalRecordEditor')">✕</button></div><div class="modal-body"><div id="recordFormFields" class="record-form-grid"></div></div><div class="modal-foot"><button class="btn" onclick="closeModal('modalRecordEditor')">Cancel</button><button class="btn btn-primary" onclick="saveRecordEditor()">Save Record</button></div></div></div>

<div class="toast" id="toast"></div>

<script src="script.js"></script>
</body>
</html>