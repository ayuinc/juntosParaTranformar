(function() {
  'use-strict';
  $(document).ready(function() {
    $('.disable-anchors a').click(function(e) {
      e.preventDefault();
    });
    $('[data-href]').click(function(e) {
      var lastPath, locationArr, mainPath, pathObj;
      locationArr = window.location.pathname.split('/');
      lastPath = locationArr[locationArr.length - 1];
      mainPath = locationArr[locationArr.length - 2];
      pathObj = {};
      pathObj[mainPath] = lastPath;
      window.history.pushState(pathObj, '', lastPath);
      document.location.replace($(this).data('href'));
    });
    transformicons.add('.tcon');
  });

}).call(this);

(function() {
  'use-strict';
  $(document).ready(function() {
    var parallaxController, parallaxScene, tween;
    parallaxController = new ScrollMagic();
    tween = TweenMax.fromTo(".on-scroll", 1, {
      bottom: 0,
      opacity: 1
    }, {
      bottom: -98,
      opacity: 0.3
    }, {
      ease: Linear.easeNone
    });
    parallaxScene = new ScrollScene({
      triggerElement: '.site-content',
      triggerHook: 'onEnter',
      duration: 300
    }).setTween(tween).addTo(parallaxController);
  });

}).call(this);

(function() {
  'use-strict';
  $(document).ready(function() {
    var scrollToController;
    scrollToController = new ScrollMagic();
    scrollToController.scrollTo(function(newpos) {
      TweenMax.to(window, 0.5, {
        scrollTo: {
          y: newpos
        }
      });
    });
    $(document).on('click', 'a[href^=#]', function(e) {
      var id;
      id = $(this).attr('href');
      if ($(id).length > 0 && !id.match(/nav/g) && !id.match(/carousel/g)) {
        e.preventDefault();
        scrollToController.scrollTo(id);
      }
    });
  });

}).call(this);
