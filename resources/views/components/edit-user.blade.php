<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog rounded" role="document">
        <div class="modal-content">
        <div class="modal-body">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <form method="POST" files="true" enctype="multipart/form-data" action="profile">
            @csrf
                <input type="text" name="byAdmin" id="byAdmin" class="d-none">
                <input type="text" name="id" id="id" class="d-none">
                <div class="mt-4 mb-5">
                    <h5 class="modal-title" id="exampleModalLabel">Editace údajů uživatele</h5> 
                    <div class="col">
                                <label for="name">Jméno</label>
                                <input type="text" class="form-control" id="edit-name" name="username" required oninvalid="this.setCustomValidity('Vyplnite toto policko')">
                    </div>
                    <div class="col">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="edit-email" name="email" required oninvalid="this.setCustomValidity('Vyplnite toto policko')">
                    </div>
                    <div class="col">
                                <label for="password">Reset hesla</label>
                                <input type="text" class="form-control" id="edit-password-byAdmin" name="password" value="">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button>
                <button type="submit" class="btn btn-success">Uložit změny</button>
            </form>
        </div>
        </div>
    </div>
</div>