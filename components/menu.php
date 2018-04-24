<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
  <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
  <!-- BEGIN: Aside Menu -->
<div
id="m_ver_menu"
class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
data-menu-vertical="true"
data-menu-scrollable="false" data-menu-dropdown-timeout="500"
>
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

      <li class="m-menu__section">
        <h4 class="m-menu__section-text">
          Components
        </h4>
        <i class="m-menu__section-icon flaticon-more-v3"></i>
      </li>
      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="send.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-paper-plane"></i>
          <span class="m-menu__link-text">
            Send Key
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>
      
      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="send-bulk.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-paper-plane"></i>
          <span class="m-menu__link-text">
            Send Keys In Bulk
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>

      <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="active.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-visible"></i>
          <span class="m-menu__link-text">
            View Active Keys
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>
      
      <li class="m-menu__item  m-menu__item--submenu <?php echo $superadmin ?>" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="log.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-interface-1"></i>
          <span class="m-menu__link-text">
            View Log
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>
      
      <li class="m-menu__item  m-menu__item--submenu <?php echo $superadmin ?>" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="user-management.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-user"></i>
          <span class="m-menu__link-text">
            User Management
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>
      
      <li class="m-menu__item  m-menu__item--submenu <?php echo $superadmin ?>" aria-haspopup="true"  data-menu-submenu-toggle="hover">
        <a  href="register-user.php" class="m-menu__link">
          <i class="m-menu__link-icon flaticon-user-add"></i>
          <span class="m-menu__link-text">
            Register User
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
      </li>


  </div>
  <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
