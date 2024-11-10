const currentPassword = document.getElementById('currentPassword');
const newPassword = document.getElementById('newPassword');
const renewPassword = document.getElementById('renewPassword');
const passForm = document.getElementById('passForm');
//modal
const modalVerifyTitleFront = document.getElementById('modalVerifyTitle-Front');
const modalVerifyTextFront = document.getElementById('modalVerifyText-Front');

//EventListener for ChangePassword Button
passForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(passForm);

    fetch('changeUserPass.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Success';
                modalVerifyTextFront.textContent = 'Your password was updated succesfully!';
                confirmationModalFront.show();
                setTimeout(() => {
                    location.reload(); // Redirect on success
                }, 1000);
            }else{
                const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Error';
                modalVerifyTextFront.textContent = 'Your password was not updated due to an error. \nMake sure that the new password is not the same as the old one.';
                console.log(data.message);
                confirmationModalFront.show();
                setTimeout(() => {
                    location.reload(); // Redirect on success
                }, 2000);
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
        submitButton.disabled = false;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

document.getElementById('profileEditForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Create FormData object

    fetch('updateUserDetails.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Success';
                modalVerifyTextFront.textContent = 'User details were updated succesfully!';
                confirmationModalFront.show();
                setTimeout(() => {
                    location.reload(); // Redirect on success
                }, 1000);
            } else {
                const confirmationModalFront = new bootstrap.Modal(document.getElementById('disablebackdrop-Front'));
                modalVerifyTitleFront.textContent = 'Error';
                modalVerifyTextFront.textContent = 'User details were not updated due to an error.';
                console.log(data.message);
                confirmationModalFront.show();
                setTimeout(() => {
                    location.reload(); // Redirect on success
                }, 1000);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
});