@component('mail::message')
# Leave Approve

This is to inform you that your leave application was <strong>approved</strong>.

Date Approved: {{$getdatenow}}<br>
Date of Application: {{$getdatefrom}} - {{$getdateto}} <br>
Purpose: {{$getpurpose}}

Kindly check on the HRIS system for assurance. Thank you!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
