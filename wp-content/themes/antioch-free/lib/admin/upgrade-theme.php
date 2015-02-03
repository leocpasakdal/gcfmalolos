<?php
/**
 * Setup a new menu item and corresponding admin screen for upgrading the theme.
 *
 * @action admin_menu
 */
function churchthemes_upgrade_menu() {
    add_menu_page(
    	__( 'Upgrade to ChurchThemes Premium', 'churchthemes' ),
    	__( 'ChurchThemes', 'churchthemes' ),
    	'read',
    	'churchthemes-upgrade',
    	'churchthemes_upgrade_page'
    );
}
add_action( 'admin_menu', 'churchthemes_upgrade_menu' );

/**
 * Outputs the page content for the upgrade theme admin screen.
 *
 * @see churchthemes_upgrade_menu
 */
function churchthemes_upgrade_page() {
	$theme = wp_get_theme();
	?>
	<style>
		.churchthemes-upgrade-page .welcome-panel h3 {
			margin-bottom: 5px;
		}
		.churchthemes-upgrade-page .welcome-panel-column li {
			padding: 5px;
		}
		.churchthemes-upgrade-page .welcome-panel-column li span {
			margin-right: 5px;
			font-size: 1.4em;
			color: limegreen;
		}
		.churchthemes-upgrade-page .welcome-panel-column .about-description {
			margin-top: 10px;
		}
	</style>
	<div class="wrap churchthemes-upgrade-page">
		<h2><?php _e( 'Upgrade to ChurchThemes Premium', 'churchthemes' ) ?></h2>
		<h3><?php printf( __( "We hope you're enjoying %s!", 'churchthemes' ), esc_html( $theme->Name ) ) ?></h3>
		<p><?php _e( "Our free themes are great for test driving the design and functionality to see how it can work for your church.", 'churchthemes' ) ?></p>
		<p><?php _e( "Once you're convinced, please upgrade to the <strong>Standard Edition</strong> or <strong>Developer Edition</strong> to take advantage of the amazing premium features we've built <em>just for churches.</em>", 'churchthemes' ) ?></p>
		<div id="welcome-panel" class="welcome-panel">
			<h3><?php _e( "After upgrading you'll enjoy premium features like...", 'churchthemes' ) ?></h3>
			<div class="welcome-panel-column">
				<ul>
					<li><span>&#x2713;</span> <?php _e( 'Free and automatic theme updates.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php printf( __( "Accept tithes and offerings online via %s or %s.", 'churchthemes' ), '<a href="https://www.paypal.com/us/mrb/pal=WC5EWXNR7VAXS" target="_blank">PayPal</a>', '<a href="https://www.easytithe.com/signup/?r=livi1941" target="_blank">EasyTithe</a>' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'Publish and manage sermon media with ease.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'Directly embed YouTube or Vimeo videos of your sermons.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'A fully searchable library of your sermon media.', 'churchthemes' ) ?></li>
				</ul>
			</div>
			<div class="welcome-panel-column">
				<ul>
					<li><span>&#x2713;</span> <?php _e( 'Publish your sermons as an audio podcast in iTunes.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'Directories for staff, pastors, &amp; small group leaders.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'Managing multiple church locations and services.', 'churchthemes' ) ?></li>
					<li><span>&#x2713;</span> <?php _e( 'Easily display Tweets in any sidebar area.', 'churchthemes' ) ?></li>
				</ul>
			</div>
			<div class="welcome-panel-column">
				<p class="about-description"><?php _e( 'No contracts, monthly payments or hidden fees. Ever.', 'churchthemes' ) ?></p>
				<a href="<?php echo esc_url( CHURCHTHEMES_UPGRADE_THEME_URL ) ?>" class="button button-primary button-hero" target="_blank"><?php _e( 'Compare Premium Editions', 'churchthemes' ) ?></a>
			</div>
		</div>
	</div>
	<?php
}
