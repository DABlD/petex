@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('users.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th>Email</th>
								<th>Birthday</th>
								<th>Contact</th>
								<th>Created At</th>
								<th>Action</th>
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
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{ route('datatables.users') }}',
            columns: [
                { data: 'fullname', name: 'fullname' },
                { data: 'role', name: 'role' },
                { data: 'email', name: 'email' },
                { data: 'birthday', name: 'birthday' },
                { data: 'contact', name: 'contact' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: [3,5],
                    render: function(date){
                        return toDate(date);
                    }
                },
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

		function filterGlobal () {
		    $('#table').DataTable().search(
		        $('#global_filter').val(),
		        $('#global_regex').prop('checked'),
		        $('#global_smart').prop('checked')
		    ).draw();
		}
		 
		function filterColumn ( i ) {
		    $('#table').DataTable().column( i ).search(
		        $('#col'+i+'_filter').val(),
		        $('#col'+i+'_regex').prop('checked'),
		        $('#col'+i+'_smart').prop('checked')
		    ).draw();
		}
		 
		$(document).ready(function() {
		 
		    $('input.global_filter').on( 'keyup click', function () {
		        filterGlobal();
		    } );
		 
		    $('input.column_filter').on( 'keyup click', function () {
		        filterColumn( $(this).parents('tr').attr('data-column') );
		    } );
		} );

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

	    	$('[data-original-title="Edit User"]').on('click', user => {
	    		window.location.href = "users/edit/" + $(user.target).data('id');
	    	});

	    	$('[data-original-title="Disable User"]').on('click', user => {
	    		swal({
	    			type: 'warning',
	    			title: 'Are you sure you want to disable this user?',
	    			showCancelButton: true,
	    			allowOutsideClick: false,
	    			cancelButtonColor: '#f76c6b',
	    		}).then(choice => {
	    			if(choice.value){
	    				$.ajax({
	    					url: 'users/disable/' + $(user.target).data('id'),
	    					success: result => {
	    						$('#table').DataTable().ajax.reload();

	    						swalNotification(
	    							result? 'success' : 'error',
	    							result? 'Successfully disabled' : 'Try Again',
	    						);
	    					}
	    				});
	    			}
	    		});
	    	});

	    	$('[data-original-title="Activate User"]').on('click', user => {
	    		swal({
	    			type: 'warning',
	    			title: 'Are you sure you want to activate this user?',
	    			showCancelButton: true,
	    			allowOutsideClick: false,
	    			cancelButtonColor: '#f76c6b',
	    		}).then(choice => {
	    			if(choice.value){
	    				$.ajax({
	    					url: 'users/activate/' + $(user.target).data('id'),
	    					success: result => {
	    						$('#table').DataTable().ajax.reload();

	    						swalNotification(
	    							result? 'success' : 'error',
	    							result? 'Successfully activated' : 'Try Again',
	    						);
	    					}
	    				});
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
        };
	</script>
@endpush