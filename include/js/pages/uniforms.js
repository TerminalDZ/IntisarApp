$(document).ready(function () {
  var table = $("#UniformsTable").DataTable({
    language: {
      sProcessing: "جارٍ التحميل...",
      sLengthMenu: "أظهر _MENU_ سجل",
      sZeroRecords: "لم يعثر على أية سجلات",
      sInfo: "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
      sInfoEmpty: "يعرض 0 إلى 0 من أصل 0 سجل",
      sInfoFiltered: "(منتقاة من مجموع _MAX_ مُدخل)",
      sInfoPostFix: "",
      sSearch: "ابحث:",
      sUrl: "",
      oPaginate: {
        sFirst: "الأول",
        sPrevious: "السابق",
        sNext: "التالي",
        sLast: "الأخير",
      },
    },
    paging: false,
    searching: true,
    order: [[6, "desc"]],
    info: true,
    autoWidth: true,
    scrollX: true,
    scrollY: "50vh",
  });

  function showNotification(message, type) {
    $.notify(
      {
        message: `<strong>${message}</strong>`,
      },
      {
        type: type,
        z_index: 999999999,
      }
    );
  }

  function SwalConfirm(
    title,
    text,
    confirmButtonText,
    icon = "warning",
    showCancelButton = true,
    cancelButtonText = "إلغاء",
    confirmCallback
  ) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      showCancelButton: showCancelButton,
      confirmButtonText: confirmButtonText,
      cancelButtonText: cancelButtonText,
    }).then((result) => {
      if (result.isConfirmed) {
        confirmCallback();
      }
    });
  }

  function SwalAlert(title, text, icon = "success") {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
    });
  }

  function GetUniforms() {
    $.ajax({
      url: "/include/api/pages/uniforms.php?action=get_uniforms",
      type: "POST",
      success: function (response) {
        response = JSON.parse(response);
        if (response.status == "success") {
          updateTable(response.data);
        } else {
          showNotification(response.message, "danger");
        }
      },
    });
  }

  GetUniforms();

  function updateTable(uniforms) {
    table.clear();

    console.log(uniforms);

    uniforms.forEach((uniform) => {
      table.row.add([
        uniform.member_id,
        uniform.member.first_name + " " + uniform.member.last_name,
        uniform.uniform_type,
        uniform.size,
        uniform.amount_paid,
        uniform.paid,
        uniform.created_at,
        `<button class="btn btn-primary btn-sm edit-uniform" data-id="${uniform.id}">تعديل</button>
        <button class="btn btn-danger btn-sm delete-uniform" data-id="${uniform.id}">حذف</button>`,
      ]);
    });
  }
});
