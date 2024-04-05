async function makeCallXHR(url) {
  try {
    const response = await fetch(url);
    if (response.ok) {
      return await response.text();
    } else {
      throw new Error(`Error: ${response.statusText}`);
    }
  } catch (error) {
    console.error(error);
  }
}

function showModal(targetElementId) {
  new bootstrap.Modal(document.getElementById(targetElementId)).show();
}

async function makeRequest(url, data, config) {
  const response = await fetch(url, {
    method: config.method, // Change to 'GET', 'PUT', or 'DELETE' as needed
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${config.token}`,
    },
    body: JSON.stringify(data),
  });
  console.log(response);

  if (!response.ok) {
    throw new Error(`API request failed with status ${response.status}`);
  }
  return await response.json();
}
function redirectAfterDelay(url, delay = 2000) {
  // Default delay to 2 seconds (2000 milliseconds)
  setTimeout(() => {
    window.location.href = url;
  }, delay);
}
