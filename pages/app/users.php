<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>المستخدمين</h2>
      </div>
    </div>
  </div>
</div>



<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>جدول المستخدمين</h5>
          <div class="card-header-right">
            <a href="?p=addUser" class="btn btn-primary">اضافة مستخدم</a>
          </div>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display table dataTable" id="UsersList">
              <thead>
                <tr>
                  <th style="width: 10%;">#</th>
                  <th>الاسم المستخدم</th>
                  <th>الاسم الكامل </th>
                  <th>البريد الالكتروني</th>
                  <th>الدور</th>
                  <th>الحالة</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $users = DB::select('users');
                $i = 1;

                foreach ($users as $user) {
                  ?>
                  <tr id="userRow<?=$user['id']?>">
                    <td><?=$i++?></td>
                    <td><?=$user['username']?></td>
                    <td><?=$user['fr_name']?> <?=$user['ls_name']?></td>
                    <td><?=$user['email']?></td>
                    <td>

                        <?php
                        $role = User::getUserRoles($user['id']);

                        if ($role) {
                            echo '<span class="badge badge-primary">' . $role[0]['role_name'] . '</span>';
                        } else {
                            echo '<span class="badge badge-danger">لا يوجد دور</span>';
                        }
                        ?>


                    </td>
                    <td>
                        <?php
                        if ($user['access'] == 1) {
                            echo '<span class="badge badge-success">مفعل</span>';
                        } else {
                            echo '<span class="badge badge-danger">غير مفعل</span>';
                        }
                        ?>
                    </td>
                    <td>
                    <?php
                    if ($user['id'] != 1) {
                        ?>
                   
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">العمليات</button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item " href="?p=editUser&id=<?=$user['id']?>">تعديل</a>
                            <a class="dropdown-item deleteUser" href="#" data-id="<?=$user['id']?>">حذف</a>
                          </div>
                        </div>
                      
                      <?php
                    } else {
                        ?>
                        <span class="badge badge-warning"> هذا المستخدم لا يمكن حذفه أو تعديله</span>
                        <?php
                        }
                        ?>
                    </td>
                  </tr>
                  <?php
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