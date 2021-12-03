<div class="pull-right">
	<a href="{{ route('transactions.index') }}" class="btn btn-info" data-toggle="tooltip" title="View All">
		<span class="fa fa-list"></span>
	</a>
	@if(auth()->user()->role == "Seller")
		<a href="{{ route('book-now') }}" class="btn btn-primary" data-toggle="tooltip" title="Book Now">
			<span class="fa fa-plus"></span>
		</a>
	@elseif(auth()->user()->role == "Admin")
		<a class="btn btn-primary" id="price" data-toggle="tooltip" title="Price">
			<span class="fa fa-dollar"></span>
		</a>
	@endif
</div>