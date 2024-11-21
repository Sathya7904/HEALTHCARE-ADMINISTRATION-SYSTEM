function setRole(role) {
    document.getElementById('roleText').innerText = role;
        document.querySelectorAll('.role-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById(role.toLowerCase() + 'Btn').classList.add('active');
}
