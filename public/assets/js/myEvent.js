function disableWeekends($this) {
    var $days = $this.find('.datepicker-days tr').each(function() {
        var $days = $(this).find('.day');
        // disable days
        for (var i = 0; i < 2; i++) {
            if (i == 5) continue;
            $days.eq(i).addClass('old').click(false);
        }
    });

}

// create the date picker
try {
    for (var i = 1; i < 3; i++) {
        $('#dp' + i).datepicker({
            format: 'yyyy-mm-dd',
            "autoclose": true
        });
        var datepicker = $('#dp' + i).data('datepicker');

        // disable weekends in the pre-rendered version
        disableWeekends(datepicker.picker);

        // disable weekends whenever the month changes
        var _fill = datepicker.fill;
        datepicker.fill = function() {
            _fill.call(this);
            disableWeekends(this.picker);
        };
    }
    
} catch {}

const primary = "#6993FF",
	success = "#1BC5BD",
	info = "#8950FC",
	warning = "#FFA800",
    danger = "#F64E60";
var realFlag = false;
function chartDraw() {
    try {
        $.ajax({
            url: '/getchartinfodata',
            type: 'POST',
            data: {
                _token: $("[name='_token']").val()
            },
            success: function(data) {
                var currentCensus = data['currentCensus'];
                var buildings = data['buildings'];
                var seriesArr = [], buildingName = [];
                for(var i = 0 ; i < buildings.length ; i++) {
                    buildingName.push(buildings[i]['name']);
                    seriesArr.push(currentCensus.filter(item=>item.name == buildings[i]['name']).length);
                }
                var e = {
                    series: seriesArr,
                    chart: {
                        width: 380,
                        type: "pie"
                    },
                    labels: buildingName,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: "left"
                            }
                        }
                    }],
                    colors: [primary, success, danger, info]
                };
                new ApexCharts(document.querySelector("#chart_12"), e).render();
                var censusSum = [0,0,0,0], capacitySum = [0,0,0,0];
        
                for(var i = 0 ; i < currentCensus.length ; i++) {
                    if(currentCensus[i]['building_id'] == 1) {
                        censusSum[0] += currentCensus[i]['capacity'];
                        capacitySum[0] += currentCensus[i]['census'];
                    } else if (currentCensus[i]['building_id'] == 2) {
                        censusSum[1] += currentCensus[i]['capacity'];
                        capacitySum[1] += currentCensus[i]['census'];
                    } else if (currentCensus[i]['building_id'] == 3) {
                        censusSum[2] += currentCensus[i]['capacity'];
                        capacitySum[2] += currentCensus[i]['census'];
                    } else if (currentCensus[i]['building_id'] == 4) {
                        censusSum[3] += currentCensus[i]['capacity'];
                        capacitySum[3] += currentCensus[i]['census'];
                    }
                }
        
                var e1 = {
                    series: [{
                        name: "Current Census",
                        data: censusSum
                    }, {
                        name: "Total capacity",
                        data: capacitySum
                    }],
                    chart: {
                        type: "bar",
                        height: 500
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "55%",
                            endingShape: "rounded"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    xaxis: {
                        categories: buildingName
                    },
                    yaxis: {
                        title: {
                            text: ""
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(e1) {
                                return e1
                            }
                        }
                    },
                    colors: [primary, warning]
                };
                new ApexCharts(document.querySelector("#chart_3"), e1).render()
        
            }
        })
        realFlag = true;
    } catch (error) {
    }
}

if(realFlag == false) {
    chartDraw();
}

var mainVal = ["", "", "", "", "", "", "", "", "", ""];

