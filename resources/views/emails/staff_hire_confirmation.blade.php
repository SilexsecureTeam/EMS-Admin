<div style="max-width:600px;margin:0 auto;padding:20px;background:#ffffff;border:1px solid #ddd;border-radius:8px;font-family:Arial,sans-serif;font-size:14px;line-height:1.6;color:#333;">
    <h2 style="color:#000;">Application Received</h2>

    <p>Dear {{ $staffHire->first_name }},</p>

    <p>
        Thank you for applying for the <strong>{{ $staffHire->staff_category }}</strong> position.
    </p>

    <p>
        We’ve successfully received your application, and our team will review it shortly.
    </p>

    <h3 style="margin-top:20px;">Your Details</h3>
    <ul>
        <li><strong>Email:</strong> {{ $staffHire->email }}</li>
        <li><strong>Phone:</strong> {{ $staffHire->phone }}</li>
        <li><strong>Experience:</strong> {{ $staffHire->years_of_experience }} years</li>
    </ul>

    <p>
        We’ll reach out if we need more information.
    </p>

    <p style="margin-top:30px;">
        Best regards,<br>
        <strong>The HR Team</strong>
    </p>
</div>

