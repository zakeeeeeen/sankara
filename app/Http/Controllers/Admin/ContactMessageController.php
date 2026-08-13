<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()->orderByDesc('created_at')->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(Request $request, ContactMessage $message)
    {
        return view('admin.contact-messages.show', compact('message'));
    }

    public function destroy(Request $request, ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.contact-messages.index')->with('status', 'Pesan dihapus.');
    }
}

