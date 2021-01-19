<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Post
 */


namespace Aimeos\MShop\Post\Item;


/**
 * Generic interface for post items created and saved by post managers.
 *
 * @package MShop
 * @subpackage Post
 */
interface Iface
	extends \Aimeos\MShop\Common\Item\Iface, \Aimeos\MShop\Common\Item\Config\Iface,
		\Aimeos\MShop\Common\Item\ListRef\Iface, \Aimeos\MShop\Common\Item\PropertyRef\Iface,
		\Aimeos\MShop\Common\Item\Rating\Iface, \Aimeos\MShop\Common\Item\Status\Iface,
		\Aimeos\MShop\Common\Item\Time\Iface, \Aimeos\MShop\Common\Item\TypeRef\Iface
{
	/**
	 * Returns the catalog items referencing the post
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Catalog\Item\Iface
	 */
	public function getCatalogItems() : \Aimeos\Map;

	/**
	 * Returns the supplier items referencing the post
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Supplier\Item\Iface
	 */
	public function getSupplierItems() : \Aimeos\Map;

	/**
	 * Returns the stock items associated to the post
	 *
	 * @param string|null $type Type of the stock item
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Stock\Item\Iface
	 */
	public function getStockItems( $type = null ) : \Aimeos\Map;

	/**
	 * Returns the code of the post item.
	 *
	 * @return string Code of the post
	 */
	public function getCode() : string;

	/**
	 * Sets a new code of the post item.
	 *
	 * @param string $code New code of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setCode( string $code ) : \Aimeos\MShop\Post\Item\Iface;

	/**
	 * Returns the data set name assigned to the post item.
	 *
	 * @return string Data set name
	 */
	public function getDataset() : string;

	/**
	 * Sets a new data set name assignd to the post item.
	 *
	 * @param string $name New data set name
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setDataset( ?string $name ) : \Aimeos\MShop\Post\Item\Iface;

	/**
	 * Returns the label of the post item.
	 *
	 * @return string Label of the post item
	 */
	public function getLabel() : string;

	/**
	 * Sets a new label of the post.
	 *
	 * @param string $label New label of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setLabel( string $label ) : \Aimeos\MShop\Post\Item\Iface;

	/**
	 * Returns the URL segment for the post item.
	 *
	 * @return string URL segment of the post item
	 */
	public function getUrl() : string;

	/**
	 * Sets a new URL segment for the post.
	 *
	 * @param string|null $url New URL segment of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setUrl( ?string $url ) : \Aimeos\MShop\Post\Item\Iface;

	/**
	 * Returns the quantity scale of the post item.
	 *
	 * @return float Quantity scale
	 */
	public function getScale() : float;

	/**
	 * Sets a new quantity scale of the post item.
	 *
	 * @param float $value New quantity scale
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setScale( float $value ) : \Aimeos\MShop\Post\Item\Iface;

	/**
	 * Returns the URL target specific for that post
	 *
	 * @return string URL target specific for that post
	 */
	public function getTarget() : string;

	/**
	 * Sets a new label of the post item.
	 *
	 * @param string $value New URL target specific for that post
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setTarget( ?string $value ) : \Aimeos\MShop\Post\Item\Iface;
}
