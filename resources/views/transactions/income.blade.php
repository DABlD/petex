@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		{{-- LINE CHART --}}
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

		{{-- TABLE --}}
		<section class="col-lg-6">
			<div class="box box-info">

				<div class="box-header with-border">
					Income Table
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
						<thead>
							<tr>
								<th>Date</th>
								<th>Income</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>

		{{-- PIE CHART --}}
		<section class="col-lg-6">
			<div class="box box-info">

				<div class="box-header with-border">
					Pie Chart
				</div>

				<div class="box-body">
					<div class="box-body col-md-2"></div>
					<div class="box-body col-md-6">
						<canvas id="chart-2"></canvas>
					</div>
					<div class="box-body col-md-4"></div>
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
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
	<style>
		.checked{
			color: orange;
		}
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/charts.min.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		$('#table').DataTable();

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

		var chart2 = new Chart(
		document.getElementById('chart-2'),
		{
		   type: 'pie',
		   data: {
		     labels: ["Delivered", "Cancelled", "Rider Cancel"],
		     datasets: [{
		       label: "Transaction Status",
		       backgroundColor: [
		         'rgb(255, 99, 132)',
		         'rgb(54, 162, 235)',
		         'rgb(255, 205, 86)'
		       ],
		       hoverOffset: 4,
		       data: [0,0,0]
		     }]
		   },
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
			    transactions = result.transactions;
			    result = result.labels;
			    let label = init? "Past week income" : moment(from).format("MMM DD, YYYY") + " - " + moment(to).format("MMM DD, YYYY");

			    // LINE CHART DATA
			    chart.config.data.labels = Object.keys(result);
			    chart.config.data.datasets[0].label = label;
			    chart.config.data.datasets[0].data = Object.values(result);
			    chart.update();

			    // PIE CHART DATA
			    let status = [];
			    status["Delivered"] = 0;
				status["Cancelled"] = 0;
				status["Rider Cancel"] = 0;
				status["No Delivery"] = 0;

			    transactions.forEach(row => {
			    	status[row.status]++;
			    });
			    chart2.config.data.datasets[0].data = [status["Delivered"], status["Cancelled"], status["Rider Cancel"]];
			    chart2.update();

			    $('#table').DataTable().destroy();
			    // TABLE DATA
			    let tableString = "";
			    Object.keys(result).forEach(date => {
			    	tableString += `
			    		<tr>
			    			<td>${date}</td>
			    			<td>&#8369;${parseFloat(result[date] * .25).toFixed(2)}</td>
			    		</tr>
			    	`;
			    });
                $('#table tbody').html(tableString);
                $('#table').DataTable();
			  }
			});
		}
	</script>
@endpush