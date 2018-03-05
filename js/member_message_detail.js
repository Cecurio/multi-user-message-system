/**
 * 
 * @authors cecurio
 * @date    2016-09-26 18:52:03
 */

// onclick="javascript:history.back();"

window.onload = function () {
	var ret = document.getElementById('return');
	var del = document.getElementById('delete');
	ret.onclick = function () {
		history.back();
	};
	del.onclick = function () {
		if(window.confirm('确定删除？')){
			location.href = '?action=delete&id='+this.name;
		}
	};
};