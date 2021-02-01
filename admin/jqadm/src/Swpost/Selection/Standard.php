<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Swpost\Selection;

sprintf( 'selection' ); // for translation


/**
 * Default implementation of swpost selection JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/** admin/jqadm/swpost/selection/name
	 * Name of the selection subpart used by the JQAdm swpost implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Admin\Jqadm\Swpost\Selection\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the JQAdm class name
	 * @since 2016.04
	 * @category Developer
	 */


	/**
	 * Copies a resource
	 *
	 * @return string|null HTML output
	 */
	public function copy() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$view->selectionData = $this->toArray( $view->item, true );
		$view->selectionBody = parent::copy();

		return $this->render( $view );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string|null HTML output
	 */
	public function create() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$siteid = $this->getContext()->getLocale()->getSiteId();
		$data = $view->param( 'selection', [] );

		foreach( $data as $idx => $entry )
		{
			$data[$idx]['swpost.lists.siteid'] = $siteid;
			$data[$idx]['swpost.siteid'] = $siteid;
		}

		$view->selectionData = $data;
		$view->selectionBody = parent::create();

		return $this->render( $view );
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null HTML output
	 */
	public function get() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );
		$view->selectionData = $this->toArray( $view->item );
		$view->selectionBody = parent::get();

		return $this->render( $view );
	}


	/**
	 * Saves the data
	 *
	 * @return string|null HTML output
	 */
	public function save() : ?string
	{
		$view = $this->getView();

		if( $view->item->getType() === 'select' )
		{
			$this->fromArray( $view->item, $view->param( 'selection', [] ) );
			$view->selectionBody = parent::save();
		}

		return null;
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( string $type, string $name = null ) : \Aimeos\Admin\JQAdm\Iface
	{
		/** admin/jqadm/swpost/selection/decorators/excludes
		 * Excludes decorators added by the "common" option from the swpost JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "admin/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/swpost/selection/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "admin/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/swpost/selection/decorators/global
		 * @see admin/jqadm/swpost/selection/decorators/local
		 */

		/** admin/jqadm/swpost/selection/decorators/global
		 * Adds a list of globally available decorators only to the swpost JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/swpost/selection/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/swpost/selection/decorators/excludes
		 * @see admin/jqadm/swpost/selection/decorators/local
		 */

		/** admin/jqadm/swpost/selection/decorators/local
		 * Adds a list of local decorators only to the swpost JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Swpost\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/swpost/selection/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Swpost\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2016.01
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/swpost/selection/decorators/excludes
		 * @see admin/jqadm/swpost/selection/decorators/global
		 */
		return $this->createSubClient( 'swpost/selection/' . $type, $name );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames() : array
	{
		/** admin/jqadm/swpost/selection/standard/subparts
		 * List of JQAdm sub-clients rendered within the swpost selection section
		 *
		 * The output of the frontend is composed of the code generated by the JQAdm
		 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
		 * that are responsible for rendering certain sub-parts of the output. The
		 * sub-clients can contain JQAdm clients themselves and therefore a
		 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
		 * the output that is placed inside the container of its parent.
		 *
		 * At first, always the JQAdm code generated by the parent is printed, then
		 * the JQAdm code of its sub-clients. The order of the JQAdm sub-clients
		 * determines the order of the output of these sub-clients inside the parent
		 * container. If the configured list of clients is
		 *
		 *  array( "subclient1", "subclient2" )
		 *
		 * you can easily change the order of the output by reordering the subparts:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
		 *
		 * You can also remove one or more parts if they shouldn't be rendered:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
		 *
		 * As the clients only generates structural JQAdm, the layout defined via CSS
		 * should support adding, removing or reordering content by a fluid like
		 * design.
		 *
		 * @param array List of sub-client names
		 * @since 2016.01
		 * @category Developer
		 */
		return $this->getContext()->getConfig()->get( 'admin/jqadm/swpost/selection/standard/subparts', [] );
	}


	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $item Swpost item object without referenced domain items
	 * @param array $data Data array
	 * @return \Aimeos\MShop\Swpost\Item\Iface Modified swpost item
	 */
	protected function fromArray( \Aimeos\MShop\Swpost\Item\Iface $item, array $data ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		$context = $this->getContext();
		$manager = \Aimeos\MShop::create( $context, 'swpost' );
		$listManager = \Aimeos\MShop::create( $context, 'swpost/lists' );

		$listItems = $item->getListItems( 'swpost', 'default', null, false );
		$codes = [];

		foreach( $data as $idx => $entry )
		{
			if( ( $litem = $item->getListItem( 'swpost', 'default', $entry['swpost.id'], false ) ) === null ) {
				$litem = $listManager->createItem()->setType( 'default' );
			}

			if( ( $refItem = $litem->getRefItem() ) === null ) {
				$refItem = $manager->createItem()->setType( 'default' );
			}

			$litem->fromArray( $entry, true )->setPosition( $idx );
			$refItem->fromArray( $entry, true );

			if( isset( $entry['stock.stocklevel'] ) ) {
				$codes[] = $refItem->getCode();
			}

			if( isset( $entry['attr'] ) ) {
				$refItem = $this->fromArrayAttributes( $refItem, $entry['attr'] );
			}

			$item->addListItem( 'swpost', $litem, $refItem );
			unset( $listItems[$litem->getId()] );
		}

		$this->fromArrayStocks( $codes, $data );

		return $item->deleteListItems( $listItems->toArray() );
	}


	/**
	 * Updates the variant attributes of the given swpost item
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $refItem Article item object
	 * @param array $entry Associative list of key/values for swpost attribute references
	 * @return \Aimeos\MShop\Swpost\Item\Iface Updated artice item object
	 */
	protected function fromArrayAttributes( \Aimeos\MShop\Swpost\Item\Iface $refItem, array $entry )
	{
		$listManager = \Aimeos\MShop::create( $this->getContext(), 'swpost/lists' );
		$litems = $refItem->getListItems( 'attribute', 'variant', null, false );
		$pos = 0;

		foreach( $entry as $attr )
		{
			if( !isset( $attr['swpost.lists.refid'] ) || $attr['swpost.lists.refid'] == '' ) {
				continue;
			}

			if( ( $litem = $refItem->getListItem( 'attribute', 'variant', $attr['swpost.lists.refid'], false ) ) === null ) {
				$litem = $listManager->createItem()->setType( 'variant' );
			}

			$litem = $litem->fromArray( $attr, true )->setPosition( $pos++ );

			$refItem->addListItem( 'attribute', $litem, $litem->getRefItem() );
			unset( $litems[$litem->getId()] );
		}

		return $refItem->deleteListItems( $litems->toArray() );
	}


	/**
	 * Updates the stocklevels for the swposts
	 *
	 * @param array $data List of swpost codes
	 * @param array $data Data array
	 */
	protected function fromArrayStocks( array $codes, array $data )
	{
		$manager = \Aimeos\MShop::create( $this->getContext(), 'stock' );

		$search = $manager->createSearch()->setSlice( 0, 0x7fffffff );
		$search->setConditions( $search->combine( '&&', [
			$search->compare( '==', 'stock.swpostcode', $codes ),
			$search->compare( '==', 'stock.type', 'default' ),
		] ) );

		$stockItems = $manager->searchItems( $search );
		$map = $stockItems->col( 'stock.swpostcode', 'stock.id' );
		$list = [];

		foreach( $data as $entry )
		{
			if( !isset( $entry['stock.stocklevel'] ) ) {
				continue;
			}

			$code = $entry['swpost.code'];

			if( ( $stockItem = $stockItems->get( $map[$code] ?? null ) ) === null ) {
				$stockItem = $manager->createItem();
			}

			$stockItem->fromArray( $entry, true )->setSwpostCode( $code )->setType( 'default' );
			unset( $stockItems[$stockItem->getId()] );

			$list[] = $stockItem;
		}

		try
		{
			$manager->begin();
			$manager->deleteItems( $stockItems->toArray() )->saveItems( $list, false );
			$manager->commit();
		}
		catch( \Exception $e )
		{
			$manager->rollback();
			throw $e;
		}
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $item Swpost item object including referenced domain items
	 * @param bool $copy True if items should be copied
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\MShop\Swpost\Item\Iface $item, bool $copy = false ) : array
	{
		if( $item->getType() !== 'select' ) {
			return [];
		}

		$data = [];
		$siteId = $this->getContext()->getLocale()->getSiteId();


		foreach( $item->getListItems( 'swpost', 'default', null, false ) as $id => $listItem )
		{
			if( ( $refItem = $listItem->getRefItem() ) === null ) {
				continue;
			}

			$list = $listItem->toArray( true ) + $refItem->toArray( true );

			if( $copy === true )
			{
				$list['swpost.lists.siteid'] = $siteId;
				$list['swpost.lists.id'] = '';
				$list['swpost.siteid'] = $siteId;
				$list['swpost.id'] = null;
			}

			$idx = 0;

			foreach( $refItem->getListItems( 'attribute', 'variant', null, false ) as $litem )
			{
				if( ( $attrItem = $litem->getRefItem() ) !== null ) {
					$list['attr'][$idx++] = $litem->toArray( true ) + $attrItem->toArray( true );
				}
			}

			$list = array_merge( $list, $refItem->getStockItems( 'default' )->first( map() )->toArray() );

			$data[] = $list;
		}

		return $data;
	}


	/**
	 * Returns the rendered template including the view data
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with data assigned
	 * @return string HTML output
	 */
	protected function render( \Aimeos\MW\View\Iface $view ) : string
	{
		/** admin/jqadm/swpost/selection/template-item
		 * Relative path to the HTML body template of the selection subpart for swposts.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2016.04
		 * @category Developer
		 */
		$tplconf = 'admin/jqadm/swpost/selection/template-item';
		$default = 'swpost/item-selection-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
