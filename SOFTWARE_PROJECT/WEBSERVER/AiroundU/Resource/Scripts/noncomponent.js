/// <reference path="component.js" />
//Global value

//Global function

var ApFn = {
    toDbTyoe: function (type, value) {
        if (type == 'date') {
            return value.substr(0, 4) + value.substr(5, 2) + value.substr(8, 2);
        } else if (type == 'bool') {
            return value == true ? 'T' : 'F';
        }
    },
    setImportColor: function (text) {
        var tag = "<font color='red'>" + text + '</font>';
        return tag
    },
    setYMD: function (value) {
        value = value.substr(0, 4) + value.substr(5, 2) + value.substr(8, 2);
        return value;
    }
}

var viewPanel = ApPanel.create('content');
viewPanel.header = false;
var viewPort = '';
//make param
Ext.define('DBParam', {
});
DBParam.prototype.addParam = function (key, value) {
    eval("this." + key + "='" + value + "'");
};
var DBParams = {
    create: function () {
        var param = Ext.create('DBParam', {
        });
        return param;
    }
};
//getAqi function
// input, type
// output, color level, aqi value
// green = 0, yellow = 1, orange = 2, red = 3, purple = 4, Marron = 5
function getAqi(type, value) {
    //color
    //var green = '#00e400';
    //var yellow = '#ffff00';
    //var orange = '#ff7e00';
    //var red = '#ff0000';
    //var purple = '#99004c';
    //var Maroon = '#7e0023';
    value = parseFloat(value);
    if (type == 'O3'){
        if (value  >= 0 && value < 125) {
            return [0, 0];
        } else if (value  >= 125 && value < 165) {
            return [2, ComputingAqi(150, 101, 164, 125, value)];
        } else if (value  >= 165 && value < 205) {
            return [3, ComputingAqi(200, 151, 204, 165, value)];
        } else if (value  >= 205 && value < 405) {
            return [4, ComputingAqi(300, 201, 404, 205, value)];
        } else if (value  >= 405) {
            if (value >= 405 && value < 505) {
                return [5, ComputingAqi(400, 301, 504, 405, value)];
            } else {
                return [5, ComputingAqi(500, 401, 604, 505, value)];
            }
        }
    } else if (type == 'SO2') {
        if (value  >= 0 && value < 36) {
            return [0, ComputingAqi(50, 0, 35, 0, value)];
        } else if (value  >= 36 && value < 76) {
            return [1, ComputingAqi(100, 51, 75, 36, value)];
        } else if (value  >= 76 && value < 186) {
            return [2, ComputingAqi(150, 101, 185, 76, value)];
        } else if (value  >= 186 && value < 305) {
            return [3, ComputingAqi(200, 151, 304, 186, value)];
        } else if (value  >= 305 && value < 605) {
            return [4, ComputingAqi(300, 201, 604, 305, value)];
        } else if (value  >= 605) {
            if (value >= 405 && value < 505) {
                return [5, ComputingAqi(400, 301, 804, 605, value)];
            } else {
                return [5, ComputingAqi(500, 401, 1004, 805, value)];
            }
        }
    } else if (type == 'NO2') {
        if (value  >= 0 && value < 54) {
            return [0, ComputingAqi(50, 0, 53, 0, value)];
        } else if (value  >= 54 && value < 101) {
            return [1, ComputingAqi(100, 51, 100, 54, value)];
        } else if (value  >= 101 && value < 361) {
            return [2, ComputingAqi(150, 101, 360, 101, value)];
        } else if (value  >= 361 && value < 650) {
            return [3, ComputingAqi(200, 151, 649, 361, value)];
        } else if (value  >= 650 && value < 1250) {
            return [4, ComputingAqi(300, 201, 1249, 650, value)];
        } else if (value  >= 1250) {
            if (value >= 405 && value < 505) {
                return [5, ComputingAqi(400, 301, 1649, 1250, value)];
            } else {
                return [5, ComputingAqi(500, 401, 2049, 1650, value)];
            }
        }
    } else if (type == 'CO') {
        if (value  >= 0 && value < 4.5) {
            return [0, ComputingAqi(50, 0, 4.4, 0.0, value)];
        } else if (value  >= 4.5 && value < 9.5) {
            return [1, ComputingAqi(100, 51, 9.4, 4.5, value)];
        } else if (value  >= 9.5 && value < 12.5) {
            return [2, ComputingAqi(150, 101, 12.4, 9.5, value)];
        } else if (value  >= 12.5 && value < 15.5) {
            return [3, ComputingAqi(200, 151, 15.4, 12.5, value)];
        } else if (value  >= 15.5 && value < 30.5) {
            return [4, ComputingAqi(300, 201, 30.4, 15.5, value)];
        } else if (value  >= 30.5) {
            if (value >= 405 && value < 505) {
                return [5, ComputingAqi(400, 301, 40.4, 30.5, value)];
            } else {
                return [5, ComputingAqi(500, 401, 50.4, 40.5, value)];
            }
        }
    } else if (type == 'PM25') {
        if (value  >= 0 && value < 125) {
            return [0, ComputingAqi(50, 0, 12.0, 0.0, value)];
        } else if (value  >= 0 && value < 12.1) {
            return [1, ComputingAqi(100, 51, 35.4, 12.1, value)];
        } else if (value  >= 12.1 && value < 35.5) {
            return [2, ComputingAqi(150, 101, 55.4, 35.5, value)];
        } else if (value  >= 35.5 && value < 55.5) {
            return [3, ComputingAqi(200, 151, 150.4, 55.5, value)];
        } else if (value  >= 55.5 && value < 150.5) {
            return [4, ComputingAqi(300, 201, 250.4, 150.5, value)];
        } else if (value  >= 150.5) {
            if (value >= 405 && value < 505) {
                return [5, ComputingAqi(400, 301, 350.4, 250.5, value)];
            } else {
                return [5, ComputingAqi(500, 401, 500.4, 350.5, value)];
            }
        }
    } else if (type == 'AQI') {
        if (value  >= 0 && value < 125) {
            return [0, value];
        } else if (value  >= 0 && value < 51) {
            return [1, value];
        } else if (value  >= 51 && value < 101) {
            return [2, value];
        } else if (value  >= 101 && value < 151) {
            return [3, value];
        } else if (value  >= 151 && value < 201) {
            return [4, value];
        } else if (value  >= 201) {
            return [5, value];
        }
    }
}
//Api Computering function
function ComputingAqi(iH, iL, cH, cL, value){
    return (iH - iL) / (cH - cL) * (value - cL) + iL;
}

