@extends('sanatorium/bill::layout/default')

@section('bill')

<div class="container">

	<table class="bill-list-table" style="width: 100%;">

		<thead>

			<th>Name</th>

			<th>TAX ID</th>

			<th>VAT ID</th>

			<th>Client address</th>

		</thead>

		<tbody>

			@foreach ( $clients as $client )

			<tr>

				<td>

					{{ $client->name }}

				</td>

				<td>

					{{ $client->tax_id }}

				</td>

				<td>

					{{ $client->vat_id }}

				</td>

				<td>

					{{ $client->client_address }}

				</td>


			</tr>

			@endforeach

		</tbody>

	</table>

</div>

@stop