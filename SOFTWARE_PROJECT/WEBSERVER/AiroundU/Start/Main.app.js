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
        make_marker(data.LAT, data.LNG, data.TEMP, data.O3, data.SO2, data.NO2, data.CO, data.PM25);
    }
}

function make_marker(lat, lng, TEMP, O3, SO2, NO2, CO, PM25) {
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
        pm25: PM25
    });
    map.markerArr.push(marker);

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
        txt_LAT.setValue(marker.position.lat());
        txt_LNG.setValue(marker.position.lng());
        txt_TEMP.setValue(marker.temperature);
        txt_O3.setValue(marker.o3);
        txt_SO2.setValue(marker.so2);
        txt_NO2.setValue(marker.no2);
        txt_CO.setValue(marker.co);
        txt_PM25.setValue(marker.pm25);

        map.setCenter(marker.getPosition());
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
    var rangeO3 = Array();
    rangeO3.push(range[0].data.items[0].data.VALUE1);
    rangeO3.push(range[0].data.items[0].data.VALUE2);
    rangeO3.push(range[0].data.items[0].data.VALUE3);
    rangeO3.push(range[0].data.items[0].data.VALUE4);
    rangeO3.push(range[0].data.items[0].data.VALUE5);
    rangeO3.push(range[0].data.items[0].data.VALUE5);
    rangeO3.push(range[0].data.items[0].data.VALUE6);
    rangeO3.push(range[0].data.items[0].data.VALUE7);
    rangeO3.push(O3);
    rangeO3.sort(function (left, right) {
        return left - right;
    });
    /*
        I = (IH - IL) / (CH -CL) * (C - CL) + IL
    */
    //03

    return arrColor[rangeO3.indexOf(O3)-2];
}