@extends('mails.layout')

@section('header-content')

@endsection

@section('content')
    <pre>
    * You cannot reply to this email address.

    Thank you for using this App.

    We have accepted your password change request.
    
    * If you do not know this email, please discard it.
    * Please send inquiries regarding this email to the following address.
    We look forward to your continued support of this App.

    Enquiry
    Email address：{{$contact_mail_id}} (Weekdays 10:00 --19:00).

    </pre>
@endsection

@section('footer-content')

@endsection