<?php namespace Sanatorium\Clients\Handlers\Client;

use Sanatorium\Clients\Models\Client;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface ClientEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a client is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a client is created.
	 *
	 * @param  \Sanatorium\Clients\Models\Client  $client
	 * @return mixed
	 */
	public function created(Client $client);

	/**
	 * When a client is being updated.
	 *
	 * @param  \Sanatorium\Clients\Models\Client  $client
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Client $client, array $data);

	/**
	 * When a client is updated.
	 *
	 * @param  \Sanatorium\Clients\Models\Client  $client
	 * @return mixed
	 */
	public function updated(Client $client);

	/**
	 * When a client is deleted.
	 *
	 * @param  \Sanatorium\Clients\Models\Client  $client
	 * @return mixed
	 */
	public function deleted(Client $client);

}
