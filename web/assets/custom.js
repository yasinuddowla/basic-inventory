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

async function makeRequest(url, data, config = {}) {
  let options = {
    method: config.method || "POST", // Change to 'GET', 'PUT', or 'DELETE' as needed
    headers: {
      "Content-Type": "application/json",
    },
  };

  const token = localStorage.getItem("token");
  if (token) {
    options.headers.Authorization = `Bearer ${token}`;
  }
  if (options.method == "POST" || options.method == "PATCH") {
    options.body = JSON.stringify(data) || {};
  }

  try {
    const response = await fetch(url, options);
    if (response.ok) return await response.json();
    // for not ok
    if (response.status === 401) {
      // Attempt to refresh token if 401 (unauthorized)
      const refreshedToken = await refreshToken();
      if (refreshedToken) {
        // Update token and retry the request
        localStorage.setItem("token", refreshedToken);
        options.headers.Authorization = `Bearer ${refreshedToken}`;
        let newResponse = await fetch(url, options);
        return newResponse.json();
      } else {
        throw new Error("Failed to refresh token");
      }
    } else {
      throw new Error(`API request failed with status ${response.status}`);
    }
  } catch (error) {
    console.error("API request failed:", error);
    throw new Error(error);
  }
}
async function refreshToken() {
  const refreshToken = localStorage.getItem("refreshToken");
  if (!refreshToken) {
    // Handle situation where refresh token is missing (e.g., prompt for re-login)
    throw new Error("Missing refresh token");
  }

  const refreshUrl = `${apiBaseURL}refresh`; // Replace with your refresh token API endpoint

  try {
    const response = await fetch(refreshUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ refresh_token: refreshToken }),
    });

    if (response.status != 200) {
      throw new Error(
        `Refresh token request failed with status ${response.status}`
      );
    }

    const refreshData = await response.json();
    return refreshData.data.token; // Assuming the response contains a 'token' property
  } catch (error) {
    console.error("Error refreshing token:", error);
    return null; // Indicate refresh failure
  }
}
async function makeRequest1(url, data, config = {}) {
  var response = await callURL(url, data, config);
  // refresh token if 401
  if (response.status == 401) {
    const refreshResponse = await callURL(`${apiBaseURL}refresh`, {
      refresh_token: localStorage.getItem("refreshToken"),
    })
      .then((responseObj) => {
        if (responseObj.status == 401) {
          throw new Error(`API request failed with status ${response.status}`);
        }
        // store new token
        localStorage.setItem("token", refreshResponse.data.token);
      })
      .then((responseObj) => {});
  } else {
    if (!response.ok) {
      throw new Error(`API request failed with status ${response.status}`);
    }
    return await response.json();
  }
}
async function callURL1(url, data, config = {}) {
  let options = {
    method: config.method || "POST", // Change to 'GET', 'PUT', or 'DELETE' as needed
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("token") || ""}`,
    },
  };
  if (options.method == "POST" || options.method == "PATCH") {
    options.body = JSON.stringify(data) || {};
  }
  return await fetch(url, options);
}

function redirectAfterDelay(url, delay = 2000) {
  // Default delay to 2 seconds (2000 milliseconds)
  setTimeout(() => {
    window.location.href = url;
  }, delay);
}


