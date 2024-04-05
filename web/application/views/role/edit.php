<div class="modal-content">
    <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Edit User Role</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <?php $submit_url = 'role/update'; ?>
        <?= form_open($submit_url, 'class="form-horizontal validate" id="modal-form-edit"') ?>
        <input type="hidden" name="id" value="<?= $role['id'] ?>">
        <div class="row mb-2 form-group">
            <label class="col-form-label col-3 text-end">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" value="<?= $role['name'] ?>" name="name" required placeholder="name" />
            </div>
        </div>
        <?= form_close() ?>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="modal-form-edit" class="btn btn-success">Update</button>
    </div>
</div>