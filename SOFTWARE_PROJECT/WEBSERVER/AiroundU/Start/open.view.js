/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />

//top bar
var pnl_topBar = ApPanel.create('Upbar');
pnl_topBar.header = false;
var tbl_LOGO = ApTable.create();
tbl_LOGO.setTarget();
var img = ApImg.create('../Resource/Themes/LOGO2.png');
img.setSize(142, 87);
tbl_LOGO.add(img);

var tbl_topBar = ApTable.create(2);
tbl_topBar.setTarget();
var btn_Admin = ApButton.create('');
btn_Admin.addCls('buttonCassaCon');
btn_Admin.setMargin('15 0 0 0');

//downarea
var pnl_downArea = ApPanel.create('downArea');
pnl_downArea.header = false;

//data selector
var tbl_selecor = ApTable.create(1);
tbl_selecor.setTarget();
var cbo_TYPE = ApCombo.create('Time range', 'dte', 70);
cbo_TYPE.setWidth(200);
cbo_TYPE.addItem('10 sec', '0');
cbo_TYPE.addItem('Average of 1 hour', '1');
cbo_TYPE.setValue('0')

var chk_O3 = ApCheck.create('O3');
var chk_SO2 = ApCheck.create('SO2');
var chk_NO2 = ApCheck.create('NO2');
var chk_CO = ApCheck.create('CO');
var chk_PM25 = ApCheck.create('PM25');
chk_O3.setValue(true);
chk_SO2.setValue(true);
chk_NO2.setValue(true);
chk_CO.setValue(true);
chk_PM25.setValue(true);
tbl_selecor.cellShare(6);

var pnl_sideBar = ApPanel.create('menu');

var tbl_sideBar = ApTable.create(1);
tbl_sideBar.setTarget();
var txt_LAT = ApText.create('Latitude', '');
var txt_LNG = ApText.create('Longitude', '');
var txt_TEMP = ApText.create('temperature', '');
var txt_O3 = ApText.create('O3', '');
var txt_SO2 = ApText.create('S02', '');
var txt_NO2 = ApText.create('N02', '');
var txt_CO = ApText.create('C0', '');
var txt_PM25 = ApText.create('PM2.5', '');

var pnl_map = ApPanel.create();
pnl_map.header = false;
var pnl_mapData = ApPanel.create('Information of area');
pnl_mapData.setCollapsed(true);
pnl_map.setHtml("<div id='map'></div>")

var pnl_main = ApPanel.create('main');

var myLatlng = { lat: -25.363, lng: 131.044 };
var marker;

var pnl_group = ApPanel.create();
pnl_group.header = false;
var pnl_middle = ApPanel.create();
pnl_middle.header = false;
pnl_middle.setFlex(1);

var pnl_mid = ApPanel.create();
pnl_mid.header = false;
ApEvent.onlaod = function () {
    viewPanel.divideV(pnl_topBar, pnl_mid, pnl_topBar);
    pnl_topBar.setHeight(90);
    pnl_topBar.divideH(tbl_LOGO, pnl_group);
    pnl_group.divideH(pnl_middle, tbl_topBar, tbl_topBar);
    tbl_topBar.setWidth(200);
    tbl_LOGO.setWidth(150);

    pnl_mid.divideV(tbl_selecor, pnl_downArea);
    tbl_selecor.setHeight(30);
    pnl_downArea.divideH(pnl_map, pnl_mapData, pnl_mapData);
    pnl_mapData.setWidth(200);
    pnl_mapData.full(tbl_sideBar);

    //------------ Google Map source--------
    //create map
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 16,
        markerArr: [],
        circleArr: []
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            //make marker
            map.addListener('mousedown', function () {
                pnl_mapData.collapse();
            })
            map.setCenter(pos);
        });
    } else {
        // Browser doesn't support Geolocation
    }
    search_streaming();
    var task = {
        run: function () {
            search_streaming();
        },
        interval: 3000 //1 second
    }
    Ext.TaskManager.start(task);
}