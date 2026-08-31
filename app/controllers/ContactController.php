<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $this->view('contact/index', [
            'title'    => 'Contact Us',
            'activeNav' => 'contact',
        ]);
    }

    public function store()
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'    => 'required|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'max:20',
            'subject' => 'max:150',
            'message' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            $this->view('contact/index', [
                'title'    => 'Contact Us',
                'activeNav' => 'contact',
                'errors'   => $validator->errors(),
            ]);
            return;
        }

        (new ContactMessage())->create([
            'name'    => trim($_POST['name']),
            'email'   => trim($_POST['email']),
            'phone'   => trim($_POST['phone'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'message' => trim($_POST['message']),
        ]);

        flash('success', 'Thank you! Your message has been sent. We will reply soon.');
        redirect('contact');
    }
}
