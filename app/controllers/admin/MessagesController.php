<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ContactMessage;

class MessagesController extends Controller
{
    public function index()
    {
        $this->adminView('admin/messages/index', [
            'title'       => 'Messages',
            'adminActive' => 'messages',
            'messages'    => (new ContactMessage())->all(),
        ]);
    }

    public function show($id)
    {
        $message = (new ContactMessage())->find($id);

        if (!$message) {
            flash('danger', 'Message not found.');
            redirect('admin/messages');
        }

        (new ContactMessage())->markRead($id);

        $this->adminView('admin/messages/show', [
            'title'       => 'Message',
            'adminActive' => 'messages',
            'message'     => $message,
        ]);
    }

    public function destroy($id)
    {
        verifyCsrf();
        (new ContactMessage())->delete($id);
        flash('success', 'Message deleted.');
        redirect('admin/messages');
    }
}
