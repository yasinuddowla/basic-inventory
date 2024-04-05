<div class="card card-body w-75 m-auto">
    <h1>Inventory Details</h1>
    <h4>ID: <span id="inv-id"><?= $inventoryId ?></span></h4>
    <h4>Name: <span id="inv-name"></span></h4>
    <h4>Description: <span id="inv-description"></span></h4>
    <h2 class="mt-3">Items</h2>
    <div class="ms-auto">
        <button type="button" class="btn btn-info d-inline-block" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" id="addModal">
    <?php $this->load->view('inventory/items/add', ['inventoryId' => $inventoryId]) ?>
</div>

<div class="modal" tabindex="-1" id="editModal">
    <?php $this->load->view('inventory/items/edit') ?>
</div>

<!-- Delete modal -->
<div class="modal" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5">Delete Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" value="" id="delete-inp-id">
                    <h3 class="text-center">Are you sure?</h3>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="deleteBtn" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>
    // load all inventory for this user
    document.addEventListener("DOMContentLoaded", function() {
        let inventoryId = document.getElementById("inv-id").textContent
        let url = `${apiBaseURL}inventory/${inventoryId}`
        makeRequest(url, {}, {
                method: 'GET'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    document.getElementById("inv-name").textContent = response.data.name
                    document.getElementById("inv-description").textContent = response.data.description
                    // load items table
                    const table = document.querySelector("table");
                    const tbody = table.querySelector("tbody");

                    // Create table rows and append to tbody
                    for (const row of response.data.items) {
                        delete row.user_id
                        const tr = document.createElement("tr");

                        tr.innerHTML = `
                        <td>${row.id}</td>
                        <td>${row.name}</td>
                        <td>${row.description}</td>
                        <td>${row.quantity}</td>
                        <td><a target="_blank" href="${row.image}">View</a></td>
                        <td>${row.created_at}</td>
                        <td>
                            <button onClick="editInventory(${row.id})" class="btn btn-sm btn-warning">Edit</button>
                            <button onClick="showDeleteModal(${row.id})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                        `
                        tbody.appendChild(tr);
                    }
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    });
</script>

<script>
    // get clicked item for edit
    function editInventory(inventoryId) {
        let url = `${apiBaseURL}inventory/${inventoryId}`
        let data = {
            name: document.getElementById("inp-name").value,
            description: document.getElementById("inp-description").value,
        }
        makeRequest(url, data, {
                method: 'GET'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    document.getElementById("edit-inp-id").value = response.data.id;
                    document.getElementById("edit-inp-name").value = response.data.name;
                    document.getElementById("edit-inp-description").value = response.data.description;

                    showModal('editModal');
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    };

    // show delete modal
    function showDeleteModal(inventoryId) {
        document.getElementById("delete-inp-id").value = inventoryId;
        showModal('deleteModal');
    }

    document.getElementById("deleteBtn").addEventListener("click", function() {
        let inventoryId = document.getElementById("delete-inp-id").value
        let url = `${apiBaseURL}inventory/${inventoryId}`
        makeRequest(url, {}, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    redirectAfterDelay(`./inventory`, 500)
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    });
</script>