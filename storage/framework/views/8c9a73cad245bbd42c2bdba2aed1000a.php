<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'PPDB SMK ANTARTIKA 1'); ?> - SMK ANTARTIKA 1 SIDOARJO</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Modern Theme CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/modern-theme.css')); ?>">
    <!-- Admin Components CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-components.css')); ?>">
    <!-- Custom theme additions -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-theme.css')); ?>">
    <!-- Admin Modern Theme -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-modern-theme.css')); ?>">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }
        
        :root {
            --primary: #5eead4;
            --primary-light: #7ee8d9;
            --primary-dark: #14b8a6;
            --accent: #f0abfc;
            --accent-light: #f5c3ff;
            --success: #6ee7b7;
            --danger: #fca5a5;
            --warning: #fde047;
            --info: #93c5fd;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #9ca3af;
            --gray-light: #f3f4f6;
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: var(--dark);
            min-height: 100vh;
        }
        
        /* SIDEBAR STYLING */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float-icon {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 50%, #0f1419 100%);
            background-size: 200% 200%;
            animation: gradient-shift 8s ease-in-out infinite;
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 107, 53, 0.2);
            border-right: 1px solid rgba(255, 107, 53, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #FF6B35 0%, #FF1493 100%);
            border-radius: 4px;
            transition: all 0.3s;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #FF8855 0%, #FF4DB8 100%);
        }
        
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #FF6B35 0%, #FF1493 100%);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            animation: slide-in-left 0.5s ease-out;
        }
        
        .sidebar-brand:hover {
            background: linear-gradient(135deg, #FF8855 0%, #FF4DB8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }
        
        .sidebar-brand i {
            font-size: 26px;
            animation: float-icon 3s ease-in-out infinite;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 12px 0;
            margin: 0;
        }
        
        .sidebar-menu-item {
            margin: 0;
        }
        
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 14px;
            position: relative;
            border-radius: 8px;
            border-left: 3px solid transparent;
            margin: 4px 8px;
        }
        
        .sidebar-menu-link:hover {
            background: rgba(255, 107, 53, 0.15);
            color: #FF6B35;
            transform: translateX(4px);
            border-left: 3px solid #FF6B35;
        }
        
        .sidebar-menu-link.active {
            background: linear-gradient(90deg, rgba(255, 107, 53, 0.25) 0%, rgba(255, 107, 53, 0.05) 100%);
            color: #FF6B35;
            border-left: 3px solid #FF6B35;
            font-weight: 600;
        }
        
        .sidebar-menu-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            transition: all 0.3s;
        }

        .sidebar-menu-link:hover i {
            color: #FF6B35;
            animation: float-icon 2s ease-in-out infinite;
        }

        .sidebar-menu-link.active i {
            color: #FF6B35;
        }
        
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 107, 53, 0.3) 50%, transparent 100%);
            margin: 15px 0;
        }

        .sidebar-section-title {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 107, 53, 0.6);
            margin-top: 10px;
            transition: all 0.3s;
        }

        .sidebar-section-title:hover {
            color: rgba(255, 107, 53, 0.8);
        }
        
        /* NAVBAR STYLING */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 16px 30px;
            margin-left: 260px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 72px;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 2px solid rgba(255, 107, 53, 0.15);
        }
        
        .navbar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            background: linear-gradient(135deg, #FF6B35 0%, #FF1493 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF6B35 0%, #FF1493 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            transition: all 0.3s;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }
        
        .navbar-user-name {
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
        }
        
        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 260px;
            padding: 35px;
        }
        
        .page-header {
            margin-bottom: 35px;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            background: linear-gradient(135deg, #1f2937 0%, #FF6B35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .page-subtitle {
            font-size: 15px;
            color: var(--gray);
            font-weight: 500;
        }
        
        /* CARDS STYLING */
        .card {
            border: 1px solid rgba(255, 107, 53, 0.15);
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
            border-color: rgba(255, 107, 53, 0.3);
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.05) 0%, rgba(240, 171, 252, 0.05) 100%);
            border-bottom: 1px solid rgba(255, 107, 53, 0.15);
            padding: 22px;
            font-weight: 700;
            color: var(--dark);
            font-size: 16px;
        }
        
        .card-body {
            padding: 22px;
        }
        
        /* STAT CARD */
        .stat-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 107, 53, 0.15);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border-left: 4px solid;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }
        
        .stat-card.primary {
            border-left-color: #FF6B35;
        }
        
        .stat-card.success {
            border-left-color: #6ee7b7;
        }
        
        .stat-card.danger {
            border-left-color: #fca5a5;
        }
        
        .stat-card.warning {
            border-left-color: #fde047;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937 0%, #FF6B35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 13px;
            color: var(--gray);
            font-weight: 600;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            font-size: 48px;
            opacity: 0.12;
        }
        
        .stat-icon.primary {
            color: #5eead4;
        }
        
        .stat-icon.success {
            color: #6ee7b7;
        }
        
        .stat-icon.danger {
            color: #fca5a5;
        }
        
        .stat-icon.warning {
            color: #f59e0b;
        }
        
        /* BADGE STYLING */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        
        .badge-primary {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 100%);
            color: #0891b2;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }
        
        .badge-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .badge-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .badge-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        
        /* BUTTON STYLING */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 11px 20px;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #5eead4 0%, #14b8a6 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(94, 234, 212, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(94, 234, 212, 0.4);
            background: linear-gradient(135deg, #7ee8d9 0%, #5eead4 100%);
        }
        
        .btn-outline-primary {
            background: transparent;
            color: #5eead4;
            border: 2px solid #5eead4;
        }
        
        .btn-outline-primary:hover {
            background: rgba(94, 234, 212, 0.1);
            color: #14b8a6;
        }
        
        .btn-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: var(--gray);
            border: 1px solid var(--gray-light);
        }
        
        .btn-secondary:hover {
            background: rgba(100, 116, 139, 0.2);
            color: var(--dark);
        }
        
        .btn-sm {
            padding: 7px 14px;
            font-size: 12px;
        }
        
        /* TABLE STYLING */
        .table {
            color: var(--dark);
        }
        
        .table thead th {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
            border: 1px solid var(--gray-light);
            font-weight: 700;
            font-size: 12px;
            color: var(--dark);
            text-transform: uppercase;
            padding: 16px;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--gray-light);
            vertical-align: middle;
            font-size: 14px;
        }
        
        .table tbody tr:hover {
            background: rgba(6, 182, 212, 0.05);
        }
        
        /* FORM STYLING */
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .form-control {
            border: 1.5px solid var(--gray-light);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .form-control:focus {
            border-color: #5eead4;
            box-shadow: 0 0 0 4px rgba(94, 234, 212, 0.1);
            background: white;
        }
        
        .form-control::placeholder {
            color: var(--gray);
            opacity: 0.7;
        }
        
        .form-select {
            border: 1.5px solid var(--gray-light);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .form-select:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        }
        
        /* ALERT STYLING */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%);
            color: #0891b2;
            border: 1px solid rgba(6, 182, 212, 0.2);
        }
        
        /* BUTTON GROUP STYLING - FORCE HORIZONTAL */
        .btn-group, 
        .btn-group-sm {
            display: inline-flex !important;
            flex-direction: row !important;
            gap: 0 !important;
            flex-wrap: nowrap !important;
        }
        
        .btn-group .btn,
        .btn-group-sm .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Override any flex-column that might be applied */
        div[style*="flex-direction: column"] {
            flex-direction: row !important;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 260px;
                margin-left: -260px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .sidebar.active {
                width: 260px;
                margin-left: 0;
            }
            
            .navbar-custom {
                margin-left: 0;
                padding: 12px 20px;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-title {
                font-size: 24px;
            }
            
            .stat-card {
                flex-direction: column;
                text-align: center;
            }
            
            .stat-icon {
                order: -1;
                margin-bottom: 12px;
            }
        }
        
        /* PRINT STYLING */
        @media print {
            .sidebar, .navbar-custom, .btn, .d-print-none {
                display: none !important;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(94, 234, 212, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: #5eead4;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #14b8a6;
        }
        
        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            animation: slideIn 0.3s ease-out;
        }
        
        /* Link styling */
        a {
            transition: color 0.3s;
            color: #5eead4;
            text-decoration: none;
        }
        
        a:hover {
            color: #14b8a6;
        }
        
        /* Focus visible */
        *:focus-visible {
            outline: 2px solid #5eead4;
            outline-offset: 2px;
        }
        
        /* Quick Action Buttons */
        .quick-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            color: white;
        }
        
        .quick-action-btn:nth-child(1) {
            background: linear-gradient(135deg, #5eead4 0%, #14b8a6 100%);
            box-shadow: 0 4px 12px rgba(94, 234, 212, 0.3);
        }
        
        .quick-action-btn:nth-child(2) {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }
        
        .quick-action-btn:nth-child(3) {
            background: linear-gradient(135deg, #f87171 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(248, 113, 113, 0.3);
        }
        
        .quick-action-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .quick-action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
    
    <?php echo $__env->yieldContent('extra_css'); ?>
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <a href="<?php if(Auth::user()?->hasRole('admin')): ?><?php echo e(route('admin.dashboard')); ?><?php else: ?><?php echo e(route('dashboard')); ?><?php endif; ?>" class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>PPDB</span>
        </a>
        
        <ul class="sidebar-menu">
            <?php if(Auth::check()): ?>
                <!-- Dashboard -->
                <li class="sidebar-menu-item">
                    <a href="<?php if(Auth::user()->hasRole('admin')): ?><?php echo e(route('admin.dashboard')); ?><?php else: ?><?php echo e(route('dashboard')); ?><?php endif; ?>" class="sidebar-menu-link <?php if(Auth::user()->hasRole('admin') && request()->routeIs('admin.dashboard')): ?>active <?php elseif(!Auth::user()->hasRole('admin') && request()->routeIs('dashboard')): ?>active <?php endif; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php if(Auth::user()->hasRole('admin')): ?>
                    <!-- ADMIN SECTION -->
                    <div class="sidebar-divider"></div>
                    <div class="sidebar-section-title">
                        <i class="fas fa-lock-open" style="margin-right: 6px; opacity: 0.7;"></i>Admin Tools
                    </div>

                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.siswa.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.siswa*') ? 'active' : ''); ?>">
                            <i class="fas fa-users"></i>
                            <span>Daftar Siswa</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.verifikasi')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.verifikasi*') ? 'active' : ''); ?>">
                            <i class="fas fa-check-circle"></i>
                            <span>Verifikasi Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.gelombang.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.gelombang*') ? 'active' : ''); ?>">
                            <i class="fas fa-wave-square"></i>
                            <span>Atur Gelombang</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.jurusan.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.jurusan*') ? 'active' : ''); ?>">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Atur Jurusan</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.pembayaran.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.pembayaran*') ? 'active' : ''); ?>">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Kelola Pembayaran</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.jenis-dokumen.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.jenis-dokumen*') ? 'active' : ''); ?>">
                            <i class="fas fa-file-alt"></i>
                            <span>Jenis Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.reports.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
                            <i class="fas fa-file-download"></i>
                            <span>Laporan & Eksport</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('admin.peran.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('admin.peran*') ? 'active' : ''); ?>">
                            <i class="fas fa-users-cog"></i>
                            <span>Manajemen Peran</span>
                        </a>
                    </li>
                <?php elseif(Auth::user()->hasRole('user')): ?>
                    <!-- USER SECTION -->
                    <div class="sidebar-divider"></div>
                    <div class="sidebar-section-title">
                        <i class="fas fa-pencil-alt" style="margin-right: 6px; opacity: 0.7;"></i>Aplikasi
                    </div>

                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('formulir.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('formulir*') ? 'active' : ''); ?>">
                            <i class="fas fa-edit"></i>
                            <span>Isi Formulir</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('biodata.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('biodata.*') ? 'active' : ''); ?>">
                            <i class="fas fa-user-circle"></i>
                            <span>Biodata</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('user.dokumen')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('user.dokumen*') || request()->routeIs('dokumen.*') ? 'active' : ''); ?>">
                            <i class="fas fa-folder"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('cetak.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('cetak.*') ? 'active' : ''); ?>">
                            <i class="fas fa-id-card"></i>
                            <span>Cetak Kartu</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('user.pembayaran.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('user.pembayaran*') ? 'active' : ''); ?>">
                            <i class="fas fa-credit-card"></i>
                            <span>Pembayaran</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo e(route('user.status')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('user.status') ? 'active' : ''); ?>">
                            <i class="fas fa-info-circle"></i>
                            <span>Status</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- ACCOUNT SECTION -->
                <div class="sidebar-divider"></div>
                <div class="sidebar-section-title">
                    <i class="fas fa-user" style="margin-right: 6px; opacity: 0.7;"></i>Akun
                </div>

                <li class="sidebar-menu-item">
                    <a href="<?php echo e(route('profil.index')); ?>" class="sidebar-menu-link <?php echo e(request()->routeIs('profil.index') ? 'active' : ''); ?>">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="sidebar-menu-link w-100 border-0 bg-transparent text-start">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    
    <!-- NAVBAR -->
    <div class="navbar-custom">
        <button class="btn btn-link d-md-none" onclick="toggleSidebar()">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        
        <h6 class="navbar-title"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></h6>
        
        <div class="navbar-user">
            <?php if(Auth::check()): ?>
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                </div>
                <div>
                    <div class="navbar-user-name"><?php echo e(Auth::user()->name); ?></div>
                    <small class="text-muted"><?php echo e(Auth::user()->email); ?></small>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2" style="font-size: 12px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Berhasil!</strong> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i>
                <strong>Error!</strong> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- SweetAlert2 Helper Functions -->
    <script src="<?php echo e(asset('assets/js/sweetalert-helpers.js')); ?>"></script>
    <!-- Modern Theme Helpers -->
    <script src="<?php echo e(asset('assets/js/modern-theme-helpers.js')); ?>"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Close sidebar when clicking on content
        document.querySelector('.main-content').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768) {
                sidebar.classList.remove('active');
            }
        });
        
        // Filter input number fields - hanya angka
        document.addEventListener('DOMContentLoaded', function() {
            // Fields yang hanya boleh berisi angka
            const numericFields = ['nomor_rekening', 'no_hp_wali'];
            
            numericFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    // Filter saat input
                    field.addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                    
                    // Cegah paste non-numeric
                    field.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const text = (e.clipboardData || window.clipboardData).getData('text');
                        const numbersOnly = text.replace(/[^0-9]/g, '');
                        this.value = numbersOnly;
                    });
                }
            });
        });
    </script>
    
    <?php echo $__env->yieldContent('extra_js'); ?>
</body>
</html>
<?php /**PATH C:\aplikasi_ppdb_2\resources\views/layouts/master.blade.php ENDPATH**/ ?>