function getExactlyDate(val) {
    var NowDate = val.value.split('-');
    for (var i = 0; i < NowDate.length; i++) {
        NowDate[i] = parseInt(NowDate[i]);
    }

    var monthDates = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if (NowDate[0] % 4 == 0) {
        monthDates[1] = 29;
    }

    NowDate[2] = NowDate[2] + 6;
    if (NowDate[2] > monthDates[NowDate[1] - 1]) {
        NowDate[2] -= monthDates[NowDate[1] - 1];
        NowDate[1] += 1;
    }

    if (NowDate[1] > 12) {
        NowDate[1] = 1;
        NowDate[0] += 1;
    }
    var finalDate = "";
    for (var i = 0; i < NowDate.length; i++) {
        if (NowDate[i] < 10) {
            NowDate[i] = '0' + NowDate[i];
        } else {
            NowDate[i] = '' + NowDate[i];
        }
    }
    finalDate += NowDate[0] + '-' + NowDate[1] + '-' + NowDate[2];
    var eval = null;
    $.ajax({
        url: '/getDateinfo',
        type: 'post',
        data: {
            _token: $("[name='_token']").val(),
            from: val.value,
            to: finalDate
        },
        async: false,
        success: function(data) {
            if(data != null) {
                eval = data;
            }
        },
        error: function(xhr, ajaxOptions, error) {
            eval = null;
        }
    })
    return eval;
}

async function setValFrom(val) {
    var finalVal = await getExactlyDate(val);
    if (finalVal == null || finalVal == "") {

        hgreportAlert("First date is missing!");

        if (localStorage.getItem('period_id_to') != "") {
            $('.submitInput1').attr('type', 'button');
            $('.submitInput1').next().attr('style', 'background: #80808f !important;');
        }
        if(localStorage.getItem('period_id_to') == "" || localStorage.getItem('period_id_to') == "Select date")  {
            $('.submitInput').attr('type', 'button');
            $('.submitInput').next().attr('style', 'background: #80808f !important;');
            $('.submitInput1').attr('type', 'button');
            $('.submitInput1').next().attr('style', 'background: #80808f !important;');
        }

        localStorage.setItem('period_id_from', 'Select date');
    } else {
        if (localStorage.getItem('period_id_to') != "" && localStorage.getItem('period_id_to') != "Select date") {
            $('.submitInput1').attr('type', 'submit');
            $('.submitInput1').next().attr('style', 'background: var(--main-color-one) !important;');

            $('.submitInput').attr('type', 'submit');
            $('.period_id_from').attr('date', finalVal['id']);
            $('.submitInput').next().attr('style', 'background: var(--main-color-one) !important;');
        } else {
            $('.submitInput').attr('type', 'submit');
            $('.submitInput').next().attr('style', 'background: var(--main-color-one) !important;');
        }
        localStorage.setItem('period_id_from', finalVal['caption']);
        localStorage.setItem('period_id_from1', finalVal['id']);
        localStorage.setItem('period_id_from2', finalVal['starting']);
        $(val).attr({ 'value': finalVal['caption'], 'date': finalVal['id'] });
    }
    $('body').click();
    $("#inp_temp").focus();
}

async function setValTo(val) {
    var finalVal = await getExactlyDate(val);
    if (finalVal == null || finalVal == "") {

        hgreportAlert("Second date is missing!");

        if (localStorage.getItem('period_id_from') != "") {
            $('.submitInput1').attr('type', 'button');
            $('.submitInput1').next().attr('style', 'background: #80808f !important;');
        }
        if(localStorage.getItem('period_id_from') == "" || localStorage.getItem('period_id_from') == "Select date") {
            $('.submitInput').attr('type', 'button');
            $('.submitInput').next().attr('style', 'background: #80808f !important;');
            $('.submitInput1').attr('type', 'button');
            $('.submitInput1').next().attr('style', 'background: #80808f !important;');
        }

        localStorage.setItem('period_id_to', 'Select date');

    } else {
        if (localStorage.getItem('period_id_from') != "" && localStorage.getItem('period_id_from') != "Select date") {
            $('.submitInput1').attr('type', 'submit');
            $('.submitInput1').next().attr('style', 'background: var(--main-color-one) !important;');

            $('.submitInput').attr('type', 'submit');
            $('.period_id_to').attr('date', finalVal['id']);
            $('.submitInput').next().attr('style', 'background: var(--main-color-one) !important;');
        } else {
            $('.submitInput').attr('type', 'submit');
            $('.submitInput').next().attr('style', 'background: var(--main-color-one) !important;');
        }
        localStorage.setItem('period_id_to', finalVal['caption']);
        localStorage.setItem('period_id_to1', finalVal['id']);
        localStorage.setItem('period_id_to2', finalVal['starting']);
        $(val).attr({ 'value': finalVal['caption'], 'date': finalVal['id'] });
    }
    $('body').click();
    $("#inp_temp").focus();
}

