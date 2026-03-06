<script>
  /**
   * @type {{
   *   type?: string,
   *   label?: string,
   *   placeholder?: string,
   *   value?: string,
   *   name?: string,
   *   id?: string,
   *   class?: string,
   *   [key: string]: any
   * }}
   */
  let {
    type = 'text',
    label = 'Input Label',
    placeholder = ' ',
    value = $bindable(''),
    name = '',
    id = '',
    class: className = '',
    ...rest
  } = $props();

  const textTypes = ['text', 'email', 'password', 'search', 'tel', 'url'];
</script>

{#if type === 'textarea'}
  <div class="input-wrapper text-input">
    <textarea
      {name}
      {id}
      class="{className} input-textarea"
      {placeholder}
      bind:value
      {...rest}
    ></textarea>
    <label for={id} class="input-label">
      {label}
    </label>
  </div>
{:else if textTypes.includes(type)}
  <div class="input-wrapper text-input">
    <input
      {type}
      {name}
      {id}
      class="{className} input-text"
      {placeholder}
      bind:value
      {...rest}
    >
    <label for={id} class="input-label">
      {label}
    </label>
  </div>
{/if}

<style lang="scss">
  .input-wrapper {
    position: relative;
    margin-top: 1rem;

    &.text-input {
      input, textarea {
        width: 100%;
        padding:1rem;
        border-radius: 1rem;
        border: 1px solid var(--border-color, #ccc);
        background-color: var(--background-color-one, #fff);
        color: var(--text-color, #000);
      }

      label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        pointer-events: none;
        background-color: var(--background-color-one, #fff);
        color: var(--text-color, #000);
        border: none;
        transition: all 0.3s ease;
      }

      input:focus + label,
      input:not(:placeholder-shown) + label,
      textarea:focus + label,
      textarea:not(:placeholder-shown) + label {
        top: 2px;
        font-size: 0.75rem;
        background-color: var(--background-color-one, #fff);
        color: var(--text-color, #000);
        padding: 0 0.5rem;
      }

      input:focus, textarea:focus {
        outline: none;
        border: 2px solid var(--primary-color, #007BFF);
        padding: calc(1rem - 1px);
      }
    }
  }
</style>
