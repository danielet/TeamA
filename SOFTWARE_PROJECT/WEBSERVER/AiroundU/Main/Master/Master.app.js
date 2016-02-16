// 전역변수 처리용 구조체 만들기
var A_temp = {
	key: [],
	value: []
};
//전역변수 저장
A_temp.setValue = function (key, value) {
	this.key.push(key);
	this.value.push(value);
};
//전역변수 사용
A_temp.getValue = function (key) {
	return value[this.key.indexOf(key)].pop();
}