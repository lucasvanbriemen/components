@props([
  'title' => $request->input('title', 'Modal Title'),
  'content' => $request->input('content', 'Modal content goes here.'),
  'showCloseButton' => $request->input('showCloseButton', true),
  'id' => $request->input('id', 'modal_' . uniqid()),
  'backdropClass' => $request->input('backdropClass', null),
  'modalClass' => $request->input('modalClass', null),
  'modalOptions' => request()->input('modalOptions', []),
])

@vite('resources/scss/modal.scss')

@php
  $modalAttributes = collect($modalOptions)
    ->map(fn($v, $k) => $k.'="'.e($v).'"')
    ->implode(' ');
@endphp

<div class="modal-backdrop {{ $backdropClass }}" id="{{ $id }}-backdrop" data-modal-id="{{ $id }}">
  <div class="modal-container {{ $modalClass }}" {!! $modalAttributes !!}>
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


<script>
  alert('test')

  let Modal = {
    CONTAINER_SELECTOR: ".modal-container",
    CLOSE_BUTTON_SELECTOR: ".close-button",
    OPEN_CLASS: "modal-open",

    init: function () {
      $(Modal.CONTAINER_SELECTOR).on("click", function (event) {
        if (event.target === this) {
          Modal.close(this.closest(Modal.CONTAINER_SELECTOR));
        }
      });

      $(Modal.CLOSE_BUTTON_SELECTOR).on("click", function () {
        Modal.close(this.closest(Modal.CONTAINER_SELECTOR));
      });
    },

    open: function (selector) {
      $(selector).addClass(Modal.OPEN_CLASS);

      const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
      if (scrollbarWidth > 0) {
        $("html").css("padding-right", scrollbarWidth + "px");
        $("body").css("overflow", "hidden");
      }
    },

    close: function (selector) {
      $(selector).removeClass(Modal.OPEN_CLASS);

      $("html").css("padding-right", "");
      $("body").css("overflow", "");
    }
  };
</script>