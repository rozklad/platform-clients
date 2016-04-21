<script type="text/template" data-grid="client" data-template="results">

	<% _.each(results, function(r) { %>

		<tr data-grid-row>
			<td><input content="id" input data-grid-checkbox="" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a href="<%= r.edit_uri %>" href="<%= r.edit_uri %>"><%= r.id %></a></td>
			<td><%= r.name %></td>
			<td><%= r.tax_id %></td>
			<td><%= r.vat_id %></td>
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
