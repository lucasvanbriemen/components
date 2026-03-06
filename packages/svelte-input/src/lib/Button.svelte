<script>
  /**
   * @type {{
   *   type?: string,
   *   variant?: string,
   *   class?: string,
   *   [key: string]: any
   * }}
   */
  let {
    type = 'button',
    variant = 'call-to-action',
    class: className = '',
    children,
    ...rest
  } = $props();
</script>

<div class="input-wrapper button-input">
  <button
    {type}
    class="{variant} {className}"
    {...rest}
  >
    {@render children()}
  </button>
</div>

<style lang="scss">
  .input-wrapper.button-input {
    position: relative;
    margin-top: 1rem;

    button {
      width: 50%;
      padding: 0.5rem 1rem;
      border-radius: 1rem;
      border: none;
      font-weight: bold;
      cursor: pointer;

      &.call-to-action {
        background-color: var(--primary-color, #6366f1);
        color: var(--text-color, #000);

        &:hover {
          background-color: var(--primary-color-dark, #4f46e5);
        }
      }
    }
  }
</style>
