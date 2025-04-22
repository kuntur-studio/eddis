/**
 * External dependencies.
 */
import { registerFieldType } from '@carbon-fields/core';

/**
 * Internal dependencies.
 */
import './style.scss';
import IconSelectField from './main';

registerFieldType( 'icon_select', IconSelectField );
