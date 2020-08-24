@component('mail::message')
# Announcement Notice

Hi Kindly check this new Announcement regarding {{$gettitle}}

Description: {{$getdescription}}
{{$getid}}
@component('mail::button', ['url' => $getid])
Check out
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
