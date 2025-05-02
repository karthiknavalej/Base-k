@extends('mails.layout')

@section('header-content')

@endsection

@section('content')
    <pre>

    {{$user->name}}
   
    Thank you for registering our Application!. 
    We are looking forward to seeing you there and sharing our inbound content with  you.
    
    Best Regards.
    Team.

    For Enquiry
    Email address：{{$contact_mail_id}} (Weekdays 10:00 --19:00).
    </pre>
@endsection

@section('footer-content')

@endsection