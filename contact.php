<?php
    require_once 'includes/animal_list_header.php';
?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Website</title>
    <link rel="stylesheet" href="css/contact_style.css">

</head>
<body>

    <form id="contact-form">
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

    <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password"
        placeholder="Create a password">
    <div id="strength-indicator">
        <div id="strength-bar"></div>
    </div>
    <p id="strength-text">Password strength: <span>None</span></p>
    </div>

    <button type="submit">Send Message</button>
    </form>


    <section id="api-demo">
        <h2>API Data Demo</h2>
        <button id="fetch-btn">Load Posts</button>
        <div id="loading" class="hidden">Loading...</div>
        <div id="data-container"></div>
        <div id="error-container" class="hidden"></div>
    </section>

    <script src="js/script.js" defer></script>
</body>
</html>