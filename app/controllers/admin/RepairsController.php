<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\RepairRequest;

class RepairsController extends Controller
{
    public function index()
    {
        $this->adminView('admin/repairs/index', [
            'title'       => 'Repair Requests',
            'adminActive' => 'repairs',
            'repairs'     => (new RepairRequest())->all(),
        ]);
    }

    public function show($id)
    {
        $request = (new RepairRequest())->find($id);

        if (!$request) {
            flash('danger', 'Repair request not found.');
            redirect('admin/repairs');
        }

        $this->adminView('admin/repairs/show', [
            'title'       => 'Repair #' . $id,
            'adminActive' => 'repairs',
            'request'     => $request,
        ]);
    }

    public function updateStatus($id)
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'status' => 'required|in:pending,in_progress,repaired,collected,cancelled',
        ]);

        if ($validator->fails()) {
            flash('danger', 'Invalid status.');
            redirect('admin/repairs/show/' . $id);
        }

        (new RepairRequest())->update($id, ['status' => $_POST['status']]);
        flash('success', 'Repair status updated.');
        redirect('admin/repairs/show/' . $id);
    }
}
