<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validation;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (isLoggedIn()) {
            redirect(isAdmin() ? 'admin' : 'customer');
        }

        $this->view('auth/login', [
            'title'    => 'Login',
            'activeNav' => 'auth',
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth/showLogin');
        }

        verifyCsrf();

        $validator = new Validation($_POST, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $this->view('auth/login', [
                'title'    => 'Login',
                'activeNav' => 'auth',
                'errors'   => $validator->errors(),
            ]);
            return;
        }

        $user = (new User())->findByEmail($_POST['email']);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            // Regenerate the session id and rotate the CSRF token
            session_regenerate_id(true);
            Session::remove('csrf_token');
            csrf_token();
            Session::set('user', $user);

            flash('success', 'Welcome back, ' . $user['name'] . '!');
            redirect($user['role'] === 'admin' ? 'admin' : 'customer');
        }

        flash('danger', 'Invalid email or password.');
        redirect('auth/showLogin');
    }

    public function showRegister()
    {
        if (isLoggedIn()) {
            redirect(isAdmin() ? 'admin' : 'customer');
        }

        $this->view('auth/register', [
            'title'    => 'Register',
            'activeNav' => 'auth',
        ]);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth/showRegister');
        }

        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'                  => 'required|min:2|max:100',
            'email'                 => 'required|email|max:150|unique:users,email',
            'phone'                 => 'max:20',
            'address'               => 'max:255',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $this->view('auth/register', [
                'title'    => 'Register',
                'activeNav' => 'auth',
                'errors'   => $validator->errors(),
            ]);
            return;
        }

        $userId = (new User())->create([
            'name'     => trim($_POST['name']),
            'email'    => trim($_POST['email']),
            'phone'    => trim($_POST['phone'] ?? ''),
            'address'  => trim($_POST['address'] ?? ''),
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'role'     => 'customer',
        ]);

        $user = (new User())->find($userId);
        Session::set('user', $user);

        flash('success', 'Account created successfully. Welcome to ' . APP_NAME . '!');
        redirect('customer');
    }

    public function logout()
    {
        Session::destroy();
        redirect('');
    }
}
