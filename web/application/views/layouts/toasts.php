<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto"><?= $this->systemName ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-body">
            <div id="">

            </div>
        </div>
    </div>
</div>

<script>
    function showToast(type, msg) {
        let typeClass = type == 'error' ? 'bg-danger' : 'bg-success';
        document.getElementById('liveToast').classList.remove('bg-danger', 'bg-success')
        document.getElementById('liveToast').classList.add(typeClass)
        document.getElementById('toast-body').innerHTML = msg;
        const toastLiveExample = document.getElementById('liveToast')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastBootstrap.show()
    }
</script>