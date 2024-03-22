<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#admin-basic" aria-expanded="false" aria-controls="admin-basic" >
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Admin</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="admin-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.index')}}">View all admin</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('admin.create')}}">Creat Admin</a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">Career</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{route('career.index')}}">View all Vacancy</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('career.create')}}">Creat Job</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Blog</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">View Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Create Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Create Tag</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Create Catogry</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Create Clients</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ِAdd User</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">View All User</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">Export data </a></li>
              </ul>
            </div>
          </li>
       
          
         
          
          
        </ul>
      </nav>