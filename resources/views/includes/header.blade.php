
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
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
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