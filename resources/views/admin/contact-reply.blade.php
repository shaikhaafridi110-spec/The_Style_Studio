@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <h3>Reply to Contact</h3>

    <form method="POST" action="{{ url('admin/contact-reply/'.$data->contact_id) }}">
        @csrf

        <label>Name</label>
        <input type="text" value="{{ $data->name }}" class="form-control" disabled>

        <label>Email</label>
        <input type="text" value="{{ $data->email }}" class="form-control" disabled>

        <label>Message</label>
        <textarea class="form-control" disabled>{{ $data->message }}</textarea>

        <label>Reply</label>
        <textarea name="admin_reply" class="form-control" required></textarea>

        <br>
        <button class="btn btn-primary">Send Reply</button>
    </form>

</div>
@endsection