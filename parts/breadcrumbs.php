<?php
$check_post_type[] = 'notice';
$check_post_type[] = 'area_info';
$check_post_type[] = 'how_to';

#dump( get_post_type_object( get_post_type() ) );

?>
<div class="container_breadcrumb teal">
	<div class="container container_custom">
		<nav class="nav_breadcrumb">
		    <div class="nav-wrapper white-text teal">
				<div class="col s12">
					<a href="<?= home_url('/') ?>" class="breadcrumb waves-effect waves-light"><i class="material-icons bottom">home</i><?php articnet_echo_string('home'); ?></a>
<?php if( in_array( get_post_type(), $check_post_type ) ): ?>
	<a href="<?= home_url( get_post_type_object( get_post_type() )->name ) ?>" class="breadcrumb waves-effect waves-light"><?= get_field_articnet( get_post_type() ); ?></a>
	<?php if( is_single() ): ?>
	<a class="breadcrumb"><?= get_the_title() ?></a>
	<?php endif; ?>
<?php else: ?>
	<a class="breadcrumb"><?= get_the_title() ?></a>
<?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
</div>