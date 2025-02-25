<?php include 'includes/header.php'; ?>
<?php session_start(); 
?>

<body class="bg-dark d-flex justify-content-center" style="height: 100vh;">
    <div class="container text-center">
        <div class="position-absolute top-0 end-0 p-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fa fa-user"></i>
            </button>
        </div>
        <div class="position-absolute top-0 start-50 translate-middle-x mt-5">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="mb-2">'
                        <img src="assets/images/GENTRI-LOGO.webp" alt="GENTRI LOGO" style="max-width: 150px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="assets/images/SK-logo.png" alt="SK LOGO" style="max-width: 200px;">
                </div>
                <div class="col-md-4">
                    <img src="assets/images/SK-logo.png" alt="SK LOGO" style="max-width: 150px;">
                </div>
            </div>




            <h1 style="font-size: 2.8rem;" class="card-title text-light">SANGGUNIANG KABATAAN - PINAGTIPUNAN</h1>
        </div>


        <div id="date-time-container" class="text-light">
            <h2 id="date" class="date"></h2>
            <h2 id="clock" class="clock"></h2>
        </div>


        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show mt-3" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row mt-7">
            <div class="col-md-6 offset-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card text-center" data-bs-toggle="modal" data-bs-target="#timeInModal">
                            <div class="card-body">
                                <h5 class="card-title">TIME IN</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center" data-bs-toggle="modal" data-bs-target="#timeOutModal">
                            <div class="card-body">
                                <h5 class="card-title">TIME OUT</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">
                        <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name']; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="includes/generate-qr-code.php" alt="QR Code">
                    <p class="mt-3">Please take a capture for your QR CODE <br> or use this code for time out.</p>
                    <h4><?php echo $_SESSION['randomCode'] ?></h4>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="process/print-receipt.php" method="GET">
                                    <input type="hidden" name="visitor_code" id="visitor_code" value="<?php echo $_SESSION['randomCode']; ?>">
                                    <button type="submit" class="btn btn-primary">Print</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Time In Modal -->
    <div class="modal fade" id="timeInModal" tabindex="-1" aria-labelledby="timeInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeInModalLabel">Personal Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="type">VISITOR TYPE</label>
                            <select name="type" id="type" class="form-select">
                                <option value="" selected disabled>Select Visitor Type</option>
                                <option value="chairperson">SK OFFICIALS</option>
                                <option value="visitor">VISITOR</option>
                            </select>
                        </div>
                    </div>


                    <div id="chairpersonFields" class="visitor-fields" style="display: none;">
                        <!-- CHAIRPERSON & COUNCILOR -->

                        <div class="modal-body">
                            <h4 class="text-center">Place your QR Code on camera to time in</h4>
                            <div class="d-flex justify-content-center">
                                <video id="previewTimeIn" style="width: 100%; max-width: 600px;"></video>
                            </div>
                            <form action="process/time-in-out.php" method="POST">
                                <div class="mb-3">
                                    <label for="codeForTimeIn" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="codeForTimeIn" name="codeForTimeIn"
                                        placeholder="Enter your code">
                                </div>
                                <button type="submit" class="btn btn-danger" name="timeIn" id="btnTimeIn">TIME
                                    IN</button>
                            </form>
                        </div>


                    </div>
                    <!-- VISITOR FIELDS -->
                    <div id="visitorFields" class="visitor-fields" style="display: none;">
                        <form action="process/time-in-out.php" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                            placeholder="Ex. Juan">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="middleName" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName"
                                            placeholder="Ex. Santos">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName"
                                            placeholder="Ex. Dela Cruz">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Ex. abcdefg@gmail.com">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="noEmail" name="noEmail">
                                        <label class="form-check-label text-light" for="noEmail">
                                            I don't have an email
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Purpose</label>
                                        <input type="text" class="form-control" id="purpose" name="purpose"
                                            placeholder="Ex. Personal Matters">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="age" class="form-label">Age</label>
                                        <input type="text" class="form-control" id="age" name="age"
                                            placeholder="Ex. 21">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="sex" class="form-label">Sex</label>
                                        <select name="sex" class="form-select" id="sex">
                                            <option value="1">MALE</option>
                                            <option value="2">FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="timeIn">TIME IN</button>
                        </form>
                    </div>



                </div>

            </div>
        </div>
    </div>

    <!-- Time Out Modal -->
    <div class="modal fade" id="timeOutModal" tabindex="-1" aria-labelledby="timeOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeOutModalLabel">Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Place your QR Code on camera to time out</h4>
                    <video id="preview" width="100%" class="camera-view"></video>
                    <form action="process/time-in-out.php" method="POST">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter your code">
                        </div>
                        <button type="submit" class="btn btn-danger" name="timeOut" id="btnTimeOut">Time Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel"><i class="fa fa-user"></i> Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="process/login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

    <script>
        <?php if (isset($_SESSION['showQRModal'])): ?>
            var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            qrModal.show();
            <?php unset($_SESSION['showQRModal']); ?>
        <?php endif; ?>
    </script>

</body>

</html>