/// <reference path="../Resource/Scripts/ext-all-debug.js" />
/// <reference path="../Resource/Scripts/component.js" />
/// <reference path="../Resource/Scripts/noncomponent.js" />

//button
var tbl_ButtonBar = ApTable.create();
tbl_ButtonBar.setTarget();

var btn_search = ApButton.create('');
btn_search.addCls('search');
btn_search.setMargin('0 0 0 10');

var btn_save = ApButton.create('');
btn_save.addCls('save');
btn_save.setMargin('0 0 0 15');

var btn_add = ApButton.create('');
btn_add.addCls('add');
btn_add.setMargin('0 0 0 15');

//var btn_delete = ApButton.create('');
//btn_delete.addCls('delete');
//btn_delete.setMargin('0 0 0 15');

tbl_ButtonBar.cellShare(3);

var pnl_down = ApPanel.create();
pnl_down.header = false;
var tbl_VIEW = ApTable.create(1);
tbl_VIEW.setTarget();

var txt_USER_ID = ApText.create(ApFn.setImportColor('ID'));
txt_USER_ID.setReadOnly(true);
txt_USER_ID.setWidth(365);
var txt_FIRSTNAME = ApText.create(ApFn.setImportColor('Name'));
var txt_LASTNAME = ApText.create('');
tbl_VIEW.cellShare(2);
var cbo_GENDER = ApCombo.create('Gender');
cbo_GENDER.addItem('male', 'M');
cbo_GENDER.addItem('female', 'W');
var txt_ADDRESS = ApText.create('Address');
txt_ADDRESS.setWidth(365);
var txt_AFFILIATION = ApText.create(ApFn.setImportColor('Affiliation'));
txt_AFFILIATION.setWidth(365);
var txt_CURPASSWORD = ApText.create('Current P/W');
txt_CURPASSWORD.emptyText = 'Current P/W';
txt_CURPASSWORD.inputType = 'password';
var txt_NEWPASSWORD = ApText.create('New P/W');
txt_NEWPASSWORD.emptyText = 'New P/W'
txt_NEWPASSWORD.inputType = 'password';
var txt_CONPASSWORD = ApText.create('Confirm P/W');
txt_CONPASSWORD.emptyText = 'Confirm P/W'
txt_CONPASSWORD.inputType = 'password';
tbl_VIEW.cellShare(2);

var grd_ADMIN = ApGrid.create();
grd_ADMIN.addColumn('text', 'User Id', 'USER_ID', 200);
grd_ADMIN.addColumn('text', 'First Name', 'FIRSTNAME', 100);
grd_ADMIN.addColumn('text', 'Last Name', 'LASTNAME', 100);
grd_ADMIN.addColumn('text', 'Join Date', 'JOINDATE', 100);
grd_ADMIN.addColumn('text', 'Affilation', 'AFFILIATION', 100);
grd_ADMIN.setLockColumns('USER_ID', 'FIRSTNAME', 'LASTNAME', 'JOINDATE', 'AFFILIATION');

ApEvent.onlaod = function () {
    viewPanel.divideV(tbl_ButtonBar, pnl_down);
    tbl_ButtonBar.setHeight(37);
    pnl_down.divideH(grd_ADMIN, tbl_VIEW);
    grd_ADMIN.setWidth(700);
    SEARCH_H();
}