@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('booking.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								{{-- <th>Transaction ID</th> --}}
								<th>Name</th>
								<th>Contact</th>
								<th>Address</th>
								<th>Price</th>
								<th>Status</th>
								<th>Listed On</th>
								@if(auth()->user()->role == "Seller")
								<th>Action</th>
								@endif
							</tr>
						</thead>
					</table>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{ route('datatables.transactions') }}',
            columns: [
                // { data: 'tid', name: 'tid' },
                { data: 'fname', name: 'fname' },
                { data: 'contact', name: 'contact' },
                { data: 'address', name: 'address' },
                { data: 'price', name: 'price' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                @if(auth()->user()->role == "Seller")
                { data: 'actions', name: 'actions' },
                @endif
            ],
            columnDefs: [
                {
                    targets: [5],
                    render: function(date){
                        return toDateTime(date);
                    }
                },
                {
                	targets: [0],
                    render: function(a,b,row){
                        return row.fname + " " + row.lname;
                    }
                },
                {
                	targets: [3],
                    render: function(price){
                        return parseFloat(price).toFixed(2);
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            	initializeActions();
            },
            // order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
        	setTimeout(() => {
        		$('.preloader').fadeOut();
        	}, 800);
        });

        // MAPS
        var distance;

        function initializeActions(){
	    	$('[data-original-title="View User"]').on('click', user => {
	    		$.ajax({
	    			url: 'users/get/' + $(user.target).data('id'),
	    			success: user => {
	    				user = JSON.parse(user);
	    				let fields = "";

	    				let names = [
	    					'First Name', 'Middle Name', 'Last Name', 
	    					'Birthday', 'Gender', 'Role',
	    					'Contact', 'Created At'
	    				];

	    				let columns = [
	    					'fname', 'mname', 'lname',
	    					'birthday', 'gender', 'role',
	    					'contact', 'created_at'
	    				];

	    				$.each(Object.keys(user), (index, key) => {
	    					let temp = columns.indexOf(key);
	    					if(temp >= 0){
	    						fields += `
									<div class="row">
										<div class="col-md-3">
											<h5><strong>` + names[temp] + `</strong></h5>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" value="` + user[key]+ `" readonly/>
										</div>
									</div>
									<br id="` + key + `">
								`;
	    					}
	    				});

	    				swal({
	    					title: 'User Details',
	    					width: '50%',
	    					html: `
	    						<br><br>
								<div class="row">
									<div class="col-md-3">
										<img src="` + user.avatar + `" alt="User Avatar" height="120px"/>
									</div>
									<div class="col-md-9">
										` + fields + `
									</div>
								</div>
	    					`,
	    					onBeforeOpen: () => {
	    						// CUSTOM FIELDS
	    						$(`	<div class="row">
										<div class="col-md-3">
											<h5><strong>Address</strong></h5>
										</div>
										<div class="col-md-9">
											<textarea type="text" class="form-control" readonly>`+ user.address +`</textarea>
										</div>
									</div>
									<br id="address">`).insertAfter($('#role'));

	    						$('h5').css('text-align', 'left');

	    						// OPTIONAL
	    						$('textarea').css('resize', 'none');

	    						// MODIFIERS
	    						let birthday = $($('#birthday')[0].previousElementSibling).find('.form-control');
	    						birthday.val(toDate(birthday.val()));

	    						let created_at = $($('#created_at')[0].previousElementSibling).find('.form-control');
	    						created_at.val(toDateTime(created_at.val()));
	    					}
	    				});
	    			}
	    		});
	    	});

	    	$('[data-original-title="Cancel"]').on('click', elem => {
	    		if($(elem.target).data('status') == "Cancelled"){
	    			swal({
	    				type: 'info',
	    				title: 'This transaction has already been cancelled',
	    				timer: 1500,
	    				showConfirmButton: false
	    			})
	    		}
	    		else if($(elem.target).data('status') == "Delivered"){
	    			swal({
	    				type: 'info',
	    				title: 'This transaction has already been completed',
	    				timer: 1500,
	    				showConfirmButton: false
	    			})	
	    		}
	    		else{
		    		swal({
		    			type: 'warning',
		    			title: 'Are you sure you want to cancel?',
		    			showCancelButton: true,
		    			allowOutsideClick: false,
		    			cancelButtonColor: '#f76c6b',
		    		}).then(choice => {
		    			if(choice.value){
		    				$.ajax({
		    					url: "cancel/" + $(elem.target).data('id'),
		    					success: result => {
		    						$('#table').DataTable().ajax.reload();

		    						swalNotification(
		    							result? 'success' : 'error',
		    							result? 'Successfully Cancelled' : 'Try Again',
		    						);
		    					}
		    				});
		    			}
		    		});
	    		}
	    	});

	    	$('[data-original-title="Find Driver"]').on('click', elem => {
	    		swal('Finding Driver');
	    		swal.showLoading();

	    		$.ajax({
	    			url: "{{ route('getDriversLocation') }}",
	    			success: result => {
	    				result = JSON.parse(result);

	    				if(result.length == 0){
	    					swal({
	    						type: 'error',
	    						title: 'No driver available at the moment',
	    						text: 'Try again later',
	    					});
	    				}
	    				else{
		    				var closest = {distance: 10};
		    				var eta = "0";

		    				result.forEach(rider => {
	            				distance = new google.maps.DistanceMatrixService();

	            				distance.getDistanceMatrix(
	            				  {
	            				    origins: [
	            				    	{
	            				    		lat: parseFloat(rider.lat),
	            				    		lng: parseFloat(rider.lng)
	            				    	}
	            				    ],
	            				    destinations: [
	            				    	{
	            				    		lat: parseFloat(rider.lat2),
	            				    		lng: parseFloat(rider.lng2)
	            				    	}
	            				    ],
	            				    travelMode: 'DRIVING',
	            				  }, callback);

	            				function callback(response, status) {
	            					eta = response.rows[0].elements[0].duration.text;
	            				    rider.distance = (response.rows[0].elements[0].distance.value / 1000).toFixed(2);
	            				    if(rider.distance < closest.distance){
	            				    	closest = rider;
	            				    }
	            				}
		    				});

		    				setTimeout(() => {
		    					$.ajax({
		    						url: "{{ route("assignDriver") }}",
		    						data: {
		    							tid: closest.id,
		    							id: $(elem.target).data('id'),
		    							eta: eta
		    						},
		    						success: result => {
		    							swal({
		    								type: 'info',
		    								title: 'Driver Found!',
		    								text: 'Your delivery will be assigned to ' + closest.fname + " " + closest.lname,
		    							}).then(() => {
		    								$('#table').DataTable().ajax.reload();
		    							});
		    						}
		    					});
		    				}, 1000);
	    				}
	    				
	    			}
	    		});
	    	});

	    	$('[data-original-title="Already Picked-Up"]').on('click', elem => {
	    		swal('Processing');
	    		swal.showLoading();

	    		let id = $(elem.target).data('id');

	    		$.ajax({
	    			url: "{{ route('updateStatus') }}",
	    			data: {
	    				id: id,
	    				status: 'For Delivery',
	    				pickup_time: moment().format('Y-MM-DD H:m:s')
	    			},
	    			success: result => {
			            swal({
			              type: 'success',
			              title: 'Success',
			              text: 'Completed!',
			              showConfirmButton: false,
			              timer: 2000
			            });

		    			$('#table').DataTable().ajax.reload();
	    			}
	    		})
	    	});
        };

    	// setTimeout(() => {
    		renewTable();
    	// }, 1000);

    	function renewTable(){
	    	$('#table').DataTable().ajax.reload();
	    	setTimeout(() => {
	    		renewTable();
	    	}, 10000);
    	}
	</script>
@endpush