<div class="input-wrapper text-input">
  <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" class="{{ $class ?? 'input-text' }}" placeholder="{{ $placeholder }}">
  <label for="{{ $id }}" class="input-label">
    {{ $label ?? ucfirst($name) }}
  </label>
</div>

@vite('resources/scss/input.scss')