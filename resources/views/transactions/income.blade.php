@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header with-border">
				  <div class="col-md-2">
				    <input type="text" id="from" placeholder="From" data-input>
				  </div>
				  <div class="col-md-2">
				    <input type="text" id="to" placeholder="To" data-input>
				  </div>
				  <div class="col-md-1">
				    <a class="btn btn-danger clear" data-toggle="tooltip" title="Clear" onclick="setDates()">
				      <span class="fa fa-close"></span>
				    </a>
				  </div>
				</div>

				<div class="box-body">
					<div class="col-md-12">
					  <canvas id="chart-1"></canvas>
					</div>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
  	<link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
	<style>
		.checked{
			color: orange;
		}
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/charts.min.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		function setDates(){
			$('#from, #to').flatpickr({
			    altInput: true,
			    altFormat: 'F j, Y',
			    dateFormat: 'Y-m-d',
			    maxDate: moment().format('YYYY-MM-DD')
			});
		} 
		setDates();

		var chart = new Chart(
		document.getElementById('chart-1'),
		{
		   type: 'line',
		   data: {
		     labels: [],
		     datasets: [{
		       label: "Number of Transactions from selected date range",
		       backgroundColor: 'rgb(255, 99, 132)',
		       borderColor: 'rgb(255, 99, 132)',
		       data: []
		     }]
		   },
		   options: {
		    scales: {
		      y: {
		        beginAtZero: true,
		        ticks: {
		          stepSize: 1,
		          maxTicksLimit: 5
		        }
		      }
		    }
		   }
		 }
		);

		$('#from, #to').change(e => {
			let from = $('#from').val();
			let to = $('#to').val();

			from = to != "" ? from != "" ? from : to : from;
			to = to == "" ? moment().format("YYYY-MM-DD") : to;

			getChartData(from, to, false);
		});

		$(document).ready(e => {
			getChartData(
				moment().subtract(7, "days").format("YYYY-MM-DD"),
				moment().format("YYYY-MM-DD")
			);
		});

		function getChartData(from, to, init=true){
			$.ajax({
			  url: '{{ route('getIncome') }}',
			  data: {
			    from: from,
			    to: to
			  },
			  success: result => {
			    result = JSON.parse(result);
			    let label = init? "Past week income" : moment(from).format("MMM DD, YYYY") + " - " + moment(to).format("MMM DD, YYYY");

			    chart.config.data.labels = Object.keys(result);
			    chart.config.data.datasets[0].label = label;
			    chart.config.data.datasets[0].data = Object.values(result);
			    chart.update();
			  }
			});
		}
	</script>
@endpush