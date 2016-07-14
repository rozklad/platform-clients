<?php namespace Sanatorium\Clients\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;
use Sanatorium\Clients\Repositories\Client\ClientRepositoryInterface;

class ClientsController extends Controller {

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Clients\Repositories\Client\ClientRepositoryInterface  $clients
	 * @return void
	 */
	public function __construct(ClientRepositoryInterface $clients)
	{
		parent::__construct();

		$this->clients = $clients;
	}

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		$clients = app('sanatorium.clients.client')->get();

		return view('sanatorium/clients::index', compact('clients'));
	}

	/**
	 * Show the form for creating new client.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}


	/**
	 * Handle posting of the form for creating new client.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the client
		list($messages) = $this->clients->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("sanatorium/clients::clients/message.success.{$mode}"));

			return redirect()->route('sanatorium.clients.clients.index');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a client identifier?
		if (isset($id))
		{
			if ( ! $client = $this->clients->find($id))
			{
				$this->alerts->error(trans('sanatorium/clients::clients/message.not_found', compact('id')));

				return redirect()->route('sanatorium.clients.clients.index');
			}
		}
		else
		{
			$client = $this->clients->createModel();
		}

		// Show the page
		return view('sanatorium/clients::form', compact('mode', 'client'));
	}

}
