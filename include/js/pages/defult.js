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

    function SwalConfirm(title, text, confirmButtonText, icon = 'warning', showCancelButton = true, cancelButtonText = 'إلغاء' , confirmCallback) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: showCancelButton,
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText
        }).then((result) => {
            if (result.isConfirmed) {
                confirmCallback();
            }
        });
    }

    function SwalAlert(title, text, icon = 'success') {
        Swal.fire({
            title: title,
            text: text,
            icon: icon
        });
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


});