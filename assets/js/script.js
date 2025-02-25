// Function to show or hide forms
function showForm(formId) {
    document.getElementById('timeInForm').style.display = 'none';
    document.getElementById('timeOutForm').style.display = 'none';
    document.getElementById(formId).style.display = 'block';
}

function hideForm(formId) {
    document.getElementById(formId).style.display = 'none';
}

// Automatically close alerts after 10 seconds
setTimeout(function () {
    var alert = document.querySelector('.alert');
    if (alert) {
        var bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 10000);

// Get URL query parameters
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Show login modal if specified in URL parameters
if (getQueryParam('showLoginModal') === 'true') {
    const LoginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    LoginModal.show();
}

// Update the clock on the page
function updateClock() {
    const clockElement = document.getElementById("clock");
    const now = new Date();
    const hours = now.getHours() > 12 ? now.getHours() - 12 : now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");
    const amPm = now.getHours() >= 12 ? "PM" : "AM";
    const timeString = `${hours}:${minutes}:${seconds} ${amPm}`;
    clockElement.textContent = timeString;
}
setInterval(updateClock, 1000);
updateClock();

// Set the date on the page
document.addEventListener('DOMContentLoaded', () => {
    const dateElement = document.getElementById('date');
    const today = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

    dateElement.textContent = today.toLocaleDateString(undefined, options);

    const noEmailCheckbox = document.getElementById("noEmail");
    const emailField = document.getElementById("email");

    if (noEmailCheckbox) {
        noEmailCheckbox.addEventListener("change", function () {
            if (this.checked) {
                emailField.value = "This visitor has no email.";
                emailField.disabled = true;
            } else {
                emailField.disabled = false;
            }
        });
    }
});

// QR Scanner for Timing Out
let scanner = new Instascan.Scanner({ video: document.getElementById("preview") });
Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else {
        alert('No camera found');
    }
}).catch(function (e) {
    console.error(e);
});

scanner.addListener('scan', function (content) {
    // Assign scanned content to the input field
    let codeInput = document.getElementById("code");
    codeInput.value = content;

    // Ensure the value is set before submitting the form
    if (codeInput.value) {
        setTimeout(() => {
            document.getElementById("btnTimeOut").click();
        }, 100); // Small delay to ensure proper setting
    } else {
        alert("Failed to scan the QR code. Please try again.");
    }
});


// QR Scanner for SK Officials Timing In
let scannerForTimeIn = new Instascan.Scanner({ video: document.getElementById("previewTimeIn") });
Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scannerForTimeIn.start(cameras[0]);
    } else {
        alert('No camera found');
    }
}).catch(function (e) {
    console.error(e);
});

scannerForTimeIn.addListener('scan', function (content) {
    let codeInput = document.getElementById("code");
    codeInput.value = content;

    setTimeout(() => {
        if (codeInput.value) {
            document.getElementById("btnTimeIn").click();
        } else {
            alert("Failed to scan the QR code. Please try again.");
        }
    }, 100); 
});


// Show and hide fields based on visitor type
document.addEventListener("DOMContentLoaded", function () {
    const typeSelect = document.getElementById("type");
    const chairpersonFields = document.getElementById("chairpersonFields");
    const visitorFields = document.getElementById("visitorFields");

    if (typeSelect) {
        typeSelect.addEventListener("change", function () {
            if (typeSelect.value === "chairperson") {
                chairpersonFields.style.display = "block";
                visitorFields.style.display = "none";
            } else if (typeSelect.value === "visitor") {
                visitorFields.style.display = "block";
                chairpersonFields.style.display = "none";
            } else {
                chairpersonFields.style.display = "none";
                visitorFields.style.display = "none";
            }
        });
    }
});
