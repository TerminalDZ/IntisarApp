$(document).ready(function() {

    var checkedMembers = [];


    var table =   $('#members-table').DataTable({
        "language": {
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
        "paging": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "scrollX": true,
        "scrollY": '50vh',
        "scrollCollapse": true,
        "processing": true,
        select: {
            style: 'multi',
            selector: 'td:not(:nth-child(1)):not(:nth-child(3)):not(:nth-child(20))'

        },
        
        "columnDefs": [
            {
                "targets": [8, 9, 16, 17, 18],
                "createdCell": function (td, cellData, rowData, row, col) {
                    var $cell = $(td);
                    var fullText = cellData;
                    var shortText = fullText.substr(0, 5) + '...';
                    $cell.text(shortText);
                    $cell.data('fulltext', fullText);
                    $cell.addClass('toggle-text');
                    $cell.click(function() {
                        if ($cell.text() !== fullText) {
                            $cell.text(fullText);
                        } else {
                            $cell.text(shortText);
                        }
                    });
                }
            },
           
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'العمليات',
                buttons: [
                    {
                        text: 'تحديد الكل',
                        action: function (e, dt, node, config) {
                            var allSelected = table.rows({ selected: true }).count() === table.rows().count();
                    
                            if (allSelected) {
                                table.rows().deselect();
                                checkedMembers = [];
                                $('#PrintIDCard').hide();
                    
                            } else {
                                table.rows().select();
                    
                                checkedMembers = [];
                    
                                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                    var memberid = $(this.node()).find('td[data-memberid]').data('memberid');
                                    if (!checkedMembers.includes(memberid)) {
                                        checkedMembers.push(memberid);
                                    }
                                });
                    
                                $('#PrintIDCard').show();
                            }
                        }
                    },
                    {
                        text: 'فلترة البيانات',
                        action: function ( e, dt, node, config ) {
                            $('#showFilterModal').modal('show');
                        }
                    },
                    {
                        text: 'طباعة الاستمارة الفارغة',
                        action: function ( e, dt, node, config ) {
                            PrintFormEmpty();
                        }
                    },
                    {
                        text: 'اظافة منخرط',
                        action: function ( e, dt, node, config ) {
                            window.location.href = '?p=addMember';
                        }
                    },

                ],
            },
            {
                extend: 'collection',
                text: 'تصدير البيانات',
                buttons: [
                    {
                        text: 'Excel',
                        extend: 'excelHtml5',
                        title: 'الاعضاء',
                        exportOptions: {
                            columns: [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15],
                            format: {
                                body: function ( data, row, column, node ) {
                                    if($(node).hasClass('toggle-text')){
                                        if(column == 8 || column == 9){
                                            return $(node).data('fulltext');
                                        }else{
                                            return data;
                                        }
                                    }else{
                                        return $(node).text();
                                    }
                                }
                            }
                        }
                    },
                    {
                        text: 'CSV',
                        extend: 'csvHtml5',
                        title: 'الاعضاء',
                        charset: 'UTF-8',
                        bom: true,
                        exportOptions: {
                            columns: [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15],
                            format: {
                                body: function ( data, row, column, node ) {
                                    if($(node).hasClass('toggle-text')){
                                        if(column == 8 || column == 9){
                                            return $(node).data('fulltext');
                                        }else{
                                            return data;
                                        }
                                    }else{
                                        return $(node).text();
                                    }
                                }
                            }
                        }
                        
                    },
                    {
                        text: 'PRINT',
                        extend: 'print',
                        title: 'الاعضاء',
                        exportOptions: {
                            columns: [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15],
                            format: {
                                body: function ( data, row, column, node ) {
                                    if($(node).hasClass('toggle-text')){
                                        if(column == 8 || column == 9){
                                            return $(node).data('fulltext');
                                        }else{
                                            return data;
                                        }
                                    }else{
                                        return $(node).text();
                                    }
                                }
                            }
                        }
                       
                    }
                ]
            }
           
        ]
    });



    table.on('select', function(e, dt, type, indexes) {


        if (table.rows('.selected').count() > 0) {
            $('#PrintIDCard').show();

            var selectedRow = table.row(indexes).node();
            var memberid = $(selectedRow).find('td[data-memberid]').data('memberid');

            if (!checkedMembers.includes(memberid)) {
                checkedMembers.push(memberid);
            }


        }
    });

    table.on('deselect', function(e, dt, type, indexes) {
        var deselectedRow = table.row(indexes).node();
        var memberid = $(deselectedRow).find('td[data-memberid]').data('memberid');

        var memberIndex = checkedMembers.indexOf(memberid);
        if (memberIndex !== -1) {
            checkedMembers.splice(memberIndex, 1);
        }

 
        if (table.rows('.selected').count() < 1) {
            $('#PrintIDCard').hide();
        }
    });

    $('#filter-form').submit(function(e) {
        e.preventDefault();
        var form = this; 
        var url = new URL(window.location.href);
        url.searchParams.set('p', 'members');

        var formData = new FormData(form);
        formData.forEach(function(value, key) {
            url.searchParams.set(key, value);
        });

        window.location.href = url.toString();
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

    function PrintFormEmpty() {
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
    }

 

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
