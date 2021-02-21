/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />

var pnl_test = ApPanel.create('panel1');
var tbl_test = ApTable.create(3);
tbl_test.setTarget();
var txt_test = ApText.create('Date');
var txt_test2 = ApText.create('Time');
var btn_search = ApButton.create('search');
//var cbo_test2 = ApCombo.create('지영');
//cbo_test2.addItem('male', 'M');
//cbo_test2.addItem('female', 'W');

var panel2 = ApPanel.create('panel2');
panel2.header = false;
panel2.setHtml('<div id="columnchart_values"></div>');


//var grd_ADMIN = ApGrid.create();
//grd_ADMIN.addColumn('text', 'User Id', 'U_ID', 200);
//grd_ADMIN.addColumn('text', 'First Name', 'FIRSTNAME', 100);
//grd_ADMIN.addColumn('text', 'Last Name', 'LASTNAME', 100);
//grd_ADMIN.addColumn('text', 'Join Date', 'JOINDATE', 100);
//grd_ADMIN.addColumn('text', 'Affilation', 'AFFILIATION', 100);
//grd_ADMIN.setLockColumns('U_ID', 'FIRSTNAME', 'LASTNAME', 'JOINDATE', 'AFFILIATION');

ApEvent.onlaod = function () {
    //최상단
    viewPanel.divideV(tbl_test,panel2);
    tbl_test.setHeight(40);
    

    //지도르~
    google.charts.load("current", { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["O3", "Density", { role: "style" }],
          ["CO", 8.94, "#b87333"],
          ["SO2", 10.49, "silver"],
          ["NO2", 19.30, "gold"],
          ["PM2.5", 21.45, "color: #e5e4e2"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         {
                             calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation"
                         },
                         2]);

        var options = {
            title: "AIRPOLLUTION DATA",
            width: 600,
            height: 400,
            bar: { groupWidth: "95%" },
            legend: { position: "none" },
        };
        var options = {

        }
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
         
}
