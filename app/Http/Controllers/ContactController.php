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
    
    public function contact(){
        return view('user.contact');
    }
public function submit(Request $request)
    {
        // Validate
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:15',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required'    => 'Please enter your name.',
            'email.required'   => 'Please enter your email address.',
            'email.email'      => 'Please enter a valid email address.',
            'message.required' => 'Please enter a message.',
            'message.min'      => 'Message must be at least 10 characters.',
        ]);
 
        try {
            Contact::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,

            ]);
 
            return redirect()->route('contact')
                ->with('success', 'Your message has been sent successfully! We will get back to you within 24 hours.');
 
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }

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
