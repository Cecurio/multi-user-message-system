/**
 * 
 * @authors cecurio
 * @date    2016-09-27 13:37:31
 */

window.onload = function () {
	var all = document.getElementById('all');
	var fm = document.getElementsByTagName('form')[0];
	all.onclick = function () {
		// form.elements 获取表单内的所有表单
		for(var i=0;i < fm.elements.length;i++) {
			if(fm.elements[i].name != 'chkall') {
				fm.elements[i].checked = fm.chkall.checked;
			}
		}
	};
	fm.onsubmit = function () {
		if(window.confirm('确定删除？')) {
			return true;
		}else {
			return false;
		}
	};
};

