$(document).ready(function () {
  $("#member_idSelect").select2({
    dir: "rtl",
    placeholder: "اختر العضو",
    allowClear: true,
    minimumInputLength: 0,
    language: {
      errorLoading: function () {
        return "لا يمكن تحميل النتائج";
      },
      inputTooLong: function (args) {
        return "الرجاء حذف " + (args.input.length - args.maximum) + " عناصر";
      },
      inputTooShort: function (args) {
        return "الرجاء إضافة " + (args.minimum - args.input.length) + " عناصر";
      },
      loadingMore: function () {
        return "جاري تحميل نتائج اضافية...";
      },
      maximumSelected: function (args) {
        return "تستطيع ان تختار فقط " + args.maximum + " بنود";
      },
      noResults: function () {
        return "لم يتم العثور على نتائج";
      },
      searching: function () {
        return "جاري البحث…";
      },
    },

    ajax: {
      url: "/include/api/pages/uniforms.php?action=GetMembers",
      dataType: "json",
      delay: 250,
      data: function (params) {
        var query = params.term || "";
        return {
          q: query,
        };
      },
      processResults: function (data) {
        var results = [];
        $.each(data.members, function (index, item) {
          results.push({
            id: item.member_id,
            text:
              item.member_id + " - " + item.first_name + " " + item.last_name,
          });
        });

        return {
          results: results,
        };
      },
      cache: true,
    },
  });

  function GetMembersByMemberId(memberID) {
    $.ajax({
      url: "/include/api/pages/uniforms.php?action=GetMembersByMemberId",
      type: "POST",
      data: {
        member_id: memberID,
      },
      success: function (data) {
        var data = JSON.parse(data);
        if (data.status == "success") {
          $("#member_idInput").val(data.member.member_id);
          $.notify(
            {
              title: "<strong></strong>",
              message:
                "<strong>" +
                data.message +
                " | " +
                data.member.first_name +
                " " +
                data.member.last_name +
                "</strong>",
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

  $("#member_idSelect").change(function () {
    var memberID = $("#member_idSelect").val();
    if (!memberID == "") {
      $("#member_idInput").val(memberID);
    }
  });

  $("#member_idInput").keyup(function () {
    var memberID = $("#member_idInput").val();
    if (memberID.length > 5 && memberID.length < 7) {
      GetMembersByMemberId(memberID);
    }
  });

  //QR Code
  const ModalQRScanner = `
    <div class="modal fade" id="QRScannerModal" tabindex="-1" role="dialog" aria-labelledby="QRScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="QRScannerModalLabel">ماسح QR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-reader" style="width:100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="SwitchCamera">تبديل الكاميرا</button>
                    <button type="button" class="btn btn-info" id="SwitchFlash">تشغيل الفلاش</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
            
        </div>
    </div>
    `;

  $("#scanQR").click(function () {
    if ($("#QRScannerModal").length == 0) {
      $("body").append(ModalQRScanner);
    }

    $("#QRScannerModal").modal("show");

    let html5QrCode = new Html5Qrcode("qr-reader");
    let isScanning = false;
    let currentFacingMode = "environment";
    let powerTorch = false;

    function onScanSuccess(qrCodeMessage) {
      let regex = /MemberID=(\d+)/;
      let match = qrCodeMessage.match(regex);

      if (!match || match.length < 2) {
        $.notify(
          {
            title: "<strong></strong>",
            message: "<strong>رمز غير صالح</strong>",
          },
          {
            type: "danger",
            z_index: 999999999,
          }
        );
        return;
      }

      let memberId = match[1];

      $("#QRScannerModal").modal("hide");
      $("#member_idInput").val(memberId);
      GetMembersByMemberId(memberId);
      $("#member_idSelect").val(null).trigger("change");
      if (isScanning) {
        html5QrCode.stop().then(() => {
          isScanning = false;
        });
      }
    }

    function powerTorchToggle(powerOn) {
      if (
        html5QrCode.getState() === Html5QrcodeScannerState.SCANNING ||
        html5QrCode.getState() === Html5QrcodeScannerState.PAUSED
      ) {
        html5QrCode.applyVideoConstraints({
          advanced: [
            {
              torch: powerOn,
            },
          ],
        });

        if (powerOn) {
          $("#SwitchFlash").removeClass("btn-info").addClass("btn-warning");
          $("#SwitchFlash").text("إيقاف الفلاش");
        } else {
          $("#SwitchFlash").removeClass("btn-warning").addClass("btn-info");
          $("#SwitchFlash").text("تشغيل الفلاش");
        }
      }
    }

    $("#SwitchFlash").click(function () {
      powerTorch = !powerTorch;
      powerTorchToggle(powerTorch);
    });

    function startScanner(facingMode) {
      if (isScanning) {
        html5QrCode
          .stop()
          .then(() => {
            isScanning = false;
            startScanner(facingMode);
          })
          .catch((err) => {
            console.error("Failed to stop scanning", err);
          });
      } else {
        html5QrCode
          .start(
            { facingMode: facingMode },
            {
              fps: 60,
              qrbox: 200,
              aspectRatio: 1.7777778,
            },
            onScanSuccess
          )
          .then(() => {
            isScanning = true;
            currentFacingMode = facingMode;
          })
          .catch((err) => {
            console.error("Failed to start scanning", err);
          });
      }
    }

    startScanner(currentFacingMode);

    $("#QRScannerModal").on("hidden.bs.modal", function (e) {
      if (isScanning) {
        html5QrCode
          .stop()
          .then(() => {
            isScanning = false;
          })
          .catch((err) => {
            console.error("Failed to stop scanning", err);
          });
      }
    });

    $("#SwitchCamera").click(function () {
      let newFacingMode =
        currentFacingMode === "environment" ? "user" : "environment";
      startScanner(newFacingMode);
    });
  });

  function validateInput(selector) {
    const value = $(selector).val();
    if (value === "") {
      $(selector).addClass("is-invalid");
      return false;
    } else {
      $(selector).removeClass("is-invalid");
      return true;
    }
  }

  function checkEmptyInputs() {
    const inputs = [
      "#member_idInput",
      "#uniform_select",
      "#uniform_size",
      "#uniform_price",
      "#uniform_paid",
      "#uniform_received",
    ];
    let allFilled = true;

    inputs.forEach((selector) => {
      if (!validateInput(selector)) {
        allFilled = false;
      }
    });

    if (!allFilled) {
      $.notify(
        {
          title: "<strong></strong>",
          message: "<strong>الرجاء ملئ جميع الحقول</strong>",
        },
        {
          type: "danger",
        }
      );
      return false;
    }

    return true;
  }

  function addUniform(Close = false) {
    if (!checkEmptyInputs()) {
      return;
    }

    const data = {
      member_id: $("#member_idInput").val(),
      uniform_type: $("#uniform_select").val(),
      uniform_size: $("#uniform_size").val(),
      uniform_price: $("#uniform_price").val(),
      uniform_paid: $("#uniform_paid").val(),
      uniform_received: $("#uniform_received").val(),
      uniform_notes: $("#uniform_notes").val(),
    };

    console.log(data, Close);

    postUniform(data, Close);
  }

  function postUniform(data = {}, Close = false) {
    $.ajax({
      url: "/include/api/pages/uniforms.php?action=AddUniform",
      type: "POST",
      data: data,
      success: function (response) {
        const responseData = JSON.parse(response);
        const messageType =
          responseData.status === "success" ? "success" : "danger";

        $.notify(
          {
            title: "<strong></strong>",
            message: `<strong>${responseData.message}</strong>`,
          },
          {
            type: messageType,
          }
        );

        if (responseData.status === "success") {
          if (Close) {
            setTimeout(function () {
              window.location.href = "/?p=uniforms";
            }, 1000);
          }

          $(
            "#member_idInput, #uniform_select, #uniform_size, #uniform_price, #uniform_paid, #uniform_received, #uniform_notes"
          ).val("");
          $("#member_idSelect").val(null).trigger("change");
        }
      },
    });
  }

  $("#addUniform").click(function () {
    addUniform();
  });

  $("#addUniformAndReturn").click(function () {
    addUniform(true);
  });
});
