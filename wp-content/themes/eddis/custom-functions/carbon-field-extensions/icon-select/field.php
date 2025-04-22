<?php

use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Icon_Select\Icon_Select_Field;

define( 'Carbon_Field_Icon_Select\\DIR', __DIR__ );

Carbon_Fields::extend( Icon_Select_Field::class, function( $container ) {
	return new Icon_Select_Field(
		$container['arguments']['type'],
		$container['arguments']['name'],
		$container['arguments']['label']
	);
} );
