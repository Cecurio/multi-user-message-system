/**
 * @authors cecurio
 * @date    2016-08-20 09:58:53
*/
 function code() {
 	var code = document.getElementById('code');
	code.onclick = function () {
		this.src = 'code.php?tm=' + Math.random();
	};
 }

// 这里只是函数的定义，没有被调用，实现不了刷新的作用