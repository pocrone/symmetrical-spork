# NexusCore Web Application Guide

> **CodeIgniter 4 Application Starter**  
> A lightweight, modern PHP 8.1+ application featuring an executive dashboard UI, standalone authentication flow, and streamlined developer setup.

---

## 📋 Table of Contents

- [Overview & Architecture](#-overview--architecture)
- [Directory Layout](#-directory-layout)
- [Local Development Setup](#-local-development-setup)
- [Key Application Endpoints](#-key-application-endpoints)
- [License](#-license)

---

## 🏛 Overview & Architecture

This repository is built on **CodeIgniter 4** (v4.6+) with modern front-end integration (Bootstrap 5.3, Bootstrap Icons, and Chart.js). It is designed with clean architectural boundaries to serve as a micro-service, administrative portal, or full-stack web application.

- **Framework**: CodeIgniter 4 (`codeigniter4/framework`)
- **Runtime**: PHP 8.1+ (CLI & FPM)
- **Front-End Stack**: Responsive HTML5, Bootstrap 5.3, Chart.js, Vanilla ES6 JavaScript
- **State & Data**: Standalone mock UI pipelines ready for database model binding (MySQLi / Postgres / SQLite)

---

## 📁 Directory Layout

```text
project-root/
├── app/                      # Application core code
│   ├── Config/               # Routes, filters, database, and system configs
│   │   └── Routes.php        # Application routing definitions
│   ├── Controllers/          # Request handlers
│   │   ├── Dashboard.php     # Executive analytics & metrics controller
│   │   ├── Home.php          # Welcome / root controller
│   │   └── Login.php         # Standalone auth UI controller
│   └── Views/                # Presentation views
│       ├── dashboard.php     # High-performance responsive dashboard template
│       ├── login.php         # Mock login interface with credentials helper
│       └── welcome_message.php
├── public/                   # Web server document root
│   ├── index.php             # Front controller entrypoint
│   ├── .htaccess             # Apache rewrite rules
│   └── favicon.ico
├── writable/                 # Runtime ephemeral state (must be writable by web server)
│   ├── cache/                # Query & template cache
│   ├── debugbar/             # Development profiling data
│   ├── logs/                 # Daily application logs
│   ├── session/              # File-based user sessions
│   └── uploads/              # Dynamic uploaded media
├── tests/                    # PHPUnit automated test suite
├── composer.json             # PHP dependency manifest
├── env                       # Base environment template (copy to .env)
└── spark                     # CodeIgniter CLI tool
```

---

## 💻 Local Development Setup

### 1. Prerequisites

- **PHP 8.1+** with the following extensions enabled:
  - `intl`, `mbstring`, `json`, `mysqlnd` (if using MySQL), `curl`, `libxml`
- **Composer 2.0+**

Verify your local PHP version:
```bash
php -v
php -m | grep -E "intl|mbstring|json|curl"
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Local Environment

Copy the example environment configuration:
```bash
# On Linux / macOS
cp env .env

# On Windows (PowerShell)
Copy-Item env .env
```

Edit `.env` to configure your local development parameters:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false
app.sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler'
```

### 4. Run Development Server

```bash
php spark serve
```
The server will bind to `http://localhost:8080`.

---

## 🌐 Key Application Endpoints

| Route | Method | Controller Handler | Purpose |
| :--- | :--- | :--- | :--- |
| `/` | `GET` | `Home::index` | Default landing / welcome screen |
| `/dashboard` | `GET` | `Dashboard::index` | Executive analytics dashboard with KPIs & Chart.js |
| `/login` | `GET` | `Login::index` | Standalone login interface (demo credentials included) |
| `/login/auth` | `POST` | `Login::auth` | Mock credential authentication flow |
| `/logout` | `GET` | `Login::logout` | Session teardown and redirect |

---

## 📄 License

This software is released under the [MIT License](LICENSE).
