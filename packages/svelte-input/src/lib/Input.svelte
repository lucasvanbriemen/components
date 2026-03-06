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
{:else if type === 'checkbox'}
  <div class="input-wrapper checkbox-input">
    <input
      type="checkbox"
      {name}
      {id}
      bind:checked={value}
      {...rest}
    >
    <span class="checkmark"></span>
    <label for={id}>
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
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        border: 1px solid var(--border-color, #ccc);
        background-color: var(--background-color-one, #fff);
        color: var(--text-color, #000);
      }

      input:-webkit-autofill, textarea:-webkit-autofill {
        box-shadow: 0 0 0px 1000px var(--background-color-one, #fff) inset !important;
        -webkit-text-fill-color: var(--text-color, #000) !important;
      }

      label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        pointer-events: none;
        background-color: transparent;
        color: var(--text-color, #000);
        border: none;
        transition: all 0.2s ease;
      }

      input:focus + label,
      input:not(:placeholder-shown) + label,
      textarea:focus + label,
      textarea:not(:placeholder-shown) + label {
        top: 0;
        font-size: 0.75rem;
        background-color: var(--background-color-one, #fff);
        border: 1px solid var(--primary-color, #6366f1);
        color: var(--text-color, #000);
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
      }
    }

    &.checkbox-input {
      display: flex;
      align-items: center;
      gap: 0.5rem;

      input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
      }

      label {
        cursor: pointer;
        color: var(--text-color, #000);
        user-select: none;
      }

      .checkmark {
        width: 1.5rem;
        height: 1.5rem;
        background-color: var(--background-color-one, #fff);
        border-radius: 0.5rem;
        border: 1px solid var(--border-color, #ccc);
        display: inline-block;
        position: relative;
        cursor: pointer;
        flex-shrink: 0;

        &::after {
          position: absolute;
          left: 8px;
          top: 3px;
          width: 7px;
          height: 14px;
          border: solid white;
          border-width: 0 2px 2px 0;
          transform: rotate(45deg);
          content: "";
          display: none;
        }
      }

      input:checked + .checkmark {
        background-color: var(--primary-color, #6366f1);

        &::after {
          display: block;
        }
      }
    }
  }
</style>
