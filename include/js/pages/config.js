// Autor: Idriss Boukmouche

$(document).ready(function(){


    //GetData Member

    function GetDataMember(member_id, generateModule = false, printForm = false, picture = false) {
        $.ajax({
            url: '/include/api/pages/members.php?action=GetMemberData',
            type: "POST",
            data: { member_id: member_id },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    notifyUser('success', data.message);
                    const memberData = data;
    
                    if (generateModule) {
                        generateModuleMember(memberData, memberData.insurances);


                    }
    
                    if (printForm) {
                        editImage(picture, memberData.data);
                    }
                } else {
                    notifyUser('danger', data.message);
                }
            }
        });
    }
    
    function notifyUser(type, message) {
        $.notify({
            title: '<strong></strong>',
            message: '<strong>' + message + '</strong>'
        }, {
            type: type,
        });
    }
    
    function getAge(dateString) {
        const today = new Date();
        const birthDate = new Date(dateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age + ' سنة';
    }


    function GetUserFullName(id) {
        return $.ajax({
            url: '/include/api/pages/members.php?action=GetUser',
            type: "POST",
            data: { id: id },
            dataType: 'json' 
        }).then(function (response) {
            if (response.status === 'success') {
                return response.FullName;
            } else {
                notifyUser('danger', response.message);
                return $.Deferred().reject(response.message).promise();
            }
        });
    }
    
 
    
    function generateModuleMember(data, insurances) {
        var data = data.data;

        if ($('#showMemberDATA').length) {
            $('#showMemberDATA').remove();
        }
    
        const genderBadge = data.gender === 'ذكر' ? 'badge-info' : 'badge-danger';
        const caregiverStyle = data.caregiver ? '' : 'style="display:none;"';
        const chronicDiseases = data.chronic_diseases || 'ليس لديه امراض مزمنة';
        const hobbies = data.hobbies || 'ليس لديه هوايات';
        const educationalInstitution = data.educational_institution || 'ليس مسجل في اي مؤسسة تعليمية';
        const sport = data.sport || 'ليس لديه رياضة مفضلة';

        const has_scout_uniform = data.has_scout_uniform == '1' ? 'نعم' : 'لا';
        const has_scout_uniformBadge = data.has_scout_uniform == '1' ? 'badge-info' : 'badge-danger';
    
        const scout_uniform_payer = data.scout_uniform_payer == '1' ? 'نعم' : 'لا';
        const scout_uniform_payerBadge = data.scout_uniform_payer == '1' ? 'badge-info' : 'badge-danger';
    

        const scout_uniform_size = data.scout_uniform_size || 'ليس لديه مقاس زي كشفي';

        $.when(
            GetUserFullName(data.added_by),
            GetUserFullName(data.last_modified_by)
        ).done(function (created_by, updated_by) {


    
        const modalContent = `
            <div class="modal fade" id="showMemberDATA" tabindex="-1" role="dialog" aria-labelledby="showMemberDATA" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="showMemberDATA">بيانات العضو : <span class="badge badge-info">${data.first_name} ${data.last_name}</span><sup class="badge badge-danger mt-1">${data.member_id}</sup> <sup class="badge badge-warning mt-1">${data.scout_unit}</sup></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-right">
                        <a class="PrintForm" data-id="${data.member_id}" href="#"><i class="icofont icofont-print"></i> طباعة الاستمارة</a>

                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active show" id="basic-data-tab" data-toggle="pill" href="#basic-data" role="tab" aria-controls="basic-data" aria-selected="true"><i class="icofont icofont-user"></i> البيانات الأساسية</a>
                                        <a class="nav-link" id="contact-data-tab" data-toggle="pill" href="#contact-data" role="tab" aria-controls="contact-data" aria-selected="false"><i class="icofont icofont-contacts"></i> بيانات الاتصال</a>
                                        <a class="nav-link" id="insurance-data-tab" data-toggle="pill" href="#insurance-data" role="tab" aria-controls="insurance-data" aria-selected="false"><i class="icofont icofont-ssl-security"></i> بيانات التأمين</a>
                                        <a class="nav-link" id="scout-data-tab" data-toggle="pill" href="#scout-data" role="tab" aria-controls="scout-data" aria-selected="false"><i class="icofont icofont-compass"></i> بيانات الكشفية</a>
                                        <a class="nav-link" id="athor-data-tab" data-toggle="pill" href="#athor-data" role="tab" aria-controls="athor-data" aria-selected="false"><i class="icofont icofont-compass"></i> بيانات اخرى</a>
                                    </div>
                                </div>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade active show" id="basic-data" role="tabpanel" aria-labelledby="basic-data-tab">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <img src="../../../uploads/${data.picture}" class="img-thumbnail" style="width: 150px; height: 150px;">
                                                </div>

                                                <div class="col-md-12 text-center">
                                                    <label for="member_id">رقم الانخراط</label>
                                                    <input type="text" class="form-control" value="${data.member_id}" readonly>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <label for="first_name">الإسم</label> 
                                                    <input type="text" class="form-control" value="${data.first_name}" id="first_name_fast_edit" readonly>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <label for="last_name">اللقب</label>
                                                    <input type="text" class="form-control" value="${data.last_name}" readonly>
                                                </div>

                                                <div class="col-md-6 text-left">

                                                    <b>الجنس</b> : <span id="gender_fast_edit" class="badge ${genderBadge}">${data.gender}</span>
                                                </div>
                                                
                                                <div class="col-md-6 text-left">
                                                    <b>تاريخ الميلاد</b> : <span>${data.dob} - (${getAge(data.dob)})</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>مكان الإزدياد</b> : <span>${data.place_of_increase}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>اسم الاب</b> : <span>${data.father_name}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>اسم و لقب الام</b> : <span>${data.mother_name} ${data.mother_last_name}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>وظيفة الاب</b> : <span>${data.job_father}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>وظيفة الام</b> : <span>${data.job_mother}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>الحالة الاجتماعية</b> : <span>${data.family_status}</span>
                                                </div>

                                                <div class="col-md-6 text-left" ${caregiverStyle}>
                                                    <b>المتكفل</b> : <span>${data.caregiver}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>الحالة المعيشية</b> : <span>${data.living_condition}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>الامراض المزمنة</b> : <span>${chronicDiseases}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>الهوايات</b> : <span>${hobbies}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>المؤسسة التعليمية</b> : <span>${educationalInstitution}</span>
                                                </div>

                                                <div class="col-md-6 text-left">
                                                    <b>الرياضة المفضلة</b> : <span>${sport}</span>
                                                </div>

                                                <div class="col-md-12 text-center">
                                                    <label for="joining_date">تاريخ الانخراط</label>
                                                    <input type="text" class="form-control" value="${data.joining_date}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contact-data" role="tabpanel" aria-labelledby="contact-data-tab">
                                            <div class="row">
                                                <div class="col-md-12 text-left">
                                                    <label for="phone_number">رقم الهاتف</label>
                                                    <input type="text" class="form-control" value="${data.phone_number}" readonly>
                                                </div>
    
    
                                                <div class="col-md-6 text-left">
                                                    <label for="address">العنوان</label>
                                                    <input type="text" class="form-control" value="${data.address}" readonly>
                                                </div>
    
                                                <div class="col-md-6 text-left">
                                                    <label for="guardian_id_number">رقم الهوية للولي </label>
                                                    <input type="text" class="form-control" value="${data.guardian_id_number}" readonly>
                                                </div>
    
                                            
                                            </div>
                                        


                                        </div>
                                        <div class="tab-pane fade" id="insurance-data" role="tabpanel" aria-labelledby="insurance-data-tab">
                                            
                                            <div class="row">
                                                <div class="table" style="overflow-x: auto;">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>سنة التأمين</th>
                                                                <th>رقم التأمين</th>
                                                                <th>حالة دفع التأمين</th>
                                                                <th>كم تم دفعه</th>
                                                                <th>متى تم اضافته</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        ${Array.isArray(insurances) ? insurances.map(insurance => `
                                                            <tr>
                                                                <td>${insurance.year}</td>
                                                                <td>${insurance.insurance_number || '<span class="badge badge-danger">لم يتم تأمينه في قيادة العامة</span>'}</td>
                                                                <td>${insurance.paid == '1' ? '<span class="badge badge-success">تم الدفع</span>' : '<span class="badge badge-danger">لم يتم الدفع</span>'}</td>
                                                                <td>${insurance.amount}</td>
                                                                <td>${insurance.created_at}</td>
                                                            </tr>
                                                        `).join('') : ''}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="tab-pane fade" id="scout-data" role="tabpanel" aria-labelledby="scout-data-tab">
                                            
                                            <div class="row">
                                                    
                                                    <div class="col-md-12 text-left">
                                                        <b>هل يمتلك الزي الكشفي ؟</b> : <span class="badge ${has_scout_uniformBadge}">${has_scout_uniform}</span>
                                                    </div>
                                                    
                                                    <div class="col-md-12 text-left">
                                                        <b>هل دافع ثمن الزي الكشفي ؟</b> : <span class="badge ${scout_uniform_payerBadge}">${scout_uniform_payer}</span>
                                                    </div>

                                                    <div class="col-md-12 text-left">
                                                        <b>مقاس الزي الكشفي </b> : <span>${scout_uniform_size}</span>
                                                    </div>

                                                    <div class="col-md-12 text-left">
                                                        <b>الوحدة الكشفية </b> : <span>${data.scout_unit}</span>
                                                    </div>
                                            </div>


                                        </div>

                                        <div class="tab-pane fade" id="athor-data" role="tabpanel" aria-labelledby="athor-data-tab">
                                            <div class="row">
                                                <div class="col-md-12 text-left">
                                                    <b>تم اظفته في : </b> : <span>${data.added_date}</span>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <b>تم اظفته بواسطة : </b>  <span>${created_by}</span>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <b>أخر تحديث : </b> : <span>${data.last_modified_date}</span>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <b>تم تحديث بواسطة : </b>  <span>${updated_by}</span>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    
            $('body').append(modalContent);
            $('#showMemberDATA').modal('show');
        }).fail(function (error) {
            notifyUser('danger', 'خطأ في جلب بيانات المستخدم.');
        });
    }
    
    $(document).on('click', '.GetSpeedDataMember', function(e) {
        e.preventDefault();
        const member_id = $(this).attr('data_memberid');
        GetDataMember(member_id, true, false, false);
    });

  
    
    function Date_Format(date) {
        const formattedDate = new Date(date);
        const day = formattedDate.getDate();
        const month = formattedDate.getMonth() + 1;
        const year = formattedDate.getFullYear();
        return `${day}/${month}/${year}`;
    }
    
    function editImage(picture = false, form) {
        const imageUrl = '../../../assets/pdf/Form.jpg';
        const QrUrl = '/include/api/qr/qrcode.php?text=' + form.member_id;
    
        var member_id = form.member_id || '';
        var first_name = form.first_name || '';
        var last_name = form.last_name || '';
        var dob = form.dob || '';
        var place_of_increase = form.place_of_increase || '';
        var address = form.address || '';
        var father_name = form.father_name || '';
        var mother_name = form.mother_name || '';
        var mother_last_name = form.mother_last_name || '';
        var guardian_id_number = form.guardian_id_number || '';
        var job_father = form.job_father || '';
        var job_mother = form.job_mother || '';
        var phone_number = form.phone_number || '';
        var educational_institution = form.educational_institution || '';
        var sport = form.sport || '';
        var hobbies = form.hobbies || '';
        var chronic_diseases = form.chronic_diseases || '';
        var insurance_number = form.insurance_number || '';
        var joining_date = form.joining_date || '';
    
        const formImage = new Image();
        formImage.src = imageUrl;
        formImage.onload = function() {
            const canvas = $('<canvas/>')[0];
            const context = canvas.getContext('2d');
            canvas.width = formImage.width;
            canvas.height = formImage.height;
            context.drawImage(formImage, 0, 0);
            context.font = "30px Arial";
            context.fillStyle = "red";
            context.textAlign = "right";
            context.fillText(`${first_name} ${last_name}`, 900, 520);
            context.fillText(dob, 900, 562);
            context.fillText(place_of_increase, 900, 590);
            context.fillText(address, 850, 630);
            context.fillText(father_name, 950, 665);
            context.fillText(`${mother_name} ${mother_last_name}`, 900, 700);
            context.fillText(guardian_id_number, 800, 735);
            context.fillText(job_father, 950, 770);
            context.fillText(job_mother, 950, 805);
            context.fillText(phone_number, 980, 840);
            context.fillText(educational_institution, 900, 875);
            context.fillText(sport, 900, 910);
            context.fillText(hobbies, 880, 945);
            context.fillText(chronic_diseases, 1100, 1020);
            context.fillText(member_id + ' | ' + insurance_number, 800, 1140);
            context.fillText(Date_Format(joining_date), 800, 1175);
    
           
            const qr = new Image();
            qr.src = QrUrl;
            qr.onload = function() {
                context.drawImage(qr, 1025, 270, 150, 150);
    
                if (picture) {
                    const img = new Image();
                    img.src = `../../../uploads/${form.picture}`;
                    img.onload = function() {
                        context.drawImage(img, 150, 415, 210, 250);
                        const dataURL = canvas.toDataURL('image/jpeg');
                        downloadURI(dataURL, "edited.jpg");
                    };
                } else {
                    const dataURL = canvas.toDataURL('image/jpeg');
                    downloadURI(dataURL, "edited.jpg");
                }
            };
         

           
            

        };
    }
    
    function downloadURI(uri, name) {
        const printWindow = window.open('', 'PRINT', 'height=800,width=800');
        printWindow.document.write('<style>img {width: 100%; height: 100%;} body {margin: 0; padding: 0; display: flex; justify-content: center; align-items: center;}</style>');
        printWindow.document.write('<img src="' + uri + '" />');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.onafterprint = function() {
            printWindow.close();
        };
    }



    $(document).on('click', '.PrintForm', function(e) {
        e.preventDefault();
        const member_id = $(this).attr('data-id');
        swal({
            title: "هل تريد طباعة الصورة؟",
            icon: "info",
            buttons: {
                cancel: "إلغاء",
                no: "لا",
                yes: "نعم"
            },
            dangerMode: true,
        })
        .then((willPrint) => {
            if (willPrint === "yes") {
                GetDataMember(member_id, false, true, true);
            } else if(willPrint === "cancel"){
                swal("تم الإلغاء!", {
                    icon: "info",
                });
            } else if(willPrint === "no"){
                GetDataMember(member_id, false, true, false);
            }
        });
    });
    
   

    function LouGout() {
      
        $.ajax({
            url: '/include/api/auth/logout.php',
            type: 'POST',
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    notifyUser('success', data.message);
                }else{
                    notifyUser('danger', data.message);
                }
            }
        });
      
    }

    $('#LogOut').click(function(){
        
        swal({
            title: "هل أنت متأكد؟",
            text: "هل تريد تسجيل الخروج؟",
            icon: "warning",
            buttons: true,
            buttons: ["إلغاء", "نعم"],
            dangerMode: true,
        })
        .then((willLogOut) => {
            if (willLogOut) {
                LouGout();
                setTimeout(function(){
                    window.location.href = '/';
                }, 1000);
            }
        });
      


    });









    $("#SearchMembers").on("input", function() {
        var query = $(this).val();
    
        if (query.length > 0) {
            $(".Typeahead-menu").addClass("is-open");
    
                $.ajax({
                    url: "/include/api/pages/members.php?action=SearchMembers",
                    method: "POST",
                    data: { q: query },
                    success: function(response) {
                        response = JSON.parse(response);
    
                        if (response.status === "success") {

                            displayResults(response);
                        } else {
                            $(".Typeahead-menu").html('<div class="tt-dataset tt-dataset-0"><div class="EmptyMessage"><p>' + response.message + '</p></div></div>');
                        }
                    }
                });
            
        } else {
            $(".Typeahead-menu").removeClass("is-open");
        }
    });
    
    function displayResults(response) {
        var members = response.data;
        var html = "";
    
        if (members.length > 0) {
            html += '<ul class="list-group">';
            $.each(members, function(index, member) {
                html += `
                    <li class="list-group-item">
                        <a href="#" class="GetSpeedDataMember m-1" data_memberid="${member.member_id}">
                            <span class="text-warning">${member.member_id}</span> |
                            <span class="text-info">${member.first_name} ${member.last_name}</span> |
                            <span class="text-danger">${member.scout_unit}</span>
                        </a>
                    </li>
                `;
            });
            html += "</ul>";
        } else {
            html += "<p>" + response.message + "</p>";
        }
    
        $(".Typeahead-menu").html(html);
    }

    $(document).click(function(e) {
        if (!$(e.target).closest('#SearchMembers').length) {
            $(".Typeahead-menu").removeClass("is-open");
        }
    });





});