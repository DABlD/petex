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
								<th>Rider</th>
								<th>Rider #</th>
								<th>Price</th>
								<th>Status</th>
								<th>ETA</th>
								<th>Schedule</th>
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
                { data: 'rfname', name: 'rfname' },
                { data: 'rcontact', name: 'rcontact' },
                { data: 'price', name: 'price' },
                { data: 'status', name: 'status' },
                { data: 'eta', name: 'eta' },
                { data: 'schedule', name: 'schedule' },
                { data: 'created_at', name: 'created_at' },
                @if(auth()->user()->role == "Seller")
                	{ data: 'actions', name: 'actions' },
                @endif
            ],
            columnDefs: [
                {
                    targets: [8],
                    render: function(date){
                    	date = date == null ? "ASAP" : date;
                        if(date != "ASAP"){
                        	return toDate(date);
                        }
                        else{
                        	return date;
                        }
                    }
                },
                {
                    targets: [9],
                    render: function(date){
                        return toDateTime(date);
                    }
                },
                {
                    targets: [7],
                    render: function(eta){
                        return eta == null ? "---" : eta;
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
                    render: function(a,b,row){
                        return row.rfname != null ? row.rfname + " " + row.rlname : "-----";
                    }
                },
                {
                	targets: [4],
                    render: function(a,b,row){
                        return row.rcontact ?? "-----";
                    }
                },
                {
                	targets: [5],
                    render: function(price){
                        return parseFloat(price).toFixed(2);
                    }
                },
                {
                	targets: [4],
                    render: function(status, x, row){
                    	if(row.status == "Rider Cancel" && row.rider_cancel == null){
                    		swal({
                    			type: 'info',
                    			title: `Delivery to ${row.fname} ${row.lname} on ${row.address} has been cancelled by the rider`
                    		}).then(() => {
					            $.ajax({
					              url: '{{ route('updateStatus') }}',
					              data: {
					                id: row.id,
					                rider_cancel: moment().format("YYYY-MM-DD hh:mm:ss"),
					              },
					              success: result => {
					              	console.log("rider_cancel", result);
					              }
					            });
                    		})
                    	}
                        return status;
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

	    	$('[data-original-title="Find Rider"]').on('click', elem => {
	    		swal('Finding Rider');
	    		swal.showLoading();

	    		$.ajax({
	    			url: "{{ route('getDriversLocation') }}",
	    			success: results => {
	    				results = JSON.parse(results);
	    				let result = [];
	    				
	    			    Object.keys(results).forEach(a => {
	    			        result.push(results[a]);
	    			    });

	    				if(result.length == 0){
	    					swal({
	    						type: 'error',
	    						title: 'No rider available at the moment',
	    						text: 'Try again later',
	    					});
	    				}
	    				else{
	    					if($(elem.target).data('schedule') == "ASAP"){
			    				var closest = {distance: 100000};
			    				var temp;
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
		            				    	if(rider.ave_ratings >= 60){
		            				    		closest = rider;
		            				    	}
		            				    	else{
		            				    		temp = rider;
		            				    	}
		            				    }
		            				}
			    				});

			    				setTimeout(() => {
			    					if(closest.id == undefined && temp != ""){
			    						closest = temp;
			    					}

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
			    								title: 'Rider Found!',
			    								text: 'Your delivery will be assigned to ' + closest.fname + " " + closest.lname,
			    							}).then(() => {
			    								$('#table').DataTable().ajax.reload();
			    							});
			    						}
			    					});
			    				}, 1500);
	    					}
	    					else{
	    						var selected;
			    				var temp;

			    				result.forEach(rider => {
            				    	if(rider.ave_ratings >= 60){
            				    		selected = rider;
            				    	}
            				    	else{
            				    		temp = rider;
            				    	}
			    				});

			    				setTimeout(() => {
			    					if(selected == undefined && temp != ""){
			    						selected = temp;
			    					}

			    					$.ajax({
			    						url: "{{ route("assignDriver") }}",
			    						data: {
			    							tid: selected.id,
			    							id: $(elem.target).data('id'),
			    							eta: eta
			    						},
			    						success: result => {
			    							swal({
			    								type: 'info',
			    								title: 'Rider Found!',
			    								text: 'Your delivery will be assigned to ' + selected.fname + " " + selected.lname,
			    							}).then(() => {
			    								$('#table').DataTable().ajax.reload();
			    							});
			    						}
			    					});
			    				}, 1500);
	    					}
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

	    	$('[data-original-title="Check Rider Location"]').on('click', elem => {
	    		let id = $(elem.target).data('id');
      			var markers = [];

	    		swal({
	    			html: '<div id="map" style="width: 100%; height: 50vh;"></div>',
	    			width: '80vh',
	    			onOpen: () => {
	    				navigator.geolocation.getCurrentPosition(position => {
	    				    slat = position.coords.latitude;
	    				    slng = position.coords.longitude;
	    				    initMap(slat, slng);
	    				});

	    				function initMap(slat, slng){
	    					markers.forEach((marker) => {
	    					  marker.setMap(null);
	    					});
	    					markers = [];

	    					$.ajax({
	    						url: "{{ route('getDriverLocation') }}",
	    						data: {
	    							id: id
	    						},
	    						success: result => {
	    							result = JSON.parse(result);
	    							let rloc = {lat: parseFloat(result.rlat), lng: parseFloat(result.rlng)};

	    							map = new google.maps.Map(document.getElementById("map"), {
	    							    center: rloc,
	    							    zoom: 12,
	    							});

							        directionsService = new google.maps.DirectionsService();
							        directionsRenderer = new google.maps.DirectionsRenderer();

									directionsService2 = new google.maps.DirectionsService();
									directionsRenderer2 = new google.maps.DirectionsRenderer();

									directionsRenderer2.setMap(map);

									let request2 = {
										origin: rloc,
										destination: {lat: slat, lng:slng},
										travelMode: 'DRIVING'
									};

									directionsService2.route(request2, function(result, status) {
										if (status == 'OK') {
											directionsRenderer2.setOptions({
											    polylineOptions: {
											      	strokeColor: 'red'
											    }
											}); 
											directionsRenderer2.setDirections(result);
										}
									});

	    							// let dMarker = new google.maps.Marker({
	    							//   position: loc,
	    							//   map,
	    							//   label: {
	    							//     color: 'white',
	    							//     text: 'R'
	    							//   }
	    							// });

                      				markers.push(dMarker);
	    						}
	    					});

	    					setTimeout(() => {
	    						initMap(slat, slng);
	    					}, 5000);
	    				}
	    			}
	    		});
	    	});

	    	$('[data-original-title="View Files"]').on('click', user => {
	    		let temp = $(user.target).data('files');

	    		if(temp == "``"){
	    			swal({
	    				type: 'warning',
	    				title: "No Files Submitted",
	    				timer: 1500,
	    				showConfirmButton: false
	    			});
	    		}
	    		else{
		    		let files = JSON.parse(temp.replace(/`/gi, ''));
		    		// let files = $(user.target).data('files').replace(/`/gi, '\'');
		    		swal({
		    			width: "100vh",
		    			html: `
		    				<a target="_blank" href="${files[0]}">
		    					<img src="${files[0]}" style="width: 50vh; height: 50vh;">
		    				</a>
		    				<a target="_blank" href="${files[0]}">
		    					<img src="${files[1]}" style="width: 50vh; height: 50vh;">
		    				</a>
		    			`
		    		})
	    		}
	    	});

	    	$('[data-original-title="Rate Rider"]').on('click', e => {
	    		let temp = $(e.target);
	    		let id = temp.data('id');
	    		let oRating = temp.data('rating');

	    		swal({
	    			html: `
	    				<span class="fa fa-star fa-3x" id="1"></span>
	    				<span class="fa fa-star fa-3x" id="2"></span>
	    				<span class="fa fa-star fa-3x" id="3"></span>
	    				<span class="fa fa-star fa-3x" id="4"></span>
	    				<span class="fa fa-star fa-3x" id="5"></span>
	    			`,
	    			onOpen: () => {

    					for(let i = 0; i < oRating; i++){
    						$($('*[id].fa-star')[i]).addClass('checked');
    					}

	    				$('.fa-star').on('click', e => {
	    					let rating = $(e.target).attr('id');

	    					$('*[id].fa-star.checked').each((a,b) => {
	    						$(b).removeClass('checked');
	    					})

	    					for(let i = 0; i < rating; i++){
	    						$($('*[id].fa-star')[i]).addClass('checked');
	    					}
	    				})
	    			}
	    		}).then(result => {
	    			if(result.value){
	    				$.ajax({
	    				  url: '{{ route('updateStatus') }}',
	    				  data: {
	    				    id: id,
	    				    rating: $('*[id].fa-star.checked').length,
	    				  },
	    				  success: result => {
	    				    setTimeout(() => {
	    				      swal({
	    				        type: 'success',
	    				        title: 'Success',
	    				        text: 'Completed!',
	    				        showConfirmButton: false,
	    				        timer: 1200
	    				      });

    							renewTable();
	    				    });
	    				  }
	    				});
	    			}
	    		})
	    	});

	    	$('[data-original-title="View Proof of Delivery"]').on('click', e => {
	    		let proof = $(e.target).data('proof');

	    		if(proof == ""){
	    			swal({
	    				type: 'warning',
	    				title: "No Proof Submitted",
	    				timer: 1500,
	    				showConfirmButton: false
	    			});
	    		}
	    		swal({
	    			width: "100vh",
	    			html: `
	    				<a target="_blank" href="${proof}">
	    					<img src="${proof}" style="width: 50vh; height: 50vh;">
	    				</a>
	    			`
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

    	renewETA();
    	function renewETA(){
    		$.ajax({
    			url: '{{ route('getAll') }}',
    			data: {
    				cond: JSON.stringify([
    					["status", 'LIKE', "For %"],
    				]),
    				fields: JSON.stringify(["id", "sid", "tid"])
    			},
    			success: transactions => {
    				transactions = JSON.parse(transactions);

    				transactions.forEach(transaction => {
	    				rider = [];
	    				seller = [];

	    				$.ajax({
	    					url: '{{ route("getDriverLocation") }}',
	    					data: {
	    						id: transaction.tid,
	    						fields: JSON.stringify(["trackers.lat", 'trackers.lng'])
	    					},
	    					success: result => {
	    						rider = JSON.parse(result);

	    						// rider.lat = rider.lat.toString();
	    						// rider.lng = rider.lng.toString();
	    					}
	    				});

	    				$.ajax({
	    					url: '{{ route("getUserAddress") }}',
	    					data: {id: transaction.sid},
	    					success: result => {
	    						seller = JSON.parse(result);

	    						seller.lat = parseFloat(seller.lat);
	    						seller.lng = parseFloat(seller.lng);
	    					}
	    				}).done(() => {
	    					// DISTANCE
        					let distance = new google.maps.DistanceMatrixService();
        					
	    					distance.getDistanceMatrix({
	    						origins: [rider],
	    						destinations: [seller],
	    						travelMode: 'DRIVING',
	    					}, callback);

	    					function callback(response, status) {
	    						$.ajax({
	    							url: '{{ route("updateStatus") }}',
	    							data: {
	    								id: transaction.id,
	    								eta: response.rows[0].elements[0].duration.text
	    							}
	    						}).done(() => {
	    							setTimeout(() => {
	    								renewETA();
	    							}, 5000);
	    						})
	    					}
	    				});
    				});
    			}
    		})
    	}

    	checkBookings();
    	function checkBookings(){
    		$.ajax({
    			url: '{{ route('getAll') }}',
    			data: {
    				cond: JSON.stringify([
    					["status", '=', "Finding Driver"],
    				]),
    				fields: JSON.stringify(["id", "created_at"])
    			},
    			success: transactions => {
    				transactions = JSON.parse(transactions);

    				transactions.forEach(transaction => {
    					if(moment.duration(moment().diff(moment(transaction.created_at))).asMinutes() >= 1){
    						$.ajax({
    							url: '{{ route("updateStatus") }}',
    							data: {
    								id: transaction.id,
    								status: "Cancelled"
    							}
    						})
    					}
    				});
    			}
    		})
    	}
	</script>
@endpush