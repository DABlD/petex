

<div class="row">
  <section class="col-lg-12">
    <div class="box box-info">

      <div class="box-header with-border">
        <table class="table table-hover table-bordered table-responsive" id="table" style="width: 100%;">
			<thead>
				<tr>
					{{-- <th>Transaction ID</th> --}}
					<th>Seller</th>
					<th>Contact</th>
					<th>Address</th>
					<th>Customer</th>
					<th>Contact</th>
					<th>Address</th>
					<th>Price</th>
					<th>Status</th>
					<th>ETA</th>
					<th>Schedule</th>
					<th>Listed On</th>
				</tr>
			</thead>
		</table>
      </div>

      {{-- 
      <div class="col-md-12">
        <canvas id="chart-1"></canvas>
      </div> --}}

      <div class="box-body">
          <div id="map" style="width: 100%; height: 50vh; position: block;"></div>
      </div>
      <div class="box-footer clearfix">
      </div>

    </div>
  </section>
</div>

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
@endpush

@push('after-scripts')
  <script>
    let table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{ route('datatables.scheduled_booking') }}',
            columns: [
                // { data: 'tid', name: 'tid' },
                { data: 'sfname', name: 'sfname' },
                { data: 'scontact', name: 'scontact' },
                { data: 'saddress', name: 'saddress' },
                { data: 'fname', name: 'fname' },
                { data: 'contact', name: 'contact' },
                { data: 'address', name: 'address' },
                { data: 'price', name: 'price' },
                { data: 'status', name: 'status' },
                { data: 'eta', name: 'eta' },
                { data: 'schedule', name: 'schedule' },
                { data: 'created_at', name: 'created_at' },
            ],
            columnDefs: [
                {
                  	targets: [0],
                    render: function(a,b,row){
                        return row.sfname + " " + row.slname;
                    }
                },
                {
                  	targets: [3],
                    render: function(a,b,row){
                        return row.fname + " " + row.lname;
                    }
                },
                {
                  	targets: [7],
                    render: function(status, x, row){
                        return status;
                    }
                },
                {
                  	targets: [4],
                    render: function(a,b,row){
                        return row.contact ?? "-----";
                    }
                },
                {
                  	targets: [6],
                    render: function(price){
                        return parseFloat(price).toFixed(2);
                    }
                },
                {
                    targets: [8],
                    render: function(eta){
                        return eta == null ? "---" : eta;
                    }
                },
                {
                    targets: [9],
                    render: function(date){
                      date = date == null ? "ASAP" : date;
                        if(date != "ASAP"){
                          return moment(date).format("MMM DD, YYYY h:mm A");
                        }
                        else{
                          return date;
                        }
                    }
                },
                {
                    targets: [10],
                    render: function(date){
                        return moment(date).format("MMM DD, YYYY h:mm A");
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            },
            // order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
          setTimeout(() => {
            $('.preloader').fadeOut();
          }, 800);
        });
  </script>
@endpush