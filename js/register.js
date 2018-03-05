/**
 * @authors Your Name (you@example.org)
 * @date    2016-08-10 03:26:11
 * @version $Id$
 */

//还没加载好呢
//alert('JS ');

//已经加载完毕
// window.onload = function () {
// 	alert('finished');
// }
// window.onload = function () {
// 	var faceimg = document.getElementById('faceimg');
// 	alert(faceimg.src);
// }




//等在网页加载完毕再执行
window.onload = function () {
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function () {
		window.open('face.php', 'face', 'width=400,height=400,top=0,left=0,scrollbar=1');
	};

	code();

	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		//尽量用客户端验证
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

		if(fm.password.value.length < 6 ) {
			alert('密码不能少于6位！');
			fm.password.value = ''; //清空数据
			fm.password.focus();  //移动光标
			return false;
		}
		if(fm.password.value != fm.notpassword.value) {
			alert('两次密码不一致');
			fm.password.value = ''; //清空数据
			fm.notpassword.value = '';  //清空数据
			fm.password.focus();  //移动光标
			return false;
		}
		
		//密码提示与回答
		if (fm.question.value.length < 2 || fm.question.value.length > 20) {
			alert('密码提示不得小于2位或者大于20位');
			fm.question.value = ''; //清空
			fm.question.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
			alert('密码回答不得小于2位或者大于20位');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value == fm.question.value) {
			alert('密码提示和密码回答不得相等');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
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





