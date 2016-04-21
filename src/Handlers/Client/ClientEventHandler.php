<?php namespace Sanatorium\Clients\Handlers\Client;

use Illuminate\Events\Dispatcher;
use Sanatorium\Clients\Models\Client;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class ClientEventHandler extends BaseEventHandler implements ClientEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('sanatorium.clients.client.creating', __CLASS__.'@creating');
		$dispatcher->listen('sanatorium.clients.client.created', __CLASS__.'@created');

		$dispatcher->listen('sanatorium.clients.client.updating', __CLASS__.'@updating');
		$dispatcher->listen('sanatorium.clients.client.updated', __CLASS__.'@updated');

		$dispatcher->listen('sanatorium.clients.client.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Client $client)
	{
		$this->flushCache($client);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Client $client, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Client $client)
	{
		$this->flushCache($client);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Client $client)
	{
		$this->flushCache($client);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Sanatorium\Clients\Models\Client  $client
	 * @return void
	 */
	protected function flushCache(Client $client)
	{
		$this->app['cache']->forget('sanatorium.clients.client.all');

		$this->app['cache']->forget('sanatorium.clients.client.'.$client->id);
	}

}
