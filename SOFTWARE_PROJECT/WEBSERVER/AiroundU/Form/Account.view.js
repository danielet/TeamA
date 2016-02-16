/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />

var tbl_SEARCH = ApTable.create(1);
tbl_SEARCH.setTarget();

var txt_USER_ID = ApText.create('ID');
txt_USER_ID.setReadOnly(true);
var txt_FIRSTNAME = ApText.create('FIRSTNAME');
var txt_LASTNAME = ApText.create('LASTNAME');
var cbo_GENDER = ApCombo.create('GENDER');
cbo_GENDER.addItem('male', 'M');
cbo_GENDER.addItem('female', 'W');
var txt_ADDRESS = ApText.create('ADDRESS');
var txt_AFFILATION = ApText.create('AFFILATION');

var grd_ADMIN = ApGrid.create();
grd_ADMIN.addColumn('text', 'User Id', 'USER_ID', 200);
grd_ADMIN.addColumn('text', 'First Name', 'FIRSTNAME', 100);
grd_ADMIN.addColumn('text', 'Last Name', 'LASTNAME', 100);
grd_ADMIN.addColumn('text', 'Join Date', 'JOINDATE', 100);
grd_ADMIN.addColumn('text', 'Affilation', 'AFFILIATION', 100);
grd_ADMIN.setLockColumns('USER_ID', 'FIRSTNAME', 'LASTNAME', 'JOINDATE', 'AFFILIATION');

ApEvent.onlaod = function () {
    viewPanel.divideH(grd_ADMIN, tbl_SEARCH);
    grd_ADMIN.setWidth(700);
    SEARCH_H();
}