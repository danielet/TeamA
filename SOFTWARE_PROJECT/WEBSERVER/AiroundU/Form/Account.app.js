/// <reference path="../Resource/Script/ext-all-debug.js" />
/// <reference path="../Resource/Script/component.js" />
/// <reference path="../Resource/Script/noncomponent.js" />
/// <reference path="FormA.view.js" />

//search admin user

function SEARCH_H() {

    var param = DBParams.create();
    param.addParam('WORK_TYPE', 'SERACH_ADMIN_USER');
    var url = '../Server/WebService.php';
    var ds = DBCONN(url, param);
    grd_ADMIN.reconfig(ds[0]);
    if (grd_ADMIN.getTotalCount() > 0) {
        grd_ADMIN.setFocus(0);
    }

}

grd_ADMIN.eSelectionChange = function (record, rowIndex, paramId) {
    txt_USER_ID.setValue(record.data.USER_ID);
    txt_FIRSTNAME.setValue(record.data.FIRSTNAME);
    txt_LASTNAME.setValue(record.data.LASTNAME);
    cbo_GENDER.setValue(record.data.GENDER);
    txt_ADDRESS.setValue(record.data.ADDRESS);
    txt_AFFILATION.setValue(record.data.AFFILIATION);
}