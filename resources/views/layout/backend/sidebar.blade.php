<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/public/components/adminlte-2.3.0/dist/img/user2-160x160.jpg" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Nguyễn Mạnh Vũ</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="{!! (Request::is('admin/dashboard')) ? 'active' : ''!!}">
                <a href="">
                    <i class="fa fa-th"></i> <span>Bảng tin</span>
                </a>
            </li>

            <li class="treeview {!! (Request::is('admin/item*')) ? 'active' : '' !!}">
                <a href="#">
                    <i class="fa fa-cart-plus"></i>
                    <span>Sản phẩm</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{!! (Request::is('admin/item/add')) ? 'active' : '' !!}"><a href="{!! route('admin::item::add') !!}"><i class="fa fa-circle-o"></i> Thêm</a></li>
                    <li class="{!! (Request::is('admin/item')) ? 'active' : '' !!}"><a href="{!! route('admin::item::index') !!}"><i class="fa fa-circle-o"></i> Tất cả sản phẩm</a></li>
                    <li class="{!! (Request::is('admin/item/category')) ? 'active' : '' !!}"><a href="{!! route('admin::item::category') !!}"><i class="fa fa-circle-o"></i> Danh mục</a></li>
                </ul>
            </li>

            <li class="treeview {!! (Request::is('admin/blog*')) ? 'active' : '' !!}">
                <a href="#">
                    <i class="fa fa-rss"></i>
                    <span>Bài viết</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{!! (Request::is('admin/blog/add')) ? 'active' : '' !!}"><a href="{!! route('admin::blog::add') !!}"><i class="fa fa-circle-o"></i> Thêm</a></li>
                    <li class="{!! (Request::is('admin/blog')) ? 'active' : '' !!}"><a href="{!! route('admin::blog::index') !!}"><i class="fa fa-circle-o"></i> Tất cả bài viết</a></li>
                    <li class="{!! (Request::is('admin/blog/category')) ? 'active' : '' !!}"><a href="{!! route('admin::blog::category') !!}"><i class="fa fa-circle-o"></i> Danh mục</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>