function showToast(message, type) {
    const $toast = $('.toast');
    if ($toast.length === 0) return;

    // Reset classes and content
    $toast.stop(true, true);
    $toast.removeClass('bg-success bg-danger text-white show');
    $toast.html('');

    // Apply type styling
    if (type === 'error') {
      $toast.addClass('bg-danger text-white');
    } else {
      $toast.addClass('bg-success text-white');
    }

    $toast.text(message);
    // Show
    $toast.addClass('show');

    // Auto-hide after 3s
    setTimeout(() => {
      $toast.removeClass('show');
      setTimeout(() => $toast.html(''), 300);
    }, 3000);
  }