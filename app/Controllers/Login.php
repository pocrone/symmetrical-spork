<?php

namespace App\Controllers;

/**
 * Sample Login Controller
 *
 * Demonstrates a complete Login UI flow (Controller, View, Routes)
 * without any database interaction or models.
 */
class Login extends BaseController
{
    /**
     * Sample mock users for demonstration (no DB interaction).
     *
     * @var array<string, string>
     */
    private array $sampleUsers = [
        'admin' => 'password123',
        'user'  => 'password123',
    ];

    /**
     * Display the sample login page or active session state.
     */
    public function index(): string
    {
        $session = session();

        $data = [
            'title'      => 'Sample Login - CodeIgniter 4',
            'isLoggedIn' => (bool) $session->get('isLoggedIn'),
            'username'   => $session->get('username'),
            'validation' => $session->getFlashdata('validation'),
        ];

        return view('login', $data);
    }

    /**
     * Handle sample authentication using mock data (No DB query).
     */
    public function auth()
    {
        $session = session();

        // 1. Validate form input
        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'   => 'Please enter your username.',
                    'min_length' => 'Username must be at least 3 characters long.',
                ],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Please enter your password.',
                    'min_length' => 'Password must be at least 6 characters long.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/login')
                ->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        // 2. Mock credential validation (No database interaction)
        if (isset($this->sampleUsers[$username]) && $this->sampleUsers[$username] === $password) {
            $session->set([
                'username'   => $username,
                'isLoggedIn' => true,
            ]);

            $session->setFlashdata('success', 'Login successful! Welcome back, ' . esc($username) . '.');
            return redirect()->to('/dashboard');
        }

        // 3. Invalid credentials feedback
        $session->setFlashdata('error', 'Invalid username or password. Please use the demo credentials provided below.');
        return redirect()->to('/login')->withInput();
    }

    /**
     * Handle logout (Clears mock session).
     */
    public function logout()
    {
        $session = session();
        $session->destroy();

        // Restart session to flash message
        session()->start();
        session()->setFlashdata('success', 'You have been logged out successfully.');

        return redirect()->to('/login');
    }
}
