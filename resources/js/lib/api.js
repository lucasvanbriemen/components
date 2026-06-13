const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  ?.getAttribute("content");

const jsonHeaders = {
  Accept: "application/json",
  "X-CSRF-TOKEN": csrfToken,
};

async function parse(response) {
  const isJson = response.headers
    .get("content-type")
    ?.includes("application/json");
  const body = isJson ? await response.json() : await response.text();

  if (!response.ok) {
    const message = (isJson && body?.message) || response.statusText;
    throw new Error(message);
  }

  return body;
}

export default {
  get(url) {
    return fetch(url, {
      method: "GET",
      headers: jsonHeaders,
      credentials: "same-origin",
    }).then(parse);
  },

  // Posts multipart/form-data — the browser sets the Content-Type/boundary.
  upload(url, formData) {
    return fetch(url, {
      method: "POST",
      headers: { Accept: "application/json", "X-CSRF-TOKEN": csrfToken },
      body: formData,
      credentials: "same-origin",
    }).then(parse);
  },

  delete(url) {
    return fetch(url, {
      method: "DELETE",
      headers: jsonHeaders,
      credentials: "same-origin",
    }).then(parse);
  },
};
