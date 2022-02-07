<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src={{asset("dist/img/serha_logo2.png")}} alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: 4">
      <span class="brand-text font-weight-light">E-Procurement</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src={{asset("dist/img/blank.png")}} class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">Hello {{auth()->user()->firstname}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview" >
            <a href="/dashboard" accesskey="1"  class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              
              </p>
            </a>
           
          </li>
          {{-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-truck"></i>
              <p>
               Requisition Tracker
              </p>
            </a>
          </li> --}}
          <li class="nav-item has-treeview">
            <a href="/internal_requisition" class="nav-link ">
              <i class="nav-icon fas fa-file"></i>
              <p>
               Internal Request
              </p>
            </a>
          </li>
          @if(in_array(auth()->user()->role_id,[1,9,12]))
          <li class="nav-item">
            <a href="/assign_requisition" class="nav-link">
              <i class="far fa-address-book nav-icon"></i>
              <p>Assign internal request</p>
            </a>
          </li>
          @endif
          @if(in_array(auth()->user()->role_id,[1,5,9,10,12]))
          <li class="nav-item has-treeview" class="{{Request::path()==='dashboard' ? 'current_page_item' :''}}">
            <a href="/requisition" accesskey="2"  class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Requisition
                
              </p>
            </a>
          </li>
          @endif
          @if(in_array(auth()->user()->role_id,[1,5,9,10,12]))
          <li class="nav-item has-treeview">
            <a href="/check-purchase" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Certify Requisition
              </p>
            </a>
          </li>
           @if(in_array(auth()->user()->role_id,[1,5,9,12]))
          <li class="nav-item has-treeview">
            <a href="/purchase-order" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Purchase Order
              </p>
            </a>
         
          </li>
          @endif
          @endif
          @if(in_array(Auth::user()->role_id, [1,2,5,8,9,10,11,12,13,14]))
          <li class="nav-item has-treeview">
            
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Approve
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array(Auth::user()->role_id, [1,2,11,12,13,14]))
              <li class="nav-item">
                <a href="/certify-internal-requisition" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Certify</p>
                </a>
              </li>
              @endif
              @if(in_array(Auth::user()->role_id, [1,3,2,10,11,12,14]))
              <li class="nav-item">
                <a href="/approve-internal-requisition" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Internal Requisition</p>
                </a>
              </li>
              @endif
              @if(in_array(Auth::user()->role_id, [1,3,9,10,11,12]))
              <li class="nav-item">
                <a href="/approve-requisition" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Requisition</p>
                </a>
              </li>
              @endif

              @if(in_array(Auth::user()->role_id, [1,3,5,8,9,12,14]))
              <li class="nav-item">
                <a href="/approve-budget-requisition" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approve Budget</p>
                </a>
              </li>
              @endif
              {{-- @if(in_array(Auth::user()->role_id, [1,3]))
                <li class="nav-item">
                <a href="/certifying-voucher" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Certifying PO</p>
                </a>
              </li> 
              @endif --}}
             
            </ul>
          </li>
          @endif
          @if(in_array(Auth::user()->role_id, [1,7,8,14]))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Accounts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/budgetcommitment" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Budget Commitment </p>
                </a>
              </li>
              {{-- @if(in_array(Auth::user()->role_id, [1]))
               <li class="nav-item">
                <a href="/payment-voucher" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Voucher</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/voucher-check" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Voucher Checked</p>
                </a>
              </li>
              @endif --}}
              {{-- <li class="nav-item">
                <a href="pages/forms/validation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Certifying Officer</p>
                </a>
              </li> --}}
            </ul>
          </li> 
          @endif
          @if(in_array(auth()->user()->role_id,[1,3,6,12]))
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-trailer"></i>
              <p>
                Audit
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               
          <li class="nav-item has-treeview" class="{{Request::path()==='dashboard' ? 'current_page_item' :''}}">
            <a href="/audit-trail" accesskey="2"  class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Audit Trail
                
              </p>
            </a>
          </li>
         
              <li class="nav-item">
                <a href="/trail-ipr" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trail IPR</p>
                </a>
              </li>
            </ul>
          </li>
           @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/general-report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Report</p>
                </a>
              </li>
              </ul>
             {{--  <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Institution</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Unit Of Measuremet</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Control</p>
                </a>
              </li>
            </ul> --}}
          </li>
          {{-- <li class="nav-header">Settings</li> --}}
          @if(in_array(Auth::user()->role_id, [1,3,5,9,12]) OR Auth::user()->role_id===2 And Auth::user()->department_id===1 )
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/department" class="nav-link">
                  <i class="far fa-building nav-icon"></i>
                  <p>Add Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/institution" class="nav-link">
                  <i class="far fa-building nav-icon"></i>
                  <p>Add Institution</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/suppliers" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/measurement" class="nav-link">
                  <i class="far fa-square nav-icon"></i>
                  <p>Add Measurement</p>
                </a>
              </li> <li class="nav-item">
                <a href="/unit" class="nav-link">
                  <i class="far fa-map nav-icon"></i>
                  <p>Add Units</p>
                </a>
              </li>
              @if(in_array(Auth::user()->role_id, [1,3,9,12]) OR Auth::user()->role_id===2 And Auth::user()->department_id===1  )
              <li class="nav-item">
                <a href="/user" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>User Control</p>
                </a>
              </li>
              @endif
              {{-- <li class="nav-item">
                <a href="/assign_requisition" class="nav-link">
                  <i class="far fa-address-book nav-icon"></i>
                  <p>Assign Requisition</p>
                </a>
              </li>
        --}}
          </li>
          
        </ul>
        <div class="nav-item">
                <a href="/logout" class="nav-link">
                {{-- <span><img src={{asset("dist/img/icons/account-logout-3x.png")}} class="img-circle elevation-1" alt="User Image"></span> --}}
                 <i class="far fa-edit nav-icon"></i> 
                <p>Logout</p>
                </a>
              </div>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>