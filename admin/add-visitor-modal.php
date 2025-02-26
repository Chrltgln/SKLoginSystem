<!-- Add Account Modal -->
<div class="modal fade <?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal']) echo 'show'; ?>" 
     id="modalForVisitor" 
     tabindex="-1" 
     aria-labelledby="exampleModalLabel" 
     aria-hidden="true"
     style="<?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal']) echo 'display: block;'; ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">

                <!-- Form -->
                <form action="process/add-visitor-logic.php" method="POST">
                    <div class="mb-3">
                        <label for="role" class="form-label">Select a Visitor Type</label>
                        <select name="role" id="role" class="form-control">
                            <option value="COUNCILOR">COUNCILOR</option>
                            <option value="CHAIRPERSON">CHAIRPERSON</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" id="middlename" name="middlename" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" id="lastname" name="lastname" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" id="age" name="age" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select name="sex" id="sex" class="form-select">
                            <option value="1">MALE</option>
                            <option value="2">FEMALE</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">ADD</button>
                </form>
            </div>
        </div>
    </div>
</div>
