<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Post
 */


namespace Aimeos\MShop\Post\Manager;


/**
 * Generic interface for managing posts
 *
 * @package MShop
 * @subpackage Post
 */
interface Iface
	extends \Aimeos\MShop\Common\Manager\Iface, \Aimeos\MShop\Common\Manager\Find\Iface
{
	/**
	 * Adds a new post to the storage.
	 *
	 * @param \Aimeos\MShop\Post\Item\Iface $item Post item that should be saved to the storage
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Post\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Post\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Post\Item\Iface;
}
