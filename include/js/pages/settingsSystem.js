$(document).ready(function () {
  $(".dropify").dropify({
    messages: {
      default: "اضغط أو اسحب الملف هنا",
      replace: "اضغط أو اسحب الملف هنا لتغيير الملف",
      remove: "حذف",
      error: "عذراً، حدث خطأ ما.",
    },
  });

  $(".keywords").selectize({
    plugins: ["remove_button"],
    delimiter: ",",
    persist: false,
    create: function (input) {
      var illegalChars = /[+/\-()#%=àç_è@|'"{}]/;
      if (illegalChars.test(input)) {
        return false;
      } else {
        return {
          value: input,
          text: input,
        };
      }
    },
  });

  function UpdateSettings() {
    var token = $("#token").val();
    var site_name = $("#site_name").val();
    var logo = $("#logo").val();
    var icon = $("#icon").val();
    var description = $("#description").val();
    var keywords = $("#keywords").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var governorate_state = $("#governorate_state").val();

    if (
      site_name == "" ||
      description == "" ||
      keywords == "" ||
      email == "" ||
      phone == "" ||
      address == "" ||
      governorate_state == ""
    ) {
      $.notify(
        {
          title: "<strong></strong>",
          message: "<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>",
        },
        {
          type: "warning",
        }
      );

      return;
    }

    var form = new FormData();
    form.append("token", token);
    form.append("site_name", site_name);
    form.append("logo", $("#logo")[0].files[0]);
    form.append("icon", $("#icon")[0].files[0]);
    form.append("description", description);
    form.append("keywords", keywords);
    form.append("email", email);
    form.append("phone", phone);
    form.append("address", address);
    form.append("governorate_state", governorate_state);

    $.ajax({
      url: "/include/api/pages/settingsSystem.php?action=UpdateSettings",
      type: "POST",
      data: form,
      processData: false,
      contentType: false,
      success: function (data) {
        data = JSON.parse(data);
        if (data.status == "success") {
          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "success",
            }
          );
          setTimeout(function () {
            window.location.href = "/?p=settingsSystem";
          }, 1000);
        } else {
          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "danger",
            }
          );
        }
      },
    });
  }

  $("#UpdateSettings").click(function () {
    UpdateSettings();
  });

  //SMTP

  function UpdateSmtp() {
    var token = $("#token").val();
    var smtp_email = $("#smtp_email").val();
    var smtp_password = $("#smtp_password").val();
    var smtp_host = $("#smtp_host").val();
    var smtp_port = $("#smtp_port").val();
    var smtp_encryption = $("#smtp_encryption").val();

    if (
      smtp_email == "" ||
      smtp_password == "" ||
      smtp_host == "" ||
      smtp_port == "" ||
      smtp_encryption == ""
    ) {
      $.notify(
        {
          title: "<strong></strong>",
          message: "<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>",
        },
        {
          type: "warning",
        }
      );

      return;
    }

    var form = new FormData();
    form.append("token", token);
    form.append("smtp_email", smtp_email);
    form.append("smtp_password", smtp_password);
    form.append("smtp_host", smtp_host);
    form.append("smtp_port", smtp_port);
    form.append("smtp_encryption", smtp_encryption);

    $.ajax({
      url: "/include/api/pages/settingsSystem.php?action=UpdateSmtp",
      type: "POST",
      data: form,
      processData: false,
      contentType: false,
      success: function (data) {
        data = JSON.parse(data);
        if (data.status == "success") {
          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "success",
            }
          );
        } else {
          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "danger",
            }
          );
        }
      },
    });
  }

  $("#UpdateSmtp").click(function () {
    UpdateSmtp();
  });

  //Test SMTP

  $("#TestSmtp").click(function () {
    $("#modalTestSmtp").modal("show");
    $("#UploadImage").addClass("bounceIn animated");
  });

  function TestSend() {
    var token = $("#token").val();
    var test_email = $("#test_email").val();

    if (test_email == "") {
      $.notify(
        {
          title: "<strong></strong>",
          message: "<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>",
        },
        {
          type: "warning",
          z_index: 200000,
        }
      );

      return;
    }

    $("#contentSmtp").hide();
    $("#ReloadSend").show();

    var form = new FormData();
    form.append("token", token);
    form.append("test_email", test_email);

    $.ajax({
      url: "/include/api/pages/settingsSystem.php?action=TestSMTP",
      type: "POST",
      data: form,
      processData: false,
      contentType: false,
      success: function (data) {
        data = JSON.parse(data);
        if (data.status == "success") {
          $("#ReloadSend").hide();
          $("#contentSmtp").show();
          $("#modalTestSmtp").modal("hide");

          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "success",
              z_index: 200000,
            }
          );
        } else {
          $("#ReloadSend").hide();
          $("#contentSmtp").show();

          $.notify(
            {
              title: "<strong></strong>",
              message: "<strong>" + data.message + "</strong>",
            },
            {
              type: "danger",
              z_index: 200000,
            }
          );
        }
      },
    });
  }

  $("#TestSend").click(function () {
    TestSend();
  });
});
