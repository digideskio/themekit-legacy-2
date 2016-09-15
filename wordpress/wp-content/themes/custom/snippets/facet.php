<? 
$compressFacetThreshold = 9; // Minimum number of entries before compression kicks in
$compressedFacetFold = 6; // Number of entries to show when compressed

// $facet and $facet_data propagate from the sidebar-* that is including this file.
//
?>


<section class="facet facet-<?= $facet ?>">
  <?
    $sorted_facets = facet_sidebar_sorted($facet,$facet_data);
    $do_compress = count($sorted_facets) >= $compressFacetThreshold;
  ?>
  <h2><?= facet_display_key($facet) ?> &nbsp;<i class="icon-filter"></i></h2>
  <ul>
    <? foreach ($sorted_facets as $index=>$item): ?>
      <? $hidden = $do_compress && $index>=$compressedFacetFold? "hidden" : ""; ?>
      <? if ($item['active']): ?>
        <li class="dp-active active <?= $hidden ?>">
          <a href="<?= querystring_unlink($facet,$item['name']); ?>">
            <?= $item['display_name'] ?>
          </a>
        </li>
      <? else: ?>
        <li class="<?= $hidden ?>">
          <a href="<?= querystring_link($facet,$item['name'],true); ?>">
            <?= $item['display_name'] ?> (<?=$item['count']?>)
          </a>
        </li>
      <? endif; ?>
    <? endforeach; ?>
    <? if ($do_compress): ?>
      <li>
        <a class="hidden" href="#" data-widget="ShowMoreFacets">
          Show <?= count($sorted_facets)-$compressedFacetFold; ?> more...
        </a>
      </li>
    <? endif; ?>
    <? if (count($facet_data['items'])==0): ?>
      <li class="dp-no-more-facets">
        <a><em>(No further facets)</em></a>
      </li>
    <? endif; ?>
  </ul>
</section>
