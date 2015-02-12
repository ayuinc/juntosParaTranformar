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
    var $progressWizard, $stepActions, $stepCounters, $stepPanels;
    $progressWizard = $('#progress-wizard');
    $stepCounters = $('ul.step-counters', $progressWizard);
    $stepPanels = $('.step-panels', $progressWizard);
    $stepActions = $('.step-actions', $progressWizard);
    $stepCounters.on('click', 'li', function(e) {
      var stepRef;
      e.preventDefault();
      $stepCounters.find('li').removeClass('active');
      $(this).addClass('active');
      $stepPanels.find('.step-panel').removeClass('active');
      stepRef = $(this).data('panel-ref');
      $stepPanels.find('#' + stepRef).addClass('active');
    });
    $stepActions.on('click', '.next', function(e) {
      var stepRef;
      e.preventDefault();
      stepRef = $stepCounters.find('li.active').next().data('panel-ref');
      console.log($stepCounters.find('li[data-panel-ref="' + stepRef + '"]'));
      $stepCounters.find('li').removeClass('active');
      $stepCounters.find('li[data-panel-ref="' + stepRef + '"]').addClass('active');
      $stepPanels.find('.step-panel').removeClass('active');
      $stepPanels.find('#' + stepRef).addClass('active');
    });
    $stepActions.on('click', '.prev', function(e) {
      e.preventDefault();
    });
    $stepActions.on('click', '.finish', function(e) {
      e.preventDefault();
      $('.step-wizard-instructions').addClass('hidden');
      $stepCounters.addClass('hidden');
      $('.step-wizard-thanks').removeClass('hidden');
      $stepPanels.find('.step-panel').removeClass('active');
      $('#step-panel-last').addClass('active');
    });
  });

}).call(this);
