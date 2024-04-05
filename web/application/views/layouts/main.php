<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->systemName ?> | Inventory Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Custom styles/JS -->
	<link href="<?= base_url('assets/styles.css') ?>" rel="stylesheet">
	<script src="<?= base_url('assets/color-modes.js') ?>"></script>
</head>

<body class="bg-body-tertiary">
	<?php $this->load->view('layouts/theme') ?>
	<?php $this->load->view('layouts/toasts') ?>

	<?php
	if ($this->loadTopNav)
		$this->load->view('layouts/top_nav')
	?>
	<main class="container">
		<?php $this->load->view($mainView) ?>
	</main>
	<script>
		const apiBaseURL = `<?= config_item('api_url') ?>`
	</script>
	<script src="<?= base_url('assets/custom.js') ?>"></script>


	<script>
		let lastResponse = localStorage.getItem("lastResponse");
		if (lastResponse) {
			response = JSON.parse(lastResponse);
			showToast(
				response.error ? 'error' : 'success',
				response.message
			)
			localStorage.removeItem('lastResponse')
			localStorage.setItem('lastResponseCopy', lastResponse)
		}
	</script>
</body>

</html>