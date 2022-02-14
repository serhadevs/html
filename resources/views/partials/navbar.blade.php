 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/dashboard" class="nav-link">Home</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
      
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
       
      <li class="nav-item dropdown">
        <a class="nav-link" style="color:blue">
        @if(auth::user()->institution=== null)
          All Institution
        @else
          {{auth::user()->institution->name}}
        @endif
        </a>       
      </li> 
     
       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          {{-- <div class="dropdown-divider"></div> --}}
          @if(in_array(auth::user()->role_id,[1,3,6,10,11,12,14]))
          <a href="/change-institution" class="dropdown-item">
            <i class="fas fa-building mr-2"></i>Change Institution
            
          </a>
          @endif
          <div class="dropdown-divider"></div>
          <a href="/change-password" class="dropdown-item">
            <i class="fas fa-file mr-2"></i>Change Password
      
          </a>
          <div class="dropdown-divider"></div>
          <a href="/logout" class="dropdown-item">
            <i class="far fa-edit mr-2"></i>Logout
      
          </a>




         
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">{{auth()->user()->notifications->count()}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">{{auth()->user()->notifications->count()}} Notifications</span>
               <div class="dropdown-divider"></div>
           
               @if(auth()->user()->notifications->count() !== 0)
              <a href="#" class="dropdown-item">
               <i class="fas fa-envelope mr-2"></i>
              <span class="float-right text-muted text-sm"></span>
              </a>

              {{-- <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{\App\Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionPublish')->count()}} {{substr(\App\Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionApprovePublish')->get()[0]->type,18,26)}}
                {{-- <i class="fas fa-envelope mr-2"></i> {{$internalRequisitionApprove->count()}} {{substr($internalRequisitionApprove[0]->type,18,26) }} --}}
                {{-- <span ="float-right text-muted text-sm"></span>
                </a> --}}
              @endif
              {{-- substr($n->type,18,19) --}}
              {{-- <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
            </div> 
          </li>
          
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
    
  </nav>