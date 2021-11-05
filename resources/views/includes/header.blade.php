
  <header class="main-header">
    <a href="index2.html" class="logo">
      <span class="logo-mini">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="height: 30px; width: 30px;">
      </span>
      <span class="logo-lg">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="width: 150px; height: 45px;">
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset(auth()->user()->avatar)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ auth()->user()->fullname }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ asset(auth()->user()->avatar)}}" class="img-circle" alt="User Image">
                <p>
                  {{ auth()->user()->fullname }}
                  <small>Member since {{ auth()->user()->created_at->format('M. d, Y') }}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" id="profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  @push('after-scripts')
    <script>
      $('#profile').on('click', () => {
        $.ajax({
          url: '{{ route('users.get', ['user' => auth()->user()->id]) }}',
          success: result => {
            let user = JSON.parse(result);

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
                $(` <div class="row">
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
                birthday.val(moment(birthday.val()).format('MMM. DD, YYYY'));

                let created_at = $($('#created_at')[0].previousElementSibling).find('.form-control');
                created_at.val(moment(created_at.val()).format('MMM. DD, YYYY h:mm A'));
              }
            });
          }
        })
      });
    </script>
  @endpush