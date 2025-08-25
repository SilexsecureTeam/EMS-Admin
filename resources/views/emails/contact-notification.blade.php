@component('mail::message')
# 📩 New Contact Form Submission

**Name:** {{ $contact->firstname }} {{ $contact->lastname }}  
**Email:** {{ $contact->email }}  
**Phone:** {{ $contact->phone_number }}  
**Subject:** {{ $contact->subject }}  

**Message:**  
{{ $contact->message }}

---

*This message was sent from your EMS contact form.*
@endcomponent
