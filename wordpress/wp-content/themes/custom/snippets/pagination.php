<?
  $pages = paginate_links( array(
      'type'          => 'array',
			'prev_text'     => __('«', 'sage'),
			'next_text'     => __('»', 'sage'),
    ) );
  if( is_array( $pages ) ) {
    $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
    echo '<nav class="text-center"><ul class="pagination">';
    foreach ( $pages as $i => $page ) {
      $active = ($current_page == $i ? 'active' : '');
      echo "<li class=\"{$active}\">$page</li>";
    }
    echo '</ul></nav>';
  }
?>
