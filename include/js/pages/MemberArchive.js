$(document).ready(function() {
    $('.toggle-text').each(function() {
        var $this = $(this);
        var fullText = $this.data('fulltext');
        var shortText = fullText.substr(0, 5) + '...';
        $this.text(shortText);
        $this.click(function() {
            if ($this.text() !== fullText) {
                $this.text(fullText);
            } else {
                $this.text(shortText);
            }
        });
    });



    $('#members-table').DataTable({
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
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
    });



    $('.picture').click(function() {
        var src = $(this).attr('src');
        var fullname = $(this).data('name');
        $('#memberPicture').attr('src', src);
        $('#memberName').text(fullname);
        $('#showMemberPicture').modal('show');
    });




    function restoreMember(member_id) {
        $.ajax({
            url: '/include/api/pages/members.php?action=restoreMember',
            type: "POST",
            data: {
                member_id: member_id
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

                    setTimeout(function() {
                        location.reload();
                    }, 1000);

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


    $(document).on('click', '.restoreMember', function() {
        var memberId = $(this).attr('data-id');
        swal({
            title: "هل أنت متأكد؟",
            text: "هل تريد استعادة العضو؟",
            icon: "warning",
            buttons: {
                cancel: "الغاء",
                confirm: "استعادة"
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                restoreMember(memberId);
            }
        }
        );
        


    });



});
