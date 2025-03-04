<?php

include_once path_join( __DIR__, 'service.php' );


add_action( 'wpcf7_init', 'wpcf7_turnstile_register_service', 35, 0 );

function wpcf7_turnstile_register_service() {
	$integration = WPCF7_Integration::get_instance();

	$integration->add_service( 'turnstile',
		WPCF7_Turnstile::get_instance()
	);
}


add_action(
	'wp_enqueue_scripts',
	'wpcf7_turnstile_enqueue_scripts',
	20, 0
);

function wpcf7_turnstile_enqueue_scripts() {
	$service = WPCF7_Turnstile::get_instance();

	if ( ! $service->is_active() ) {
		return;
	}

	wp_register_script(
		'cloudflare-turnstile',
		'https://challenges.cloudflare.com/turnstile/v0/api.js',
		array(),
		null,
		array(
			'strategy' => 'async',
		)
	);

	wp_enqueue_script( 'cloudflare-turnstile' );
}


add_action(
	'wpcf7_init',
	'wpcf7_add_form_tag_turnstile',
	10, 0
);

function wpcf7_add_form_tag_turnstile() {
	wpcf7_add_form_tag(
		'turnstile',
		'wpcf7_turnstile_form_tag_handler',
		array(
			'display-block' => true,
			'singular' => true,
		)
	);
}


function wpcf7_turnstile_form_tag_handler( $tag ) {
	$service = WPCF7_Turnstile::get_instance();

	if ( ! $service->is_active() ) {
		return;
	}

	$sitekey = $service->get_sitekey();

	return sprintf(
		'<div class="cf-turnstile" data-sitekey="%s"></div>',
		esc_attr( $sitekey )
	);
}


add_filter( 'wpcf7_posted_data', 'wpcf7_posted_data_turnstile', 10, 1 );

function wpcf7_posted_data_turnstile( $posted_data ) {
	if ( isset( $posted_data['cf-turnstile-response'] ) ) {
		unset( $posted_data['cf-turnstile-response'] );
	}

	return $posted_data;
}
