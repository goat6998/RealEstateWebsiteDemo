<script>
jQuery(function($){
	
	$('.nextpostslink').html('<i class="fas fa-angle-right"></i>');
	$('.previouspostslink').html('<i class="fas fa-angle-left"></i>');
	
	<?php if( $paged >= 6 && $max_num_pages >= 6 ): ?>
	$('.wp-pagenavi').prepend('<a class="firstpostslink" rel="first" href="<?= home_url('/property_list/page/1/') ?>?<?= $_SERVER['QUERY_STRING'] ?>"><i class="fas fa-angle-double-left"></i></a>');
	<?php endif; ?>
	
	<?php if( $paged!=$max_num_pages && $max_num_pages >= 6 ): ?>
	$('.wp-pagenavi').append('<a class="lastpostslink" rel="last" href="<?= home_url('/property_list/page/').$max_num_pages ?>/?<?= $_SERVER['QUERY_STRING'] ?>"><i class="fas fa-angle-double-right"></i></a>');
	<?php endif; ?>
});
</script>