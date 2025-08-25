@component('mail::message')
# New Staff Hire Application Received

**Name:** {{ $staffHire->first_name }} {{ $staffHire->last_name }}  
**Email:** {{ $staffHire->email }}  
**Phone:** {{ $staffHire->phone }}  
**Category:** {{ $staffHire->staff_category }}  

@component('mail::button', ['url' => url('/admin')])
View in Admin Dashboard
@endcomponent

Thanks,  
**EMS**
@endcomponent
