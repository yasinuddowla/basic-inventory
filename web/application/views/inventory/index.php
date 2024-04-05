<div class="card card-body w-75 m-auto">
    <h1 class="me-auto">Inventory List</h1>
    <div class="ms-auto">
        <button type="button" class="btn btn-info d-inline-block" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Last Updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" id="addModal">
    <?php $this->load->view('inventory/add') ?>
</div>

<div class="modal" tabindex="-1" id="editModal">
    <?php $this->load->view('inventory/edit') ?>
</div>

<script>
    // load all inventory for this user
    document.addEventListener("DOMContentLoaded", function() {
        let url = `${apiBaseURL}inventory`
        makeRequest(url, null, {
                method: 'GET'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    const table = document.querySelector("table");
                    const tbody = table.querySelector("tbody");

                    // Create table rows and append to tbody
                    for (const row of response.data) {
                        delete row.user_id
                        const tr = document.createElement("tr");
                        for (const value in row) {
                            const td = document.createElement("td");
                            td.textContent = row[value];
                            tr.appendChild(td);
                        }
                        // add buttons
                        const td = document.createElement("td");
                        td.innerHTML = `
                            <button onClick="editInventory(${row.id})" class="btn btn-sm btn-warning">Edit</button>
                            <button onClick="deleteInventory(${row.id})" class="btn btn-sm btn-danger">Delete</button>
                        `
                        tr.appendChild(td);
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
    // get clicked item
    function editInventory(invntoryId) {
        let url = `${apiBaseURL}inventory/${invntoryId}`
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
</script>