function hgreportAlert(data) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.error(data);
}

function suhgreportAlert(data) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.success(data);
}

$('body').on('click', '#login_signup_form [class="dropdown-item"]', function() {
    $(this).parent().prev().text($(this).text());
})

$('body').on('click', '.editActionq .viewreportcommon1 .dropdown-menu ul li', function(){
    $('.viewreportcommon1').prev().attr('value', communities.filter(item => item.name == $(this).text().trim())[0]['id']);
    $('.viewreportcommon1').next().next().click();
})

$('body').on('click', '.viewreportcommon .dropdown-menu ul li', function() {
    $('.viewreportcommon').prev().attr('value', communities.filter(item => item.name == $(this).text().trim())[0]['id']);
    $('.viewreportcommon').next().next().click();
})


$('body').on('click', '.mainContainer ul li', function() {
    if ($(this).attr('cId')) {
        $(this).parent().parent().parent().prev().children().children().children().attr('value', $(this).attr('cId'));
        $(this).parent().parent().parent().prev().children().children().children().val($(this).attr('cId'));
    } else if ($(this).attr('pFrom')) {
        $(this).parent().parent().parent().prev().children().children().children().attr('value', $(this).attr('pFrom'));
        $(this).parent().parent().parent().prev().children().children().children().val($(this).attr('pFrom'));
    } else if ($(this).attr('pTo')) {
        $(this).parent().parent().parent().prev().children().children().children().attr('value', $(this).attr('pTo'));
        $(this).parent().parent().parent().prev().children().children().children().val($(this).attr('pTo'));
    } else {
        $(this).parent().parent().parent().prev().children().children().children().attr('value', $(this).attr('pId'));
        $(this).parent().parent().parent().prev().children().children().children().val($(this).attr('pId'));
    }
})
$('body').on('click', '#UpdateUserModalCenter ul li a', function() {
    var mainValue = $(this).children().text().trim();
    var ddd = JSON.parse(communitiess);
    for(var i = 0 ; i < ddd.length ; i++) {
        if(ddd[i]['name'].trim() == mainValue) {
            $(this).parent().parent().parent().parent().parent().prev().attr('value', ddd[i]['id']);
        }
    }
})

$('body').on('click', '#kt_login_signup', function() {
    $('.login-class').hide('slow');
    $('.login-signup').show('slow');
})

$('body').on('click', '#kt_login_forgot', function() {
    $('.login-class').hide('slow');
    $('.login-forgot').show('slow');
})

$('body').on('click', '#kt_login_forgot_cancel', function() {
    $('.login-class').show('slow');
    $('.login-forgot').hide('slow');
})

$('body').on('click', '#kt_login_signup_cancel', function() {
    $('.login-signup').hide('slow');
    $('.login-class').show('slow');
})

$('body').on('click', '.gotoPage', function() {
    $('#goTopageAction').parent().attr('action', $(this).attr('href'));
    $('#goTopageAction').click();
})

$('body').on('click', ".changePasswordModal", function() {
    $('#mainId').val($(this).parent().parent().parent().attr('id-value'));
    $('#modalName').text($(this).parent().parent().parent().attr('nameValue'));
    $('#changePasswordModal').click();
})

$('body').on('click', '.signupinfo .dropdown-menu .dropdown-item', function() {
    $(this).parent().prev().val($(this).attr('type'));
})

$('body').on('click', '#PasswordUpdate', function() {
    $('#sendUpdate').click();
})

$('body').on('click', '.newUser', function() {
    $('#mainIdAdd').attr('value', $(this).parent().attr('id-value'));
    $('body #AddUserModal').click();
})

$('body').on('click', '.OrderName', function() {
    var mainValue = $($(this).parent().children()[$(this).parent().children().length - 1]).children();
    $('#mainIdUpdate').attr('value', $(this).parent().attr('id-value'));
    $('.mUsername').val(mainValue.attr('type0'));

    $('.mCommunity_id').attr('value', mainValue.attr('type1'));
    var ddd = JSON.parse(communitiess);
    for(var i = 0 ; i < ddd.length ; i++) {
        if(ddd[i]['id'] == mainValue.attr('type1')) {
            $('.mCommunity_id_value button').children().children().children().text(ddd[i]['name']);
        }
    }
    $('.mName').val(mainValue.attr('type2'));
    $('.mEmail').val(mainValue.attr('type3'));
    $('.mPosition').val(mainValue.attr('type4'));
    
    $('.mLeveladd').attr('value', mainValue.attr('type9'));
    if($(".leveladdDropdown [type='"+mainValue.attr('type9')+"']").text() != "") {
        $('.leveladdDropdown button').text($(".leveladdDropdown [type='"+mainValue.attr('type9')+"']").text());
    }

    $('.mLeveledit').attr('value', mainValue.attr('type5'));
    if($(".leveleditDropdown [type='"+mainValue.attr('type5')+"']").text() != "") {
        $('.leveleditDropdown button').text($(".leveleditDropdown [type='"+mainValue.attr('type5')+"']").text());
    }

    $('.mLevelreport').attr('value', mainValue.attr('type6'));
    if($(".levelreportDropdown [type='"+mainValue.attr('type6')+"']").text() != "") {
        $('.levelreportDropdown button').text($(".levelreportDropdown [type='"+mainValue.attr('type6')+"']").text());
    }

    $('.mLevelcompany').attr('value', mainValue.attr('type7'));
    if($(".levelcompanyDropdown [type='"+mainValue.attr('type7')+"']").text() != "") {
        $('.levelcompanyDropdown button').text($(".levelcompanyDropdown [type='"+mainValue.attr('type7')+"']").text());
    }

    $('.mLeveluser').attr('value', mainValue.attr('type8'));
    if($(".leveluserDropdown [type='"+mainValue.attr('type8')+"']").text() != "") {
        $('.leveluserDropdown button').text($(".leveluserDropdown [type='"+mainValue.attr('type8')+"']").text());
    }

    $('.mLevelreportm').attr('value', mainValue.attr('type10'));
    if($(".levelreportmrDropdown [type='"+mainValue.attr('type10')+"']").text() != "") {
        $('.levelreportmrDropdown button').text($(".levelreportmrDropdown [type='"+mainValue.attr('type10')+"']").text());
    }

    $('body #UpdateUserModal').click();
})
$('body').on('click', '.inactiveBtn', function() {
    $('#activeId').attr('value', $(this).parent().parent().parent().attr('id-value'));
    if ($(this).text() == 'Active') {
        $(this).text('Inactive');
        $('#statuId').attr('value', '0');
    } else {
        $('#statuId').attr('value', '1');
        $(this).text('Active');
    }
    $('#changeactive').click();
})

$('body').on('click', '.dropdown-menu .dropdown-item', function() {
    $(this).parent().parent().parent().parent().prev().children().children().children().attr('value', $(this).attr('type'));
    $(this).parent().parent().parent().parent().prev().children().children().children().text($(this).children().text());
})

$('body').on('click', '.loginBtn', function() {
    $('#kt_login_signin_submit').click();
})

$('body').on('mouseenter', '.table-condensed td:nth-child(6)', function() {
    $(this).next().attr('style', 'background: #eee !important; color: black;');
    for (var i = 0; i < 4; i++) {
        $($(this).parent().next().children()[i]).attr('style', 'background: #eee !important; color: black;');
    }
    $($(this).parent().next().children()[i]).attr('style', 'background: crimson !important; color: black;');
})

$('body').on('mouseout', '.table-condensed td:nth-child(6)', function() {
    $(this).next().attr('style', 'background: #fff !important;');
    for (var i = 0; i < 5; i++) {
        $($(this).parent().next().children()[i]).attr('style', 'background: #fff !important; color: #80808f;');
    }
})

$('body').on('click', '.cm', function() {
    $(this).children().focus();
    $(this).children().focus();
})

$('body').on('click', '#AddUserModalCenter .dropdown-item, #UpdateUserModalCenter .dropdown-item', function() {
    $(this).parent().prev().prev().text($(this).text());
    $(this).parent().prev().attr('value', $(this).attr('type'));
})



$('body').on('click', '.goBtn', function() {
    if ($(this).prev().attr('type') == 'button') {
        hgreportAlert('Input correct info');
    } else {
        var prevName = $(this).prev().prev().attr('name');
        if (prevName == 'period_id') {
            var exD = $('.period_id_from').attr('date') || $('.period_id_to').attr('date');
            $(this).prev().prev().attr('value', exD);
        } else if (prevName == 'period_id_to') {
            var exDfrom = $('.period_id_from').attr('date');
            $(this).prev().prev().prev().attr('value', exDfrom);
            var exDto = $('.period_id_to').attr('date');
            $(this).prev().prev().attr('value', exDto);
        }
        if ($(this).attr('option') == 'edit') {
            var exD = $('.period_id_from').attr('date') || $('.period_id_to').attr('date');
            $(this).parent().parent().parent().parent().attr('action', 'editaction');
            $(this).parent().parent().parent().find('.period_id').attr('value', exD);
        }
        if ($(this).attr('option1') == 'community_id') {
            var Mname = $(this).parent().parent().parent().find('.filter-option-inner-inner').text().trim();
            for (var i = 0; i < communities.length; i++) {
                if (Mname == communities[i]['name'].trim()) {
                    $(this).parent().parent().parent().find('.com').attr('value', communities[i]['id']);
                }
            }
        }
        $(this).prev().click();
    }
})

$(document).ready(function() {
    $("body").on("keyup", '.dropdownList', function() {
        var value = $(this).val().toLowerCase();
        $(this).parent().next().find('li').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

$('body').on('click', '.debtn_1', function() {
    var obj = {
        _token: $('[name="_token"]').attr('value'),
        report_id: $('#report_id').attr('value'),
        building_id: $(this).parent().prev().prev().prev().find('.bId').attr('value'),
        census: $(this).parent().prev().prev().children().attr('value'),
        capacity: $(this).parent().prev().children().attr('value')
    }
    $.ajax({
        url: 'removecc',
        type: 'post',
        data: obj,
        success: function(data) {
            suhgreportAlert(data);
        },
        fail: function() {
            hgreportAlert('Server Error!');
        }
    })
    $(this).parent().parent().remove();
})

$('body').on('click', '.addbtn_1', function() {
    var num = $('#ccs_num').val();
    $('#ccs_num').attr('value', parseInt(num) + 1);
    if (buildingsData) {
        var AddStr = `<tr><td class="w-30"><div class="dropdown bootstrap-select form-control EditactionCencaps"><div class="dropdown bootstrap-select form-control"><button aria-expanded="false" aria-haspopup="listbox" aria-owns="bs-select-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" tabindex="-1" title="Manor" type="button"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Manor</div></div></div></button><div class="dropdown-menu" style="max-height: 678.063px; overflow: hidden; min-height: 188px;"><div class="bs-searchbox"><input aria-activedescendant="bs-select-1-0" aria-autocomplete="list" aria-controls="bs-select-1" aria-label="Search" autocomplete="off" class="form-control dropdownList" role="combobox" type="search"></div><div class="inner show" id="bs-select-1" role="listbox" style="max-height: 608.063px; overflow-y: auto; min-height: 118px;" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation" style="margin-top: 0px; margin-bottom: 0px;"><li class="selected active"><a aria-posinset="1" aria-selected="true" aria-setsize="4" class="dropdown-item active selected" id="bs-select-1-0" role="option" tabindex="0">` + '<span class="text dropDownBuildings" cid="' + buildingsData[0]['id'] + '" >' + buildingsData[0]['name'] + '</span></a></li>';
        for (var i = 1; i < buildingsData.length; i++) {
            AddStr += `<li><a aria-posinset="2" aria-setsize="4" class="dropdown-item" id="bs-select-1-1" role="option" tabindex="0"><span class="text" cId="` + buildingsData[i]['id'] + `">` + buildingsData[i]['name'] + `</span></a></li>`;
        }
        AddStr += `</ul></div></div></div></div><input value="1" name="_buildingid,` + num + `" class="dn bId"></td><td class="w-30"><input value="" name="_census,` + num + `" class="form-control form-control-solid"></td><td class="w-30"><input value="" name="_capacity,` + num + `" class="form-control form-control-solid"></td><td class="w-10"><a class="btn btn-sm btn-clean btn-icon debtn_1" href="javascript:;" title="Delete"><span class="svg-icon svg-icon-md"><svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1"><rect height="24" width="24" x="0" y="0"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span></a></td></tr>`;
        $(this).parent().prev().children().append(AddStr);
    }
})

$('body').on('click', '.addbtn_2', function() {
    var num = $('#inquiries_num').val();
    $('#inquiries_num').attr('value', parseInt(num) + 1);
    var str = `
        <tr>
            <td class="w-45">
                <input value="" name="idesctiption_Inquiries_description-` + num + `" class="form-control form-control-solid">
            </td>
            <td class="w-45">
                <input value="" name="icount_Inquiries_count-` + num + `" class="form-control form-control-solid">
            </td>
            <td class="w-10">
                <a class="btn btn-sm btn-clean btn-icon delBtn" type="inquries" href="javascript:;" title="Delete">
                    <span class="svg-icon svg-icon-md">
                        <svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
                                <rect height="24" width="24" x="0" y="0"></rect>
                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                    </span>
                </a>
            </td>
        </tr>`
    $(this).parent().prev().children().append(str);
})

$('body').on('click', '.addbtn_3', function() {
    var num = $('#moveouts_num').val();
    $('#moveouts_num').attr('value', parseInt(num) + 1);
    var str = `
    <tr>
        <td class="w-45">
            <input value="" name="md_moveouts_description-` + num + `" class="form-control form-control-solid">
        </td>
        <td class="w-45">
            <input value="" name="md_moveouts_number-` + num + `" class="form-control form-control-solid">
        </td>
        <td class="w-10">
            <a class="btn btn-sm btn-clean btn-icon delBtn" type="moveouts" href="javascript:;" title="Delete">
                <span class="svg-icon svg-icon-md">
                    <svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
                            <rect height="24" width="24" x="0" y="0"></rect>
                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                        </g>
                    </svg>
                </span>
            </a>
        </td>
    </tr>`
    $(this).parent().prev().children().append(str);
})

$('body').on('click', '.delBtn', function() {
    if ($(this).attr('type') == 'inquries') {
        var getinfo = $(this).parent().prev().prev().children().attr('name').split(',');
        if (getinfo.length == 3) {
            $.ajax({
                url: 'removeinquries',
                type: 'post',
                data: {
                    _token: $('[name="_token"]').attr('value'),
                    id: getinfo[2]
                },
                success: function(data) {
                    if (data == 'sccuss') {
                        suhgreportAlert('Remove successfuly.');
                    }
                }
            })
        }
    } else if ($(this).attr('type') == 'moveouts') {
        var getinfo = $(this).parent().prev().prev().children().attr('name').split(',');
        if (getinfo.length == 3) {
            $.ajax({
                url: 'removemoveouts',
                type: 'post',
                data: {
                    _token: $('[name="_token"]').attr('value'),
                    description: getinfo[2],
                    report_id: $('#report_id').attr('value')
                },
                success: function(data) {
                    if (data == 'sccuss') {
                        suhgreportAlert('Remove successfuly.');
                    }
                }
            })
        }
    }
    $(this).parent().parent().remove();
})

$('body').on('click', '.EditactionCencaps a', function() {
    for (var i = 0; i < buildingsData.length; i++) {
        if (buildingsData[i]['name'] == $(this).children().text()) {
            $(this).parent().parent().parent().parent().parent().parent().next().attr('value', buildingsData[i]['id']);
        }
    }
})

async function refresh(parent) {
    if(localStorage.getItem('setDatelocal') == "true") {
        localStorage.setItem('setDatelocal', 'false');
        var finalVal = await getExactlyDate(parent);
        $(parent).attr('value', finalVal['caption']);
        $(parent).val(finalVal['caption']);
        $(parent).prev().prev().attr('value', finalVal['id']);
    } else {
        var finalVal = await getExactlyDate(parent);
        if(finalVal == null) {
            hgreportAlert("Date is missing!");
        } else {
            localStorage.setItem('period_from', finalVal['caption']);
            localStorage.setItem('period_from1', finalVal['id']);
            $(parent).prev().prev().attr('value', finalVal['id']);
            $(parent).prev().click();
            $('#randomBtn').click();
        }
    }
}
$('body').on('click', '.addBtn', function(){
    $('body .uploadBtn').click();
})
// '<span class="iconify sortEm" data-icon="fa-solid:sort-amount-down" data-inline="false"></span>'
// '<span class="iconify sortEm" data-icon="fa-solid:sort-amount-up-alt" data-inline="false"></span>'
function sortTable(f,n){
	var rows = $('#kt_datatable2 tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getVal(a);
		var B = getVal(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getVal(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#kt_datatable2').children('tbody').append(row);
	});
}
var SortArr = [];
var localValue = null;
try {
    localValue = $('.sortEmotic').attr('SDType');
    var sortValA = localStorage.getItem(localValue).split(',');
    if(sortValA[0] === '1') {
        $('#sortname'+sortValA[1]).append('<span class="iconify sortEm" data-icon="fa-solid:sort-amount-down" data-inline="false" style="color: #7236f1 !important;"></span>');
    } else {
        $('#sortname'+sortValA[1]).append('<span class="iconify sortEm" data-icon="fa-solid:sort-amount-up-alt" data-inline="false" style="color: #7236f1 !important;"></span>');
    }
    sortTable(parseInt(sortValA[0]), parseInt(sortValA[1]));
} catch (error) {}

for(var i = 0 ; i <= $('.sortEmotic').children().length ; i++) {
	var obj = {};
    obj['name'] = 'sortname'+i;
    obj['value'] = 1;
	SortArr.push(obj);
}
$('body').on('click', '#kt_datatable2 th', function() {
    var index = SortArr.findIndex(item => item.name === $(this).attr('id'));
    SortArr[index]['value'] *= -1;
    var n = $(this).prevAll().length;
    localStorage.setItem(localValue, SortArr[index]['value'] +','+ n);
    $('.sortEm').remove();
    if(SortArr[index]['value'] === 1) {
        $('#sortname'+n).append('<span class="iconify sortEm" data-icon="fa-solid:sort-amount-down" data-inline="false" style="color: #7236f1 !important;"></span>');
    } else {
        $('#sortname'+n).append('<span class="iconify sortEm" data-icon="fa-solid:sort-amount-up-alt" data-inline="false" style="color: #7236f1 !important;"></span>');
    }
    sortTable(SortArr[index]['value'],n);
})


var KTLayoutStretchedCard=function() {
	// Private properties
	var _element;

	// Private functions
	var _init=function() {
		var scroll=KTUtil.find(_element, '.card-scroll');
		var cardBody=KTUtil.find(_element, '.card-body');
		var cardHeader=KTUtil.find(_element, '.card-header');

		var height=KTLayoutContent.getHeight();

		height=height - parseInt(KTUtil.actualHeight(cardHeader));

		height=height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
		height=height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element, 'paddingBottom'));

		height=height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody, 'paddingBottom'));
		height=height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));

		height=height - 3;

		KTUtil.css(scroll, 'height', height + 'px');
	}

	// Public methods
	return {
		init: function(id) {
			_element=KTUtil.getById(id);

			if ( !_element) {
				return;
			}

			// Initialize
			_init();

			// Re-calculate on window resize
			KTUtil.addResizeHandler(function() {
					_init();
				}
			);
		},

		update: function() {
			_init();
		}
	};
}();

// Webpack support
if (typeof module !=='undefined') {
	module.exports=KTLayoutStretchedCard;
}

$('body').on('click', '.changePass', function(){
    $(this).attr('class', 'btn btn-primary okBtn');
    $(this).text('Change');
    $(this).next().show('slow');
    $(this).parent().next().children().children().children().show('slow');
})
$('body').on('click', '.cancellBtn', function(){
    $(this).prev().attr('class', 'btn btn-primary changePass');
    $(this).prev().text('Change Password');
    $(this).hide('slow');
    $(this).parent().next().children().children().children().hide('slow');
})
$('body').on('click', '.okBtn', function(){
    $('.changeConfirmBtn').click();
})

$('body').on('click', '.changeReportBtn', function(){
    $(this).parent().prev().find('.cpeBtn').click();
})
// profileuser

var uflag = false;

$('body').on('keyup', '.profileuser', function(){
    uflag = true;
})

var eflag = false;

$('body').on('keyup', '.profileemail', function(){
    eflag = true;
})

$('body').click(function() {
    for (var i = 0; i < mainVal.length; i++) {
        if (mainVal[i] != "") {
            $('#dp' + (i + 1)).attr('value', mainVal[i]);
        }
    }
    $('.period_id_from').attr('value', localStorage.getItem('period_id_from'));

    $('.period_id_from').attr('date', localStorage.getItem('period_id_from1'));
    $('.period_id_to').attr('value', localStorage.getItem('period_id_to'));

    $('.period_id_to').attr('date', localStorage.getItem('period_id_to1'));
    
    if(uflag == true || eflag == true) {
        $.ajax({
            type: 'post',
            url : 'editprofile',
            data : {
                _token : $('[name = "_token"]').attr('value'),
                oldname : $('.profileuser').attr('value'),
                oldemail : $('.profileemail').attr('value'),
                value1 : $('.profileuser').val(),
                value2 : $('.profileemail').val(),
            }
        })
    }
    
    uflag = false;
    eflag = false;
})

$('body').on('click', '.kt_login_signup_submit_Btn', function(){
    $('.reportmanageqq').click();
})
var eTypeV = "";
function whateditFunc(parent) {
    var eT = $(parent).attr('eType');
    if(eTypeV.length == 0) {
        eTypeV += eT;
    } else if(eTypeV.indexOf(eT) == -1){
        eTypeV += ','+eT;
    }
    $(".whateditC").attr('value', eTypeV);
    $(".whateditC").val(eTypeV);
}
