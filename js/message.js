/**
 * @authors cecurio
 * @date    2016-09-19 18:59:07
 */

window.onload = function () {
	code();

	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {

		if(fm.yzm.value.length != 4) {
			alert('验证码形式不正确');
			fm.yzm.focus();
			return false;
		}

		if(fm.content.value.length < 10 || fm.content.value.length > 200) {
			alert('发信内容不能少于10位或者大于200位！');
			fm.content.focus();  //移动光标
			return false;
		}
		return true;
	};
};
