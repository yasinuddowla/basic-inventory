<div class="card">
    <div class="card-body">
        <div class="mb-2 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ph-plus-circle me-1"></i> Add Role</button>
        </div>

        <?php if ($numRoles > 0) : ?>
            <table class="table table-bordered <?= $this->userData->isSuperAdmin ? 'datatable-button-html5-basic' : 'datatable-simple' ?>">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Public</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role) : ?>
                        <tr>
                            <td><?= $role['id'] ?></td>
                            <td><?= $role['name'] ?></td>
                            <td>
                                <?php $status = getBooleanStatus($role['is_public']) ?>
                                <span class="badge bg-<?= $status['colorClass'] ?> bg-opacity-20 text-<?= $status['colorClass'] ?>"><?= $status['text'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" class="dropdown-item" onclick="showEditModal(<?= $role['id'] ?>)"><i class="ph-note-pencil me-2"></i> Edit</button>
                                            <button type="button" class="dropdown-item" onclick="showDeleteModal(<?= $role['id'] ?>)"><i class="ph-trash me-2"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-primary mt-3">
                <h3 class="text-center">No role added.</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    async function showEditModal(id) {
        document.getElementById('modalBody').innerHTML = '';
        document.getElementById('modalBody').innerHTML = await makeCallXHR("<?= base_url('role/edit/') ?>" + id);
        showModal('viewModal');
    }

    function showDeleteModal(id) {
        document.querySelector('#delId').value = id;
        showModal('delModal');
    }
</script>


<!-- Edit role Modal Starts -->
<div class="modal fade custom-width" id="viewModal">
    <div class="modal-dialog" id="modalBody"></div>
</div>

<div id="addModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add User Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <?= form_open('role/add', 'id="modal-form" class="form-horizontal form-groups-bordered validate"') ?>
                <div class="row mb-2 form-group">
                    <label class="col-form-label col-3 text-end">Name</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="name" required placeholder="Role name" />
                    </div>
                </div>
                <?= form_close() ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="modal-form" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal Starts-->
<div id="delModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h3>Are you sure?</h3>
                    <h4 class="text-danger">User role will be deleted.</h4>
                    <?php $submit_url = 'role/delete/'; ?>
                    <?= form_open($submit_url); ?>
                    <input type="hidden" name="id" id="delId" value="">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>