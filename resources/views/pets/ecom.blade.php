@extends('layouts.app')
@section('content')

<section class="content">

		
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