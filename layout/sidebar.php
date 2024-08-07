<div class="iconsidebar-menu">
  <div class="sidebar">
    <ul class="iconMenu-bar custom-scrollbar">
      <li><a class="bar-icons" href="#"><i class="pe-7s-home"></i><span>رئيسية</span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">لوحة التحكم</li>
          <li><a href="/">الرئيسية</a></li>
        </ul>
      </li>

      <?php if ($show_scout) { ?>
      <li><a class="bar-icons" href="#"><i class="pe-7s-users"></i><span>المنخرطين</span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">المنخرطين</li>
          <li><a href="/?p=members">عرض المنخرطين</a></li>
          <?php if ($add_scout) { ?>
          <li><a href="/?p=addMember">اضافة منخرط</a></li>
          <?php } ?>
          <?php if ($delete_scout) { ?>
          <li><a href="/?p=MemberArchive">الأرشيف (الحذف)</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <?php if ($show_insurance) { ?>
      <li><a class="bar-icons" href="#"><i class="pe-7s-cash"></i><span>التأمينات</span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">التأمينات</li>
          <li><a href="/?p=insurances">عرض التأمينات</a></li>
          <?php if ($add_insurance) { ?>
          <li><a href="/?p=addInsurance">اضافة تأمين</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <?php if ($show_uniform) { ?>
      <li><a class="bar-icons" href="#"><i class="pe-7s-note2"></i><span>الزي</span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">الزي</li>
          <li><a href="/?p=uniforms">عرض الزي</a></li>
          <?php if ($add_uniform) { ?>
          <li><a href="/?p=addUniform">اضافة زي</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>




      <?php if ($show_users) { ?>

      <li><a class="bar-icons" href="#"><i class="pe-7s-users"></i><span>المستخدمين</span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">المستخدمين</li>
          <li><a href="/?p=users">عرض المستخدمين</a></li>
          <?php if ($add_user) { ?>
          <li><a href="/?p=addUser">اضافة مستخدم</a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <li><a class="bar-icons" href="#"><i class="pe-7s-settings"></i><span>الاعدادات </span></a>
        <ul class="iconbar-mainmenu custom-scrollbar">
          <li class="iconbar-header">الاعدادات</li>
          <li><a href="/?p=settings">اعدادات الحساب</a></li>
          <?php if ($edit_website_settings) { ?>
          <li><a href="/?p=settingsSystem">اعدادات الموقع</a></li>
          <?php } ?>
          <?php if ($edit_insurance_settings) { ?>
          <li><a href="/?p=settingsInsurance">اعدادات التأمين</a></li>
          <?php } ?>
          <?php if ($show_role_permission) { ?>
          <li><a href="/?p=permissionsRoles">الصلاحيات والأدوار</a></li>
          <?php } ?>
        </ul>
      </li>
      
    </ul>
  </div>
</div>