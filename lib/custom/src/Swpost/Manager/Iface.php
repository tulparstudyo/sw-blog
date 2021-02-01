<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Swpost
 */


namespace Aimeos\MShop\Swpost\Manager;


/**
 * Generic interface for managing swposts
 *
 * @package MShop
 * @subpackage Swpost
 */
interface Iface
	extends \Aimeos\MShop\Common\Manager\Iface, \Aimeos\MShop\Common\Manager\Find\Iface
{
	/**
	 * Adds a new swpost to the storage.
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $item Swpost item that should be saved to the storage
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Swpost\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Swpost\Item\Iface;
}
