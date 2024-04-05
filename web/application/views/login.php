<div class="d-flex align-items-center py-4" style="height: 100%;">
	<div class="form-signin w-100 m-auto">
		<form>
			<h1 class="h3 mb-3 fw-normal">Sign in</h1>

			<div class="form-floating">
				<input type="email" class="form-control" id="emailInput" placeholder="name@example.com" autocomplete="off">
				<label for="emailInput">Email</label>
			</div>
			<div class="form-floating mt-2">
				<input type="password" class="form-control" id="passInput" placeholder="Password" autocomplete="off">
				<label for="passInput">Password</label>
			</div>
			<button class="btn btn-primary w-100 py-2" type="button" id="signin">Sign in</button>
			<p class="text-end mt-2"><a href="<?= base_url('register') ?>">Signup</a></p>
		</form>
	</div>
</div>

<script>
	document.getElementById("signin").addEventListener("click", function() {
		let url = `${apiBaseURL}login`
		let data = {
			email: document.getElementById("emailInput").value,
			password: document.getElementById("passInput").value,
		}
		makeRequest(url, data)
			.then(response => {
				if (response.error) {
					showToast('error', response.message)
				} else {
					localStorage.setItem("token", response.data.token);
					localStorage.setItem("refreshToken", response.data.refresh_token);
					localStorage.setItem("user_id", response.data.user_id);
					localStorage.setItem("lastResponse", JSON.stringify(response));
					redirectAfterDelay(`./`, 500)
				}
			})
			.catch(error => {
				showToast('error', 'Something went wrong.');
				console.error('Error:', error);
			});
	});
</script>