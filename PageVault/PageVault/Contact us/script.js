document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('message').value = '';
    document.getElementById('confirmationMessage').classList.remove('hidden');
    document.getElementById('contactForm').classList.add('hidden');
});
