/**
 * 
 * @authors cecurio
 * @date    2016-08-20 09:55:48
 */
window.onload = function () {
    code();
    var fm = document.getElementsByTagName('form')[0];
    fm.onsubmit = function () {
        if(fm.username.value.length < 2 || fm.username.value.length > 20 ) {
			alert('用户名不能少于2位或者大于20位');
			fm.username.value = ''; //清空数据
			fm.username.focus();  //移动光标
			return false;
		}
		if(/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('用户名不能包含非法字符');
			fm.username.value = ''; //清空数据
			fm.username.focus();  //移动光标
			return false;
		}
        //密码验证
		if(fm.password.value.length < 6 ) {
			alert('密码不能少于6位！');
			fm.password.value = ''; //清空数据
			fm.password.focus();  //移动光标
			return false;
		}

        if(fm.code.value.length != 4) {
			alert('验证码形式不正确');
			fm.code.value = '';
			fm.code.focus();
			return false;
		}

        return true;
    };
};
