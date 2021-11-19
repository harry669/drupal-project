(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.MyModuleBehavior = {
    attach: function (context, settings) {
      // get color_body value with "drupalSettings.mymodule.color_body"
      var color_body = drupalSettings.mymodule.color_body;
      $('body').css('background', color_body);
    }
  };
})(jQuery, Drupal, drupalSettings);