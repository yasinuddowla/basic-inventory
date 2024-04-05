<div class="d-flex align-items-center py-4" style="height: 100%;">
	<div class="form-signin w-100 m-auto">
		<form>
			<h1 class="h3 mb-3 fw-normal">Sign in</h1>

			<div class="form-floating">
				<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
				<label for="floatingInput">Email</label>
			</div>
			<div class="form-floating mt-2">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off">
				<label for="floatingPassword">Password</label>
			</div>
			<button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
			<p class="text-end mt-2"><a href="<?= base_url('register') ?>">Signup</a></p>
		</form>
	</div>
</div>

<script>
	let lastResponse = localStorage.getItem("lastResponse");
	if (lastResponse) {
		response = JSON.parse(lastResponse);
		showToast(
			response.error ? 'error' : 'success',
			response.message
		)
		localStorage.removeItem('lastResponse')
	}
</script>