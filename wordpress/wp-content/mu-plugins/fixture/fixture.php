<?
class Fixture {

  public static function init() {
    if (is_admin()) {
      return;
    }

    global $datapress;
    // Bare request path
    $url_path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    /*
     * Routed path: [ 
     *   "filename" => ...,
     *   "title"    => ...,
     *   "template" => ...,
     * ]
     */
    $route = self::lookup($url_path);
    // Map the filename to a file in the json/ folder
    $filename = $route['filename']; 
    $mode = current_user_can( 'manage_options' ) ? "admin" : "public";
    $filepath = dirname(__FILE__)."/json/$mode/$filename.json";
    // Load the cached $datapress variable from disk
    $raw_json = file_get_contents($filepath);
    $datapress = json_decode($raw_json,true);

    if (array_key_exists('raw', $route) && $route['raw']) { 
      header('Content-Type: application/json');
      echo json_encode($datapress);
      die();
    }

    // echo "<pre>";
    // echo "<strong>$url_path</strong><br/>";
    // echo "<strong>$filepath</strong><br/>";
    // print_r($datapress['payload']);
    // echo "</pre>";

    // if ( ! empty($route['title']) ) {
    //   $datapress['page_title'] = $route['title'];
    //   add_filter('wp_title'         , [__CLASS__ , 'hook_ckan_title']       );
    // }

    // ==> Handle custom template redirect
    if ( ! empty($route['template']) ) {
      $template = $route['template'];
      $datapress['template_name'] = $template;
      // $datapress['template_vars'] = $template_vars;
      $datapress['template_path'] = get_template_directory()."/$template.php";
      if ( ! file_exists($datapress['template_path']) ) {
        throw new Exception("Could not find template: ".$datapress['template_path']);
      }
      if ( isset($breadcrumbs) ) {
        if (is_callable($breadcrumbs)) {
          $breadcrumbs = $breadcrumbs($datapress);
        }
        $datapress['breadcrumbs'] = $breadcrumbs;
      }
      else if (isset($title)) {
        $datapress['breadcrumbs'] = [ [ "title" => $title ] ];
      }
      else {
        $datapress['breadcrumbs'] = [ [ "title" => $template ] ];
      }
      add_action('template_redirect', [__CLASS__ , 'hook_http_header'] );
      add_filter('template_include' , [__CLASS__ , 'hook_ckan_template'] );
      add_filter('body_class'       , [__CLASS__ , 'hook_ckan_body_class']  );
      add_filter('nav_menu_css_class' , [__CLASS__ , 'hook_ckan_nav_highlighting'], 10, 2 );
    }
  }

  private static function lookup($url_path) {
    if ( preg_match("/^\/$/", $url_path) ) {
      return [ "filename" => "latest" ];
    }
    if ( preg_match("/^\/user(\/?)$/", $url_path) ) {
      return [ "filename" => "profile", "template" => "ckan-user-read" ];
    }
    if ( preg_match("/^\/publisher(\/?)$/", $url_path) ) {
      return [ "filename" => "publishers", "template" => "ckan-publisher-index" ];
    }
    if ( preg_match("/^\/topic(\/?)$/", $url_path) ) {
      return [ "filename" => "topics", "template" => "ckan-topic-index" ];
    }
    if ( preg_match("/^\/topic\/[^\/]+(\/?)$/", $url_path) ) {
      return [ "filename" => "topic_read", "template" => "ckan-search" ];
    }
    if ( preg_match("/^\/publisher\/[^\/]+(\/?)$/", $url_path) ) {
      return [ "filename" => "publisher_read", "template" => "ckan-search" ];
    }
    if ( preg_match("/^\/dataset\/[^\/]+(\/?)$/", $url_path) ) {
      return [ "filename" => "dataset_read", "template" => "ckan-dataset-read" ];
    }
    if ( preg_match("/^\/dataset\/activity\/[^\/]+(\/?)$/", $url_path) ) {
      return [ "filename" => "dataset_activity", "template" => "ckan-activity" ];
    }
    if ( preg_match("/^\/dataset(\/?)$/", $url_path) ) {
      if (strlen($_SERVER['QUERY_STRING']) > 0) {
        return [ "filename" => "datasets2", "template" => "ckan-search" ];
      }
      return [ "filename" => "datasets", "template" => "ckan-search" ];
    }
    if ( preg_match("/^\/dataset\/[^\/]+(\/?)$/", $url_path) ) {
      return [ "filename" => "dataset_read", "template" => "ckan-dataset-read" ];
    }
    if ( preg_match("/^\/dataset\/[^\/]+\/resource/", $url_path) ) {
      return [ "filename" => "resource_read", "template" => "ckan-dataset-resource-read" ];
    }
    if ( preg_match("/^\/api\/action\/package_search(\/?)$/", $url_path) ) {
      return [ "filename" => "api_package_search", "raw" => true ];
    }
    return [ "filename" => "_background" ];
  }


  public static function hook_ckan_title($title) {
    global $datapress;
    return $datapress['page_title'] . ' | ' . $title;
  }


  public static function hook_ckan_body_class($classes) {
    global $datapress;
    $classes[] = "ckan";
    if(array_key_exists('template_name', $datapress)) {
      $classes[] = "ckan_".$datapress['template_name'];
    }
    return $classes;
  }

  public static function hook_ckan_template() {
    global $datapress;
    if(array_key_exists('template_path', $datapress)) {
      return $datapress['template_path'];
    }
    return null;
  }

  public static function hook_http_header() {
    global $datapress;
    global $wp_query;
    $code = isset($datapress['http_code']) ? $datapress['http_code'] : 200;
    if ($code != 404) {
      $wp_query->is_404 = false;
    }
    status_header($code);
  }

  public static function hook_ckan_nav_highlighting($classes,$item) {
    // Remove existing classes
    if(($key = array_search("current_page_parent", $classes)) !== false) {
      unset($classes[$key]);
    }
    if(($key = array_search("current_page", $classes)) !== false) {
      unset($classes[$key]);
    }
    // String matching based on URL
    $my_url = rtrim( parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH), "/");
    $the_url = rtrim( parse_url($item->url,PHP_URL_PATH), "/");
    if ($my_url==$the_url) {
      $classes[] = "current_page";
    }
    else if (strlen($the_url) && strpos($my_url,$the_url)===0) {
      $classes[] = "current_page_parent";
    }
    return $classes;
  }
}

add_action( 'init', ['Fixture','init' ] );
