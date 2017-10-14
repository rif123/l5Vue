 <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dist/img/avatar.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#">{{date("F j, Y")}}</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-key"></i> <span>Check In / Out</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('checkin.index')}}"><i class="fa fa-circle-o"></i> Check In</a></li>
            <li><a href="{{route('checkin.checkout')}}""><i class="fa fa-circle-o"></i> Check Out</a></li>
            <li><a href="#""><i class="fa fa-circle-o"></i> Reservasi / Booking</a></li>
            <li><a href="{{route('checkin.tamu')}}""><i class="fa fa-circle-o"></i> Tamu In House</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Room Service</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('transaksilayanan.index')}}"><i class="fa fa-circle-o"></i> Pesan Layanan / Produk</a></li>
            <li><a href="{{route('transaksilayanan.create')}}""><i class="fa fa-circle-o"></i> Pembersihan Kamar</a></li>
          </ul>
        </li>
        <li><a href="{{route('berita.index')}}"><i class="fa fa-newspaper-o"></i> <span>Berita</span></a></li>
        @if(Gate::check('dev-access') || Gate::check('super-access') || Gate::check('admin-access'))
        <li class="header">ADMINISTRASI HOTEL</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bed"></i> <span>Kamar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('kamar.index')}}"><i class="fa fa-circle-o"></i> Lihat Kamar</a></li>
            <li><a href="{{route('typekamar.index')}}""><i class="fa fa-circle-o"></i> Tipe Kamar</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cutlery"></i> <span>Layanan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('layanan.index')}}"><i class="fa fa-circle-o"></i> Lihat Layanan</a></li>
            <li><a href="{{route('kategorilayanan.index')}}""><i class="fa fa-circle-o"></i> Kategori Layanan</a></li>
          </ul>
        </li>
        <li><a href="{{route('tamu.index')}}"><i class="fa fa-suitcase"></i> <span>Buku Tamu</span></a></li>
        <li><a href="{{route('user.index')}}"><i class="fa fa-user"></i> <span>User Manager</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-exchange"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('laporan','kamar')}}"><i class="fa fa-circle-o"></i> Laporan Kamar</a></li>
            <li><a href="{{route('laporan','layanan')}}""><i class="fa fa-circle-o"></i> Laporan Layanan</a></li>
          </ul>
        </li>
        @if(Gate::check('dev-access'))
        <li><a href="{{route('perusahaan.index')}}"><i class="fa fa-user"></i> <span>Perusahaan</span></a></li>
        @endif
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->