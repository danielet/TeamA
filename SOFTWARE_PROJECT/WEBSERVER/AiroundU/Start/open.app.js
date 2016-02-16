/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />
/// <reference path="Open.view.js" />

//global value

//get Atoms color
var param = DBParams.create();
param.addParam('WORK_TYPE', 'SEARCH_AIRPOLUTIONLANGE');
var url = '../Server/WebService.php';
var range = DBCONN(url, param);
console.log(range);

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
        make_marker(data.LAT, data.LNG, data.TEMP, data.O3, data.SO2, data.NO2, data.CO, data.PM25, data.USER_ID);
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
            txt_O3.setValue(O3);
            txt_SO2.setValue(SO2);
            txt_NO2.setValue(NO2);
            txt_CO.setValue(CO);
            txt_PM25.setValue(PM25);
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
        txt_O3.setValue(marker.o3);
        txt_SO2.setValue(marker.so2);
        txt_NO2.setValue(marker.no2);
        txt_CO.setValue(marker.co);
        txt_PM25.setValue(marker.pm25);

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

    return arrColor[rangeO3.indexOf(O3) - 2];
}

btn_Admin.eClick = function () {

    
    var pnl_login = ApPanel.create();
    pnl_login.header = false;

    var tbl_img = ApTable.create(1);
    tbl_img.setTarget();
    var img = ApImg.create('../Resource/Themes/administrator.png');
    img.setMargin('10 0 0 0');
    img.setSize(142, 142);

    var tbl_login = ApTable.create(1);
    tbl_login.setTarget();
    var txt_ID = ApText.create('');
    txt_ID.emptyText = 'Admin Id'
    var txt_PW = ApText.create('');
    txt_PW.emptyText = '******'
    txt_PW.inputType = 'password';
    var btn_login = ApButton.create('Log-in');
    btn_login.setWidth(87);
    var btn_forgot = ApButton.create('forgot');
    btn_forgot.setWidth(87);
    tbl_login.cellShare(2);
    var lbl_message = ApLabel.create('');

    pnl_login.divideH(tbl_img, tbl_login);
    var window = Ext.create('Ext.window.Window', {
        title: 'Administrator',
        height: 200,
        width: 400,
        layout: 'fit',
        modal: true
    }).show();
    window.add(pnl_login);

    btn_login.eClick = function () {
        //아이디 확인
        var param = DBParams.create();
        param.addParam('WORK_TYPE', 'LOGIN');
        param.addParam('USER_ID', txt_ID.getValue());
        param.addParam('PASSWORD', txt_PW.getValue());
        var url = '../Server/WebService.php';
        var result = DBCONN(url, param);
        if (result[0].data.items[0].data.RESULT == "Nodata") {
            lbl_message.setText('Your id or password is wrong');
        } else if (result[0].data.items[0].data.RESULT == "success") {
            location.replace("main.php");
        } else if (result[0].data.items[0].data.RESULT == "Change_Password") {
            window.close();
            var pnl_PasswordChange = ApPanel.create();
            pnl_PasswordChange.header = false;

            var tbl_PwImg = ApTable.create(1);
            tbl_PwImg.setTarget();
            var img_Pw = ApImg.create('../Resource/Themes/lock.png');
            img_Pw.setMargin('10 0 0 0');
            img_Pw.setSize(142, 142);

            var tbl_PasswordChange = ApTable.create(1);
            tbl_PasswordChange.setTarget();
            var txt_PwID = ApText.create('');
            txt_PwID.setReadOnly(true);
            var txt_PwPW = ApText.create('');
            txt_PwPW.emptyText = '******'
            txt_PwPW.inputType = 'corrent password';
            var txt_PwNew = ApText.create('');
            txt_PwNew.emptyText = '******'
            txt_PwNew.inputType = 'new password';
            var txt_PwNewConfirm = ApText.create('');
            txt_PwNewConfirm.emptyText = '******'
            txt_PwNewConfirm.inputType = 'new password confirm';

            var btn_login = ApButton.create('Save');
            btn_login.setWidth(87);
            var lbl_message2 = ApLabel.create('');


            pnl_PasswordChange.divideH(tbl_PwImg, tbl_PasswordChange);

            var win_PasswordChange = Ext.create('Ext.window.Window', {
                title: 'PasswordChange',
                height: 200,
                width: 400,
                layout: 'fit',
                modal: true
            });
            win_PasswordChange.add(pnl_PasswordChange);
            win_PasswordChange.show();
        } else if (result[0].data.items[0].data.RESULT == "Wrong_password") {
            lbl_message.setText('Your id or password is wrong');
        } else if (result[0].data.items[0].data.RESULT == "many_fail") {
            var param = DBParams.create();
            param.addParam('WORK_TYPE', 'FORGOT_PASSWORD');
            param.addParam('USER_ID', txt_ID.getValue());
            var url = '../Server/WebService.php';
            var result = DBCONN(url, param);
            if (result[0].data.items[0].data.RESULT == "success") {
                ApMsg.warning('your new password mail was sended.');
            } else if (result[0].data.items[0].data.RESULT == "noId") {
                lbl_message.setText('Your id is not exist.');
            } else {
                lbl_message.setText('Your account is not exist.');
            }
        }
        
    }
    btn_forgot.eClick = function () {
        var param = DBParams.create();
        param.addParam('WORK_TYPE', 'FORGOT_PASSWORD');
        param.addParam('USER_ID', txt_ID.getValue());
        var url = '../Server/WebService.php';
        var result = DBCONN(url, param);
        if (result[0].data.items[0].data.RESULT == "success") {
            ApMsg.warning('mail was sended.');
        } else if (result[0].data.items[0].data.RESULT == "noId") {
            lbl_message.setText('Your id is not exist.');
        } else {
            lbl_message.setText('Your account is not exist.');
        } 
    }
}