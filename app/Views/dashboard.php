<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Executive Analytics Dashboard') ?></title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --app-sidebar-width: 270px;
            --app-sidebar-collapsed-width: 80px;
            --app-header-height: 68px;
            --app-transition-speed: 0.25s;
            --card-radius: 1rem;
        }

        /* Light & Dark Base Adjustments */
        [data-bs-theme="light"] {
            --body-bg: #f4f6fa;
            --surface-bg: #ffffff;
            --sidebar-bg: #0f172a;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: #1e293b;
            --sidebar-active-color: #38bdf8;
            --border-subtle: #e2e8f0;
            --metric-bg: #ffffff;
            --header-bg: rgba(255, 255, 255, 0.85);
        }

        [data-bs-theme="dark"] {
            --body-bg: #090d16;
            --surface-bg: #111827;
            --sidebar-bg: #0b101b;
            --sidebar-color: #9ca3af;
            --sidebar-active-bg: #1f2937;
            --sidebar-active-color: #60a5fa;
            --border-subtle: #1f2937;
            --metric-bg: #131b2e;
            --header-bg: rgba(17, 24, 39, 0.85);
        }

        body {
            background-color: var(--body-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--bs-body-color);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Layout Structure */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar */
        .app-sidebar {
            width: var(--app-sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: all var(--app-transition-speed) ease-in-out;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            overflow-y: auto;
        }

        .sidebar-brand {
            height: var(--app-header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            color: #ffffff;
        }

        .sidebar-brand .brand-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.35);
        }

        .sidebar-menu {
            padding: 1.25rem 0.85rem;
            flex-grow: 1;
        }

        .menu-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            font-weight: 700;
            padding: 0.5rem 0.75rem 0.35rem;
            margin-top: 0.75rem;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            padding: 0.65rem 0.85rem;
            color: var(--sidebar-color);
            text-decoration: none;
            border-radius: 0.65rem;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.18s ease;
            margin-bottom: 0.25rem;
        }

        .nav-item-link i {
            font-size: 1.15rem;
            margin-right: 0.85rem;
            width: 22px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .nav-item-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.07);
        }

        .nav-item-link:hover i {
            transform: scale(1.1);
        }

        .nav-item-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #0d6efd 0%, #0a58ca 100%);
            box-shadow: 0 4px 14px rgba(13, 110, 253, 0.3);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
        }

        /* App Main Area */
        .app-main {
            flex-grow: 1;
            margin-left: var(--app-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--app-transition-speed) ease-in-out;
        }

        /* Top Header Navbar */
        .app-header {
            height: var(--app-header-height);
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
        }

        .header-search {
            position: relative;
            max-width: 360px;
            width: 100%;
        }

        .header-search input {
            border-radius: 999px;
            padding-left: 2.5rem;
            padding-right: 3rem;
            background: rgba(125, 125, 125, 0.08);
            border: 1px solid var(--border-subtle);
            font-size: 0.9rem;
        }

        .header-search input:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            background-color: var(--surface-bg);
        }

        .header-search .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .header-search .search-kbd {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.7rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            background: rgba(125, 125, 125, 0.15);
            border: 1px solid rgba(125, 125, 125, 0.2);
            color: #64748b;
        }

        /* Content Body */
        .app-content {
            padding: 1.75rem;
            flex-grow: 1;
        }

        /* Modern Cards */
        .card-custom {
            background-color: var(--surface-bg);
            border: 1px solid var(--border-subtle);
            border-radius: var(--card-radius);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        }

        /* Performance Isolation for Dashboard Widget Columns (modern-web-guidance) */
        .dashboard-contain-region {
            content-visibility: auto;
            contain-intrinsic-size: auto 300px auto 450px;
        }

        @supports not (content-visibility: auto) {
            .dashboard-contain-region {
                contain: layout style paint;
            }
        }

        /* Metric KPI Card Styling */
        .metric-card {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border-radius: var(--card-radius);
            background-color: var(--surface-bg);
            border: 1px solid var(--border-subtle);
            position: relative;
            overflow: hidden;
        }

        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* Modern Data Table with sticky header & container query (modern-web-guidance) */
        .table-wrapper {
            overflow: auto;
            max-inline-size: 100%;
            max-block-size: 480px;
            container-type: inline-size;
            border-radius: 0.75rem;
            border: 1px solid var(--border-subtle);
        }

        .table-wrapper:focus-visible {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        .table-custom {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead {
            position: sticky;
            inset-block-start: 0;
            z-index: 2;
            background-color: var(--surface-bg);
        }

        .table-custom thead th {
            background-color: rgba(125, 125, 125, 0.05);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            font-weight: 700;
            padding: 0.95rem 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            white-space: nowrap;
        }

        .table-custom tbody td,
        .table-custom tbody th {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-subtle);
            font-size: 0.9rem;
            background-color: var(--surface-bg);
        }

        .table-custom tbody tr:hover td,
        .table-custom tbody tr:hover th {
            background-color: rgba(125, 125, 125, 0.03);
        }

        /* Mobile Container Query Transformation for Data Table */
        @container (max-width: 680px) {
            .table-custom,
            .table-custom thead,
            .table-custom tbody,
            .table-custom tr,
            .table-custom th,
            .table-custom td {
                display: block;
            }

            .table-custom thead {
                display: none; /* Accessible fallback: hidden for visual stacked layout */
            }

            .table-custom tbody tr {
                margin-bottom: 1rem;
                border: 1px solid var(--border-subtle);
                border-radius: 0.75rem;
                padding: 0.75rem;
                background-color: var(--surface-bg);
            }

            .table-custom tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0.25rem;
                border-bottom: 1px dashed var(--border-subtle);
                text-align: right;
            }

            .table-custom tbody td:last-child {
                border-bottom: none;
            }

            .table-custom tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.8rem;
                text-transform: uppercase;
                color: #64748b;
                text-align: left;
                padding-right: 1rem;
            }
        }

        /* Timeline Feed */
        .timeline-widget {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-widget::before {
            content: '';
            position: absolute;
            top: 6px;
            bottom: 6px;
            left: 11px;
            width: 2px;
            background-color: var(--border-subtle);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            background-color: var(--surface-bg);
            border: 2px solid;
            z-index: 1;
        }

        /* Mobile Sidebar Backdrop & Responsive Behavior */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            backdrop-filter: blur(2px);
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.show {
                transform: translateX(0);
            }

            .sidebar-backdrop.show {
                display: block;
            }

            .app-main {
                margin-left: 0;
            }
        }

        /* Quick Action Cards */
        .quick-action-btn {
            background-color: rgba(125, 125, 125, 0.05);
            border: 1px dashed var(--border-subtle);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .quick-action-btn:hover {
            background-color: rgba(13, 110, 253, 0.08);
            border-color: #0d6efd;
            transform: translateY(-2px);
            color: #0d6efd;
        }

        .spin-animation {
            animation: spinOnce 0.6s ease-in-out;
        }

        @keyframes spinOnce {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="app-layout">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar Navigation -->
    <aside class="app-sidebar" id="appSidebar" aria-label="Main Navigation">
        <!-- Sidebar Brand -->
        <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
            <div class="brand-logo-icon me-2">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>
            <div>
                <div class="fw-bold fs-6 lh-1">NexusCore</div>
                <small class="text-secondary" style="font-size: 0.72rem;">CI4 Admin Suite v2.4</small>
            </div>
        </a>

        <!-- Sidebar Navigation Menu -->
        <div class="sidebar-menu">
            <div class="menu-header">Overview</div>
            <a href="<?= site_url('dashboard') ?>" class="nav-item-link active" aria-current="page">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Analytics View', 'Analytics module preview will be displayed here.')">
                <i class="bi bi-graph-up"></i>
                <span>Analytics</span>
                <span class="badge bg-primary-subtle text-primary ms-auto" style="font-size: 0.7rem;">Live</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Reports', 'Report generation is ready.')">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Reports</span>
            </a>

            <div class="menu-header">Management</div>
            <a href="#ordersSection" class="nav-item-link">
                <i class="bi bi-receipt"></i>
                <span>Orders</span>
                <span class="badge bg-success ms-auto rounded-pill" style="font-size: 0.7rem;"><?= count($recentOrders) ?></span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Customers', 'Customer directory is loaded.')">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Products', 'Inventory catalogue ready.')">
                <i class="bi bi-box-seam"></i>
                <span>Products</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Invoices', 'Billing & invoicing manager.')">
                <i class="bi bi-credit-card"></i>
                <span>Invoices</span>
            </a>

            <div class="menu-header">Administration</div>
            <a href="<?= site_url('login') ?>" class="nav-item-link">
                <i class="bi bi-shield-lock"></i>
                <span>Auth / Login UI</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Settings', 'Application settings panel opened.')">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
            <a href="javascript:void(0)" class="nav-item-link" onclick="showToast('Audit Log', 'Viewing system audit logs.')">
                <i class="bi bi-journal-text"></i>
                <span>Audit Logs</span>
            </a>

            <!-- Plan / Quota Widget -->
            <div class="p-3 mx-1 mt-4 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-light">Cloud Storage</span>
                    <span class="badge bg-primary text-white" style="font-size: 0.68rem;">64%</span>
                </div>
                <div class="progress" style="height: 6px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 64%" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-secondary d-block mt-2" style="font-size: 0.72rem;">12.8 GB of 20 GB used</small>
            </div>
        </div>

        <!-- Sidebar User Footer -->
        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <img src="<?= esc($currentUser['avatar']) ?>" alt="<?= esc($currentUser['name']) ?>" class="rounded-circle border border-2 border-primary" width="36" height="36" style="object-fit: cover;">
                    <div class="text-truncate">
                        <div class="text-light small fw-bold text-truncate"><?= esc($currentUser['name']) ?></div>
                        <div class="text-secondary" style="font-size: 0.72rem;"><?= esc($currentUser['role']) ?></div>
                    </div>
                </div>
                <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-light border-0" title="Log Out">
                    <i class="bi bi-box-arrow-right fs-6"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="app-main" id="appMain">

        <!-- Top Header Navigation -->
        <header class="app-header">
            <div class="d-flex align-items-center gap-3">
                <!-- Hamburger Button (Mobile & Desktop) -->
                <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center" id="sidebarToggle" aria-label="Toggle navigation menu">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <!-- Search Input Bar -->
                <div class="header-search d-none d-md-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control" id="globalSearchInput" placeholder="Search orders, metrics, users..." aria-label="Search">
                    <span class="search-kbd">/</span>
                </div>
            </div>

            <!-- Header Right Actions -->
            <div class="d-flex align-items-center gap-2">
                <!-- Theme Mode Switcher -->
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2 py-1 d-flex align-items-center gap-1" id="themeToggleBtn" title="Toggle Light / Dark mode" aria-label="Toggle theme">
                    <i class="bi bi-sun-fill text-warning" id="themeIcon"></i>
                    <span class="small d-none d-sm-inline" id="themeLabel">Light</span>
                </button>

                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border position-relative rounded-circle p-2" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border p-2" style="width: 320px;" aria-labelledby="notifDropdown">
                        <li class="d-flex justify-content-between align-items-center px-2 py-1 mb-1">
                            <span class="fw-bold small">Notifications</span>
                            <span class="badge bg-primary-subtle text-primary small">3 Unread</span>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item rounded p-2 d-flex gap-2 align-items-start" href="javascript:void(0)">
                                <div class="bg-success-subtle text-success p-2 rounded-circle fs-6">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div class="small">
                                    <div class="fw-semibold">Payout sent successfully</div>
                                    <span class="text-muted" style="font-size: 0.75rem;">$1,249.00 transferred via Stripe &bull; 10m ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded p-2 d-flex gap-2 align-items-start" href="javascript:void(0)">
                                <div class="bg-warning-subtle text-warning p-2 rounded-circle fs-6">
                                    <i class="bi bi-shield-exclamation"></i>
                                </div>
                                <div class="small">
                                    <div class="fw-semibold">SSL Certificate Renewal</div>
                                    <span class="text-muted" style="font-size: 0.75rem;">Renews automatically in 14 days &bull; 2h ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded p-2 d-flex gap-2 align-items-start" href="javascript:void(0)">
                                <div class="bg-info-subtle text-info p-2 rounded-circle fs-6">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="small">
                                    <div class="fw-semibold">New user registration</div>
                                    <span class="text-muted" style="font-size: 0.75rem;">Marcus Chen verified account &bull; 5h ago</span>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item text-center small text-primary fw-medium py-1" href="javascript:void(0)">Mark all as read</a>
                        </li>
                    </ul>
                </div>

                <!-- Quick Action Modal Trigger -->
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#quickActionModal">
                    <i class="bi bi-plus-lg"></i>
                    <span class="d-none d-sm-inline">Quick Add</span>
                </button>

                <!-- User Profile Dropdown -->
                <div class="dropdown ms-1">
                    <button class="btn btn-sm p-0 d-flex align-items-center gap-2 border-0" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= esc($currentUser['avatar']) ?>" alt="Avatar" class="rounded-circle border" width="34" height="34" style="object-fit: cover;">
                        <span class="d-none d-lg-inline small fw-semibold"><?= esc($currentUser['name']) ?></span>
                        <i class="bi bi-chevron-down small text-muted d-none d-lg-inline"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border p-2" aria-labelledby="userMenuBtn">
                        <li class="px-3 py-2 border-bottom mb-1">
                            <div class="fw-bold small"><?= esc($currentUser['name']) ?></div>
                            <div class="text-muted small text-truncate" style="max-width: 180px;"><?= esc($currentUser['email']) ?></div>
                            <span class="badge bg-info-subtle text-info mt-1" style="font-size: 0.7rem;"><?= esc($currentUser['role']) ?></span>
                        </li>
                        <li>
                            <a class="dropdown-item rounded small py-1" href="javascript:void(0)" onclick="showToast('Profile', 'Opening user profile...')">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded small py-1" href="javascript:void(0)" onclick="showToast('Account Settings', 'Configuring account preferences...')">
                                <i class="bi bi-gear me-2"></i>Account Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded small py-1" href="<?= site_url('login') ?>">
                                <i class="bi bi-shield-check me-2"></i>Switch / Test Auth UI
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item rounded small py-1 text-danger" href="<?= site_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Dashboard View Container -->
        <div class="app-content">

            <!-- Flash Session Feedback -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div class="small flex-grow-1">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Page Title Bar & Action Controls -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1 small text-muted">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>" class="text-decoration-none">Analytics</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0">Executive Dashboard</h4>
                    <p class="text-muted small mb-0">High-level sales, performance metrics, and activity breakdown.</p>
                </div>

                <!-- Date Range & Action Buttons -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="input-group input-group-sm" style="width: 190px;">
                        <span class="input-group-text bg-body border-end-0"><i class="bi bi-calendar3"></i></span>
                        <select class="form-select form-select-sm border-start-0" id="timePeriodSelector" aria-label="Select Time Range">
                            <option value="7d">Last 7 Days</option>
                            <option value="30d" selected>Last 30 Days</option>
                            <option value="90d">This Quarter</option>
                            <option value="1y">Year to Date</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" id="refreshBtn" onclick="triggerRefresh()">
                        <i class="bi bi-arrow-clockwise" id="refreshIcon"></i>
                        <span>Refresh</span>
                    </button>

                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" onclick="showToast('Export Successful', 'Dashboard summary exported to CSV successfully.')">
                        <i class="bi bi-download"></i>
                        <span>Export CSV</span>
                    </button>
                </div>
            </div>

            <!-- KPI Summary Cards Grid -->
            <section class="row g-3 mb-4" aria-label="Key Performance Indicators">
                <?php foreach ($metrics as $key => $metric): ?>
                    <div class="col-12 col-sm-6 col-xl-3 dashboard-contain-region">
                        <div class="metric-card shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="text-secondary small fw-medium text-uppercase letter-spacing"><?= esc($metric['title']) ?></span>
                                    <h3 class="fw-bold mt-1 mb-0 text-body"><?= esc($metric['value']) ?></h3>
                                </div>
                                <div class="metric-icon-box bg-<?= esc($metric['color']) ?>-subtle text-<?= esc($metric['color']) ?>">
                                    <i class="bi <?= esc($metric['icon']) ?>"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge <?= $metric['direction'] === 'up' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> d-flex align-items-center gap-1 py-1 px-2 rounded-pill small">
                                    <i class="bi bi-arrow-<?= $metric['direction'] === 'up' ? 'up-right' : 'down-right' ?>"></i>
                                    <?= esc($metric['trend']) ?>
                                </span>
                                <span class="text-muted small"><?= esc($metric['description']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- Chart Visualizations Grid -->
            <section class="row g-3 mb-4" aria-label="Analytics Charts">
                <!-- Main Line / Area Chart (8 Columns) -->
                <div class="col-12 col-xl-8 dashboard-contain-region">
                    <div class="card-custom p-4 h-100">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Revenue & Transaction Volume</h5>
                                <p class="text-muted small mb-0">Historical revenue comparison across sales periods</p>
                            </div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Chart Period Toggle">
                                <button type="button" class="btn btn-outline-primary active" id="btnChartWeekly" onclick="switchChartDataset('weekly')">Weekly</button>
                                <button type="button" class="btn btn-outline-primary" id="btnChartMonthly" onclick="switchChartDataset('monthly')">Monthly</button>
                                <button type="button" class="btn btn-outline-primary" id="btnChartYearly" onclick="switchChartDataset('yearly')">Yearly</button>
                            </div>
                        </div>
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="revenueOverviewChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Acquisition Channels Doughnut Chart (4 Columns) -->
                <div class="col-12 col-xl-4 dashboard-contain-region">
                    <div class="card-custom p-4 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Traffic Channels</h5>
                                <p class="text-muted small mb-0">Distribution by acquisition source</p>
                            </div>
                            <button class="btn btn-sm btn-light border p-1" title="Options" onclick="showToast('Channels', 'Custom breakdown options')">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-grow-1" style="position: relative; min-height: 200px;">
                            <canvas id="trafficDonutChart" style="max-height: 220px;"></canvas>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <div class="row g-2">
                                <?php foreach ($trafficSources as $source): ?>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: <?= esc($source['color']) ?>; display: inline-block;"></span>
                                            <div class="small text-truncate flex-grow-1"><?= esc($source['name']) ?></div>
                                            <span class="small fw-bold"><?= esc($source['percent']) ?>%</span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quick Action Shortcuts -->
            <section class="row g-3 mb-4" aria-label="Quick Actions">
                <div class="col-6 col-md-3">
                    <a href="javascript:void(0)" class="quick-action-btn" onclick="showToast('Quick Invoice', 'Opening invoice composer modal...')">
                        <div class="mb-1 text-primary fs-4"><i class="bi bi-file-earmark-plus"></i></div>
                        <div class="fw-semibold small">Create Invoice</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Bill client instantly</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="javascript:void(0)" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#quickActionModal">
                        <div class="mb-1 text-success fs-4"><i class="bi bi-person-plus"></i></div>
                        <div class="fw-semibold small">Add Customer</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Enroll new account</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="javascript:void(0)" class="quick-action-btn" onclick="showToast('API Generator', 'Production keys copied to clipboard!')">
                        <div class="mb-1 text-info fs-4"><i class="bi bi-key"></i></div>
                        <div class="fw-semibold small">API Keys</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Access credentials</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="javascript:void(0)" class="quick-action-btn" onclick="showToast('Security Scan', 'System security audit initiated...')">
                        <div class="mb-1 text-warning fs-4"><i class="bi bi-shield-check"></i></div>
                        <div class="fw-semibold small">Security Audit</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Run diagnostics</div>
                    </a>
                </div>
            </section>

            <!-- Main Data Table & Activity Feed Row -->
            <div class="row g-3" id="ordersSection">
                <!-- Orders Table (8 Columns) -->
                <div class="col-12 col-xl-8 dashboard-contain-region">
                    <div class="card-custom p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                            <div>
                                <h5 class="fw-bold mb-1" id="recent-orders-heading">Recent Transactions & Orders</h5>
                                <p class="text-muted small mb-0">Review verified payments and order status</p>
                            </div>

                            <!-- Live Filter & Status Dropdown -->
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="max-width: 200px;">
                                    <span class="input-group-text bg-body border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0" id="tableFilterInput" placeholder="Filter rows..." aria-label="Filter orders table">
                                </div>
                                <select class="form-select form-select-sm" id="statusFilterSelect" style="width: 130px;" aria-label="Filter by Status">
                                    <option value="ALL" selected>All Status</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Accessible Responsive Data Table (Conforming to modern-web-guidance) -->
                        <div tabindex="0" role="region" aria-labelledby="recent-orders-heading" class="table-wrapper">
                            <table class="table-custom" id="ordersDataTable">
                                <caption class="visually-hidden">Current list of customer transactions and fulfillment statuses</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Plan / Item</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr data-status="<?= esc($order['status']) ?>" data-search="<?= esc(strtolower($order['id'] . ' ' . $order['customer'] . ' ' . $order['plan'] . ' ' . $order['status'])) ?>">
                                            <th scope="row" data-label="Order ID" class="fw-bold text-primary">
                                                <?= esc($order['id']) ?>
                                            </th>
                                            <td data-label="Customer">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="<?= esc($order['avatar']) ?>" alt="<?= esc($order['customer']) ?>" class="rounded-circle border" width="30" height="30" style="object-fit: cover;">
                                                    <div class="text-start">
                                                        <div class="fw-medium text-body leading-tight"><?= esc($order['customer']) ?></div>
                                                        <div class="text-muted" style="font-size: 0.72rem;"><?= esc($order['email']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Plan / Item">
                                                <span class="text-body fw-medium"><?= esc($order['plan']) ?></span>
                                            </td>
                                            <td data-label="Date" class="text-muted">
                                                <?= esc($order['date']) ?>
                                            </td>
                                            <td data-label="Amount" class="fw-bold text-body">
                                                <?= esc($order['amount']) ?>
                                            </td>
                                            <td data-label="Status">
                                                <span class="badge <?= esc($order['badgeClass']) ?> px-2 py-1 rounded-pill">
                                                    <?= esc($order['status']) ?>
                                                </span>
                                            </td>
                                            <td data-label="Actions" class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" title="View details" onclick="openOrderModal('<?= esc($order['id']) ?>', '<?= esc($order['customer']) ?>', '<?= esc($order['email']) ?>', '<?= esc($order['plan']) ?>', '<?= esc($order['amount']) ?>', '<?= esc($order['status']) ?>', '<?= esc($order['payment']) ?>', '<?= esc($order['date']) ?>')">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" title="Download invoice" onclick="showToast('Invoice Downloaded', 'Invoice PDF for <?= esc($order['id']) ?> is ready.')">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer / Pagination Preview -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 mt-3 pt-2 border-top">
                            <span class="small text-muted" id="tableRecordCount">Showing <?= count($recentOrders) ?> of <?= count($recentOrders) ?> entries</span>
                            <nav aria-label="Table navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">Prev</a></li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0)">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed & System Health (4 Columns) -->
                <div class="col-12 col-xl-4 dashboard-contain-region">
                    <!-- Recent Activities Card -->
                    <div class="card-custom p-4 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Activity Feed</h5>
                            <span class="badge bg-secondary-subtle text-secondary small">Realtime</span>
                        </div>
                        <div class="timeline-widget">
                            <?php foreach ($recentActivities as $act): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker border-<?= esc($act['color']) ?> text-<?= esc($act['color']) ?>">
                                        <i class="bi <?= esc($act['icon']) ?>"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small text-body"><?= esc($act['title']) ?></div>
                                        <div class="text-muted" style="font-size: 0.78rem;"><?= esc($act['desc']) ?></div>
                                        <div class="text-secondary mt-1" style="font-size: 0.7rem;">
                                            <i class="bi bi-clock me-1"></i><?= esc($act['time']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Server Health & Diagnostics -->
                    <div class="card-custom p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">System Health</h5>
                            <span class="badge bg-success-subtle text-success small">Operational</span>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($systemHealth as $key => $res): ?>
                                <div>
                                    <div class="d-flex justify-content-between align-items-center small mb-1">
                                        <span class="text-secondary fw-medium"><?= esc($res['label']) ?></span>
                                        <span class="fw-bold"><?= esc($res['val']) ?>% (<?= esc($res['status']) ?>)</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar <?= $res['val'] > 80 ? 'bg-danger' : ($res['val'] > 50 ? 'bg-primary' : 'bg-success') ?>" role="progressbar" style="width: <?= esc($res['val']) ?>%" aria-valuenow="<?= esc($res['val']) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Dashboard Footer -->
        <footer class="mt-auto py-3 px-4 border-top text-center text-md-start d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-muted">
            <div>
                &copy; <?= date('Y') ?> <strong>NexusCore Portal</strong> &bull; CodeIgniter 4 Standalone UI
            </div>
            <div class="d-flex gap-3">
                <a href="<?= site_url('login') ?>" class="text-decoration-none text-muted">Login UI</a>
                <a href="<?= site_url('/') ?>" class="text-decoration-none text-muted">Home</a>
                <a href="javascript:void(0)" class="text-decoration-none text-muted" onclick="showToast('Documentation', 'Accessing documentation...')">Docs</a>
                <a href="javascript:void(0)" class="text-decoration-none text-muted" onclick="showToast('Privacy', 'Privacy policy terms')">Privacy</a>
            </div>
        </footer>

    </main>
</div>

<!-- Modal 1: View Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header border-bottom">
                <div>
                    <h5 class="modal-title fw-bold" id="orderDetailsModalLabel">Order Details</h5>
                    <span class="text-muted small" id="modalOrderId">#ORD-XXXX</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 bg-body-tertiary">
                    <div>
                        <span class="text-muted small d-block">Amount Charged</span>
                        <h4 class="fw-bold mb-0 text-primary" id="modalOrderAmount">$0.00</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill" id="modalOrderStatus">Completed</span>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-semibold">Customer Information</label>
                    <div class="fw-medium" id="modalCustomerName">John Doe</div>
                    <div class="text-muted small" id="modalCustomerEmail">john@example.com</div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="text-muted small fw-semibold">Product / Plan</label>
                        <div class="fw-medium small" id="modalOrderPlan">Pro Plan</div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small fw-semibold">Order Date</label>
                        <div class="fw-medium small" id="modalOrderDate">Nov 09, 2026</div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-muted small fw-semibold">Payment Method</label>
                    <div class="small text-body d-flex align-items-center gap-1">
                        <i class="bi bi-credit-card-2-front text-primary"></i>
                        <span id="modalOrderPayment">Credit Card ending 4421</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="showToast('Print Job', 'Preparing printer format...');">
                    <i class="bi bi-printer me-1"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Quick Action / Add New Record -->
<div class="modal fade" id="quickActionModal" tabindex="-1" aria-labelledby="quickActionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="quickActionModalLabel">Quick Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onsubmit="handleQuickAdd(event)">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newCustomerName" class="form-label small fw-semibold">Full Name</label>
                        <input type="text" class="form-control" id="newCustomerName" placeholder="e.g. Jessica Taylor" required>
                    </div>
                    <div class="mb-3">
                        <label for="newCustomerEmail" class="form-label small fw-semibold">Email Address</label>
                        <input type="email" class="form-control" id="newCustomerEmail" placeholder="e.g. jessica@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="newCustomerPlan" class="form-label small fw-semibold">Selected Tier</label>
                        <select class="form-select" id="newCustomerPlan">
                            <option value="Pro Enterprise Plan">Pro Enterprise Plan ($1,249/mo)</option>
                            <option value="Team Annual License">Team Annual License ($599/yr)</option>
                            <option value="Starter Tier">Starter Tier ($49/mo)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i> Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notifications Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
    <div id="liveToast" class="toast align-items-center text-bg-dark border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill text-primary fs-5" id="toastIcon"></i>
                <div>
                    <strong class="d-block" id="toastTitle">Notification</strong>
                    <span id="toastMessage" class="small">Action completed successfully.</span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ==========================================================================
       1. Theme Toggle (Light / Dark Mode with localStorage)
       ========================================================================== */
    const htmlElem = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');
    const themeLabel = document.getElementById('themeLabel');

    function applyTheme(theme) {
        htmlElem.setAttribute('data-bs-theme', theme);
        localStorage.setItem('nexus_theme', theme);

        if (theme === 'dark') {
            themeIcon.className = 'bi bi-moon-stars-fill text-info';
            if (themeLabel) themeLabel.textContent = 'Dark';
        } else {
            themeIcon.className = 'bi bi-sun-fill text-warning';
            if (themeLabel) themeLabel.textContent = 'Light';
        }

        // Re-render charts with updated theme colors if initialized
        updateChartThemes(theme);
    }

    // Initialize stored theme or default to light
    const currentSavedTheme = localStorage.getItem('nexus_theme') || 'light';
    applyTheme(currentSavedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const nextTheme = htmlElem.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(nextTheme);
        });
    }

    /* ==========================================================================
       2. Responsive Sidebar Toggle & Mobile Backdrop
       ========================================================================== */
    const sidebarToggle = document.getElementById('sidebarToggle');
    const appSidebar = document.getElementById('appSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    if (sidebarToggle && appSidebar && sidebarBackdrop) {
        sidebarToggle.addEventListener('click', () => {
            appSidebar.classList.toggle('show');
            sidebarBackdrop.classList.toggle('show');
        });

        sidebarBackdrop.addEventListener('click', () => {
            appSidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
        });
    }

    /* ==========================================================================
       3. Interactive Charts (Chart.js)
       ========================================================================== */
    let revenueChartInstance = null;
    let donutChartInstance = null;

    const chartDatasets = {
        weekly: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            revenue: [14200, 19400, 16800, 24500, 29800, 21200, 31500],
            orders: [120, 165, 140, 210, 260, 190, 280]
        },
        monthly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            revenue: [48000, 62000, 79000, 94000],
            orders: [420, 560, 690, 840]
        },
        yearly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            revenue: [65000, 72000, 89000, 84000, 99000, 112000, 108000, 125000, 118000, 134000, 128450, 145000],
            orders: [680, 750, 920, 880, 1050, 1190, 1140, 1320, 1260, 1420, 1842, 1600]
        }
    };

    function initCharts() {
        const isDark = htmlElem.getAttribute('data-bs-theme') === 'dark';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';
        const textColor = isDark ? '#9ca3af' : '#64748b';

        // 1. Revenue Overview Chart
        const revCanvas = document.getElementById('revenueOverviewChart');
        if (revCanvas) {
            const ctx = revCanvas.getContext('2d');
            const initialData = chartDatasets.weekly;

            revenueChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: initialData.labels,
                    datasets: [
                        {
                            label: 'Revenue ($)',
                            data: initialData.revenue,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.12)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Orders',
                            data: initialData.orders,
                            borderColor: '#20c997',
                            backgroundColor: 'transparent',
                            borderDash: [5, 5],
                            tension: 0.35,
                            borderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';
                                    if (context.datasetIndex === 0) {
                                        label += '$' + context.parsed.y.toLocaleString();
                                    } else {
                                        label += context.parsed.y.toLocaleString() + ' units';
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: gridColor },
                            ticks: { color: textColor }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: gridColor },
                            ticks: {
                                color: textColor,
                                callback: val => '$' + (val >= 1000 ? (val / 1000) + 'k' : val)
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { color: textColor }
                        }
                    }
                }
            });
        }

        // 2. Traffic Donut Chart
        const donutCanvas = document.getElementById('trafficDonutChart');
        if (donutCanvas) {
            const ctxDonut = donutCanvas.getContext('2d');
            donutChartInstance = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: ['Direct Traffic', 'Organic Search', 'Social Media', 'Referral'],
                    datasets: [{
                        data: [42, 28, 18, 12],
                        backgroundColor: ['#0d6efd', '#20c997', '#0dcaf0', '#ffc107'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function switchChartDataset(period) {
        ['btnChartWeekly', 'btnChartMonthly', 'btnChartYearly'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.classList.remove('active');
        });

        const activeBtn = document.getElementById('btnChart' + period.charAt(0).toUpperCase() + period.slice(1));
        if (activeBtn) activeBtn.classList.add('active');

        if (revenueChartInstance && chartDatasets[period]) {
            const selected = chartDatasets[period];
            revenueChartInstance.data.labels = selected.labels;
            revenueChartInstance.data.datasets[0].data = selected.revenue;
            revenueChartInstance.data.datasets[1].data = selected.orders;
            revenueChartInstance.update();
        }
    }

    function updateChartThemes(theme) {
        const isDark = theme === 'dark';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';
        const textColor = isDark ? '#9ca3af' : '#64748b';

        if (revenueChartInstance) {
            revenueChartInstance.options.scales.x.grid.color = gridColor;
            revenueChartInstance.options.scales.x.ticks.color = textColor;
            revenueChartInstance.options.scales.y.grid.color = gridColor;
            revenueChartInstance.options.scales.y.ticks.color = textColor;
            revenueChartInstance.options.scales.y1.ticks.color = textColor;
            if (revenueChartInstance.options.plugins.legend) {
                revenueChartInstance.options.plugins.legend.labels.color = textColor;
            }
            revenueChartInstance.update();
        }
    }

    /* ==========================================================================
       4. Client-side Table Search & Status Filter
       ========================================================================== */
    const tableFilterInput = document.getElementById('tableFilterInput');
    const statusFilterSelect = document.getElementById('statusFilterSelect');
    const ordersTable = document.getElementById('ordersDataTable');
    const tableRecordCount = document.getElementById('tableRecordCount');

    function applyTableFilter() {
        if (!ordersTable) return;
        const query = (tableFilterInput ? tableFilterInput.value : '').toLowerCase().trim();
        const selectedStatus = statusFilterSelect ? statusFilterSelect.value : 'ALL';
        const rows = ordersTable.querySelectorAll('tbody tr');

        let visibleCount = 0;
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            const status = row.getAttribute('data-status') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesStatus = selectedStatus === 'ALL' || status === selectedStatus;

            if (matchesQuery && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (tableRecordCount) {
            tableRecordCount.textContent = `Showing ${visibleCount} of ${rows.length} entries`;
        }
    }

    if (tableFilterInput) tableFilterInput.addEventListener('input', applyTableFilter);
    if (statusFilterSelect) statusFilterSelect.addEventListener('change', applyTableFilter);

    /* ==========================================================================
       5. Keyboard Shortcuts (e.g. '/' focuses search bar)
       ========================================================================== */
    window.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const searchInput = document.getElementById('globalSearchInput');
            if (searchInput) searchInput.focus();
        }
    });

    /* ==========================================================================
       6. Modals & Interactive Toast Helper
       ========================================================================== */
    function showToast(title, message) {
        const toastElem = document.getElementById('liveToast');
        if (!toastElem) return;

        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;

        const toast = new bootstrap.Toast(toastElem, { delay: 3500 });
        toast.show();
    }

    function openOrderModal(id, customer, email, plan, amount, status, payment, date) {
        document.getElementById('modalOrderId').textContent = id;
        document.getElementById('modalCustomerName').textContent = customer;
        document.getElementById('modalCustomerEmail').textContent = email;
        document.getElementById('modalOrderPlan').textContent = plan;
        document.getElementById('modalOrderAmount').textContent = amount;
        document.getElementById('modalOrderStatus').textContent = status;
        document.getElementById('modalOrderPayment').textContent = payment;
        document.getElementById('modalOrderDate').textContent = date;

        const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
        modal.show();
    }

    function handleQuickAdd(e) {
        e.preventDefault();
        const name = document.getElementById('newCustomerName').value;
        const plan = document.getElementById('newCustomerPlan').value;

        // Dismiss modal
        const modalElem = document.getElementById('quickActionModal');
        const modal = bootstrap.Modal.getInstance(modalElem);
        if (modal) modal.hide();

        showToast('Customer Created', `Successfully enrolled ${name} for ${plan}!`);
        e.target.reset();
    }

    function triggerRefresh() {
        const icon = document.getElementById('refreshIcon');
        if (icon) icon.classList.add('spin-animation');

        setTimeout(() => {
            if (icon) icon.classList.remove('spin-animation');
            showToast('Refreshed', 'Dashboard stats updated to the latest sync.');
        }, 600);
    }

    // Initialize charts on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        initCharts();
    });
</script>

</body>
</html>
