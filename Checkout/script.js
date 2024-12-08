document.getElementById('checkoutForm').addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('cardName').value = '';
    document.getElementById('cardNumber').value = '';
    document.getElementById('expiryDate').value = '';
    document.getElementById('cvv').value = '';
    document.getElementById('confirmationMessage').classList.remove('hidden');
    document.getElementById('checkoutForm').classList.add('hidden');
});
