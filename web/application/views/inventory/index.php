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
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" id="addModal">
    <?php $this->load->view('inventory/add') ?>
</div>

<script>
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
                        const tableRow = createTableData(row);
                        tbody.appendChild(tableRow);
                    }
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    });
</script>