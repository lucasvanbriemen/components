<script>
  import api from '../lib/api.js';

  let files = $state([]);
  let loading = $state(true);
  let error = $state('');
  let uploading = $state(false);
  let dragging = $state(false);
  let fileInput;

  async function loadFiles() {
    loading = true;
    error = '';
    try {
      const data = await api.get('/api/files');
      files = data.files ?? [];
    } catch (e) {
      error = e.message || 'Could not load files.';
    } finally {
      loading = false;
    }
  }

  async function uploadFiles(fileList) {
    const list = Array.from(fileList ?? []);
    if (list.length === 0) return;

    uploading = true;
    error = '';
    const form = new FormData();
    for (const file of list) {
      form.append('files[]', file, file.name);
    }

    try {
      await api.upload('/api/files', form);
      await loadFiles();
    } catch (e) {
      error = e.message === 'Unauthenticated.'
        ? 'You need to be logged in to upload files.'
        : (e.message || 'Upload failed.');
    } finally {
      uploading = false;
      if (fileInput) fileInput.value = '';
    }
  }

  async function replaceFile(file, fileList) {
    const next = fileList?.[0];
    if (!next) return;

    error = '';
    const form = new FormData();
    form.append('file', next, next.name);

    try {
      await api.upload(`/api/files/${file.path}`, form);
      await loadFiles();
    } catch (e) {
      error = e.message === 'Unauthenticated.'
        ? 'You need to be logged in to update files.'
        : (e.message || 'Update failed.');
    }
  }

  function onDrop(event) {
    event.preventDefault();
    dragging = false;
    uploadFiles(event.dataTransfer?.files);
  }

  function formatSize(bytes) {
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
  }

  function isImage(type) {
    return type?.startsWith('image/');
  }

  loadFiles();
</script>

<div class="file-manager">
  <div
    class="dropzone"
    class:dragging
    role="button"
    tabindex="0"
    ondragover={(e) => { e.preventDefault(); dragging = true; }}
    ondragleave={() => (dragging = false)}
    ondrop={onDrop}
    onclick={() => fileInput.click()}
    onkeydown={(e) => (e.key === 'Enter' || e.key === ' ') && fileInput.click()}
  >
    <input
      type="file"
      multiple
      bind:this={fileInput}
      onchange={(e) => uploadFiles(e.currentTarget.files)}
      hidden
    />
    <p class="dropzone-title">
      {uploading ? 'Uploading…' : 'Drop files here or click to upload'}
    </p>
    <p class="dropzone-hint">Up to 50 MB per file</p>
  </div>

  {#if error}
    <p class="error">{error}</p>
  {/if}

  {#if loading}
    <p class="status">Loading files…</p>
  {:else if files.length === 0}
    <p class="status">No files yet.</p>
  {:else}
    <ul class="file-list">
      {#each files as file (file.path)}
        <li class="file-row">
          <div class="thumb">
            {#if isImage(file.type)}
              <img src={file.url} alt={file.name} />
            {:else}
              <span class="thumb-ext">{(file.name.split('.').pop() || '?').toUpperCase()}</span>
            {/if}
          </div>
          <div class="file-meta">
            <a class="file-name" href={file.url} target="_blank" rel="noopener">{file.name}</a>
            <span class="file-sub">{file.type} · {formatSize(file.size)}</span>
          </div>
          <div class="file-actions">
            <a class="btn" href={`${file.url}?download`}>Download</a>
            <label class="btn">
              Replace
              <input
                type="file"
                onchange={(e) => replaceFile(file, e.currentTarget.files)}
                hidden
              />
            </label>
          </div>
        </li>
      {/each}
    </ul>
  {/if}
</div>

<style lang="scss">
  .file-manager {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .dropzone {
    border: 2px dashed var(--border-color, #ccc);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    background-color: var(--background-color-one, #fff);
    transition: border-color 0.2s ease, background-color 0.2s ease;

    &:hover,
    &.dragging {
      border-color: var(--primary-color, #007BFF);
      background-color: color-mix(in srgb, var(--primary-color, #007BFF) 6%, transparent);
    }
  }

  .dropzone-title {
    font-weight: 600;
    color: var(--text-color, #000);
  }

  .dropzone-hint {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.25rem;
  }

  .error {
    color: #dc2626;
    font-size: 0.9rem;
  }

  .status {
    color: #6b7280;
  }

  .file-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .file-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    border: 1px solid var(--border-color, #ccc);
    border-radius: 0.75rem;
    background-color: var(--background-color-one, #fff);
  }

  .thumb {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 0.5rem;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f3f4f6;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  .thumb-ext {
    font-size: 0.7rem;
    font-weight: 700;
    color: #6b7280;
  }

  .file-meta {
    display: flex;
    flex-direction: column;
    min-width: 0;
    flex: 1;
  }

  .file-name {
    font-weight: 600;
    color: var(--text-color, #000);
    text-decoration: none;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    &:hover {
      text-decoration: underline;
    }
  }

  .file-sub {
    font-size: 0.8rem;
    color: #6b7280;
  }

  .file-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  .btn {
    font-size: 0.85rem;
    padding: 0.4rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border-color, #ccc);
    background-color: var(--background-color-one, #fff);
    color: var(--text-color, #000);
    cursor: pointer;
    text-decoration: none;

    &:hover {
      border-color: var(--primary-color, #007BFF);
    }
  }
</style>
