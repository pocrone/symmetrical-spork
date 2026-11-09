<?php

namespace App\Controllers;

/**
 * Sample Dashboard Controller
 *
 * Provides a modern, rich, standalone Dashboard UI demonstration.
 * Requires no database interaction or models - mock data is supplied directly
 * for full frontend preview.
 */
class Dashboard extends BaseController
{
    /**
     * Display the main Dashboard view with sample statistics, charts, and activity data.
     */
    public function index(): string
    {
        $session = session();

        // Detect if user logged in via sample login controller
        $isLoggedIn = (bool) $session->get('isLoggedIn');
        $sessionUsername = $session->get('username');

        // Current active demo user
        $currentUser = [
            'name'       => $isLoggedIn ? ucfirst((string) $sessionUsername) : 'Alex Rivera',
            'username'   => $isLoggedIn ? (string) $sessionUsername : 'alexrivera',
            'email'      => $isLoggedIn ? $sessionUsername . '@example.com' : 'alex.rivera@example.com',
            'role'       => $isLoggedIn && $sessionUsername === 'admin' ? 'Super Administrator' : 'Project Manager',
            'avatar'     => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
            'isLoggedIn' => $isLoggedIn,
        ];

        // Summary KPI Metrics
        $metrics = [
            'revenue' => [
                'title'       => 'Total Revenue',
                'value'       => '$128,450.00',
                'trend'       => '+14.2%',
                'direction'   => 'up',
                'description' => 'vs last month',
                'icon'        => 'bi-currency-dollar',
                'color'       => 'primary',
            ],
            'orders' => [
                'title'       => 'Total Orders',
                'value'       => '1,842',
                'trend'       => '+5.4%',
                'direction'   => 'up',
                'description' => 'vs last month',
                'icon'        => 'bi-bag-check-fill',
                'color'       => 'success',
            ],
            'customers' => [
                'title'       => 'Active Customers',
                'value'       => '14,290',
                'trend'       => '+8.1%',
                'direction'   => 'up',
                'description' => 'vs last month',
                'icon'        => 'bi-people-fill',
                'color'       => 'info',
            ],
            'conversion' => [
                'title'       => 'Conversion Rate',
                'value'       => '3.48%',
                'trend'       => '-0.6%',
                'direction'   => 'down',
                'description' => 'vs last month',
                'icon'        => 'bi-graph-up-arrow',
                'color'       => 'warning',
            ],
        ];

        // Recent Orders Mock Dataset
        $recentOrders = [
            [
                'id'         => 'ORD-7821',
                'customer'   => 'Sophia Montgomery',
                'email'      => 'sophia.m@example.com',
                'avatar'     => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Pro Enterprise Plan',
                'date'       => 'Nov 09, 2026',
                'amount'     => '$1,249.00',
                'status'     => 'Completed',
                'badgeClass' => 'bg-success-subtle text-success border border-success-subtle',
                'payment'    => 'Mastercard ending 4421',
            ],
            [
                'id'         => 'ORD-7820',
                'customer'   => 'Marcus Chen',
                'email'      => 'm.chen@techcorp.io',
                'avatar'     => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Team Annual License',
                'date'       => 'Nov 08, 2026',
                'amount'     => '$599.00',
                'status'     => 'Completed',
                'badgeClass' => 'bg-success-subtle text-success border border-success-subtle',
                'payment'    => 'Visa ending 8812',
            ],
            [
                'id'         => 'ORD-7819',
                'customer'   => 'Amara Okafor',
                'email'      => 'amara.okafor@designco.com',
                'avatar'     => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Custom Integration Suite',
                'date'       => 'Nov 08, 2026',
                'amount'     => '$350.00',
                'status'     => 'Processing',
                'badgeClass' => 'bg-info-subtle text-info border border-info-subtle',
                'payment'    => 'PayPal Checkout',
            ],
            [
                'id'         => 'ORD-7818',
                'customer'   => 'Liam Henderson',
                'email'      => 'liam.h@startup.dev',
                'avatar'     => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Starter Tier (Monthly)',
                'date'       => 'Nov 07, 2026',
                'amount'     => '$49.00',
                'status'     => 'Pending',
                'badgeClass' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                'payment'    => 'Direct Bank Transfer',
            ],
            [
                'id'         => 'ORD-7817',
                'customer'   => 'Elena Rostova',
                'email'      => 'elena@rostova-agency.org',
                'avatar'     => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Enterprise Custom Seat',
                'date'       => 'Nov 06, 2026',
                'amount'     => '$899.00',
                'status'     => 'Cancelled',
                'badgeClass' => 'bg-danger-subtle text-danger border border-danger-subtle',
                'payment'    => 'Credit Card Expired',
            ],
            [
                'id'         => 'ORD-7816',
                'customer'   => 'David Kim',
                'email'      => 'dkim@solutions.co',
                'avatar'     => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=80&q=80',
                'plan'       => 'Cloud Storage Expansion',
                'date'       => 'Nov 05, 2026',
                'amount'     => '$180.00',
                'status'     => 'Completed',
                'badgeClass' => 'bg-success-subtle text-success border border-success-subtle',
                'payment'    => 'Apple Pay',
            ],
        ];

        // Recent Audit / Activity Logs
        $recentActivities = [
            [
                'icon'      => 'bi-cart-check',
                'color'     => 'success',
                'title'     => 'New Enterprise order received',
                'desc'      => 'Sophia Montgomery purchased Pro Enterprise Plan ($1,249.00)',
                'time'      => '12 minutes ago',
            ],
            [
                'icon'      => 'bi-shield-check',
                'color'     => 'primary',
                'title'     => 'Automated security scan completed',
                'desc'      => 'Zero critical vulnerabilities discovered in system health check',
                'time'      => '45 minutes ago',
            ],
            [
                'icon'      => 'bi-person-plus',
                'color'     => 'info',
                'title'     => 'New team member invited',
                'desc'      => 'Marcus Chen accepted workspace invitation as Developer',
                'time'      => '2 hours ago',
            ],
            [
                'icon'      => 'bi-database-up',
                'color'     => 'warning',
                'title'     => 'Scheduled database backup finished',
                'desc'      => 'Encrypted archive stored to S3 bucket (2.4 GB)',
                'time'      => '6 hours ago',
            ],
            [
                'icon'      => 'bi-arrow-repeat',
                'color'     => 'secondary',
                'title'     => 'Subscription renewed',
                'desc'      => 'David Kim auto-renewed Cloud Storage Extension',
                'time'      => '14 hours ago',
            ],
        ];

        // Traffic Acquisition Sources
        $trafficSources = [
            ['name' => 'Direct Traffic', 'percent' => 42, 'color' => '#0d6efd'],
            ['name' => 'Organic Search', 'percent' => 28, 'color' => '#20c997'],
            ['name' => 'Social Media',   'percent' => 18, 'color' => '#0dcaf0'],
            ['name' => 'Referral Links', 'percent' => 12, 'color' => '#ffc107'],
        ];

        // System Resource Meters
        $systemHealth = [
            'cpu'     => ['label' => 'Server CPU Usage', 'val' => 28, 'status' => 'Healthy'],
            'memory'  => ['label' => 'RAM Consumption',   'val' => 64, 'status' => 'Normal'],
            'storage' => ['label' => 'NVMe Storage Used', 'val' => 45, 'status' => 'Optimal'],
        ];

        $data = [
            'title'            => 'Executive Analytics Dashboard - CI4',
            'currentUser'      => $currentUser,
            'metrics'          => $metrics,
            'recentOrders'     => $recentOrders,
            'recentActivities' => $recentActivities,
            'trafficSources'   => $trafficSources,
            'systemHealth'     => $systemHealth,
        ];

        return view('dashboard', $data);
    }
}
