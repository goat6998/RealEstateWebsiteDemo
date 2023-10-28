<footer class="page-footer" role="contentinfo">
	
<!-- Load Facebook SDK for JavaScript -->

<!-- Load Facebook SDK for JavaScript -->


      <div id="fb-root"></div>

	<p id="page-top"><a href="#" class="teal"><i class="fas fa-arrow-up"></i></a></p>
	
    <div class="container container_footer">
		<div class="row">
			<div class="col s12 m6 footer_menu" role="complementary">
<?php

//フッターメニュー
$footer_menu[] = 'property_search_menu';
$footer_menu[] = 'member_menu';
$footer_menu[] = 'useful_information_menu';
$footer_menu[] = 'corporate_information_menu';

foreach( $footer_menu as $key => $value ){
	get_footer_menu( $value );
}

?>
			</div>
	
			<div class="col s12 m6">
				<div class="company_wrap">
					<div class="footer_logo_wrap"><a href="<?= home_url('/'); ?>"><img src="<?= get_the_logo_url(); ?>" alt="Logo" class="footer_logo"></a></div>
					<div class="company_name"><?php echo articnet_echo_string('company_name'); ?></div>
					<div class="company_tel"><i class="fas fa-phone-square-alt" aria-hidden="true"></i> <?= get_site_info()['tel'] ?></div>
				</div>
			</div>
	    
    	</div>
    </div>
    		
    		
    <div class="footer-copyright">
	    <div class="container">
	            <address><p>Copyright &copy; <?php echo date('Y'); ?> · sample · All Rights Reserved.</p></address>
	    </div>
	</div>
		
		
</footer>
<!-- /footer -->


<?php wp_footer(); ?>


</body>
</html>
