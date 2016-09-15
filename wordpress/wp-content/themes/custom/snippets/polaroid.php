<?
/* 
 * $polaroid is a preset variable passed in from 
 * the calling function, eg. ckan-publisher-index
 * or ckan-topic-index.
 */
$subheader = sprintf( __('%d Datasets', 'sage'), $polaroid['package_count']) ;
if ($polaroid['package_count']==1) {
  $subheader = __('1 Dataset', 'sage');
}
?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
  <a class="polaroid" href="<?= $polaroid['href'] ?>">
    <div class="polaroid-image">
      <? if ( empty($polaroid['image_url']) ): ?>
        <div class="img-empty"><i class="icon-folder-open"></i></div>
      <? else: ?>
        <img src="<?= get_stylesheet_directory_uri()."/assets/images/".basename($polaroid['image_url']) ?>" alt="<?= $polaroid['title'] ?>"/>
      <? endif; ?>
    </div>
      <h4><?= $polaroid['title'] ?></h4>
      <small><?= $subheader ?></small>
  </a>
</div>
