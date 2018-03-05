/**
 * @authors cecurio
 * @date    2016-09-12 18:37:53
 */
window.onload = function () {
	
	code();

	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		if(fm.password.value != '') {
			if(fm.password.value.length < 6 ) {
				alert('密码不能少于6位！');
				fm.password.value = ''; //清空数据
				fm.password.focus();  //移动光标
				return false;
			}
		}
		
		if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮箱格式不正确');
			fm.email.value = '';
			fm.email.focus();
			return false;
		}

		if(fm.qq.value != '') {
			if(!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)) {
				alert('QQ格式不正确');
				fm.qq.value = '';
				fm.qq.focus();
				return false;
			}
		}

		if(fm.url.value != '') {
			if(!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('url格式不正确');
				fm.url.value = '';
				fm.url.focus();
				return false;
			}
		}

		if(fm.yzm.value.length != 4) {
			alert('验证码形式不正确');
			fm.yzm.value = '';
			fm.yzm.focus();
			return false;
		}

		return true;
	};
};
