<?php namespace Sanatorium\Clients\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;

class ClientsController extends Controller {

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

}
