    //SWAL FOR LOGOUT
    document.addEventListener("DOMContentLoaded", function () {
        const logoutButton = document.getElementById("logout-button");

        if (logoutButton) {
            logoutButton.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You will be logged out of your session.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0A9548",
                    cancelButtonColor: "#a9a9a9",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "process/logout.php";
                    }
                });
            });
        }
        
    });

    //SWAL FOR DELETE BUTTON IN VIEW ACCOUNT FORMS
    document.addEventListener("DOMContentLoaded", function () {
        const deleteForms = document.querySelectorAll(".delete-form");
    
        deleteForms.forEach((form) => {
            const deleteButton = form.querySelector(".delete-button");
            deleteButton.addEventListener("click", function (e) {
                e.preventDefault(); 
    
                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will permanently delete the account.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0A9548",
                    cancelButtonColor: "#a9a9a9",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Successfully Deleted.",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then(() => {
                            form.submit(); 
                        });
                        
                    }
                });
            });
        });
    });
    

    //Pop up modal for edit user account
    document.addEventListener("DOMContentLoaded", function () {
        const editButtons = document.querySelectorAll(".editModalBtn");
    
        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                const username = this.getAttribute("data-username");
                const role = this.getAttribute("data-role");
    
                document.getElementById("edit-id").value = id;
                document.getElementById("edit-username").value = username;
                document.getElementById("edit-role").value = role;
            });
        });
    });
    
    // Pop up modal for edit official account
    document.addEventListener("DOMContentLoaded", () => {
        const editButtons = document.querySelectorAll(".btn-primary[data-bs-target='#editModal']");
    
        editButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const id = button.getAttribute("data-id");
                const type = button.getAttribute("data-type");
                const firstName = button.getAttribute("data-firstname");
                const middleName = button.getAttribute("data-middlename");
                const lastName = button.getAttribute("data-lastname");
                const email = button.getAttribute("data-email");
                const sex = button.getAttribute("data-sex");
                const age = button.getAttribute("data-age");
    
                // Populate the form
                document.getElementById("edit-id").value = id;
                document.getElementById("edit-type").value = type;
                document.getElementById("edit-firstname").value = firstName;
                document.getElementById("edit-middlename").value = middleName;
                document.getElementById("edit-lastname").value = lastName;
                document.getElementById("edit-email").value = email;
                document.getElementById("edit-sex").value = sex;
                document.getElementById("edit-age").value = age;
            });
        });
    });
    


    //fetch visitors data by search
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("search-input");
        const visitorTable = document.getElementById("visitor-table");

        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value;
                fetch(`fetch-visitors.php?search=${encodeURIComponent(query)}`)
                    .then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text();
                    })
                    .then((data) => {
                        visitorTable.innerHTML = data; 
                    })
                    .catch((error) => console.error("Error fetching data:", error));
            });
        }
    });

    //fetch officials data by search
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("search-officials-input");
        const visitorTable = document.getElementById("officials-table");

        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value;
                fetch(`fetch-official-duties.php?search=${encodeURIComponent(query)}`)
                    .then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text();
                    })
                    .then((data) => {
                        visitorTable.innerHTML = data; 
                    })
                    .catch((error) => console.error("Error fetching data:", error));
            });
        }
    });

    //fetch account data by search
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("search-input");
        const accountTable = document.getElementById("account-table");

        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value;
                fetch(`fetch-accounts.php?search=${encodeURIComponent(query)}`)
                    .then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text();
                    })
                    .then((data) => {
                        accountTable.innerHTML = data; 
                    })
                    .catch((error) => console.error("Error fetching data:", error));
            });
        }
    });


    //fetch insite data by search
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInsite");
        const visitorTable = document.getElementById("insite-table");
    
        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value;
                fetch(`fetch-monitor-visitor.php?searchInsite=${encodeURIComponent(query)}`)
                    .then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text();
                    })
                    .then((data) => {
                        visitorTable.innerHTML = data; 
                    })
                    .catch((error) => console.error("Error fetching data:", error));
            });
        }
    });

     //fetch outgoing data by search
     document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchOutgoing");
        const visitorTable = document.getElementById("outgoing-table");
    
        if (searchInput) {
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value;
                fetch(`fetch-monitor-visitor.php?searchOutgoing=${encodeURIComponent(query)}`)
                    .then((response) => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.text();
                    })
                    .then((data) => {
                        visitorTable.innerHTML = data; 
                    })
                    .catch((error) => console.error("Error fetching data:", error));
            });
        }
    });
    

    //Pop up modal for adding an account
    $(document).ready(function () {
        $("#addAccountBtn").click(function (e) {
            e.preventDefault(); 

            // Load modal 
            $.get("add-account-modal.php", function (data) {
                $("#modalContainer").html(data); 
                $("#exampleModal").modal("show");   
            });
        });
    });

    //Pop up modal for adding a visitor
    $(document).ready(function () {
        $("#addVisitorBtn").click(function (e) {
            e.preventDefault(); 

            // Load modal 
            $.get("add-visitor-modal.php", function (data) {
                $("#modalContainer").html(data); 
                $("#modalForVisitor").modal("show");   
            });
        });
    });

    //Pop up modal for custom range filter
    $(document).ready(function () {
        $("#customRangeBtn").click(function (e) {
            e.preventDefault(); 

            // Load modal 
            $.get("custom-range-modal.php", function (data) {
                $("#modalContainer").html(data); 
                $("#customRangeModal").modal("show");   
            });
        });
    });

    //Custom range for XLSX export in Visitor Reports section
    $(document).ready(function () {
        $("#customRangeExportXLSXBtn").click(function (e) {
            e.preventDefault(); 

            // Load modal 
            $.get("custom-range-export-XLSX-modal.php", function (data) {
                $("#modalContainer").html(data); 
                $("#customRangeExportXLSXModal").modal("show");   
            });
        });
    });



    //Custom range for PDF export in Visitor Reports section
    $(document).ready(function () {
        $("#customRangeExportPDFBtn").click(function (e) {
            e.preventDefault(); 

            // Load modal 
            $.get("custom-range-export-PDF-modal.php", function (data) {
                $("#modalContainer").html(data); 
                $("#customRangeExportPDFModal").modal("show");   
            });
        });
    });


    // alert message dismiss in 3 seconds
    setTimeout(function () {
        var alert = document.querySelector('.alert');
        if (alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
  



    // Listen for click event on "View Details" button
    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', function () {
            // Get data attributes from the clicked button
            const name = this.getAttribute('data-name');
            const age = this.getAttribute('data-age');
            const sex = this.getAttribute('data-sex');
            const code = this.getAttribute('data-code');
            const purpose = this.getAttribute('data-purpose');

            // Populate modal with visitor data
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-age').textContent = age;
            document.getElementById('modal-sex').textContent = sex;
            document.getElementById('modal-code').textContent = code;
            document.getElementById('modal-purpose').textContent = purpose;
            document.getElementById('visitor_code').value = code;

            // Dynamically generate QR code for the visitor code
            const qrImage = document.getElementById('qr-code');
            qrImage.src = '../../../includes/generate-qr-code.php?visitor_code=' + encodeURIComponent(code);
        });
    });


// Assuming you are using jQuery to set the value in the modal
$('.view-details').on('click', function() {
    let visitorCode = $(this).data('code');  
    $('#visitor_code').val(visitorCode); 
});



