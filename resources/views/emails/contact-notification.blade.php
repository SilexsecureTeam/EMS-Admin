<div style="max-width:600px;margin:0 auto;padding:20px;background:#ffffff;border:1px solid #ddd;border-radius:8px;font-family:Arial, sans-serif;font-size:14px;line-height:1.6;color:#333;">
    <h2 style="color:#000;">📩 New Contact Form Submission</h2>

    <p><strong>Name:</strong> {{ $contact->firstname }} {{ $contact->lastname }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone_number }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>

    <p><strong>Message:</strong><br>
    {{ $contact->message }}</p>

    <hr style="margin:20px 0;border:none;border-top:1px solid #eee;">

    <p style="font-size:12px;color:#666;"><em>This message was sent from your EMS contact form.</em></p>
</div>

