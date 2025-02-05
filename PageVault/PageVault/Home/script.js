document.querySelectorAll('.book').forEach(book => {
    book.addEventListener('click', () => {
        alert(`More details about "${book.querySelector('h3').textContent}" coming soon!`);
    });
});
