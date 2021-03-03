<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Swpost;

sprintf( 'swpost' ); // for translation


/**
 * Default implementation of swpost JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/**
	 * Adds the required data used in the template
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface View object with assigned parameters
	 */
	public function addData( \Aimeos\MW\View\Iface $view ) : \Aimeos\MW\View\Iface
	{
		$view->itemSubparts = $this->getSubClientNames();
		$view->itemTypes = $this->getTypeItems();
		return $view;
	}


	/**
	 * Copies a resource
	 *
	 * @return string|null HTML output
	 */
	public function copy() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );

		try
		{
			if( ( $id = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$manager = \Aimeos\MShop::create( $this->getContext(), 'swpost' );
			$view->item = $manager->getItem( $id, $this->getDomains() );

			$view->itemData = $this->toArray( $view->item, true );
			$view->itemBody = parent::copy();
		}
		catch( \Exception $e )
		{
			$this->report( $e, 'copy' );
		}

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

		try
		{
			$data = $view->param( 'item', [] );

			if( !isset( $view->item ) ) {
				$view->item = \Aimeos\MShop::create( $this->getContext(), 'swpost' )->createItem();
			}

			$data['swpost.siteid'] = $view->item->getSiteId();

			$view->itemData = array_replace_recursive( $this->toArray( $view->item ), $data );
			$view->itemBody = parent::create();
		}
		catch( \Exception $e )
		{
			$this->report( $e, 'create' );
		}

		return $this->render( $view );
	}


	/**
	 * Deletes a resource
	 *
	 * @return string|null HTML output
	 */
	public function delete() : ?string
	{
		$tags = ['swpost'];
		$view = $this->getView();
		$context = $this->getContext();

		$manager = \Aimeos\MShop::create( $context, 'swpost' );
		$manager->begin();

		try
		{
			if( ( $ids = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$search = $manager->createSearch()->setSlice( 0, count( (array) $ids ) );
			$search->setConditions( $search->compare( '==', 'swpost.id', $ids ) );
			$items = $manager->searchItems( $search, $this->getDomains() );

			foreach( $items as $id => $item )
			{
				$tags[] = 'swpost-' . $id;
				$view->item = $item;
				parent::delete();
			}

			$manager->deleteItems( $items->toArray() );
			$manager->commit();

			\Aimeos\MShop::create( $context, 'index' )->deleteItems( $items->toArray() );
			$context->getCache()->deleteByTags( $tags );

			return $this->redirect( 'swpost', 'search', null, 'delete' );
		}
		catch( \Exception $e )
		{
			$manager->rollback();
			$this->report( $e, 'delete' );
		}

		return $this->search();
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null HTML output
	 */
	public function get() : ?string
	{
		$view = $this->getObject()->addData( $this->getView() );

		try
		{
			if( ( $id = $view->param( 'id' ) ) === null ) {
				throw new \Aimeos\Admin\JQAdm\Exception( sprintf( 'Required parameter "%1$s" is missing', 'id' ) );
			}

			$manager = \Aimeos\MShop::create( $this->getContext(), 'swpost' );

			$view->item = $manager->getItem( $id, $this->getDomains() );
            $itemData = $this->toArray( $view->item );
            unset($itemData['swpost.config']['icon']);
            foreach($itemData['config'] as $config_key => $config ){
                if($config['key']=='icon'){
                    unset($itemData['config'][$config_key]);
                }
            }

			$view->itemData = $itemData;
			$view->itemBody = parent::get();
		}
		catch( \Exception $e )
		{
			$this->report( $e, 'get' );
		}

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
		$context = $this->getContext();

		$manager = \Aimeos\MShop::create( $context, 'swpost' );
		$manager->begin();

		try
		{
			$item = $this->fromArray( $view->param( 'item', [] ) );
			$view->item = $item->getId() ? $item : $manager->saveItem( $item );
			$view->itemBody = parent::save();
			$item = $manager->saveItem( clone $view->item );
			$manager->commit();

			\Aimeos\MShop::create( $context, 'index' )->rebuild( [$item->getId() => $item] );
			$context->getCache()->deleteByTags( ['swpost', 'swpost-' . $item->getId()] );

			return $this->redirect( 'swpost', $view->param( 'next' ), $view->item->getId(), 'save' );
		}
		catch( \Exception $e )
		{
			$manager->rollback();
			$this->report( $e, 'save' );
		}

		return $this->create();
	}


	/**
	 * Returns a list of resource according to the conditions
	 *
	 * @return string|null HTML output
	 */
	public function search_data() 
	{
		$view = $this->getView();
		try
		{
			$total = 0;
			$domains = map( $this->getDomains() )->remove( 'swpost' );
			$params = $this->storeSearchParams( $view->param(), 'swpost' );
			$manager = \Aimeos\MShop::create( $this->getContext(), 'swpost' );
			$search = $manager->createSearch();
			$search->setSortations( [$search->sort( '+', 'swpost.id' )] );
			$search = $this->initCriteria( $search, $params );
			$view->items = $manager->searchItems( $search, $domains->toArray(), $total );
			$view->filterAttributes = $manager->getSearchAttributes( true );
			$view->filterOperators = $search->getOperators();
			$view->itemTypes = $this->getTypeItems();
			$view->itemBody = parent::search();
			$view->total = $total;
		}
		catch( \Exception $e )
		{
			$this->report( $e, 'search' );
		}
        return $view;

	}
	public function search() : ?string
	{
		try
		{
            $view = $this->search_data();
		}
		catch( \Exception $e )
		{
			$this->report( $e, 'search' );
		}

		$tplconf = 'admin/jqadm/swpost/template-list';
		$default = 'swpost/list-standard';

		return $view->render( $view->config( $tplconf, $default ) );
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
		return $this->createSubClient( 'swpost/' . $type, $name );
	}


	/**
	 * Returns the domain names whose items should be fetched too
	 *
	 * @return string[] List of domain names
	 */
	protected function getDomains() : array
	{
		return $this->getContext()->getConfig()->get( 'admin/jqadm/swpost/domains', [] );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames() : array
	{
		return $this->getContext()->getConfig()->get( 'admin/jqadm/swpost/standard/subparts', ['text', 'media'] );
	}


	/**
	 * Returns the available swpost type items
	 *
	 * @return \Aimeos\Map List of item implementing \Aimeos\MShop\Common\Type\Iface
	 */
	protected function getTypeItems() : \Aimeos\Map
	{
		$typeManager = \Aimeos\MShop::create( $this->getContext(), 'swpost/type' );

		$search = $typeManager->createSearch( true )->setSlice( 0, 10000 );
		$search->setSortations( [$search->sort( '+', 'swpost.type.position' )] );

		return $typeManager->searchItems( $search );
	}


	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param array $data Data array
	 * @return \Aimeos\MShop\Swpost\Item\Iface New swpost item object
	 */
	protected function fromArray( array $data ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		$conf = [];

		foreach( (array) $this->getValue( $data, 'config', [] ) as $idx => $entry )
		{
			if( ( $key = trim( $entry['key'] ?? '' ) ) !== '' ) {
				$conf[$key] = trim( $entry['val'] ?? '' );
			}
		}

		$manager = \Aimeos\MShop::create( $this->getContext(), 'swpost' );

		if( isset( $data['swpost.id'] ) && $data['swpost.id'] != '' ) {
			$item = $manager->getItem( $data['swpost.id'], $this->getDomains() );
		} else {
			$item = $manager->createItem();
		}

		return $item->fromArray( $data, true )->setConfig( $conf );
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $item Swpost item object
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\MShop\Swpost\Item\Iface $item, bool $copy = false ) : array
	{
		$data = $item->toArray( true );
		$data['config'] = [];

		if( $copy === true )
		{
			$data['swpost.siteid'] = $this->getContext()->getLocale()->getSiteId();
			$data['swpost.code'] = $data['swpost.code'] . '_copy';
			$data['swpost.url'] = $data['swpost.url'] . '-' . time();
			$data['swpost.id'] = '';
		}

		foreach( $item->getConfig() as $key => $value ) {
			$data['config'][] = ['key' => $key, 'val' => $value];
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
		$tplconf = 'admin/jqadm/swpost/template-item';
		$default = 'swpost/item-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
