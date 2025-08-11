<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Submission</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; background: white; margin: auto; padding: 20px; border-radius: 8px; }
        h2 { color: #333; }
        .info { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-left: 5px; color: #222; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📩 New Contact Form Submission</h2>
        <div class="info">
            <span class="label">Name:</span>
            <span class="value">{{ $contact->firstname }} {{ $contact->lastname }}</span>
        </div>
        <div class="info">
            <span class="label">Email:</span>
            <span class="value">{{ $contact->email }}</span>
        </div>
        <div class="info">
            <span class="label">Phone:</span>
            <span class="value">{{ $contact->phone_number }}</span>
        </div>
        <div class="info">
            <span class="label">Subject:</span>
            <span class="value">{{ $contact->subject }}</span>
        </div>
        <div class="info">
            <span class="label">Message:</span>
            <span class="value">{{ $contact->message }}</span>
        </div>
        <p style="color:#777; font-size: 12px;">This message was sent from your website's contact form.</p>
    </div>
</body>
</html>

