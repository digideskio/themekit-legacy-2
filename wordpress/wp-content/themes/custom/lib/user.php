<?
NameSpace DataPress\User;

/*
 * Returns TRUE if the backend failed to respond
 * or gave corrupt data. We don't know about the user's
 * bookmarks or permissions.
 */
function no_backend_available() {
  return isset($datapress['is_default']) && $datapress['is_default'];
}


/*
 * How many bookmarks in total does this user have?
 */
function count_bookmarks() {
  global $datapress; 
  return count(bookmarked_publishers())
    + count(bookmarked_users()) 
    + count(bookmarked_topics())
    + count(bookmarked_datasets());
}

function bookmarked_users() {
  global $datapress;
  return $datapress['me']['following']['user'];
}

function bookmarked_topics() {
  global $datapress;
  return $datapress['me']['following']['topic'];
}

function bookmarked_datasets() {
  global $datapress;
  return $datapress['me']['following']['dataset'];
}

/* 
 * Return just those publishers of which I am explicitly a member.
 * Sysadmin doesn't count.
 */
function bookmarked_publishers() {
  global $datapress;
  // Filter those publishers I am not _actually_ a member of
  $member_of = array_filter($datapress['me']['publishers'], function($pub) { 
    return isset($pub['capacity']); 
  });
  $skip_these = [];
  foreach ($member_of as $pub) { 
    $skip_these[] = $pub['name']; 
  }
  $bookmarked = []; 
  // Don't duplicate bookmarks
  foreach ($datapress['me']['following']['publisher'] as $pub) {
    if ( ! in_array($pub['name'],$skip_these) ) {
      $bookmarked[] = $pub;
    }
  }
  return $member_of + $bookmarked;
}


function content_types() {
  $out = [];
  foreach ( get_post_types(["show_ui"=>true], "objects") as $post_type ) {
    if ($post_type->name=="media") { continue; }
    if ($post_type->name=="attachment") { continue; }
    if ($post_type->name=="acf") { continue; }

    $out[] = $post_type;
  }
  return $out;
}

function create_new_links() {
  $out = [];
  foreach ( content_types() as $post_type ) {
    $icon = $post_type->menu_icon;
    if ($post_type->name=="post") { $icon = "dashicons-admin-post"; }
    if ($post_type->name=="page") { $icon = "dashicons-admin-page"; }

    $text = str_replace("Add New","Add a",$post_type->labels->add_new_item);
    // Oh jeez; "Add a Event"...
    if ( preg_match("/^Add a [aeiouAEIOU]/", $text) ) {
      $text = str_replace("Add a ","Add an ",$text);
    }

    $out[] = [
      "name" => $post_type->name,
      "text" => $text,
      "icon" => $icon,
    ];
  }
  return $out;
}

/*
 * If you can edit the current page, returns:
 * [ 
 *   "text" => "Edit this App" (or page, blog etc)
 *   "url" => ... link to the editor
 * ]
 */
function link_edit_this_page() {
  global $wp_the_query;
  $current_object = $wp_the_query->get_queried_object();
  if ( ! empty($current_object)
    //&& $current_object->post_type==$post_type->name
    && current_user_can( 'edit_post', $current_object->ID )
    && ( $post_type_object = get_post_type_object( $current_object->post_type ) )
    && $post_type_object->show_ui 
    && $post_type_object->show_in_admin_bar)
  {
    return [
      "url" => get_edit_post_link( $current_object->ID ),
      "text" => str_replace("Edit ","Edit This ",$post_type_object->labels->edit_item),
    ];
  } 
}


function can_add_dataset() {
  global $datapress;
  return $datapress['me']['caps']['dataset_create'];
}


function can_add_publisher() {
  global $datapress;
  return $datapress['me']['caps']['organization_create'];
}


function li_header($text){
  return "<li class=\"dropdown-header\">$text</li>";
}

function li($class, $href, $text, $icon="",$dropdown=""){
  if ($icon) {
    if ( substr($icon,0,8)=="dashicon" ) {
      $icon = "<div class=\"dashicons $icon\"></div>&nbsp; ";
    }
    else {
      $icon = "<i class=\"$icon\"></i>&nbsp; ";
    }
  }
  $link_attributes = "";
 if ($dropdown) {
    $class .= " dropdown";
    $text  .= " <b class=\"caret\"></b>";
    $link_attributes = "class=\"dropdown-toggle\" data-toggle=\"dropdown\" data-target=\"#\"";
    $dropdown = "<ul class=\"dropdown-menu\">$dropdown</ul>";
  }
  return "<li class=\"$class\"><a $link_attributes href=\"$href\">$icon$text</a>$dropdown</li>";
}










if ( ! function_exists("show_global_search") ) {
  // Override in functions.php if you're feeling bold
  function show_global_search() {
    return true;
  }
}

function get_search() {
  if ( ! show_global_search() ) { 
    return; 
  }
  $placeholder = "<div class=\"placeholder\">$placeholder</div>";
  return '
  <li class="hidden-xs" id="dp-global-search2">
    <form 
      role="search"
      action="/dataset">
        '.$placeholder.'
        <input 
          name="q" 
          tabindex="1" 
          data-widget="AutocompleteDataset" 
          type="text" 
          class="form-control" 
        />
      <div class="search-icon"><i class="icon-search"></i></div>
    </form>
  </li>';
}


/* 
 * Renders the links in the navbar menu
 */
function get_nav_options() {
  global $datapress;

  $hide = "";
  if (defined("DP_HIDE_NAV_ACTIONS") && DP_HIDE_NAV_ACTIONS) {
    $hide = "hidden visible-xs";
  }

  $login_class = is_user_logged_in()? "loggedin" : "unlogged";
  if ( ! is_user_logged_in() ) {
    return li("$hide actionbar menu-register","/register","Register")
      . li("$hide actionbar menu-login","/login","Login","icon-user")
      . get_search();
  }
  global $current_user;

  $actions = li("$hide actionbar menu-actions","#",$current_user->display_name,"icon-user",_get_actions_dropdown());
  if ( isset($datapress['is_default']) && $datapress['is_default']) {
    $favourites = li("$hide actionbar menu-favourites disabled","#","Bookmarks","icon-unlink");
  }
  else {
    $text = "Bookmarks (". count_bookmarks() .")";
    $favourites = li("$hide actionbar menu-favourites","#",$text,"icon-bookmark",_get_favourites_dropdown());
  }

  $search = get_search();
  return $actions . $favourites . $search;
}
