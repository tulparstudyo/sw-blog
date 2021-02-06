<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Controller
 * @subpackage Frontend
 */

namespace Aimeos\Controller\Frontend\Swpost;

/**
 * Swpost frontend controller factory.
 *
 * @package Controller
 * @subpackage Frontend
*/
class Factory
	extends \Aimeos\Controller\Frontend\Common\Factory\Base
	implements \Aimeos\Controller\Frontend\Common\Factory\Iface
{
	/**
	 * Creates a new swpost controller object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context instance with necessary objects
	 * @param string|null $name Name of the controller implementaton (default: "Standard")
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Controller object
	 */
	public static function create( \Aimeos\MShop\Context\Item\Iface $context, string $name = null ) : \Aimeos\Controller\Frontend\Iface
	{
		if( $name === null ) {
			$name = $context->getConfig()->get( 'controller/frontend/swpost/name', 'Standard' );
		}

		$iface = '\\Aimeos\\Controller\\Frontend\\Swpost\\Iface';
		$classname = '\\Aimeos\\Controller\\Frontend\\Swpost\\' . $name;

		if( ctype_alnum( $name ) === false ) {
			throw new \Aimeos\Controller\Frontend\Exception( sprintf( 'Invalid characters in class name "%1$s"', $classname ) );
		}

		$controller = self::createController( $context, $classname, $iface );

		return self::addControllerDecorators( $context, $controller, 'swpost' );
	}
}
