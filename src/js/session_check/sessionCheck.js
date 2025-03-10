// Script directory variables (For page redirection purposes)
const scriptLocation = document.currentScript.src;
const scriptDirectory = scriptLocation.substring(0, scriptLocation.lastIndexOf('/') + 1);

// Page interaction variables
let mouseMoved = false;
let inactivityTimer;
let sessionTimeoutTimer; // Timer for session timeout after inactivity

// Local storage variables
const userSession = localStorage.getItem('userEmail');
let activityTimestamp = Number(localStorage.getItem('activityTimestamp'));
let expirationTime = Number(localStorage.getItem('sessionExpirationTime'));

// Function to check auth timestamp on page load (Determines if session is still authenticated based on time restriction)
function checkAuthTimestamp() {
    // Get the current timestamp
    let authTimeStamp = Date.now();

    // Compare the stored activityTimestamp to the current timestamp
    if (expirationTime > authTimeStamp) {
        return true;
    } else {
        return false;
    }
}

// Function to check username in local storage (Runs an async call to check_auth.php)
function checkAuthDB(userSessionName, callback) {
    $.ajax({
        url: scriptDirectory + './check_auth.php',
        type: 'POST',
        data: { userEmail: userSessionName },
        dataType: 'JSON',
        success: function(response) {
            let isExisting = response.status === 'success'; // Set isExisting based on the response
            callback(isExisting); // Call the callback function with the result
        },
        error: function(xhr, status, error) {
            alert('Internal server error. Please check browser console.');
            console.error(error);
            callback(false); // Call callback with false if there's an error
        }
    });
}

// Function that runs when there's no mouse movement for 10 seconds (Starts countdown for session timeout)
function onInactivityDetected() {
    console.log("No mouse movement detected for 10 seconds");

    // Update the activity timestamp and expiration time
    const currentTimestamp = new Date().getTime();  // Using getTime() for milliseconds
    const expirationTimestamp = new Date().getTime();  // Also using getTime() here
    const updatedExpiration = expirationTimestamp + 1 * 60 * 1000; // add 1 minute to exp

    activityTimestamp = currentTimestamp;
    expirationTime = updatedExpiration;

    localStorage.setItem('activityTimestamp', currentTimestamp); // Store activity timestamp (login time)
    localStorage.setItem('sessionExpirationTime', updatedExpiration); // Set session expiration based on login time

    // Start a 30-second countdown for session timeout if no mouse movement
    startSessionTimeoutCountdown();
}

// Function to handle session timeout (Basically redirects to login page when session timeout is reached)
function startSessionTimeoutCountdown() {
    // Clear the previous session timeout timer if it exists
    clearTimeout(sessionTimeoutTimer);

    // Set a new 30-second timeout to clear localStorage and redirect
    sessionTimeoutTimer = setTimeout(function() {
        console.log("Session timeout! No movement detected for 30 seconds.");
        alert('Session time out. You have been logged out due to inactivity.');
        localStorage.clear();
        location.reload();
    }, 30000); // 30 seconds = 30000 ms
}

// Listen for mouse movements (Also clears inactivity timer when mouse is moving)
if (userSession !== null) {
    document.addEventListener('mousemove', function() {
        mouseMoved = true;
        console.log("Mouse moved!");

        // Clear the previous inactivity timer
        clearTimeout(inactivityTimer);
        clearTimeout(sessionTimeoutTimer); // Clear session timeout if there's activity

        inactivityTimer = setTimeout(onInactivityDetected, 10000); 
    });

    // Trigger inactivity detection if no movement happens from the start
    inactivityTimer = setTimeout(onInactivityDetected, 10000); // Trigger after 10 seconds if no movement from the start
}

$(document).ready(function() {
    console.log(scriptDirectory);

    const checkAuth = checkAuthTimestamp();
    let authDiv = $('#auth');
    let logOutDiv = $('#logOut');

    console.log(authDiv);
        
    // Pass a callback function to handle the result of the checkAuthDB function
    checkAuthDB(userSession, function(checkName) {
        console.log('checkName: ', checkName);

        if(userSession === null){
            localStorage.clear();
            authDiv.removeClass('d-none');
            logOutDiv.addClass('d-none');
        } else if (!checkAuth) {
            alert('You have been logged out due to inactivity.');
            localStorage.clear();
            location.reload();
        } else if (!checkName) {
            alert('Your email is not registered. If you want to use members tab, please register and login first.');
            localStorage.clear();
            location.reload();
        } else {
            // If the session is valid, show logOutDiv and hide authDiv
            authDiv.addClass('d-none');
            logOutDiv.removeClass('d-none');
        }
    });
});
