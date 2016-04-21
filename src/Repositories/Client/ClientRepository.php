<?php namespace Sanatorium\Clients\Repositories\Client;

use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;

class ClientRepository implements ClientRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Sanatorium\Clients\Handlers\Client\ClientDataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent clients model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['sanatorium.clients.client.handler.data'];

		$this->setValidator($app['sanatorium.clients.client.validator']);

		$this->setModel(get_class($app['Sanatorium\Clients\Models\Client']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('sanatorium.clients.client.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('sanatorium.clients.client.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new client
		$client = $this->createModel();

		// Fire the 'sanatorium.clients.client.creating' event
		if ($this->fireEvent('sanatorium.clients.client.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the client
			$client->fill($data)->save();

			// Fire the 'sanatorium.clients.client.created' event
			$this->fireEvent('sanatorium.clients.client.created', [ $client ]);
		}

		return [ $messages, $client ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the client object
		$client = $this->find($id);

		// Fire the 'sanatorium.clients.client.updating' event
		if ($this->fireEvent('sanatorium.clients.client.updating', [ $client, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($client, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the client
			$client->fill($data)->save();

			// Fire the 'sanatorium.clients.client.updated' event
			$this->fireEvent('sanatorium.clients.client.updated', [ $client ]);
		}

		return [ $messages, $client ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the client exists
		if ($client = $this->find($id))
		{
			// Fire the 'sanatorium.clients.client.deleted' event
			$this->fireEvent('sanatorium.clients.client.deleted', [ $client ]);

			// Delete the client entry
			$client->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}
