<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="process/edit-official-logic.php" method="POST" id="editAccountForm">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-type" class="form-label">Select a type</label>
                        <select name="type" id="edit-type" class="form-select">
                            <option value="CHAIRPERSON">CHAIRPERSON</option>
                            <option value="COUNCILOR">COUNCILOR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First name</label>
                        <input type="text" id="edit-firstname" name="firstname" class="form-control">

                        <label for="middlename" class="form-label">Middle name</label>
                        <input type="text" id="edit-middlename" name="middlename" class="form-control">

                        <label for="lastname" class="form-label">Last name</label>
                        <input type="text" id="edit-lastname" name="lastname" class="form-control">

                        <label for="email" class="form-label">email</label>
                        <input type="text" id="edit-email" name="email" class="form-control">

                        <label for="sex" class="form-label">Sex</label>
                        <select name="sex" id="edit-sex" class="form-select">
                            <option value="1">MALE</option>
                            <option value="2">FEMALE</option>
                        </select>


                        <label for="age" class="form-label">Age</label>
                        <input type="text" id="edit-age" name="age" class="form-control">


                    </div>
                    <button type="submit" class="btn btn-success w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>