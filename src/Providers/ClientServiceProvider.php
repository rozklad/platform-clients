<?php namespace Sanatorium\Clients\Providers;

use Cartalyst\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Sanatorium\Clients\Models\Client']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('sanatorium.clients.client.handler.event');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('sanatorium.clients.client', 'Sanatorium\Clients\Repositories\Client\ClientRepository');

		// Register the data handler
		$this->bindIf('sanatorium.clients.client.handler.data', 'Sanatorium\Clients\Handlers\Client\ClientDataHandler');

		// Register the event handler
		$this->bindIf('sanatorium.clients.client.handler.event', 'Sanatorium\Clients\Handlers\Client\ClientEventHandler');

		// Register the validator
		$this->bindIf('sanatorium.clients.client.validator', 'Sanatorium\Clients\Validator\Client\ClientValidator');
	}

}
