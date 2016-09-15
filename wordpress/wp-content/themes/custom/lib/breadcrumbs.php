<?
NameSpace DataPress\Breadcrumbs;

function get_breadcrumbs() {
  global $datapress;

  function archive_link() {
    $post_type = get_post_type();
    return [ "title" => $post_type ];
    if ($post_type=="post") {
      $blog_id = get_option("page_for_posts");
      return [ "title" => get_the_title($blog_id), "url" => get_permalink($blog_id) ];
    }
    $post_type_obj = get_post_type_object($post_type);
    return [ "title" => $post_type_obj->labels->name, "url" => $archive_link ];
  }

  function parent_post() {
    $post_type = get_post_type();
    if ($post_type=="post") {
      $blog_id = get_option("page_for_posts");
      return [ "title" => get_the_title($blog_id), "url" => get_permalink($blog_id) ];
    }
    $post_type_obj = get_post_type_object($post_type);
    $archive_link = get_post_type_archive_link($post_type);
    return [ "title" => $post_type_obj->labels->name, "url" => $archive_link ];
  }

  if (is_front_page()) { 
    if ( defined("FRONT_PAGE_BREADCRUMBS") && FRONT_PAGE_BREADCRUMBS ) {
      return [["title"=>FRONT_PAGE_BREADCRUMBS]];
    }
    return [];
  }
  if (is_home()) { 
    return [ parent_post() ];
  }
  if ( is_post_type_archive() ) {
    $post_type = get_post_type();
    $post_type_obj = get_post_type_object($post_type);
    $archive_link = get_post_type_archive_link($post_type);
    return [ [ "title" => $post_type_obj->labels->name, "url" => $archive_link ] ];
  }
  if (is_single()) {
    return [ parent_post(), [ "title" => get_the_title() ] ];
  }
  if (is_category()) {
    return [ parent_post(), [ "title" => single_cat_title("Category: ",false) ] ];
  }
  if (is_page()) {
    $out = [];
    foreach (array_reverse(get_post_ancestors(get_the_id())) as $id) {
      $out[] = [ "title" => get_the_title($id), "url" => get_permalink($id) ];
    }
    $out[] = [ 'title' => get_the_title() ];
    return $out;
  }
  if (is_tag()) {
    return [ parent_post(), [ "title" => single_tag_title("Tag: ",false) ] ];
  } 
  if (is_day()) {
    return [ parent_post(), [ "title" => "Archive for: ".get_the_time('F jS, Y') ] ];
  } 
  if (is_month()) {
    return [ parent_post(), [ "title" => "Archive for: ".get_the_time('F, Y') ] ];
  } 
  if (is_year()) {
    return [ parent_post(), [ "title" => "Archive for: ".get_the_time('Y') ] ];
  }
  if (is_author()) {
    return [ parent_post(), [ "title" => "Author Archives" ] ];
  }
  if (isset($_GET['paged']) && !empty($_GET['paged'])) {
    return [ parent_post(), [ "title" => "Archives" ] ];
  }
  if (is_search()) {
    return [ parent_post(), [ "title" => "Search Results" ] ];
  }
}
