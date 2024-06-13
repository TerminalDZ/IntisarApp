$(document).ready(function(){

    //dataTables
    $('#UsersList').DataTable({

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
    "info": false,

         
    
        
    });



    function deleteUser(userId) {
        
        $.ajax({
            url: '/include/api/pages/users.php?action=deleteUser',
            type: 'POST',
            data: {
                userId: userId
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $('#userRow'+userId).remove();
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>'+data.message+'</strong>'
                    },{
                        type: 'success',
                    });
                }else{
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>'+data.message+'</strong>'
                    },{
                        type: 'danger',
                    });
                }



            }
        });

    }


    $(document).on('click', '.deleteUser', function(event) {
        event.preventDefault();

        var userId = $(this).attr('data-id');

        swal({
            title: "هل أنت متأكد؟",
            text: "بمجرد الحذف، لن تكون قادرًا على استعادة هذا السجل!",
            icon: "warning",
            buttons: ["إلغاء", "نعم"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                deleteUser(userId);
                
                swal("تم الحذف!", {
                    icon: "success",
                });
            } else {
                swal("تم الإلغاء!", {
                    icon: "error",
                });
            }
        });
    });


});