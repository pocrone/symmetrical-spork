<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sample Login') ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 1.5rem;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #ffffff;
            width: 100%;
            max-width: 440px;
        }
        .card-header-custom {
            background: #ffffff;
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: none;
            text-align: center;
        }
        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
        .demo-box {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
        }
        .demo-badge-btn {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .demo-badge-btn:hover {
            transform: translateY(-1px);
            filter: brightness(0.95);
        }
        .input-group-text {
            background-color: #f8fafc;
            border-color: #dee2e6;
            color: #64748b;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card-header-custom">
        <div class="brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h3 class="fw-bold text-dark mb-1">CI4 Sample Login</h3>
        <p class="text-muted small mb-0">Standalone UI preview (No database interaction)</p>
    </div>

    <div class="card-body px-4 pt-2 pb-4">
        <!-- Flash Message: Success -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="small flex-grow-1">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Flash Message: Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="small flex-grow-1">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($isLoggedIn)): ?>
            <!-- State: Already Logged In -->
            <div class="text-center py-3">
                <div class="mb-3">
                    <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill">
                        <i class="bi bi-person-check-fill me-1"></i> Active Session
                    </span>
                </div>
                <h5 class="fw-semibold mb-1">Hello, <?= esc($username ?? 'User') ?>!</h5>
                <p class="text-muted small mb-4">You are currently logged in with sample mock authentication.</p>

                <div class="d-grid gap-2">
                    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                        <i class="bi bi-speedometer2 me-1"></i> Open Dashboard
                    </a>
                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i> Log Out
                    </a>
                    <a href="<?= site_url('/') ?>" class="btn btn-light border">
                        <i class="bi bi-house me-1"></i> Return to Home
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- State: Login Form -->
            <form method="post" action="<?= site_url('login/auth') ?>" autocomplete="off" novalidate>
                <?= csrf_field() ?>

                <!-- Username Field -->
                <div class="mb-3">
                    <label for="username" class="form-label small fw-semibold text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input
                            type="text"
                            class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>"
                            id="username"
                            name="username"
                            value="<?= esc(old('username')) ?>"
                            placeholder="Enter username"
                            required
                        >
                        <?php if (isset($validation['username'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($validation['username']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label small fw-semibold text-secondary mb-1">Password</label>
                        <a href="javascript:void(0)" class="small text-decoration-none text-muted" onclick="alert('This is a sample UI demo. No actual password reset flow.')">Forgot?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input
                            type="password"
                            class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>"
                            id="password"
                            name="password"
                            placeholder="Enter password"
                            required
                        >
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" title="Toggle password visibility">
                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </button>
                        <?php if (isset($validation['password'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($validation['password']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember_me">
                    <label class="form-check-label small text-secondary" for="rememberMe">
                        Remember me on this browser
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fs-6 fw-semibold py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </div>

                <!-- Demo Credentials Box -->
                <div class="demo-box mt-3 text-secondary">
                    <div class="d-flex align-items-center mb-1 fw-semibold text-dark">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        <span>Sample Credentials (Click to fill)</span>
                    </div>
                    <p class="text-muted small mb-2">No database used. Click either credential to auto-fill the form:</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-outline-primary demo-badge-btn" onclick="fillCredentials('admin', 'password123')">
                            <strong>admin</strong> / password123
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary demo-badge-btn" onclick="fillCredentials('user', 'password123')">
                            <strong>user</strong> / password123
                        </button>
                    </div>
                </div>

                <div class="text-center mt-3 pt-2 border-top">
                    <a href="<?= site_url('dashboard') ?>" class="text-decoration-none small text-primary fw-medium">
                        <i class="bi bi-speedometer2 me-1"></i> Or preview Sample Dashboard UI &rarr;
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Password visibility toggle
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
        togglePasswordBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            togglePasswordIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    // Helper to auto-fill credentials for UI testing
    function fillCredentials(username, password) {
        const userInput = document.getElementById('username');
        const passInput = document.getElementById('password');
        if (userInput) userInput.value = username;
        if (passInput) passInput.value = password;
    }
</script>

</body>
</html>
