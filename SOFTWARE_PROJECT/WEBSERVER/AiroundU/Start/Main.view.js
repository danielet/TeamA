/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />

//top bar
//var pnl_topBar = ApPanel.create('Upbar');
//var tbl_topBar = ApTable.create(1);
//tbl_topBar.setTarget();
//var btn_Logout = ApButton.create('Log out');
////pnl_topBar.setHtml('<h2>hello</h2>');
//pnl_topBar.header = false;

var pnl_topBar = ApPanel.create('Upbar');
pnl_topBar.header = false;
var tbl_LOGO = ApTable.create();
tbl_LOGO.setTarget();
var img = ApImg.create('../Resource/Themes/LOGO2.png');
img.setSize(142, 87);
tbl_LOGO.add(img);

var tbl_topBar = ApTable.create(2);
tbl_topBar.setTarget();
var btn_Logout = ApButton.create('');
btn_Logout.addCls('buttonCassaCon');
btn_Logout.setMargin('15 0 0 0');


//downarea
var pnl_downArea = ApPanel.create('downArea');
pnl_downArea.header = false;

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

var tre_sideBar = ApTree.create('menu');
tre_sideBar.header = false;
tre_sideBar.bindNode(getNode('admin', false, false), 1, false);
tre_sideBar.bindNode(getNode('account', true, false), 2, false);
tre_sideBar.bindNode(getNode('mailing', true, false), 2, false);
tre_sideBar.bindNode(getNode('research', false, false), 1, false);
tre_sideBar.bindNode(getNode('chart', true, false), 2, false);
tre_sideBar.bindNode(getNode('data2', true, false), 2, false);
pnl_sideBar.full(tre_sideBar)

var pnl_map = ApPanel.create();
pnl_map.header = false;
var pnl_mapData = ApPanel.create('Information of area');
//main
var tab_main = ApTab.create();
tab_main.addTab('Home').divideH(pnl_map, pnl_mapData, pnl_mapData);
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
ApEvent.onlaod = function(){
    viewPanel.divideV(pnl_topBar, pnl_downArea, pnl_topBar);
    pnl_topBar.setHeight(90);
    pnl_topBar.divideH(tbl_LOGO, pnl_group);
    pnl_group.divideH(pnl_middle, tbl_topBar, tbl_topBar);
    tbl_topBar.setWidth(200);
    pnl_downArea.divideH(pnl_sideBar, tab_main);
    pnl_sideBar.setWidth(160);
    pnl_mapData.setWidth(250);
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
            make_marker(position.coords.latitude, position.coords.longitude);
            map.addListener('mousedown', function () {
                pnl_mapData.collapse();
            })
            map.setCenter(pos);
        });
    } else {
        // Browser doesn't support Geolocation
    }

    var task = {
        run: function () {
            search_streaming();
        },
        interval: 3000 //1 second
    }
    Ext.TaskManager.start(task);
}