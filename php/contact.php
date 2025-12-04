<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(to right, #ffcc00 50%, #fff 50%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contact-card {
            background-color: #1a1a1a;
            color: #fff;
            padding: 40px 30px;
            border-radius: 20px;
            width: 360px;
            position: relative;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .contact-card h1 {
            margin-bottom: 25px;
            font-size: 28px;
            color: #fff;
        }

        .info p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
            font-size: 15px;
            border-bottom: 1px dashed #444;
            padding-bottom: 10px;
        }

        .chat-icons {
            position: absolute;
            bottom: -20px;
            right: -20px;
            font-size: 40px;
            color: #ffc107;
        }
    </style>
</head>

<body>
    <div class="contact-card">
        <h1>Contact Us</h1>
        <div class="info">
            <p><img src="https://img.icons8.com/ios-filled/20/FFC107/marker.png" /> 123 Anywhere St., Any City, ST 12345</p>
            <p><img src="https://img.icons8.com/ios-filled/20/FFC107/phone.png" /> 123-456-7890</p>
            <p><img src="https://img.icons8.com/ios-filled/20/FFC107/new-post.png" /> hello@reallygreatsite.com</p>
            <p><img src="https://img.icons8.com/ios-filled/20/FFC107/internet.png" /> www.reallygreatsite.com</p>
        </div>
        <div class="chat-icons">
        </div>
    </div>
</body>

</html>