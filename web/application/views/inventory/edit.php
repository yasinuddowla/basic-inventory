<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h1 class="modal-title fs-5">Edit Inventory</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" value="" id="edit-inp-id">
                <div class="mb-3">
                    <label for="edit-inp-name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="edit-inp-name" placeholder="inventory name">
                </div>
                <div class="mb-3">
                    <label for="edit-inp-description" class="form-label">Description</label>
                    <textarea id="edit-inp-description" rows="5" class="form-control" placeholder="inventory details"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="updateBtn" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
<script>
    document.getElementById("updateBtn").addEventListener("click", function() {
        let invId = document.getElementById("edit-inp-id").value;
        let url = `${apiBaseURL}inventory/${invId}`
        let data = {
            name: document.getElementById("edit-inp-name").value,
            description: document.getElementById("edit-inp-description").value,
        }
        makeRequest(url, data, {
                method: 'PATCH'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    localStorage.setItem("lastResponse", JSON.stringify(response));
                    redirectAfterDelay(`./inventory`, 500)
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    });
</script>