@component('mail::message')
# Application Received

Dear {{ $staffHire->first_name }},

Thank you for applying for the **{{ $staffHire->staff_category }}** position.  

We’ve successfully received your application, and our team will review it shortly.  

### Your Details
- **Email:** {{ $staffHire->email }}
- **Phone:** {{ $staffHire->phone }}
- **Experience:** {{ $staffHire->years_of_experience }} years  

We’ll reach out if we need more information.  

Best regards,  
**The HR Team**
@endcomponent
