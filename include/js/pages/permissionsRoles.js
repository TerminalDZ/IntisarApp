// permissionsRoles.js
$(document).ready(function() {
    const dataTable = $('#dataTable').DataTable({
        language: {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ سجل",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sSearch": "ابحث:",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            },
            "sInfoEmpty": "عرض 0 الى 0 من 0 سجل",
            "sInfoFiltered": "(فلترة من اصل _MAX_ )",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "جاري التحميل...",
            "oAria": {
                "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
            },
            "buttons": {
                "copy": "نسخ",
                "colvis": "الاختيار",
                "print": "طباعة",
                "excel": "اكسيل",
                "pdf": "بي.دي.اف"
            },
            "select": {
                "rows": {
                    _: "تم تحديد %d أسطر",
                    0: "تفضل بتحديد سطر للتحديد",
                    1: "تم تحديد سطر"
                }
            }
        },
        processing: true,
        paging: false,
    });

    function showNotification(message, type) {
        $.notify({
            message: `<strong>${message}</strong>`
        }, {
            type: type,
            z_index: 999999999
        });
    }

    function reloadPage() {
        setTimeout(() => location.reload(), 1000);
    }

    function ajaxRequest(url, data, successCallback, ShowNotification = true) {
        $.ajax({
            url: url,
            type: "POST",
            data: { ...data, token: $('#token').val() },
            success: function(response) {
                const responseData = JSON.parse(response);
                if (ShowNotification){
                    showNotification(responseData.message, responseData.status === "success" ? 'success' : 'danger');
                }
                
                if (responseData.status === "success" && successCallback) {
                    successCallback(responseData);
                }
            }
        });
    }

    // Add Role
    $('#addRole').click(function() {
        if ($('#addRoleModal').length === 0) {
            $('body').append($('#addRoleModalTemplate').html());
        }
        $('#addRoleModal').modal('show');
    });

    $(document).on('click', '#addRoleButton', function() {
        const roleName = $('#roleName').val();
        ajaxRequest('/include/api/pages/permissionsRoles.php?action=AddRole', { roleName }, () => {
            $('#addRoleModal').modal('hide');
            $('#roleName').val('');
            reloadPage();
        });
    });

    // Delete Role
    $(document).on('click', '.DeleteRole', function() {
        const roleId = $(this).data('role-id');
        swal({
            title: "هل انت متأكد؟",
            text: "هل تريد حذف هذا الدور؟",
            icon: "warning",
            buttons: ["الغاء", "نعم"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                ajaxRequest('/include/api/pages/permissionsRoles.php?action=DeleteRole', { roleId }, reloadPage);
            }
        });
    });

    // Edit Role and Permissions
    function getPermissions(roleId) {
        ajaxRequest('/include/api/pages/permissionsRoles.php?action=GetPermissions', { roleId }, (responseData) => {
            const permissionsHtml = responseData.permissions.map(permission => `
                <div class="form-check form-check-inline mt-1 mb-1">
                    <input class="form-check-input p-1" type="checkbox" id="permission_${permission.id}" 
                           name="permissions[]" value="${permission.id}" ${permission.checked ? 'checked' : ''}>
                    <label class="form-check-label" for="permission_${permission.id}">${permission.permission_name}</label>
                </div>
            `).join('');
            $('#rolePermissions').html(permissionsHtml);
        }, false);
    }

    $(document).on('click', '.EditRole', function() {
        const roleId = $(this).data('role-id');
        if ($('#EditRoleAndPermissionsModal').length === 0) {
            $('body').append($('#editRoleModalTemplate').html());
        }
        $('#EditRoleAndPermissionsForm').data('role-id', roleId);
        getPermissions(roleId);
        $('#EditRoleAndPermissionsModal').modal('show');
    });

    $(document).on('click', '#EditRoleAndPermissionsButton', function() {
        const roleId = $('#EditRoleAndPermissionsForm').data('role-id');
        const permissions = $('input[name="permissions[]"]:checked').map(function() {
            return this.value;
        }).get();
        ajaxRequest('/include/api/pages/permissionsRoles.php?action=EditRoleAndPermissions', 
            { roleId, permissions }, 
            () => {
                $('#EditRoleAndPermissionsModal').modal('hide');
                reloadPage();
            }
        );
    });
});