/**
 * @file
 * Contains Javascript for attaching assets module.
 */

(function ($) {
  "use strict";

  /**
   * Set a background color for paragraph custom static block.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach.
   *   Attaches the behavior for list of items.
   */
  Drupal.behaviors.assetsTestList = {
    attach: function(context, settings) {
      // Get the background color to be set for paragraph of custom static block.
      var bg_color = settings.card9_attaching_assets.custom.bg_color;

      // Check if the setting exists for background color.
      if (bg_color) {
        $('p').css('background', bg_color);
      }
    }
  };
})(jQuery);