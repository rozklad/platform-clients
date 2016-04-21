@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('sanatorium/clients::clients/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page content --}}
@section('page')

<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="clients-form" action="{{ request()->fullUrl() }}" role="form" method="post" data-parsley-validate>

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<header class="panel-heading">

			<nav class="navbar navbar-default navbar-actions">

				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<a class="btn btn-navbar-cancel navbar-btn pull-left tip" href="{{ route('admin.sanatorium.clients.clients.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
							<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
						</a>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $client->exists ? $client->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($client->exists)
							<li>
								<a href="{{ route('admin.sanatorium.clients.clients.delete', $client->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
									<i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.delete') }}}</span>
								</a>
							</li>
							@endif

							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				{{-- Form: Tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li class="active" role="presentation"><a href="#general-tab" aria-controls="general-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/clients::clients/common.tabs.general') }}}</a></li>
					<li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">{{{ trans('sanatorium/clients::clients/common.tabs.attributes') }}}</a></li>
				</ul>

				<div class="tab-content">

					{{-- Tab: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general-tab">

						<fieldset>

							<div class="row">

								<div class="form-group{{ Alert::onForm('name', ' has-error') }}">

									<label for="name" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/clients::clients/model.general.name_help') }}}"></i>
										{{{ trans('sanatorium/clients::clients/model.general.name') }}}
									</label>

									<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('sanatorium/clients::clients/model.general.name') }}}" value="{{{ input()->old('name', $client->name) }}}">

									<span class="help-block">{{{ Alert::onForm('name') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('tax_id', ' has-error') }}">

									<label for="tax_id" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/clients::clients/model.general.tax_id_help') }}}"></i>
										{{{ trans('sanatorium/clients::clients/model.general.tax_id') }}}
									</label>

									<input type="text" class="form-control" name="tax_id" id="tax_id" placeholder="{{{ trans('sanatorium/clients::clients/model.general.tax_id') }}}" value="{{{ input()->old('tax_id', $client->tax_id) }}}">

									<span class="help-block">{{{ Alert::onForm('tax_id') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('vat_id', ' has-error') }}">

									<label for="vat_id" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/clients::clients/model.general.vat_id_help') }}}"></i>
										{{{ trans('sanatorium/clients::clients/model.general.vat_id') }}}
									</label>

									<input type="text" class="form-control" name="vat_id" id="vat_id" placeholder="{{{ trans('sanatorium/clients::clients/model.general.vat_id') }}}" value="{{{ input()->old('vat_id', $client->vat_id) }}}">

									<span class="help-block">{{{ Alert::onForm('vat_id') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('supplier', ' has-error') }}">

									<label for="name" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/clients::clients/model.general.supplier_help') }}}"></i>
										{{{ trans('sanatorium/clients::clients/model.general.supplier') }}}
									</label>

									<input type="text" class="form-control" name="supplier" id="supplier" placeholder="{{{ trans('sanatorium/clients::clients/model.general.supplier') }}}" value="{{{ input()->old('supplier', $client->supplier) }}}">

									<span class="help-block">{{{ Alert::onForm('supplier') }}}</span>

								</div>


							</div>

						</fieldset>

					</div>

					{{-- Tab: Attributes --}}
					<div role="tabpanel" class="tab-pane fade" id="attributes">
						@attributes($client)
					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop
