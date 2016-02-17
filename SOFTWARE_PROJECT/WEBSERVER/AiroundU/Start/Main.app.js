/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />
/// <reference path="Main.view.js" />

//global value

//get Atoms color
var param = DBParams.create();
param.addParam('WORK_TYPE', 'SEARCH_AIRPOLUTIONLANGE');
var url = '../Server/WebService.php';
var range = DBCONN(url, param);
console.log(range);


tre_sideBar.eClick = function () {
    
}
btn_Logout.eClick = function(){
    location.href = '../server/logout.php';
}
function load_page(node, pjtType) {
    var exist = true;
    for (var i = 0; i < tab_main.items.length; i++) {
        if (tab_main.items.items[i].title == node.text)
            exist = false;
    }
    if (exist) {
        tab_main.addTab(node.text, true).full({
            html: '<iframe src="../Form/' + node.text + '.html?" id=' + node.value.getValue('FORMCD') + '" width="100%" height="100%" frameborder="0"></iframe>',
            closable: true,
            header: false,
            id: node.value.getValue('FORMCD'),
            title: node.text
        });
        tab_main.setActiveTab(tab_main.items.items.length - 1)
    } else {
        for (var i = 0; i < tab_main.items.length; i++) {
            if (tab_main.items.items[i].title == node.text)
                tab_main.setActiveTab(i);
        }
    }
}
tre_sideBar.eDbclick = function (node) {
    if (node.leaf) load_page(node, 'Com');
}

function search_streaming() {

    for (var i = 0; i < map.markerArr.length; i++) {
        map.markerArr[i].setMap(null);
    }
    map.markerArr = [];

    for (var i = 0; i < map.circleArr.length; i++) {
        map.circleArr[i].setMap(null);
    }
    map.circleArr = [];
    var param = DBParams.create();
    param.addParam('WORK_TYPE', 'SEARCH_STREAMING');
    var url = '../Server/WebService.php';
    var ds = DBCONN(url, param);

    if (ds[0].data.items.length == 0) { return; }
    for (var i = 0; i < ds[0].data.items.length; i++) {
        var data = ds[0].data.items[i].data;
        if (cbo_TYPE.getValue() == '0') {
            make_marker(data.LAT, data.LNG, data.TEMP, data.O3, data.SO2, data.NO2, data.CO, data.PM25, data.USER_ID);
        } else {
            make_marker(data.LAT, data.LNG, data.AVG_TEMP, data.AVG_O3, data.AVG_SO2, data.AVG_NO2, data.AVG_CO, data.AVG_PM25, data.USER_ID);
        }

    }
}

