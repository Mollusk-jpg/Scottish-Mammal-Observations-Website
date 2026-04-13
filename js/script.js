const form = document.getElementById('contact-form');

form.addEventListener('submit', function(event) {
    event.preventDefault(); // Stop the form from submitting

    if (validateForm()) {
        alert('Form is valid! In Block 7, this will submit to PHP.');
        // form.submit(); // Would actually submit when PHP is ready
    }
});

function validateForm() {
    let isValid = true;
    clearErrors();

    // Name validation
    const name = document.getElementById('name');
    if (name.value.trim().length < 2) {
        showError(name, 'Name must be at least 2 characters');
        isValid = false;
    }

    // Email validation
    const email = document.getElementById('email');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        showError(email, 'Please enter a valid email address');
        isValid = false;
    }

    // Phone validation (optional field)
    const phone = document.getElementById('phone');
    if (phone.value && !/^[0-9]{11}$/.test(phone.value)) {
        showError(phone, 'Phone must be 11 digits');
        isValid = false;
    }

    // Message validation
    const message = document.getElementById('message');
    if (message.value.trim().length < 10) {
        showError(message, 'Message must be at least 10 characters');
        isValid = false;
    }

    return isValid;
}

function showError(input, message) {
    const errorSpan = input.parentElement.querySelector('.error-message');
    errorSpan.textContent = message;
    errorSpan.classList.add('visible');
    input.classList.add('invalid');
}

function clearErrors() {
    document.querySelectorAll('.error-message').forEach(span => {
        span.textContent = '';
        span.classList.remove('visible');
    });
    document.querySelectorAll('.invalid').forEach(input => {
        input.classList.remove('invalid');
    });
}

document.getElementById('email').addEventListener('input', function() {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const errorSpan = this.parentElement.querySelector('.error-message');

    if (this.value && !emailPattern.test(this.value)) {
        showError(this, 'Please enter a valid email address');
    } else {
        errorSpan.textContent = '';
        errorSpan.classList.remove('visible');
        this.classList.remove('invalid');
    }
});

document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.querySelector('#strength-text span');

    let strength = 0;

    // Check criteria
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Update display
    strengthBar.className = '';
    switch (strength) {
        case 0:
            strengthText.textContent = 'None';
            break;
        case 1:
            strengthBar.classList.add('weak');
            strengthText.textContent = 'Weak';
            break;
        case 2:
            strengthBar.classList.add('fair');
            strengthText.textContent = 'Fair';
            break;
        case 3:
            strengthBar.classList.add('good');
            strengthText.textContent = 'Good';
            break;
        case 4:
            strengthBar.classList.add('strong');
            strengthText.textContent = 'Strong';
            break;
    }
});

const fetchBtn = document.getElementById('fetch-btn');
const loading = document.getElementById('loading');
const dataContainer = document.getElementById('data-container');
const errorContainer = document.getElementById('error-container');

fetchBtn.addEventListener('click', async function() {
    // Show loading state
    loading.classList.remove('hidden');
    dataContainer.innerHTML = '';
    errorContainer.classList.add('hidden');

    try {
        const response = await fetch(
            'https://jsonplaceholder.typicode.com/posts?_limit=5'
        );

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        displayData(data);

    } catch (error) {
        errorContainer.textContent = 'Failed to load data: ' + error.message;
        errorContainer.classList.remove('hidden');

    } finally {
        loading.classList.add('hidden');
    }
});

function displayData(posts) {
    posts.forEach(post => {
        const article = document.createElement('article');
        article.className = 'post-card';
        article.innerHTML = `
            <h3>${post.title}</h3>
            <p>${post.body}</p>
        `;
        dataContainer.appendChild(article);
    });
}