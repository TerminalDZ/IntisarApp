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
        "paging": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
    });

    
    var checkedMembers = [];

    $('.MBCHeck').change(function() {
        if($(this).is(':checked')){
            if(checkedMembers.length + 1 > 0){
               $('#PrintIDCard').show();
            }else{
                $('#PrintIDCard').hide();
            }

            var memberid = $(this).attr('id');
            memberid = memberid.split('-');
            memberid = memberid[1];

            if(checkedMembers.includes(memberid)){
                return;
            }
            checkedMembers.push(memberid);         
        }else{
            var memberid = $(this).attr('id');
            memberid = memberid.split('-');
            memberid = memberid[1];
            checkedMembers.splice(checkedMembers.indexOf(memberid), 1);
            if(checkedMembers.length < 1){
                $('#PrintIDCard').hide();
            }
        }

        
    });

    $('#CheckAllMembers').change(function() {
        if($(this).is(':checked')){
            $('.MBCHeck').prop('checked', true);
            checkedMembers = [];
            $('.MBCHeck').each(function() {
                var memberid = $(this).attr('id');
                memberid = memberid.split('-');
                memberid = memberid[1];
                checkedMembers.push(memberid);
            });
            $('#PrintIDCard').show();
        }else{
            $('.MBCHeck').prop('checked', false);
            checkedMembers = [];
            $('#PrintIDCard').hide();
        }
    });

    $('#PrintIDCard').click(function() {

        var members = checkedMembers.join(',');
        $url = '/print/PrintIDCard.php?membersId=' + members;
        var printWindow = window.open($url, 'PRINT');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.onafterprint = function() {
            printWindow.close();
        };
        
    });



    $('.picture').click(function() {
        var src = $(this).attr('src');
        var fullname = $(this).data('name');
        $('#memberPicture').attr('src', src);
        $('#memberName').text(fullname);
        $('#showMemberPicture').modal('show');
    });



    $('#PrintFormEmpty').click(function() {
       $file = '../../../assets/pdf/Form.pdf';
       var printWindow = window.open('', 'PRINT', 'height=800,width=800');
        printWindow.document.write('<title> الاستمارة االتسجيل</title>');
        printWindow.document.write('<style> body {margin: 0;}</style>');
        printWindow.document.write('<center><embed src="' + $file + '" type="application/pdf" width="100%" height="100%"></center>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.onafterprint = function() {
            printWindow.close();
        };


    });

    function DeleteMember(member_id) {
        $.ajax({
            url: '/include/api/pages/members.php?action=DeleteMember',
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


    $(document).on('click', '.deleteMember', function() {
        var memberId = $(this).attr('data-id');
        swal({
            title: "هل انت متأكد من حذف العضو؟",
            text: "بمجرد الحذف لا يمكن استرجاع البيانات يمكنك ارجاعها من أرشيف الحذف",
            icon: "warning",
            buttons: {
                cancel: "الغاء",
                confirm: "حذف"
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                DeleteMember(memberId);
            }
        });


    });



});
