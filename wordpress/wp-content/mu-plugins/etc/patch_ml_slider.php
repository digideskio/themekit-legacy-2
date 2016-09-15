<?
/** 
 * Fix ML-Slider to work with AWS & CloudFront.
 * Source: https://gist.github.com/tomhemsley/c05c662af05c5015ce12
 * Source source: https://wordpress.org/support/topic/images-do-not-show-up-in-meta-slider-when-i-use-cloudfront-and-s3-plugin
 *
 * === 
 *
 * Use wp_get_attachment_url to retrieve the attachment URL
 *
 * Important: Resized images created by Meta Slider are not uploaded to s3.
 * Important: Disable cropping in the slideshow settings to stop Meta Slider from outputting a URL to a file that doesn't exist on S3.
 */
function metaslider_s3_cloudfront_url($local_url, $attachment_id) {
	return wp_get_attachment_url($attachment_id);
}
add_filter('metaslider_attachment_url', 'metaslider_s3_cloudfront_url', 10, 2);
