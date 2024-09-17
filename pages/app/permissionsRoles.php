<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2> الصلاحيات والأدوار</h2>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-right">
                        <?php if ($add_role_permission) { ?>
                        <button class="btn btn-primary" id="addRole">اضافة دور جديد</button>
                        <?php } ?>
                        <?=CSRF::create_token();?>
                    </div>
                </div>
            

                <div class="card-body">
                    <div class="table-responsive">
                          <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>الاسم</th>
                                    <th>الصلاحيات</th>
                                    <th>التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $roles = DB::select('roles');
                                foreach ($roles as $i => $role) {
                                    $permissions = Permission::getPermissionsByRole($role['id']);
                                    $permissionBadges = '';
                                    foreach ($permissions as $permission) {
                                        $permissionBadges .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($permission['permission_name']) . '</span>';
                                    }
                                    if (empty($permissions)) {
                                        $permissionBadges = '<span class="badge badge-danger">لا يوجد صلاحيات</span>';
                                    }
                                    echo "<tr>
                                        <td>" . ($i + 1) . "#</td>
                                        <td>" . htmlspecialchars($role['role_name']) . "</td>
                                        <td>$permissionBadges</td>
                                        ";
                                        if ($role['id'] == 1) {
                                            echo "<td>
                                                <s[an class='badge badge-warning'>لا يمكن التعديل او الحذف</span>
                                            </td>";
                                        } else {
                                            echo "<td>
                                                <button type='button' class='btn btn-primary btn-sm EditRole' data-role-id='{$role['id']}'>تعديل</button>
                                                <button type='button' class='btn btn-danger btn-sm DeleteRole' data-role-id='{$role['id']}'>حذف</button>
                                            </td>";
                                        }
                                    echo "
                                    </tr>";
                                }
                                ?>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    


<!-- Modal templates -->
<template id="addRoleModalTemplate">
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addRoleForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">اضافة دور جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="roleName" class="col-sm-4 col-form-label">اسم الدور</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="roleName" name="roleName" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="addRoleButton">اضافة</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<template id="editRoleModalTemplate">
    <div class="modal fade" id="EditRoleAndPermissionsModal" tabindex="-1" role="dialog" aria-labelledby="EditRoleAndPermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="EditRoleAndPermissionsForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditRoleAndPermissionsModalLabel">تعديل الدور والصلاحيات</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="rolePermissions" class="col-sm-4 col-form-label">الصلاحيات</label>
                            <div class="col-sm-8 row" id="rolePermissions"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="EditRoleAndPermissionsButton">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
