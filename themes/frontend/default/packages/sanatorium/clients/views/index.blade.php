@extends('sanatorium/bill::layout/default')

@section('bill')

<div class="container">

	<table class="bill-list-table" style="width: 100%;">

		<thead>

			<th>Name</th>

			<th>TAX ID</th>

			<th>VAT ID</th>

			<th>Address line 1</th>

			<th>Address line 2</th>

			<th>Address line 3</th>

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

					{{ $client->client_address_line_1 }}

				</td>

				<td>

					{{ $client->client_address_line_2 }}

				</td>

				<td>

					{{ $client->client_address_line_3 }}

				</td>

			</tr>

			@endforeach

		</tbody>

	</table>

</div>

@stop