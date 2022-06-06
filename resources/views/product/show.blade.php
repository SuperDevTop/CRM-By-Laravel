@section('page_name')
	Edit product
@stop

@section('scripts')
	<script>
		function validateForm() {
			var name = $('[name="name"]').first().val();
			var category = $('[name="category"] option:selected').val();
			var purchasePrice = $('[name="purchasePrice"]').val();
			var salesPrice = $('[name="salesPrice"]').val();

			if (name == '') {
				showError('The product name is required.');
				return false;
			}
			if (!category) {
				showError('Sorry! The product category is required.');
				return false;
			}
			if (isNaN(purchasePrice) || isNaN(salesPrice) || purchasePrice == '' || salesPrice == '') {
				showError('Please make sure the purchase- and salesprice are numeric!');
				return false;
			}
		}
	</script>
@stop

@section('content')
	<div class="frame">
		<div class="bit-2">
			<div class="container">
				<div class="container_title blue">
					Edit product
				</div>
				<div class="container_content">
					{{ Form::model($product, array('route' => array('products.update', $product->id), 'method' => 'PUT', 'onsubmit' => 'return validateForm();')) }}
						<table class="form tlf">
							<tr>
								<td style='width: 120px;'><label>Name:</label></td>
								<td style='width: 100%;'>{{ Form::text('name') }}</td>
							</tr>
							<tr>
								<td><label>Description:</label></td>
								<td>{{ Form::textarea('description', null, array('rows' => '3')) }}</td>
							</tr>
							<tr>
								<td class='pt'><label>Supplier:</label></td>
								<td class='pt'>
									<select name='supplier' class='supplier_select select2' placeholder='Please select a supplier...'>
										<option value=""></option>
										@foreach(Supplier::orderBy('companyName', 'ASC')->select('tradingName', 'companyName', 'id')->get() as $supplier)
											<option value='{{ $supplier->id }}' @if($product->supplier == $supplier->id) selected="selected" @endif>{{ $supplier->getDisplayName() }}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr>
								<td class='pt'><label>Category:</label></td>
								<td class='pt'>
									<select name='category' class='category_select select2' placeholder='Please select a category...'>
										<option value=""></option>
										@foreach(ProductCategory::orderBy('type', 'ASC')->select('type', 'id')->get() as $category)
											<option value='{{ $category->id }}' @if($product->category == $category->id) selected="selected" @endif>{{ $category->type }}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr>
								<td class='pt'><label>Is work</label></td>
								<td class='pt'>{{ Form::checkbox('isWork') }}</td>
							</tr>
							<tr>
								<td class='pt'><label>Purchase price:</label></td>
								<td class='pt'>{{ Form::text('purchasePrice', null, array('class' =>  'euro', 'style' => 'width: 100px;')) }}</td>
							</tr>
							<tr>
								<td><label>Sell price:</label></td>
								<td>{{ Form::text('salesPrice', null, array('class' =>  'euro', 'style' => 'width: 100px;')) }}</td>
							</tr>
							<tr>
								<td class='pt'><label>Discontinued:</label></td>
								<td class='pt'>
									{{ Form::hidden('discontinued', 0) }}
									{{ Form::checkbox('discontinued', 1) }}
								</td>
							</tr>
							@if (Auth::user()->hasPermission('product_edit'))
								<tr>
									<td></td>
									<td>{{ Form::submit('Save product', array('class' => 'btn btn-green fr')) }}</td>
								</tr>
							@endif
						</table>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop