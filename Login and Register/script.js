document.querySelectorAll("a").forEach(anchor => {
    anchor.addEventListener("click", e => {
        e.preventDefault();
        alert("This feature is not implemented.");
    });
});
