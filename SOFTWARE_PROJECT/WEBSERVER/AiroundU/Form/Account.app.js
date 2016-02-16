/// <reference path="../Resource/Script/ext-all-debug.js" />
/// <reference path="../Resource/Script/component.js" />
/// <reference path="../Resource/Script/noncomponent.js" />
/// <reference path="Account.view.js" />

//search admin user
function SEARCH_H() {
    txt_USER_ID.setReadOnly(true);
    txt_CURPASSWORD.setHidden(false);
    var param = DBParams.create();
    param.addParam('WORK_TYPE', 'SERACH_ADMIN_USER');
    var url = '../Server/WebService.php';
    var ds = DBCONN(url, param);
    grd_ADMIN.reconfig(ds[0]);
    if (grd_ADMIN.getTotalCount() > 0) {
        grd_ADMIN.setFocus(0);
    }

}
//search button click
btn_search.eClick = function () {
    SEARCH_H();
}

//add button click
btn_add.eClick = function () {
    txt_USER_ID.setReadOnly(false);
    txt_USER_ID.setValue("");
    txt_FIRSTNAME.setValue("");
    txt_LASTNAME.setValue("");
    cbo_GENDER.setValue("M");
    txt_ADDRESS.setValue("");
    txt_AFFILIATION.setValue("");
    txt_CURPASSWORD.setValue("");
    txt_NEWPASSWORD.setValue("");
    txt_CONPASSWORD.setValue("");
    txt_CURPASSWORD.setHidden(true);
}
//save button click
btn_save.eClick = function () {
    //update
    if (txt_USER_ID.readOnly) {
        var param = DBParams.create();
        param.addParam('WORK_TYPE', 'UPDATE_ADMIN');
        param.addParam('USER_ID', txt_USER_ID.getValue());
        if (txt_FIRSTNAME.getValue() == "" || txt_FIRSTNAME.getValue() == "") {
            ApMsg.warning('Please list up your name.', function () {
                txt_FIRSTNAME.focus();
            });
            return;
        }
        param.addParam('FIRSTNAME', txt_FIRSTNAME.getValue());
        param.addParam('LASTNAME', txt_LASTNAME.getValue());
        param.addParam('GENDER', cbo_GENDER.getValue());
        param.addParam('ADDRESS', txt_ADDRESS.getValue());
        if (txt_AFFILIATION.getValue() == "" || txt_AFFILIATION.getValue() == "") {
            ApMsg.warning('Please list up your affiliation.', function () {
                txt_AFFILIATION.focus();
            });
            return;
        }
        param.addParam('AFFILIATION', txt_AFFILIATION.getValue());
        if (txt_NEWPASSWORD.getValue() != "") {
            if (txt_CURPASSWORD.getValue() == "") {
                ApMsg.warning('Please list up your current password.', function () {
                    txt_CURPASSWORD.focus();
                });
                return;
            } else {
                if (txt_NEWPASSWORD.getValue() != txt_CONPASSWORD.getValue()) {
                    ApMsg.warning("Please check new password and confrim password.", function () {
                        txt_NEWPASSWORD.focus();
                    });
                    return;
                }
            }
        }
        param.addParam('CURPASSWORD', txt_CURPASSWORD.getValue());
        param.addParam('NEWPASSWORD', txt_NEWPASSWORD.getValue());

        var url = '../Server/WebService.php';
        var ds = DBCONN(url, param);
        console.log(ds[0].data.items[0].data.RESULT);
        if (ds[0].data.items[0].data.RESULT == 'success') {
            txt_CURPASSWORD.setValue("");
            txt_NEWPASSWORD.setValue("");
            txt_CONPASSWORD.setValue("");
            SEARCH_H();
        } else if (ds[0].data.items[0].data.RESULT == 'wrongPw') {
            ApMsg.warning("Please check current password.", function () {
                txt_CURPASSWORD.focus();
            });
            return;
        }
    //insert
    } else {
        var param = DBParams.create();
        param.addParam('WORK_TYPE', 'INSERT_ADMIN');
        if (txt_USER_ID.getValue() == "") {
            ApMsg.warning('Please list up your id.', function () {
                txt_USER_ID.focus();
            });
            return;
        }
        param.addParam('USER_ID', txt_USER_ID.getValue());
        if (txt_FIRSTNAME.getValue() == "" || txt_FIRSTNAME.getValue() == "") {
            ApMsg.warning('Please list up your name.', function () {
                txt_FIRSTNAME.focus();
            });
            return;
        }
        param.addParam('FIRSTNAME', txt_FIRSTNAME.getValue());
        param.addParam('LASTNAME', txt_LASTNAME.getValue());
        param.addParam('GENDER', cbo_GENDER.getValue());
        param.addParam('ADDRESS', txt_ADDRESS.getValue());
        if (txt_AFFILIATION.getValue() == "") {
            ApMsg.warning('Please list up your affiliation.', function () {
                txt_AFFILIATION.focus();
            });
            return;
        }
        param.addParam('AFFILIATION', txt_AFFILIATION.getValue());
        if (txt_NEWPASSWORD.getValue() != txt_CONPASSWORD.getValue()) {
            ApMsg.warning("Please check new password and confrim password.", function () {
                txt_NEWPASSWORD.focus();
            });
            return;
        }
        param.addParam('NEWPASSWORD', txt_NEWPASSWORD.getValue());
        var url = '../Server/WebService.php';
        var ds = DBCONN(url, param);
        if (ds[0].data.items[0].data.RESULT == 'success') {
            SEARCH_H();
        } else if (ds[0].data.items[0].data.RESULT == "already") {
            ApMsg.warning("Admin id is already exist now. Please change your id.", function () {
                txt_USER_ID.focus();
            });
            return;
        }
    }
}
//btn_delete.eClick = function () {

//}

grd_ADMIN.eSelectionChange = function (record, rowIndex, paramId) {
    txt_USER_ID.setReadOnly(true);
    txt_USER_ID.setValue(record.data.USER_ID);
    txt_FIRSTNAME.setValue(record.data.FIRSTNAME);
    txt_LASTNAME.setValue(record.data.LASTNAME);
    cbo_GENDER.setValue(record.data.GENDER);
    txt_ADDRESS.setValue(record.data.ADDRESS);
    txt_AFFILIATION.setValue(record.data.AFFILIATION);
}