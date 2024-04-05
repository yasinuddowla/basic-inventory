<div class="d-flex align-items-center py-4">
	<div class="form-signin w-100 m-auto">
		<h1 class="h3 mb-3 fw-normal">Sign up</h1>
		<div class="form-floating mt-2">
			<input type="email" class="form-control" id="emailInput" placeholder="name@example.com" autocomplete="off">
			<label for="emailInput">Email</label>
		</div>
		<div class="form-floating mt-2">
			<input type="password" class="form-control" id="passInput" placeholder="Password" autocomplete="off">
			<label for="passInput">Password</label>
		</div>
		<button class="btn btn-success w-100 py-2" id="signup" type="button">Sign up</button>
		<p class="text-end mt-2"><a href="<?= base_url('login') ?>">Signin</a></p>
	</div>
</div>
<script>
	document.getElementById("signup").addEventListener("click", function() {
		let url = `${apiBaseURL}register`
		let data = {
			email: document.getElementById("emailInput").value,
			password: document.getElementById("passInput").value,
		}
		makeRequest(url, data)
			.then(response => {
				if (response.error) {
					showToast('error', response.message)
				} else {
					localStorage.setItem("lastResponse", JSON.stringify(response));
					showToast('success', response.message)
					redirectAfterDelay(`login`, 500)
				}
			})
			.catch(error => {
				showToast('error', 'Something went wrong.');
				console.error('Error:', error);
			});
	});
</script>