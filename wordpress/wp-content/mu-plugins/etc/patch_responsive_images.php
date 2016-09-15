<?
/*
 * Disable WordPress 4.4 responsive image sets.
 * This does not play well with the Amazon offload-to-S3 mechanism.
 *
 * Discussion: 
 *   https://wordpress.org/support/topic/is-it-possible-to-disable-the-responsive-image-srcset-on-wordpress-44
 * Code from:
 *   https://github.com/josephfusco/disable-responsive-images/blob/master/disable-responsive-images.php
 */
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
