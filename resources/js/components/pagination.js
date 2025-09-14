(function () {
  function initPagination(root) {
    if (!root) return;
    var prev = root.querySelector('.c-pagination__prev');
    var next = root.querySelector('.c-pagination__next');
    var pageButtons = Array.prototype.slice.call(
      root.querySelectorAll('.c-pagination__pages button')
    );

    function getActiveIndex() {
      return pageButtons.findIndex(function (btn) {
        return btn.classList.contains('is-active');
      });
    }

    function setActiveIndex(idx) {
      pageButtons.forEach(function (btn, i) {
        btn.classList.toggle('is-active', i === idx);
        btn.removeAttribute('aria-current');
      });
      if (idx >= 0 && idx < pageButtons.length) {
        pageButtons[idx].setAttribute('aria-current', 'page');
      }
      prev.disabled = idx <= 0;
      next.disabled = idx >= pageButtons.length - 1;
      var event = new CustomEvent('pagination:change', {
        bubbles: true,
        detail: {
          index: idx,
          page: idx >= 0 ? Number(pageButtons[idx].dataset.page) : null,
        },
      });
      root.dispatchEvent(event);
    }

    pageButtons.forEach(function (btn, i) {
      btn.addEventListener('click', function () {
        setActiveIndex(i);
      });
    });

    prev.addEventListener('click', function () {
      var idx = getActiveIndex();
      setActiveIndex(Math.max(0, idx - 1));
    });

    next.addEventListener('click', function () {
      var idx = getActiveIndex();
      setActiveIndex(Math.min(pageButtons.length - 1, idx + 1));
    });

    // Initialize state
    setActiveIndex(getActiveIndex());
  }

  // Auto-init for markup present on the page
  if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', function () {
      document
        .querySelectorAll('[data-component="pagination"]')
        .forEach(initPagination);
    });
  }

  // Expose for manual init if needed
  if (typeof window !== 'undefined') {
    window.PaginationComponent = { init: initPagination };
  }
})();

