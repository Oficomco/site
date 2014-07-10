(function($) {
  // Global vars
  var $header = $('.header-container'),
      header_pinned = 'header-pinned';

  $(document).ready(function() {
    bindEvents();
  });

  function bindEvents() {
    $('.jsCloseModal').on('click', closeModal);
    $('.jsOpenModal').on('click', openModal);
    $('.jsScrollTo').on('click', onScrollTo);
    $('.jsOpenMenu').on('click', openSideMenu);
    $('.jsCloseMenu').on('click', closeSideMenu);
    $('input, textarea').on('focus', addFocus);
    $('input, textarea').on('blur', removeFocus);

    $(window).on('scroll', function() {
      var pos = $(this).scrollTop();

      pinHeader(pos);
      easyParallax(pos);
    });
  };
  
  function openModal(e) {
    e.preventDefault();

    $('.modal-container').show();
    scrollToElement('#top');
  };

  function closeModal(e) {
    e.preventDefault();
    
    $('.modal-container').hide();
  };

  function onScrollTo(e) {
    e.preventDefault();

    var target = $(this).attr('href');
    scrollToElement(target);

  }
  function scrollToElement(target) {
    
    var topoffset = 90,
        speed = 600,
        destination = $( target ).offset().top - topoffset;

    $( 'html:not(:animated),body:not(:animated)' ).animate( { scrollTop: destination}, speed);
  };

  function pinHeader(pos) {
    if ( pos > 580 ) {
      if ( !$header.hasClass(header_pinned) ) {
        $header.addClass(header_pinned);
        toggleHeaderCTA(true);
      }
    } else {
      $header.removeClass(header_pinned);
      toggleHeaderCTA(false);
    }
  };

  function easyParallax(pos) {
    if ( pos < 590 ) {
      $('.hero-section').css({backgroundPosition: "0 -"+ (pos/2) +"px"})
    }
  };

  function toggleHeaderCTA(bool) {
    if (bool) {
      $('.jsToggleCTA').addClass('btn btn-primary');
    } else {
      $('.jsToggleCTA').removeClass('btn btn-primary');
    }
  };

  function openSideMenu(e) {
    e.preventDefault();
    e.stopPropagation();

    $('#site-container').addClass('side-menu-open');
    $('.slide-container').on('click', closeSideMenu);
  };

  function closeSideMenu(e) {
    e.preventDefault();

    $('#site-container').removeClass('side-menu-open');
    $('.slide-container').off('click');
  };

  function addFocus(e) {
    $(this).closest('.input-wrapper').addClass('on-focus');
  };

  function removeFocus(e) {
    $(this).closest('.input-wrapper').removeClass('on-focus');
  };


})(window.jQuery);
