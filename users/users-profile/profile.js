const currentPassword = document.getElementById('currentPassword');
const newPassword = document.getElementById('newPassword');
const renewPassword = document.getElementById('renewPassword');
const passForm = document.getElementById('passForm');

//EventListener for ChangePassword Button
passForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(passForm);

    fetch('changeUserPass.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Show the message to the user
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

