<?php

/**
 * Plugin Name: Lazy Load Sections
 * Plugin URI: https://github.com/jpjuliao/lazy-load-sections
 * Description: Lazy loads sections on your WordPress site, but only if Javascript is enabled.
 * Version: 1.0.0
 * Author: Juan Pablo Juliao
 * Author URI: https://jpjuliao.github.io/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: lazy-load-sections
 */

// Check if Javascript is enabled before adding scripts and styles
if (function_exists('wp_script_is')) {
  if (wp_script_is('jquery')) { // Ensure jQuery is loaded

    /**
     * Adds JavaScript to remove the 'lazy-load-on' class from an element when it appears on the screen.
     */
    function lazy_load_section_script()
    {
?>
      <script type="text/javascript" id="lazy-load-section-script">
        jQuery(function($) {
          /**
           * Removes the specified class from the element when it appears on the screen.
           * @param {string} className - The class name to remove from the element.
           */
          function removeClassOnScroll(className) {
            $(window).scroll(function() {
              // Get the top and bottom positions of the viewport
              var windowHeight = $(window).height();
              var windowTopPosition = $(window).scrollTop();
              var windowBottomPosition = (windowTopPosition + windowHeight);

              // Get the top and bottom positions of the element
              var elementOffset = $('.' + className).offset();
              if (typeof elementOffset === 'undefined') return;

              var elementTopPosition = elementOffset.top;
              var elementBottomPosition = (elementTopPosition + $('.' + className).outerHeight());

              // Check if the element is within the viewport
              if ((elementBottomPosition >= windowTopPosition) && (elementTopPosition <= windowBottomPosition)) {
                // Remove the class when it appears on the screen
                $('.' + className).removeClass(className);
              }
            });
          }

          // Call the function with the class name to be removed on scroll
          $(document).ready(function() {
            removeClassOnScroll('lazy-load-on');
          });
        });
      </script>
  <?php
    }

    // Add the lazy_load_section_script function to the footer of the WordPress site
    add_action('wp_footer', 'lazy_load_section_script');
  }
}

/**
 * Adds CSS to hide elements with class 'lazy-load-on'.
 */
function lazy_load_section_style()
{
  ?>
  <style id="lazy-load-section-style">
    .lazy-load-on {
      display: none;
    }
  </style>
<?php
}

// Add the lazy_load_section_style function to the head of the WordPress site
add_action('wp_head', 'lazy_load_section_style');
