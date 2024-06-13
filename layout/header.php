<div class="main-header-right">
  <div class="main-header-left text-center">
    <div class="logo-wrapper"><a href="/"><img src="<?=$urlUploads?><?=$settings['logo']?>" alt="" style="width: 30px;"></a></div>
  </div>
  <div class="mobile-sidebar">
    <div class="media-body text-right switch-sm">
      <label class="switch ml-3"><i class="font-primary" id="sidebar-toggle" data-feather="align-center"></i></label>
    </div>
  </div>
  <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar"></i></div>
  <div class="nav-right col pull-right right-menu">
    <ul class="nav-menus">    
      <li>
        <div class="form-inline search-form">
          <div class="form-group">
            <div class="Typeahead Typeahead--twitterUsers">
              <div class="u-posRelative">
                <input class="Typeahead-input form-control-plaintext" id="SearchMembers" type="text" name="q" placeholder="بحث عن منخرط"  dir="rtl">
                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">تحميل</span></div><span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
              </div>
              <div class="Typeahead-menu">
             
              </div>
            </div>
          </div>
        </div>
      </li>
      <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
      <li></li>
      <li class="onhover-dropdown"> 
        <span class="media user-header"><img class="img-fluid" src="<?=$urlUploads?><?=$profile['avatar']?>" alt="" style="width:60px  !important;height: 60px !important;border-radius: 50%;"></span>
        <ul class="onhover-show-div profile-dropdown">
          <li class="gradient-primary">
            <h5 class="f-w-600 mb-0"><?=$profile['fr_name']?> <?=$profile['ls_name']?></h5>
          </li>
          <li><a href="?p=settings"><i data-feather="settings"></i>الاعدادات</a></li>
          <li id="LogOut"><i data-feather="log-out"></i>تسجيل الخروج</li>
        </ul>
      </li>
    </ul>
    <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
  </div>

</div>