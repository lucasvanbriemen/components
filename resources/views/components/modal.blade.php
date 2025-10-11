@props([
  'title' => $request->input('title', 'Modal Title'),
  'content' => $request->input('content', 'Modal content goes here.'),
  'showCloseButton' => $request->input('showCloseButton', true),
  'size' => $request->input('size', 'medium'),
  'id' => $request->input('id', 'modal_' . uniqid()),
  'backdropClass' => $request->input('backdropClass', null),
  'modalClass' => $request->input('modalClass', null),
  'modalOptions' => request()->input('modalOptions', []),
])

@php
  $modalAttributes = collect($modalOptions)
    ->map(fn($v, $k) => $k.'="'.e($v).'"')
    ->implode(' ');
@endphp

<div class="modal-backdrop {{ $backdropClass }}" id="{{ $id }}-backdrop" data-modal-id="{{ $id }}">
  <div class="modal-container modal-{{ $size }} {{ $modalClass }}" {!! $modalAttributes !!}>
    <div class="modal-header">
      <h3 class="modal-title">{{ $title }}</h3>
      @if($showCloseButton)
      <button class="modal-close" data-close-modal="{{ $id }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
      @endif
    </div>
    <div class="modal-body">
      {!! $content !!}
    </div>
  </div>
</div>

@vite('resources/scss/modal.scss')
