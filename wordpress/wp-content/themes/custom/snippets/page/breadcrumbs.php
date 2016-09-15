<? 
use DataPress\Breadcrumbs as Breadcrumbs;

$breadcrumbs = Breadcrumbs\get_breadcrumbs();
$post_type = get_post_type();
$title = get_the_title();
$name = get_query_var('name');
if ( count($breadcrumbs) ): 
?>
  <div class="breadcrumbs">
    <ol class="breadcrumb">
      <div class="container">
        <li><a href="<?=get_option('home')?>"><i class="icon-home"></i></a></li>
        <?  foreach ($breadcrumbs as $crumb) {
          echo '<li>';
          if ( isset($crumb['url']) ) {
            echo '<a href="'.$crumb['url'].'">'.$crumb['title'].'</a>';
          }
          else {
            echo $crumb['title'];
          }
          echo '</li>';
        } ?>
      </div><!-- /container -->
    </ol>
  </div><!-- /breadcrumbs -->
<? endif; ?>