var savePos = "";
function make_marker(lat, lng, TEMP, O3, SO2, NO2, CO, PM25, KEY) {
    var marker = new google.maps.Marker({
        position: {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        },
        map: map,
        temperature: TEMP,
        o3: O3,
        so2: SO2,
        no2: NO2,
        co: CO,
        pm25: PM25,
        m_key: KEY
    });
    map.markerArr.push(marker);
    if (savePos != "") {
        if (savePos == KEY) {
            txt_LAT.setValue(lat);
            txt_LNG.setValue(lng);
            txt_TEMP.setValue(TEMP);

            switch (getAqi('O3', 03)[0]) {
                case 0:
                    txt_O3.setValue("<font color='#00e400'>" + O3 + '</font>');
                    break;
                case 1:
                    txt_O3.setValue("<font color='#ffff00'>" + O3 + '</font>');
                    break;
                case 2:
                    txt_O3.setValue("<font color='#ff7e00'>" + O3 + '</font>');
                    break;
                case 3:
                    txt_O3.setValue("<font color='#ff0000'>" + O3 + '</font>');
                    break;
                case 4:
                    txt_O3.setValue("<font color='#99004c'>" + O3 + '</font>');
                    break;
                case 5:
                    txt_O3.setValue("<font color='#7e0023'>" + O3 + '</font>');
                    break;
            }
            switch (getAqi('SO2', SO2)[0]) {
                case 0:
                    txt_SO2.setValue("<font color='#00e400'>" + SO2 + '</font>');
                    break;
                case 1:
                    txt_SO2.setValue("<font color='#ffff00'>" + SO2 + '</font>');
                    break;
                case 2:
                    txt_SO2.setValue("<font color='#ff7e00'>" + SO2 + '</font>');
                    break;
                case 3:
                    txt_SO2.setValue("<font color='#ff0000'>" + SO2 + '</font>');
                    break;
                case 4:
                    txt_SO2.setValue("<font color='#99004c'>" + SO2 + '</font>');
                    break;
                case 5:
                    txt_SO2.setValue("<font color='#7e0023'>" + SO2 + '</font>');
                    break;
            }
            switch (getAqi('NO2', NO2)[0]) {
                case 0:
                    txt_NO2.setValue("<font color='#00e400'>" + NO2 + '</font>');
                    break;
                case 1:
                    txt_NO2.setValue("<font color='#ffff00'>" + NO2 + '</font>');
                    break;
                case 2:
                    txt_NO2.setValue("<font color='#ff7e00'>" + NO2 + '</font>');
                    break;
                case 3:
                    txt_NO2.setValue("<font color='#ff0000'>" + NO2 + '</font>');
                    break;
                case 4:
                    txt_NO2.setValue("<font color='#99004c'>" + NO2 + '</font>');
                    break;
                case 5:
                    txt_NO2.setValue("<font color='#7e0023'>" + NO2 + '</font>');
                    break;
            }
            switch (getAqi('CO', CO)[0]) {
                case 0:
                    txt_CO.setValue("<font color='#00e400'>" + CO + '</font>');
                    break;
                case 1:
                    txt_CO.setValue("<font color='#ffff00'>" + CO + '</font>');
                    break;
                case 2:
                    txt_CO.setValue("<font color='#ff7e00'>" + CO + '</font>');
                    break;
                case 3:
                    txt_CO.setValue("<font color='#ff0000'>" + CO + '</font>');
                    break;
                case 4:
                    txt_CO.setValue("<font color='#99004c'>" + CO + '</font>');
                    break;
                case 5:
                    txt_CO.setValue("<font color='#7e0023'>" + CO + '</font>');
                    break;
            }
            switch (getAqi('PM25', PM25)[0]) {
                case 0:
                    txt_PM25.setValue("<font color='#00e400'>" + PM25 + '</font>');
                    break;
                case 1:
                    txt_PM25.setValue("<font color='#ffff00'>" + PM25 + '</font>');
                    break;
                case 2:
                    txt_PM25.setValue("<font color='#ff7e00'>" + PM25 + '</font>');
                    break;
                case 3:
                    txt_PM25.setValue("<font color='#ff0000'>" + PM25 + '</font>');
                    break;
                case 4:
                    txt_PM25.setValue("<font color='#99004c'>" + PM25 + '</font>');
                    break;
                case 5:
                    txt_PM25.setValue("<font color='#7e0023'>" + PM25 + '</font>');
                    break;
            }

        }
    }

    // Add the circle for this city to the map.
    var color = check_color(O3, SO2, NO2, CO, PM25);
    var circle = new google.maps.Circle({
        strokeOpacity: 0,
        strokeWeight: 0,
        fillColor: color,
        fillOpacity: 0.35,
        map: map,
        center: {
            lat: parseFloat(lat),
            lng: parseFloat(lng),
        },
        radius: 100 //야드일수 있음.
    });
    map.circleArr.push(circle);

    //marker clicl listener
    marker.addListener('click', function () {

        //databind
        savePos = marker.m_key;
        txt_LAT.setValue(marker.position.lat());
        txt_LNG.setValue(marker.position.lng());
        txt_TEMP.setValue(marker.temperature);

        switch (getAqi('O3', marker.o3)[0]) {
            case 0:
                txt_O3.setValue("<font color='#00e400'>" + marker.o3 + '</font>');
                break;
            case 1:
                txt_O3.setValue("<font color='#ffff00'>" + marker.o3 + '</font>');
                break;
            case 2:
                txt_O3.setValue("<font color='#ff7e00'>" + marker.o3 + '</font>');
                break;
            case 3:
                txt_O3.setValue("<font color='#ff0000'>" + marker.o3 + '</font>');
                break;
            case 4:
                txt_O3.setValue("<font color='#99004c'>" + marker.o3 + '</font>');
                break;
            case 5:
                txt_O3.setValue("<font color='#7e0023'>" + marker.o3 + '</font>');
                break;
        }
        switch (getAqi('SO2', marker.so2)[0]) {
            case 0:
                txt_SO2.setValue("<font color='#00e400'>" + marker.so2 + '</font>');
                break;
            case 1:
                txt_SO2.setValue("<font color='#ffff00'>" + marker.so2 + '</font>');
                break;
            case 2:
                txt_SO2.setValue("<font color='#ff7e00'>" + marker.so2 + '</font>');
                break;
            case 3:
                txt_SO2.setValue("<font color='#ff0000'>" + marker.so2 + '</font>');
                break;
            case 4:
                txt_SO2.setValue("<font color='#99004c'>" + marker.so2 + '</font>');
                break;
            case 5:
                txt_SO2.setValue("<font color='#7e0023'>" + marker.so2 + '</font>');
                break;
        }
        switch (getAqi('NO2', marker.no2)[0]) {
            case 0:
                txt_NO2.setValue("<font color='#00e400'>" + marker.no2 + '</font>');
                break;
            case 1:
                txt_NO2.setValue("<font color='#ffff00'>" + marker.no2 + '</font>');
                break;
            case 2:
                txt_NO2.setValue("<font color='#ff7e00'>" + marker.no2 + '</font>');
                break;
            case 3:
                txt_NO2.setValue("<font color='#ff0000'>" + marker.no2 + '</font>');
                break;
            case 4:
                txt_NO2.setValue("<font color='#99004c'>" + marker.no2 + '</font>');
                break;
            case 5:
                txt_NO2.setValue("<font color='#7e0023'>" + marker.no2 + '</font>');
                break;
        }
        switch (getAqi('CO', marker.co)[0]) {
            case 0:
                txt_CO.setValue("<font color='#00e400'>" + marker.co + '</font>');
                break;
            case 1:
                txt_CO.setValue("<font color='#ffff00'>" + marker.co + '</font>');
                break;
            case 2:
                txt_CO.setValue("<font color='#ff7e00'>" + marker.co + '</font>');
                break;
            case 3:
                txt_CO.setValue("<font color='#ff0000'>" + marker.co + '</font>');
                break;
            case 4:
                txt_CO.setValue("<font color='#99004c'>" + marker.co + '</font>');
                break;
            case 5:
                txt_CO.setValue("<font color='#7e0023'>" + marker.co + '</font>');
                break;
        }
        switch (getAqi('PM25', marker.pm25)[0]) {
            case 0:
                txt_PM25.setValue("<font color='#00e400'>" + marker.pm25 + '</font>');
                break;
            case 1:
                txt_PM25.setValue("<font color='#ffff00'>" + marker.pm25 + '</font>');
                break;
            case 2:
                txt_PM25.setValue("<font color='#ff7e00'>" + marker.pm25 + '</font>');
                break;
            case 3:
                txt_PM25.setValue("<font color='#ff0000'>" + marker.pm25 + '</font>');
                break;
            case 4:
                txt_PM25.setValue("<font color='#99004c'>" + marker.pm25 + '</font>');
                break;
            case 5:
                txt_PM25.setValue("<font color='#7e0023'>" + marker.pm25 + '</font>');
                break;
        }

        //map.setCenter(marker.getPosition());
        pnl_mapData.expand(true);
    });

}
//color checker
function check_color(O3, SO2, NO2, CO, PM25) {
    var green = '#00e400';
    var yellow = '#ffff00';
    var orange = '#ff7e00';
    var red = '#ff0000';
    var Purple = '#99004c';
    var Maroon = '#7e0023';
    var arrColor = [green, yellow, orange, red, Purple, Maroon];

    var arrLevel = [];
    //push selected data to arrData
    if (chk_O3.getValue()) {
        var arrResult = getAqi('O3', O3);
        arrLevel.push(arrResult[0]);
    }
    if (chk_SO2.getValue()) {
        var arrResult = getAqi('SO2', SO2);
        arrLevel.push(arrResult[0]);
    }
    if (chk_NO2.getValue()) {
        var arrResult = getAqi('NO2', NO2);
        arrLevel.push(arrResult[0]);
    }
    if (chk_CO.getValue()) {
        var arrResult = getAqi('CO', CO);
        arrLevel.push(arrResult[0]);
    }
    if (chk_PM25.getValue()) {
        var arrResult = getAqi('PM25', PM25);
        arrLevel.push(arrResult[0]);
    }
    var colorLevel = Math.max.apply(null, arrLevel)

    return arrColor[colorLevel];

}