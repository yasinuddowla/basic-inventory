<nav class="navbar navbar-expand-lg bg-body-tertiary rounded" aria-label="Thirteenth navbar example">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
            <a class="navbar-brand col-lg-3 me-0" href="#"><?= $this->systemName ?></a>
            <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('./') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('inventory') ?>">Inventory</a>
                </li>
            </ul>
            <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                <button class="btn btn-secondary" type="button" id="logoutBtn">Logout</button>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById("logoutBtn").addEventListener("click", function() {
        let url = `${apiBaseURL}logout`
        makeRequest(url, {})
            .then(response => {
                localStorage.clear();
                redirectAfterDelay(`./login`, 500)
                showToast('success', 'Logged out!');
            })
            .catch(error => {
                showToast('success', 'Logged out!');
                redirectAfterDelay(`./login`, 500)
            });
    });
</script>