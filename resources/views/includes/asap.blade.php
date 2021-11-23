

<div class="row">
  <section class="col-lg-12">
    <div class="box box-info">

      <div class="box-header with-border">
        <h3 class="box-title" style="color: red;">No Delivery</h3>
        <h4 style="color: black;">Comments: <span style="color: black;" class="comments"></span></h4>
        <h4 style="color: black;" class="hidden">Name of Seller: <span style="color: black;" class="sname"></span></h4>
        <h4 style="color: black;" class="hidden">Contact of Seller: <span style="color: black;" class="scontact"></span></h4>

        <div class="pull-right" style="position: absolute; top: 5px; right: 5px;">
           <a class="btn btn-success hidden delivery" data-toggle="tooltip" title="Complete Delivery" data-id="">
            <span class="fa fa-thumbs-up delivery" data-id=""></span>
          </a>
        </div>

        <div class="pull-right" style="position: absolute; top: 5px; right: 5px;">

            <a class="btn btn-success pickedUp hidden" data-toggle="tooltip" title="Already Picked-Up" data-id="">
              <span class="fa fa-hand-paper-o pickedUp hidden" data-id=""></span>
            </a>

           <a class="btn btn-danger cancelBooking hidden" data-toggle="tooltip" title="Decline Booking" data-id="">
            <span class="fa fa-times cancelBooking hidden" data-id=""></span>
          </a>
        </div>
        

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