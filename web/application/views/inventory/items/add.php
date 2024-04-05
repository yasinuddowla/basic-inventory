<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h1 class="modal-title fs-5">Add Item</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" value="<?= $inventoryId ?>" id="add-item-id">
                <div class="mb-3">
                    <label for="add-item-name" class="form-label">Name</label>
                    <input required type="text" class="form-control" id="add-item-name" placeholder="item name">
                </div>
                <div class="mb-3">
                    <label for="add-item-quantity" class="form-label">Quantity</label>
                    <input required type="number" class="form-control" id="add-item-quantity" placeholder="quantity">
                </div>

                <div class="mb-3">
                    <label for="add-item-image-file" class="form-label">Image</label>
                    <input type="file" class="form-control" id="add-item-image-file" accept="image/*">
                    <input type="hidden" value="" id="add-item-image">
                </div>
                <div class="mb-3">
                    <label for="add-item-description" class="form-label">Description</label>
                    <textarea id="add-item-description" rows="5" class="form-control" placeholder="item details"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="addBtn" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
<script>
    document.getElementById("addBtn").addEventListener("click", function() {
        let invId = document.getElementById("add-item-id").value
        let url = `${apiBaseURL}inventory/${invId}/items`
        let data = {
            name: document.getElementById("add-item-name").value,
            description: document.getElementById("add-item-description").value,
            quantity: document.getElementById("add-item-quantity").value,
            image: document.getElementById("add-item-image").value,
        }
        makeRequest(url, data, {
                method: 'POST'
            })
            .then(response => {
                if (response.error) {
                    showToast('error', response.message)
                } else {
                    localStorage.setItem("lastResponse", JSON.stringify(response));
                    redirectAfterDelay(`<?= base_url() ?>/inventory/details/${invId}`, 500)
                }
            })
            .catch(error => {
                showToast('error', 'Something went wrong.');
                console.error('Error:', error);
            });
    });

    const addFileInput = document.getElementById('add-item-image-file');
    addFileInput.addEventListener('change', async (event) => {
        const uploadedFile = event.target.files[0];
        if (!uploadedFile) {
            return; // No file selected
        }

        try {
            const base64String = await getBase64(uploadedFile);
            document.getElementById("add-item-image").value = base64String
        } catch (error) {
            console.error("Error:", error);
        }
    });

    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }
</script>