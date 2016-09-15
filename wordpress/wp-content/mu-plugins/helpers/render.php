<?
function render_pagination( $total, $offset, $per_page ) {

  if ($total < $per_page) {
    return;
  }
  $page_num = floor($offset / $per_page) + 1;
  $page_max = ceil($total / $per_page);
  function li_class($target,$page_num,$page_max) {
    if ($target==$page_num) { return "active"; }
    if ($target<1) { return "disabled"; }
    if ($target>$page_max) { return "disabled"; }
    return "";
  }
  function li_href($target,$page_max) {
    if ($target<1) { return "#"; }
    if ($target>$page_max) { return "#"; }
    return querystring_link("page",$target,true);
  }
  ?>
  <nav class="text-center">
    <ul class="pagination">
      <li class="<?= $page_num<=1? "disabled": ""?>">
        <a <?= $page_num<=1? "" : "href=\"".querystring_link("page",$page_num-1)."\""; ?>>
          &laquo;
        </a>
      </li>
      <? for ($p=1; $p<=$page_max; $p++): ?>
        <li class="<?= $p==$page_num?"active":"" ?>">
          <a href="<?= querystring_link("page",$p); ?>">
            <?= $p ?>
          </a>
        </li>
        <?  if ($p==1 && $page_num>5) {
                echo "<li><a>...</a></li>";
                $p = $page_num-3;
            }
            else if ( $p==$page_num+2 && $page_num<$page_max-4 ) {
                echo "<li><a>...</a></li>";
                $p = $page_max-1;
            } ?>
      <? endfor; ?>
      <li class="<?= $page_num>=$page_max? "disabled": ""?>">
        <a <?= $page_num>=$page_max? "" : "href=\"".querystring_link("page",$page_num+1)."\""; ?>>
          &raquo;
        </a>
      </li>
    </ul>
  </nav>
  <?
}

function render_follow_button($obj_type,$obj_id) {
  global $datapress;

  if ( $datapress['me']['logged_in'] ) {
    $followed_objects = $datapress['me']['following'][$obj_type];
    $following = array_key_exists( $obj_id, $followed_objects );
    if ( $following ) {
      echo '<a href="'. site_url("{$obj_type}/unfollow/{$obj_id}") .'?'.http_build_query($_GET).'" class="btn btn-info btn-sm dp-follow dp-followed">
          <span class="favourite"><i class="icon-check"></i>&nbsp; Bookmark</span>
          <span class="unfavourite"><i class="icon-check-empty"></i>&nbsp; Remove&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>';
    }
    else {
      echo '<a href="'. site_url("/{$obj_type}/follow/{$obj_id}") .'?'.http_build_query($_GET).'" class="btn btn-info btn-sm dp-follow">
          <i class="icon-plus-sign"></i>&nbsp;
          Bookmark
      </a>';
    }
  }
  else {
    echo '<a href="/login?redirect_to='. site_url("/{$obj_type}/follow/{$obj_id}") .'" class="btn btn-info btn-sm dp-follow">
        <i class="icon-plus-sign"></i>&nbsp;
        Bookmark
    </a>';
  }
}
