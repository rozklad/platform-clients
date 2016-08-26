@extends('sanatorium/bill::layout/default')

@section('bill')

<div class="container">

	<form method="POST">

		<div class="form-group">

			<select class="form-control" name="supplier" id="supplier">

				<option value="supplier">Supplier</option>

				<option value="buyer">Buyer</option>

			</select>


		</div>

		<div class="form-group">

			<input class="form-control" type="text" name="name" placeholder="Name">

		</div>

		<div class="form-group">
			
			<input class="form-control" type="text" name="tax_id" placeholder="TAX ID">

		</div>

		<div class="form-group">
			
			<input class="form-control" type="text" name="vat_id" placeholder="VAT ID">

		</div>

		<div class="form-group">
			
			<input class="form-control" type="text" name="client_address" placeholder="Client address">

		</div>

		<div class="form-group">
			
			<button class="btn btn-block btn-primary">Save</button>

		</div>

	</form>

</div>

@stop