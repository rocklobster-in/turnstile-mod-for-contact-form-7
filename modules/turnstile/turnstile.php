<?php

include_once path_join( __DIR__, 'service.php' );


add_action( 'wpcf7_init', 'wpcf7_turnstile_register_service', 35, 0 );

function wpcf7_turnstile_register_service() {
	$integration = WPCF7_Integration::get_instance();

	$integration->add_service( 'turnstile',
		WPCF7_Turnstile::get_instance()
	);
}
