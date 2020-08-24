@component('mail::message')
# Leave Request

This is to inform you that {{$getfname}} {{$getlname}} filed a leave request to you, kindly check on by clicking the button below. 

Leave Application Date: {{$daterange}}<br>
Purpose of Leaving: {{$purpose}}

@component('mail::button', ['url' => 'https://hris.livewire365.com/'])
Check out
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
