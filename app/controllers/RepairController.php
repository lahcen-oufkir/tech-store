<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\RepairRequest;

class RepairController extends Controller
{
    public function create()
    {
        $user = isLoggedIn() ? currentUser() : null;

        $this->view('repair/create', [
            'title'    => 'Request a Repair',
            'activeNav' => 'repair',
            'user'     => $user,
        ]);
    }

    public function store()
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'customer_name'     => 'required|max:100',
            'customer_email'    => 'required|email|max:150',
            'customer_phone'    => 'required|max:20',
            'device_type'       => 'required|in:computer,smartphone,tablet,printer,other',
            'brand_model'       => 'max:100',
            'issue_description' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            $this->view('repair/create', [
                'title'    => 'Request a Repair',
                'activeNav' => 'repair',
                'user'     => isLoggedIn() ? currentUser() : null,
                'errors'   => $validator->errors(),
            ]);
            return;
        }

        (new RepairRequest())->create([
            'user_id'           => isLoggedIn() ? currentUser()['id'] : null,
            'customer_name'     => trim($_POST['customer_name']),
            'customer_email'    => trim($_POST['customer_email']),
            'customer_phone'    => trim($_POST['customer_phone']),
            'device_type'       => $_POST['device_type'],
            'brand_model'       => trim($_POST['brand_model'] ?? ''),
            'issue_description' => trim($_POST['issue_description']),
            'status'            => 'pending',
        ]);

        flash('success', 'Your repair request has been submitted. We will contact you soon.');
        redirect('repair/track');
    }

    public function track()
    {
        $results = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verifyCsrf();

            $validator = new Validation($_POST, [
                'email' => 'required|email',
            ]);

            if (!$validator->fails()) {
                $results = (new RepairRequest())->where('customer_email', $_POST['email']);
            }
        }

        $this->view('repair/track', [
            'title'    => 'Track a Repair',
            'activeNav' => 'repair',
            'results'  => $results,
        ]);
    }
}
