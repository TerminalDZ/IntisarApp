$(document).ready(function() {
    var token = $('#token').val();

    //getGenderData
    function getGenderData() {


        $.ajax({
            url: '/include/api/pages/home.php?action=getGenderData&token=' + token,
            type: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                const ctx = $('#genderChart')[0].getContext('2d');
                
                new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'توزيع المنخرطين حسب الجنس'
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    getGenderData();


    //getUnitScoutData
    function getUnitScoutData() {

        $.ajax({
            url: '/include/api/pages/home.php?action=getUnitScoutData&token=' + token,
            type: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                console.log(data);
                const ctx = $('#UnitScoutChart')[0].getContext('2d');
                
                new Chart(ctx, {
                    type: 'polarArea',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'توزيع المنخرطين حسب الوحدة'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'عدد المنخرطين',
                                    ticks: {
                                        stepSize: 10,
                                        
                                    }
                                }
                            }
                        }
                    }
                });


                
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    getUnitScoutData();

  

});