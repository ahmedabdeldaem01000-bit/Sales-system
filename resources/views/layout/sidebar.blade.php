<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('dashboard')}}" class="brand-link">

    <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="pb-3 mt-3 mb-3 user-panel d-flex">
      <div class="image">
      </div>
      <div class="info">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      @if(auth()->user()->role === 'admin')
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                المنتجات
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('sales-report.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                تقارير المبيعات
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <!-- employee -->
          <li class="nav-item">
            <a href="{{ route('employee.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                تقرير مبيعات الجنود
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>


          <!-- المدينين -->
          <li class="nav-item">
            <a href="{{ route('debtor.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                تقرير المدينين
              </p>
            </a>
          </li>



        </ul>
      @endif



      @if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin')
        <li class="nav-item">
          <a href="{{ route('employee-products.index') }}" class="flex flex-row flex-wrap items-center gap-4 nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              بيع المنتجات
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
       
      @endif
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>