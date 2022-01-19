jQuery(document).ready(function ($) {
  $('#ot_logo_scroller_156 .the-carousel').carouFredSel({
    width: '100%',
    items: 3,
    scroll: 1,
    auto: {
      duration: 1000,
      timeoutDuration: 1000,
    },
    prev: '.the-prev',
    next: '.the-next',
  });
});
