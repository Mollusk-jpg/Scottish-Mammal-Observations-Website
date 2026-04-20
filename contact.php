<?php
    require_once 'includes/animal_list_header.php';

    $sitename = "Contact";
?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - My Website</title>
    <link rel="stylesheet" href="css/contact_style.css">
    <style>
    body {
        color: white;
    }
    form {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
    </style>
</head>
<body>
<h1> Contact Us </h1>
    <form action="includes/process_message.php" id="contact-form" method="post">
    <div class="form-group">
        <label for="name">Name *</label>
        <input type="text" id="name" name="name"
            required minlength="2" placeholder="Your name">
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email"
            required placeholder="your@email.com">
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone"
            pattern="[0-9]{11}" placeholder="01onal1234567">
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="message">Message *</label>
        <textarea id="message" name="message"
                required minlength="10" placeholder="Your message..."></textarea>
        <span class="error-message"></span>
    </div>

    <button type="submit">Send Message</button>
    </form>

    <script src="js/script.js" defer></script>
</body>
</html>