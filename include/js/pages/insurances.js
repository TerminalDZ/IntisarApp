$(document).ready(function() {

    function GetYearsInput() {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=GetYearsInput',
            type: 'POST',
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    var currentYear = new Date().getFullYear();
                    data.years.sort((a, b) => b - a); 
                    data.years.forEach(year => {
                        var selected = year == currentYear ? 'selected' : '';
                        $('#yearInput').append('<option value="' + year + '" ' + selected + '>' + year + '</option>');
                    });
                    $('#yearInput').select2();
                    var year = $('#yearInput').val();
                    $('.year').html(year);
                    CountMembersInsuranced(year); 
                    CountMembersSumamountInsuranced(year);
                    GetAllinsurances(year); 
                }
            }
        });
    }

    $('#yearInput').change(function() {
        var year = $(this).val();
        $('.year').html(year);
        CountMembersInsuranced(year);
        CountMembersSumamountInsuranced(year);
        GetAllinsurances(year);
        
    });

    GetYearsInput();

    function CountMembersInsuranced(year) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=CountMembersInsuranced',
            type: 'POST',
            data: {
                'year': year,
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    animateCount(data.count, $('#CountMembersInsuranced'));

                    var totalMembers = data.totalMembers;
                    var percentInsuranced = (data.count / totalMembers) * 100;

                    animateCountWithPercent(percentInsuranced, $('#PercentMembersInsuranced'));
                    updateProgressBar(percentInsuranced, $('#PercentMembersInsurancedBar'));


                    var MembersNotInsuranced = totalMembers - data.count;
                    animateCount(MembersNotInsuranced, $('#CountMembersNotInsuranced'));

                    var percentNotInsuranced = (MembersNotInsuranced / totalMembers) * 100;
                    animateCountWithPercent(percentNotInsuranced, $('#PercentMembersNotInsuranced'));
                    updateProgressBar(percentNotInsuranced, $('#PercentMembersNotInsurancedBar'));


                }
            }
        });
    }

    function CountMembersSumamountInsuranced(year) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=CountMembersSumamountInsuranced',
            type: 'POST',
            data: {
                'year': year,
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    animateCount(data.sum, $('#CountMembersSumamountInsuranced'), ' د.ج');
                }
            }
        });
    }



    function animateCount(targetCount, countElement, addoun = '') {
        let currentCount = 0;
        const increment = targetCount / 100;
        const interval = setInterval(function() {
            currentCount += increment;
            if (currentCount >= targetCount) {
                currentCount = targetCount;
                clearInterval(interval);
            }
            countElement.html(Math.floor(currentCount) + addoun);
        }, 20);
    }

    function animateCountWithPercent(targetPercent, countElement) {
        let currentPercent = 0;
        const increment = targetPercent / 100;
        const interval = setInterval(function() {
            currentPercent += increment;
            if (currentPercent >= targetPercent) {
                currentPercent = targetPercent;
                clearInterval(interval);
            }
            countElement.html(Math.floor(currentPercent) + '%');
        }, 20);
    }

    function updateProgressBar(percent, progressBarElement) {
        progressBarElement.css('width', percent + '%').attr('aria-valuenow', percent);
    }





    var table = $('#TableInsurances').DataTable({
        "language": {
            "sProcessing":     "جارٍ التحميل...",
            "sLengthMenu":     "أظهر _MENU_ سجل",
            "sZeroRecords":    "لم يعثر على أية سجلات",
            "sInfo":           "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
            "sInfoEmpty":      "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered":   "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix":    "",
            "sSearch":         "ابحث:",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "الأول",
                "sPrevious": "السابق",
                "sNext":     "التالي",
                "sLast":     "الأخير"
            }
        },
        "paging": false,
        "searching": true,
        "order": [[6, 'desc']],
        "info": true,
        "autoWidth": true,
        scrollX: true,
        scrollY: '50vh',
    });



    function GetAllinsurances(year) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=GetAllinsurances',
            type: 'POST',
            data: {
                'year': year,
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    updateTable(data.insurances);
                }
            }
        });
    }

    function updateTable(insurances) {
        table.clear();
        if(insurances.length == 0){
            table.draw();
            return;
        }

        insurances.forEach(function(insurance) {
            var date = new Date(insurance.created_at);
            var formattedDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            var paidBadge = insurance.paid == 1 ? '<span class="badge badge-success">دافع</span>' : '<span class="badge badge-danger">غير دافع</span>';
            var checked = insurance.paid == 1 ? 'checked' : '';
            var switchCheck = '<input type="checkbox" class="switch-check" data-id="' + insurance.id + '" ' + checked + '>';
            table.row.add([
                insurance.member_id,
                insurance.member.first_name + ' ' + insurance.member.last_name,
                insurance.insurance_number,
                insurance.year,
                insurance.amount,
                switchCheck + paidBadge,
                formattedDate,
                '<div class="btn-group"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">العمليات</button> <div class="dropdown-menu"> <a class="dropdown-item editinsurances" data-idE=' + insurance.id + '>تعديل</a> <a class="dropdown-item deleteinsurances" data-idD=' + insurance.id + '>حذف</a> </div></div>'

            ]).draw();
        });

       $(document).on('change', '.switch-check', function() {
            var insuranceId = $(this).data('id');
            var paidStatus = $(this).is(':checked') ? 1 : 0;
            
            swal({
                title: "هل أنت متأكد؟",
                text: "هل تريد تحديث حالة الدفع لهذا العضو؟",
                icon: "warning",
                buttons: ["لا", "نعم"],
                dangerMode: true,
            }).then((willUpdate) => {
                if (willUpdate) {
                    updatePaidStatus(insuranceId, paidStatus);
                } else {
                    $(this).prop('checked', !paidStatus);
                }
            });

        });
    }



    function updatePaidStatus(insuranceId, paidStatus) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=UpdatePaidStatus',
            type: 'POST',
            data: {
                'id': insuranceId,
                'paid': paidStatus
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'success',
                    });

                    var badge = paidStatus == 1 ? '<span class="badge badge-success">دافع</span>' : '<span class="badge badge-danger">غير دافع</span>';
                    var switchCheck = '<input type="checkbox" class="switch-check" data-id="' + insuranceId + '" ' + (paidStatus == 1 ? 'checked' : '') + '>';
                    var row = table.row($('#TableInsurances').find('input[data-id="' + insuranceId + '"]').closest('tr'));
                    var rowData = row.data();
                    rowData[5] = switchCheck + badge;
                    row.data(rowData).draw();

                    UpdateALLInfo();


                    

                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    }

    function UpdateALLInfo() {
        var year = $('#yearInput').val();
        CountMembersInsuranced(year);
        CountMembersSumamountInsuranced(year);
        GetAllinsurances(year);
    }


    function DeletInsurance(insuranceId) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=DeleteInsurance',
            type: 'POST',
            data: {
                'id': insuranceId,
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'success',
                    });
                    UpdateALLInfo();
                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    }


    $('#TableInsurances').on('click', '.deleteinsurances', function() {
        var insuranceId = $(this).attr('data-idD');

        swal({
            title: "هل أنت متأكد؟",
            text: "هل تريد حذف هذا العضو؟",
            icon: "warning",
            buttons: ["لا", "نعم"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                DeletInsurance(insuranceId);
            }
        });
    });


    const modalEditInsurances = `
    <div class="modal fade" id="modalEditInsurances" tabindex="-1" role="dialog" aria-labelledby="modalEditInsurancesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditInsurances">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditInsurancesLabel">تعديل بيانات التأمين</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-right text-left">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-right">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group row">
                            <label for="memberId" class="col-sm-3 col-form-label">رقم العضو</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="memberId" name="memberId" readonly disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="insuranceNumber" class="col-sm-3 col-form-label">رقم التأمين</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="insuranceNumber" name="insuranceNumber">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label">المبلغ</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="amount" name="amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="year" class="col-sm-3 col-form-label">السنة</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="year" name="year">
                                    <option value="0">السنة</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paid" class="col-sm-3 col-form-label">الدفع</label>
                            <div class="col-sm-9">
                                <input type="checkbox" class="form-control" id="paid" name="paid">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeEditInsurances">إغلاق</button>
                        <button type="button" class="btn btn-primary" id="submitEditInsurances">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    `;

    $('#TableInsurances').on('click','.editinsurances',function(){
        

        if($('#modalEditInsurances').length == 1){
            $('#modalEditInsurances').remove();
        }

        $('body').append(modalEditInsurances);

  
        $('#year').html('');

   

        for (let i = 1900; i <= new Date().getFullYear(); i++) {
            $('#year').append('<option value="' + i + '">' + i + '</option>');
        }
        var insuranceId = $(this).attr('data-idE');
        $.ajax({
            url: '/include/api/pages/insurances.php?action=GetInsuranceById',
            type: 'POST',
            data: {
                'id': insuranceId,
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    var insurance = data.insurance;
                    $('#memberId').val(insurance.member_id);
                    $('#id').val(insurance.id);
                    $('#insuranceNumber').val(insurance.insurance_number);
                    $('#amount').val(insurance.amount);
                   
                    $('#year').val(insurance.year);
                    $('#paid').prop('checked', insurance.paid == 1);
                    $('#modalEditInsurances').modal('show');
                }
            }
        });

    
    });



    $(document).on('click', '#submitEditInsurances', function() {
        var form = $('#formEditInsurances').serialize();
        $.ajax({
            url: '/include/api/pages/insurances.php?action=UpdateInsurance',
            type: 'POST',
            data: form,
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'success',
                    });
                    $('#modalEditInsurances').modal('hide');
                    UpdateALLInfo();
                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    });





    //AddInsuranceFast

    function GetMembersByMemberId(memberID) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=GetMembersByMemberId',
            type: "POST",
            data: {
                member_id: memberID
            },
            success: function(data) {
                var data = JSON.parse(data);
                if (data.status == "success") {
                
                    var first_name = data.member.first_name;
                    var last_name = data.member.last_name;
                    var member_id = data.member.member_id;
                    var picture = data.member.picture;
                    var scout_unit = data.member.scout_unit;
                    var amount = data.amount;
                    var year =  new Date().getFullYear() + ' / ' + (new Date().getFullYear() + 1);
                    
                    // Create a table with member data
                    var memberInfoTable = `
                        <table class="table table-bordered">
                            <tr>
                                <th>الاسم</th>
                                <td>${first_name}</td>
                            </tr>
                            <tr>
                                <th>اللقب</th> 
                                <td>${last_name}</td>
                            </tr>
                            <tr>
                                <th>رقم العضو</th>
                                <td>${member_id}</td>
                            </tr>
                            <tr>
                                <th>وحدة الكشافة</th>
                                <td>${scout_unit}</td>
                            </tr>
                            <tr>
                                <th>المبلغ</th>
                                <td>${amount} د.ج</td>
                            </tr>
                            <tr>
                                <th>السنة</th>
                                <td>${year}</td>
                            </tr>
                            <tr>
                                <th>صورة</th>
                                <td><img src="uploads/${picture}" alt="صورة العضو" style="width: 100px; height: 100px;"></td>
                            </tr>
                            
                            <tr>
                                <th>رقم التأمين</th>
                                <td><input type="text" id="swal-insurance-number" class="form-control" placeholder="أدخل رقم التأمين"></td>
                            </tr>
                            
                            <tr>
                                <th>دافع مبلغ التأمين</th>
                                <td>
                                    <select class="form-control" id="swal-insurance-paid">
                                        <option value="1" selected>نعم</option>
                                        <option value="0">لا</option>
                                    </select>
                                </td>
                            </tr>

                        </table>
                    `;
                    
                    swal({
                        title: "هل أنت متأكد من إضافة التأمين لهذا العضو؟",
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: memberInfoTable
                            },
                        },
                        icon: "warning",
                        buttons: ["لا", "نعم"],
                        dangerMode: true,
                    }).then((willAdd) => {
                        if (willAdd) {
                            var insuranceNumber = document.getElementById('swal-insurance-number').value;
                            var paid = document.getElementById('swal-insurance-paid').value;

                            if (insuranceNumber === '') {
                                swal({
                                    title: "خطأ",
                                    text: "رجاءً أدخل رقم التأمين",
                                    icon: "error",
                                    buttons: "موافق"
                                });
                                return;
                            }

                    
                            var DataPost = {
                                member_id: member_id,
                                insurance_number: insuranceNumber,
                                amount: amount,
                                year: new Date().getFullYear(),
                                paid: paid
                            };
                            
                    
                            postInsurance(DataPost);
                        }
                    });
                    



                    

                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger'
                    });
                }
            }

        });
    }

    function postInsurance(data = {}) {
        $.ajax({
            url: '/include/api/pages/insurances.php?action=AddInsurance',
            type: "POST",
            data: data,
            success: function (response) {
                const responseData = JSON.parse(response);
                const messageType = responseData.status === "success" ? 'success' : 'danger';

                $.notify({
                    title: '<strong></strong>',
                    message: `<strong>${responseData.message}</strong>`
                }, {
                    type: messageType
                });

                if (responseData.status === "success") {
                    UpdateALLInfo();
                }
            }
        });
    }


    const ModalQRScanner = `
    <div class="modal fade" id="QRScannerModal" tabindex="-1" role="dialog" aria-labelledby="QRScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="QRScannerModalLabel"> اضافة تأمين سريع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                  
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <label for="member_idInput">أدخل رقم العضو أو قم بمسح الرمز QR</label>
                                <input type="text" class="form-control" id="member_idInput" placeholder="رقم العضو">
                            </div>
                            <div class="col-12 ">
                                <div id="qr-reader" style="width:100%;"></div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="StartScan">بدء المسح QR</button>
                    <button type="button" class="btn btn-primary" id="SwitchCamera" style="display: none;">تغيير الكاميرا</button>
                    <button type="button" class="btn btn-info" id="SwitchFlash" style="display: none;">تشغيل الفلاش</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
            
        </div>
    </div>
    `;

    $(document).on('keyup', '#member_idInput', function() {
        var member_id = $(this).val();
        if (member_id.length == 6) {
            GetMembersByMemberId(member_id);
            $(this).val('');
            $('#QRScannerModal').modal('hide');
        }

    });


    function QRScan(){
        $('#member_idInput').hide();

        $('#qr-reader').html('');

        $('#SwitchCamera').show();
        $('#SwitchFlash').show();

        $('#StartScan').removeClass('btn-primary').addClass('btn-secondary');
        $('#StartScan').text('إيقاف المسح');
        $('#StartScan').attr('id', 'StopScan');
        

        


        let html5QrCode = new Html5Qrcode("qr-reader");
        let isScanning = false; 
        let currentFacingMode = "environment"; 
        let powerTorch = false;
    
        function onScanSuccess(qrCodeMessage) {
            if (isNaN(qrCodeMessage) || qrCodeMessage.length !== 6) {
                $.notify({
                    title: '<strong></strong>',
                    message: '<strong>رمز غير صالح</strong>'
                }, {
                    type: 'danger',
                    z_index: 999999999
                });
                return;
            }
    
            $('#QRScannerModal').modal('hide');
            GetMembersByMemberId(qrCodeMessage);
            if (isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                });
            }
        }

        function powerTorchToggle(powerOn) {
            if(html5QrCode.getState() === Html5QrcodeScannerState.SCANNING || html5QrCode.getState() === Html5QrcodeScannerState.PAUSED){
                html5QrCode.applyVideoConstraints(
                    {
                        advanced: [{
                            torch: powerOn
                        }]
                    }
                );

                if (powerOn) {
                    $('#SwitchFlash').removeClass('btn-info').addClass('btn-warning');
                    $('#SwitchFlash').text('إيقاف الفلاش');
                } else {
                    $('#SwitchFlash').removeClass('btn-warning').addClass('btn-info');
                    $('#SwitchFlash').text('تشغيل الفلاش');
                }
                    
            }
            
        }

        $('#SwitchFlash').click(function() {
            powerTorch = !powerTorch;
            powerTorchToggle(powerTorch);
        });
            


    
        function startScanner(facingMode) {

            if (isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                    startScanner(facingMode);
                }).catch(err => {
                    console.error("Failed to stop scanning", err);
                });
            } else {
                html5QrCode.start(
                    { facingMode: facingMode },
                    { 
                        fps: 60, 
                        qrbox: 200,
                        aspectRatio: 1.7777778
                    },
                    onScanSuccess
                ).then(() => {
                    isScanning = true;
                    currentFacingMode = facingMode;
                }).catch(err => {
                    console.error("Failed to start scanning", err);
                });
            }
        }
    
        startScanner(currentFacingMode);
    
        $('#QRScannerModal').on('hidden.bs.modal', function (e) {
            if (isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                    $('#SwitchCamera').hide();
                    $('#SwitchFlash').hide();
                    $('#StopScan').removeClass('btn-secondary').addClass('btn-primary');
                    $('#StopScan').text('بدء المسح');
                    $('#StopScan').attr('id', 'StartScan');
                    $('#member_idInput').show();

                }).catch(err => {
                    console.error("Failed to stop scanning", err);
                });
            }
        });
    
        $('#SwitchCamera').click(function() {
            let newFacingMode = currentFacingMode === "environment" ? "user" : "environment";
            startScanner(newFacingMode);
        });

        $(document).on('click', '#StopScan', function() {
            if (isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                    $('#SwitchCamera').hide();
                    $('#SwitchFlash').hide();
                    $('#StopScan').removeClass('btn-secondary').addClass('btn-primary');
                    $('#StopScan').text('بدء المسح');
                    $('#StopScan').attr('id', 'StartScan');
                    $('#member_idInput').show();
                }).catch(err => {
                    console.error("Failed to stop scanning", err);
                });
            }
        });
    }

    $('#AddInsuranceFast').click(function(){
        if ($('#QRScannerModal').length == 0) {
            $('body').append(ModalQRScanner);
        }
    
        $('#QRScannerModal').modal('show');
        $('#qr-reader').html('');
        $('#SwitchCamera').hide();
        $('#SwitchFlash').hide();
        $('#StartScan').removeClass('btn-secondary').addClass('btn-primary');
        $('#StartScan').text('بدء المسح');
        $('#StartScan').attr('id', 'StartScan');
        $('#member_idInput').show();

    });

    $(document).on('click', '#StartScan', function() {
        QRScan();
    });







});
