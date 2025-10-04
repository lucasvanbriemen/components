@props([
  'type' => $request->input('type', 'text'),
  'label' => $request->input('label', 'Input Label'),
  'placeholder' => $request->input('placeholder', ' '),
  'value' => $request->input('value', ''),
  'name' => $request->input('name', 'input_name'),
  'id' => $request->input('id', 'input_id'),
  'class' => $request->input('class', null),
  'wrapperOptions' => request()->input('wrapperOptions', []),
  'inputOptions' => request()->input('inputOptions', []),
])

@php
  $wrapperAttributes = collect($wrapperOptions)
      ->map(fn($v, $k) => $k.'="'.e($v).'"')
      ->implode(' ');

  $inputAttributes = collect($inputOptions)
      ->map(fn($v, $k) => $k.'="'.e($v).'"')
      ->implode(' ');
@endphp

<div {!! $wrapperAttributes !!} class="input-wrapper text-input">
  <input 
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ $value }}"
    class="{{ $class }} input-text"
    placeholder="{{ $placeholder }}"
    {!! $inputAttributes !!}
  >
  <label for="{{ $id }}" class="input-label">
    {{ $label ?? ucfirst($name) }}
  </label>
</div>

@vite('resources/scss/input.scss')
