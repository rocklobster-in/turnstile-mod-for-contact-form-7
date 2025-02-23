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
