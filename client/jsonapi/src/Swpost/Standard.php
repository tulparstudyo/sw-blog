<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Client
 * @subpackage JsonApi
 */


namespace Aimeos\Client\JsonApi\Swpost;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * JSON API standard client
 *
 * @package Client
 * @subpackage JsonApi
 */
class Standard
	extends \Aimeos\Client\JsonApi\Base
	implements \Aimeos\Client\JsonApi\Iface
{
	/**
	 * Returns the resource or the resource list
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @param \Psr\Http\Message\ResponseInterface $response Response object
	 * @return \Psr\Http\Message\ResponseInterface Modified response object
	 */
	public function get( ServerRequestInterface $request, ResponseInterface $response ) : \Psr\Http\Message\ResponseInterface
	{
		$view = $this->getView();

		try
		{
			$ref = $view->param( 'include', ['media', 'price', 'text'] );

			if( is_string( $ref ) ) {
				$ref = explode( ',', $ref );
			}

			$cntl = \Aimeos\Controller\Frontend::create( $this->getContext(), 'swpost' )->uses( $ref );

			if( ( $id = $view->param( 'id' ) ) != '' )
			{
				$view->items = $cntl->get($id);
				$view->total =  1 ;

			}
			else
			{
				$view->items = map();
				$view->total = count( $view->items );
			}

			$status = 200;
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$status = 404;
			$view->errors = $this->getErrorDetails( $e, 'mshop' );
		}
		catch( \Exception $e )
		{
			$status = $e->getCode() >= 100 && $e->getCode() < 600 ? $e->getCode() : 500;
			$view->errors = $this->getErrorDetails( $e );
		}

		$tplconf = 'client/jsonapi/swpost/standard/template';
		$default = 'swpost/standard';

		$body = $view->render( $view->config( $tplconf, $default ) );

		return $response->withHeader( 'Allow', 'GET,OPTIONS' )
			->withHeader( 'Cache-Control', 'max-age=300' )
			->withHeader( 'Content-Type', 'application/vnd.api+json' )
			->withBody( $view->response()->createStreamFromString( $body ) )
			->withStatus( $status );
	}


	/**
	 * Returns the available REST verbs and the available parameters
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @param \Psr\Http\Message\ResponseInterface $response Response object
	 * @return \Psr\Http\Message\ResponseInterface Modified response object
	 */
	public function options( ServerRequestInterface $request, ResponseInterface $response ) : \Psr\Http\Message\ResponseInterface
	{
		$view = $this->getView();

		$view->filter = [
			'cs_type' => [
				'label' => 'Type of the swpost items that should be returned ("delivery" or "payment")',
				'type' => 'string', 'default' => '', 'required' => false,
			],
		];

		$tplconf = 'client/jsonapi/standard/template-options';
		$default = 'options-standard';

		$body = $view->render( $view->config( $tplconf, $default ) );

		return $response->withHeader( 'Allow', 'GET,OPTIONS' )
			->withHeader( 'Cache-Control', 'max-age=300' )
			->withHeader( 'Content-Type', 'application/vnd.api+json' )
			->withBody( $view->response()->createStreamFromString( $body ) )
			->withStatus( 200 );
	}
}