//ajax connection
function DBCONN(url, params) {
    var storeSet= [];
    Ext.Ajax.request({
        async: false,
        url: url,
        method: 'POST',
        params: params,
        reader: {
            type: 'json'
        },
        success: function (response, eOpt) {
            var responseStr = response.responseText;
                var jObject = Ext.JSON.decode(responseStr);
                var json = jObject[0];
                var _sModel = null;
                if (typeof (jObject) == undefined || jObject.length == 0) {
                    var _model = Ext.define(Ext.id(), { extend: 'Ext.data.Model' });
                    var store = Ext.create('Ext.data.Store', {
                        model: _model.getName(),
                        data: jObject
                    })
                } else {
                    var fieldArr = [];
                    fieldArr.push({
                        'name': 'AP_STATE', 'type': 'bool'
                    });
                    for (var i = 0; i < Object.keys(json).length ; i++) {
                        var name = Object.keys(json)[i];
                        var type = typeof (json[Object.keys(json)[i]]);
                        if (json[Object.keys(json)[i]] == 'T' || json[Object.keys(json)[i]] == 'F') {
                            type = 'bool';
                            for (var j = 0; j < jObject.length; j++) {
                                if (jObject[j][Object.keys(json)[i]] == 'T') jObject[j][Object.keys(json)[i]] = true;
                                if (jObject[j][Object.keys(json)[i]] == 'F') jObject[j][Object.keys(json)[i]] = false;

                            }

                        }
                        fieldArr.push({
                            'name': name, 'type': type
                        })
                    }
                    var store = Ext.create('Ext.data.Store', {
                        model: Ext.define(Ext.id(), {
                            extend: 'Ext.data.Model',
                            fields: fieldArr,
                        }),
                        data: jObject,
                        proxy: {
                            type: 'memory',
                            reader: {
                                type: 'json',
                            }
                        }
                    });
                }
                storeSet.push(store);
        },
        failure: function (response, options) {
            ApMsg.warning('헉.. 통신이 실패했습니다. 인터넷 연결상태를 확인해 주세요.');
            return;
        }
    });
    return storeSet;
}

ApEvent = {
    onlaod: function () {

    }
}

Ext.onReady(function () {

    viewPort = Ext.create('Ext.container.Viewport', {
        layout: 'border',
        border: 0,
        items: [viewPanel]
    });
    ApEvent.onlaod();
    return;
});