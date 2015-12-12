<?php 

// show details in single portfolio

$dportfolio_portfolio_page_show_details = get_option( 'dportfolio_portfolio_page_show_details', 'on' );

if( $dportfolio_portfolio_page_show_details == 'on' ) { ?>

	<div style="margin-bottom:30px;">

		<?php 												
		global $post;
		$client = get_post_meta( $post->ID, '_client', true );
		$website = get_post_meta( $post->ID, '_website', true );   

		if( $client != '' || $website != '' ) { ?>

			<?php if( $client != '' ) { ?>
				<p class="dportfolio-client"><?php _e( '', 'dportfolio' );?><?php echo $client;?></p>
			<?php }

			if( $website != '' ) { ?>
				<p class="dportfolio-website"><a href="<?php echo $website;?>" target="_blank"><?php _e( 'Website', 'dportfolio' );?></a></p>
			<?php } ?>	

		<?php } ?>

	</div>

<?php } ?>


