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

          $(".TableAddUniform").removeClass("d-none");
          RanderGetUniformsMembers(data.member.member_id);
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
      $(".TableAddUniform").removeClass("d-none");
      RanderGetUniformsMembers(memberID);
    } else {
      $(".TableAddUniform").addClass("d-none");
    }
  });

  $("#member_idInput").keyup(function () {
    var memberID = $("#member_idInput").val();
    if (memberID.length > 5 && memberID.length < 7) {
      GetMembersByMemberId(memberID);
    } else {
      $(".TableAddUniform").addClass("d-none");
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

  const uniformsTable = $("#uniformsTable");

  const RowAdd = ` 
  <tr class="uniformRow">
											<td>
												<select class="form-control" name="uniform_type[]">
													<option value="" selected>اختر...</option>
													<option value="قميص">قميص</option>
													<option value="شارة">شارة</option>
													<option value="منديل">منديل</option>
													<option value="قبعة">قبعة</option>
													<option value="سترة">سترة</option>
													<option value="سروال">سروال</option>
												</select>
											</td>
											<td>
												<select class="form-control" name="uniform_size[]">
													<option value="" selected>اختر...</option>
													<option value="XS">XS</option>
													<option value="S">S</option>
													<option value="M">M</option>
													<option value="L">L</option>
													<option value="XL">XL</option>
													<option value="XXL">XXL</option>
													<option value="XXXL">XXXL</option>
													<option value="2">2</option>
													<option value="4">4</option>
													<option value="6">6</option>
													<option value="8">8</option>
													<option value="10">10</option>
													<option value="12">12</option>
													<option value="14">14</option>
													<option value="16">16</option>
													<option value="18">18</option>
													<option value="20">20</option>
													<option value="22">22</option>
													<option value="24">24</option>
													<option value="26">26</option>
													<option value="28">28</option>
													<option value="30">30</option>
													<option value="32">32</option>
													<option value="34">34</option>
													<option value="36">36</option>
													<option value="38">38</option>
													<option value="40">40</option>
													<option value="42">42</option>
													<option value="44">44</option>
													<option value="46">46</option>
													<option value="48">48</option>
													<option value="50">50</option>
												</select>
											</td>
											<td>
												<input type="text" class="form-control" name="uniform_price[]" placeholder="أدخل السعر">
											</td>
											<td>
												<select class="form-control" name="uniform_paid[]">
													<option value="" selected>اختر...</option>
													<option value="1">نعم</option>
													<option value="0">لا</option>
												</select>
											</td>
											<td>
												<select class="form-control" name="uniform_received[]">
													<option value="" selected>اختر...</option>
													<option value="1">نعم</option>
													<option value="0">لا</option>
												</select>
											</td>
											<td>
												<textarea class="form-control" name="uniform_notes[]" rows="1" placeholder="أدخل الملاحظات"></textarea>
											</td>
											<td>
												<button type="button" class="btn btn-danger removeRow"><i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-success SaveRow"><i class="fa fa-save"></i></button>
                        <button type="button" class="btn btn-primary EditRow d-none"><i class="fa fa-edit"></i></button>
											</td>
										</tr>
  `;

  $(".addRow").click(function () {
    uniformsTable.append(RowAdd);
  });

  uniformsTable.on("click", ".removeRow", function () {
    swal({
      title: "هل أنت متأكد؟",
      text: "هل تريد حذف هذا السجل؟",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        const row = $(this).closest("tr");
        const uniform_id = row.attr("data-uniform_id");

        if (uniform_id) {
          DeleteUniform(uniform_id);
        }

        row.remove();
      }
    });
  });

  function DeleteUniform(uniform_id) {
    $.ajax({
      url: "/include/api/pages/uniforms.php?action=DeleteUniform",
      type: "POST",
      data: {
        uniform_id: uniform_id,
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response.status == "success") {
          showNotification(response.message, "success");
        } else {
          showNotification(response.message, "danger");
        }
      },
    });
  }

  uniformsTable.on("click", ".SaveRow", function () {
    const row = $(this).closest("tr");
    const inputs = row.find("select, input");
    let allFilled = true;
    let isRepeated = false;

    inputs.each(function () {
      if ($(this).val() === "") {
        $(this).addClass("is-invalid");
        allFilled = false;
      } else {
        $(this).removeClass("is-invalid");
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
      return;
    }

    uniformsTable.find("select[name='uniform_type[]']").each(function () {
      if (
        $(this).val() == row.find("select[name='uniform_type[]']").val() &&
        $(this).closest("tr").attr("data-uniform_id") !=
          row.attr("data-uniform_id")
      ) {
        isRepeated = true;
      }
    });

    if (isRepeated) {
      $.notify(
        {
          title: "<strong></strong>",
          message: "<strong>نوع الزي مكرر</strong>",
        },
        {
          type: "danger",
        }
      );
      return;
    }

    const data = {
      member_id: $("#member_idInput").val(),
      uniform_id: row.attr("data-uniform_id") || null,
      uniform_type: row.find("select[name='uniform_type[]']").val(),
      uniform_size: row.find("select[name='uniform_size[]']").val(),
      uniform_price: row.find("input[name='uniform_price[]']").val(),
      uniform_paid: row.find("select[name='uniform_paid[]']").val(),
      uniform_received: row.find("select[name='uniform_received[]']").val(),
      uniform_notes: row.find("textarea[name='uniform_notes[]']").val(),
    };

    row.find("select, input, textarea").attr("disabled", true);
    row.find(".SaveRow").addClass("d-none");
    row.find(".EditRow").removeClass("d-none");

    SaveUniform(data);
  });

  function SaveUniform(data) {
    $.ajax({
      url: "/include/api/pages/uniforms.php?action=AddUniform",
      type: "POST",
      data: data,
      success: function (response) {
        response = JSON.parse(response);
        console.log(response);
        if (response.status == "success") {
          showNotification(response.message, "success");

          if (data.uniform_id == null) {
            uniformsTable
              .find("tr:last")
              .attr("data-uniform_id", response.uniform_id);
          }
        } else {
          showNotification(response.message, "danger");
        }
      },
    });
  }

  uniformsTable.on("click", ".EditRow", function () {
    const row = $(this).closest("tr");
    row.find("select, input, textarea").attr("disabled", false);
    row.find(".EditRow").addClass("d-none");
    row.find(".SaveRow").removeClass("d-none");
  });

  function RanderGetUniformsMembers(member_id) {
    $(".uniformRow").remove();

    $.ajax({
      url: "/include/api/pages/uniforms.php?action=GetUniformByMemberId",
      type: "POST",
      data: {
        member_id: member_id,
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response.status == "success") {
          showNotification(response.message, "success");

          response.uniform.forEach((uniform) => {
            $("#uniformsTable").append(RowAdd);
            const row = $("#uniformsTable tr:last");
            row.attr("data-uniform_id", uniform.uniform_id);
            row.find("select[name='uniform_type[]']").val(uniform.uniform_type);
            row.find("select[name='uniform_size[]']").val(uniform.size);
            row.find("input[name='uniform_price[]']").val(uniform.amount_paid);
            row.find("select[name='uniform_paid[]']").val(uniform.paid);
            row.find("select[name='uniform_received[]']").val(uniform.received);
            row.find("textarea[name='uniform_notes[]']").val(uniform.note);
            row.find(".SaveRow").addClass("d-none");
            row.find(".EditRow").removeClass("d-none");
            row.find("select, input, textarea").attr("disabled", true);
          });
        } else {
          showNotification(response.message, "danger");
        }
      },
    });
  }

  function showNotification(message, type) {
    $.notify(
      {
        title: "<strong></strong>",
        message: "<strong>" + message + "</strong>",
      },
      {
        type: type,
      }
    );
  }
});
