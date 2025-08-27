<div style="max-width:600px;margin:0 auto;padding:20px;background:#ffffff;border:1px solid #ddd;border-radius:8px;font-family:Arial,sans-serif;font-size:14px;line-height:1.6;color:#333;">
    <h2 style="color:#000;">New Staff Hire Application Received</h2>

    <p><strong>Name:</strong> {{ $staffHire->first_name }} {{ $staffHire->last_name }}</p>
    <p><strong>Email:</strong> {{ $staffHire->email }}</p>
    <p><strong>Phone:</strong> {{ $staffHire->phone }}</p>
    <p><strong>Category:</strong> {{ $staffHire->staff_category }}</p>

    <p style="margin-top:20px;">
        <a href="{{ url('/admin') }}" 
           style="background:#0d6efd;color:#fff;padding:10px 20px;border-radius:5px;text-decoration:none;display:inline-block;">
           View in Admin Dashboard
        </a>
    </p>

    <p style="margin-top:30px;">Thanks,<br><strong>EMS</strong></p>
</div>
