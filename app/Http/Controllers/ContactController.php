<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\User;



class ContactController extends Controller
{
    // ================= FRONTEND STORE =================


    // ================= ADMIN LIST =================
    public function contactilst(Request $req)
    {
        $search = $req->search;
        $status = $req->status;

        $data = Contact::with('user')->orderBy('created_at', 'desc');

        if ($search != '') {
            $data->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($status != '') {
            $data->where('status', $status);
        }

        $data = $data->paginate(10)->withQueryString();

        return view('admin.contact', compact('data'));
    }

    // ================= DELETE =================
    public function contactdelete($id)
    {
        Contact::where('contact_id', $id)->delete();
        return back()->with('success', 'Deleted successfully');
    }

    // ================= STATUS CHANGE =================
    public function contactstatus($id)
    {
        $c = Contact::find($id);

        if ($c->status == 'in_progress') {
            $c->status = 'resolved';
        }

        $c->save();

        return back()->with('success', 'Status updated');
    }

    // ================= REPLY FORM =================
    public function contactreplyForm($id)
    {
        $data = Contact::find($id);
        return view('admin.contact-reply', compact('data'));
    }

    // ================= SAVE REPLY =================

    public function contactreply(Request $req, $id)
    {
        $req->validate([
            'admin_reply' => 'required'
        ]);

        $c = Contact::find($id);

        // Save reply
        $c->admin_reply = $req->admin_reply;
        $c->status = 'in_progress';
        $c->replied_at = now();
        $c->save();

        // ALWAYS use contact email (entered email)
        $email = $c->email;

        // Send email
        Mail::raw(
            "Hello {$c->name},

Your Message:
{$c->message}

Admin Reply:
{$c->admin_reply}

--------------------------------------

If you have any further queries, please contact us again through our contact page.

Thank you,
The Style Studio Team",

            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Reply to your query');
            }
        );

        return redirect('admin/contact')->with('success', 'Reply sent to entered email');
    }
}
