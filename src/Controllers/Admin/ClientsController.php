<?php namespace Sanatorium\Clients\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Clients\Repositories\Client\ClientRepositoryInterface;

class ClientsController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Clients repository.
	 *
	 * @var \Sanatorium\Clients\Repositories\Client\ClientRepositoryInterface
	 */
	protected $clients;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

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
	 * Display a listing of client.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/clients::clients.index');
	}

	/**
	 * Datasource for the client Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->clients->grid();

		$columns = [
			'id',
			'name',
			'tax_id',
			'vat_id',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.sanatorium.clients.clients.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
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
	 * Show the form for updating client.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified client.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->clients->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("sanatorium/clients::clients/message.{$type}.delete")
		);

		return redirect()->route('admin.sanatorium.clients.clients.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->clients->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
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

				return redirect()->route('admin.sanatorium.clients.clients.all');
			}
		}
		else
		{
			$client = $this->clients->createModel();
		}

		$clientmodes = [
		    [
		        'name' => trans('sanatorium/clients::clients/model.general.supplier_values.buyer'),
                'description' => trans('sanatorium/clients::clients/model.general.supplier_values.buyer_help'),
                'value' => 0,
            ],
            [
                'name' => trans('sanatorium/clients::clients/model.general.supplier_values.supplier'),
                'description' => trans('sanatorium/clients::clients/model.general.supplier_values.supplier_help'),
                'value' => 1
            ]
        ];

		// Show the page
		return view('sanatorium/clients::clients.form', compact('mode', 'client', 'clientmodes'));
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

			return redirect()->route('admin.sanatorium.clients.clients.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}
