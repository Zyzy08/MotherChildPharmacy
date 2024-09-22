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

//Changing Profile Piture Events
function previewFile() {
    const file = document.getElementById('upload-input').files[0];
    const preview = document.getElementById('previewImage');
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

document.getElementById('profileEditForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Create FormData object

    fetch('updateUserDetails.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Show success message
            location.reload(); // Refresh the page
        } else {
            alert(data.message); // Show error message
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});