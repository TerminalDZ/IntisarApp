$(document).ready(function() {

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
                
                    $('#amount').val(data.amount);
                    $('#member_idSelect').val(data.member.member_id);
                    $('#member_idInput').val(data.member.member_id);


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

    $('#member_idInput').keyup(function() {
        var memberID = $('#member_idInput').val();
        if (memberID.length > 5 && memberID.length < 7) {
            GetMembersByMemberId(memberID);
        }else{
            $('#amount').val('');
            $('#member_idSelect').val('');
            $('#paid').val('');
        }
        
    });


    $('#member_idSelect').change(function() {
        var memberID = $('#member_idSelect').val();
        if (memberID == '') {
            $('#amount').val('');
            $('#member_idInput').val('');
            $('#paid').val('');
            return;
        }
        GetMembersByMemberId(memberID);
    });


    $('#changeYear').click(function() {

        if ($('#changeYearDiv').is(":hidden")) {
            $('#changeYearDiv').show();
            $('#changeYear').text('اخفاء السنة');
            $('#CerrryYear').hide();
            
    
            for (let i = 1900; i <= new Date().getFullYear(); i++) {
                $('#InputYear').append('<option value="' + i + '">' + i +'/'+ (i + 1) + '</option>');
                if (i == new Date().getFullYear()) {
                    $('#InputYear').val(i);
                }
            }

        } else {
            $('#changeYearDiv').hide();
            $('#changeYear').text('تغيير السنة');
            $('#CerrryYear').show();

            $('#InputYear').empty();
        }

    });


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

    $('#scanQR').click(function() {
        if ($('#QRScannerModal').length == 0) {
            $('body').append(ModalQRScanner);
        }
    
        $('#QRScannerModal').modal('show');
    
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
            $('#member_idInput').val(qrCodeMessage);
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
                }).catch(err => {
                    console.error("Failed to stop scanning", err);
                });
            }
        });
    
        $('#SwitchCamera').click(function() {
            let newFacingMode = currentFacingMode === "environment" ? "user" : "environment";
            startScanner(newFacingMode);
        });
    });

    function validateInput(selector) {
        const value = $(selector).val();
        if (value === '') {
            $(selector).addClass('is-invalid');
            return false;
        } else {
            $(selector).removeClass('is-invalid');
            return true;
        }
    }

    function checkEmptyInputs() {
        const inputs = ['#member_idInput', '#amount', '#paid', '#general_command'];
        let allFilled = true;

        inputs.forEach(selector => {
            if (!validateInput(selector)) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء ملئ جميع الحقول</strong>'
            }, {
                type: 'danger'
            });
            return false;
        }

        return true;
    }

    const modalAddNumberInsurance = `
    <div class="modal fade" id="AddNumberInsuranceModal" tabindex="-1" role="dialog" aria-labelledby="AddNumberInsuranceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddNumberInsuranceModalLabel">ماهو رقم تأمين خاص بالعضو</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="InsuranceNumber" class="col-form-label">أدخل رقم التأمين الخاص بالعضو</label>
                                <input type="text" class="form-control" id="InsuranceNumber" placeholder="أدخل رقم التأمين الخاص بالعضو">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="AddInsuranceNumber">إضافة</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    `;

    function addInsuranceNumber(Close = false) {
        const data = {
            member_id: $('#member_idInput').val(),
            amount: $('#amount').val(),
            paid: $('#paid').val(),
            insurance_number: '',
            general_command : $('#general_command').val(),
            year: $('#InputYear').val() || new Date().getFullYear(),
        };

        if (data.general_command == 1) {

            if ($('#AddNumberInsuranceModal').length === 0) {
                $('body').append(modalAddNumberInsurance);
            } else {
                $('#InsuranceNumber').val('');
            }

            $('#AddNumberInsuranceModal').modal('show');

            $('#AddInsuranceNumber').off('click').on('click', function () {
                const insuranceNumber = $('#InsuranceNumber').val();
                if (insuranceNumber === '') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>رجاء اضافة رقم التأمين</strong>'
                    }, {
                        type: 'danger',
                        z_index: 999999999
                    });
                    $('#InsuranceNumber').addClass('is-invalid');
                    return false;
                }

                $('#InsuranceNumber').removeClass('is-invalid');
                data.insurance_number = insuranceNumber;
                postInsurance(data, Close);

                $('#AddNumberInsuranceModal').modal('hide');
                return true;
            });
        } else {
            postInsurance(data, Close);
        }

        return false;
    }

    function addInsurance(Close = false) {
        if (!checkEmptyInputs()) {
            return;
        }

        if (!addInsuranceNumber(Close)) {
            return;
        }
    }

    function postInsurance(data = {}, Close = false) {
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
                    if (Close) {
                        setTimeout(function () {
                            window.location.href = '/?p=insurances';
                        }, 1000);
                    }

                    $('#member_idInput, #amount, #paid, #InsuranceNumber').val('');
                    $('#member_idSelect').val('');
                    $('#changeYearDiv').hide();
                    $('#changeYear').text('تغيير السنة');
                    $('#CerrryYear').show();
                    $('#InputYear').empty();
                    $('#general_command').val('');
                }
            }
        });
    }

    $('#addInsurance').click(function () {
        addInsurance(false);
    });

    $('#addInsuranceAndReturn').click(function () {
        addInsurance(true);
    });




});