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
            <a href="{{route('home')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-cubes"></i>
              <p>
                صفحات المنتجات
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('product.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>المنتجات</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('product.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>انشاء منتج جديد</p>
                </a>
              </li>



            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-basket-shopping"></i>
              <p>
                صفحات المشتريات
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('purchase.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>صفحه المشتريات</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('product.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>مشريات جديده </p>
                </a>
              </li>



            </ul>
          </li>



          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-user-tie"></i>
              <p>
                الموظفين
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('employee.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>صفحه الموظفين</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('employee.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>انشاء موظفين </p>
                </a>
              </li>



            </ul>

          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-user-tie"></i>
              <p>
                الموردين
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('supplier.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>صفحه الموردين</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('supplier.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>موردين جديده </p>
                </a>
              </li>



            </ul>

          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-users"></i>
              <p>
                العملاء
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>صفحه العملاء</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>عملاء جديده </p>
                </a>
              </li>



            </ul>

          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-file-lines"></i>
              <p>
                التقسيط
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('installment.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> جدول التقسيط</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('installment.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> انشاء خطه جديده</p>
                </a>
              </li>




            </ul>

          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-file-lines"></i>
              <p>
                الطلبات
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> جدول الطلبات</p>
                </a>
              </li>
                <li class="nav-item">
          <a href="{{ route('order-create.index') }}" class="flex flex-row flex-wrap items-center gap-4 nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              انشاء طلبات
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>

           




            </ul>

          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-file-lines"></i>
              <p>
                تقارير
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right"></span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('sales-report.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> تقارير المبيعات</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('employee.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> تقرير مبيعات الموظفين</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('debtor.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> تقرير المدينين</p>
                </a>
              </li>



            </ul>

          </li>







        </ul>
      @endif



      @if(auth()->user()->role === 'employee')
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