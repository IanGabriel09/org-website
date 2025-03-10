// Script directory variables (For page redirection purposes)
const scriptLocation = document.currentScript.src;
const scriptDirectory = scriptLocation.substring(0, scriptLocation.lastIndexOf('/') + 1);

const username = sessionStorage.getItem('username');
const password = sessionStorage.getItem('password');

function checkUser (username, password) {
    $.ajax({
        url: scriptDirectory + './sign-in_admin.php',
        type: 'POST',
        data: { uName: username, pass: password },
        dataType: 'JSON',
        success: function(response) {
            if(response.status !== 'success') {
                alert('Credentials of user are not found. Please log in first');
                window.location.href = scriptDirectory + './auth_protected.html';
            }
        },
        error: function(xhr, status, error) {

        }
    })
}

$(document).ready(function() {
    console.log('Username: ', sessionStorage.getItem('username'));
    console.log('Pass: ', sessionStorage.getItem('password'));

    checkUser(username, password);
});