document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        alert("Patient note added successfully!");
    }
});
