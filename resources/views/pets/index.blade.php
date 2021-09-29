@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('pets.includes.toolbar')
				</div>

				<section class="products">
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/1.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 1</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/2.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 2</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/3.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 3</h5><h4 style="color: red;"><b>SOLD</b></h4>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/1.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 4</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/2.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 5</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/3.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 6</h5><h4 style="color: red;"><b>SOLD</b></h4>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/1.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 7</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/2.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 8</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/3.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 9</h5><h4 style="color: red;"><b>SOLD</b></h4>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/1.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 10</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/2.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 11</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/3.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 12</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
		<div class="product-card">
			<div class="product-image">
				<img src="{{ asset('images/pets/1.jpg')}}">
			</div>
			<div class="product-info">
				<h5>Pet 13</h5>
				<h6>₱1,000.00</h6>
			</div>
		</div>
		
	</section>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

	<style>
		.products {
			display: flex;
			flex-wrap: wrap;
		}

		.product-card {
			border-radius: 15px;
			border: 2px solid #d2d6de;
			margin-left: 10px;
			margin-bottom: 10px;

			display: flex;
			flex-direction: column;
			
			padding: 2%;
			/*flex: 1 20%;*/
			width: 19%;
			
			background-color: #FFF;
			box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.25);
		}

		.product-image img {
			width: 100%;
		}

		.product-info {
			margin-top: auto;
			padding-top: 20px;
			text-align: center;
		}

		@media ( max-width: 600px ) {
			
			.product-card {
				flex: 1 46%;
			}
			
		}
	</style>	
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
	<script>

    	setTimeout(() => {
    		$('.preloader').fadeOut();
    	}, 2000);
	</script>
@endpush