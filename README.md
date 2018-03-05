# 多用户留言系统

## 使用技术
- PHP5
- 纯原生js 没有使用任何前端框架
- 纯原生css 没有使用任何前端框架
- MySQL5.3

## 运行

1. 装好lnmp或者phpstudy
2. 新建数据库，导入`./sql/sk_guest.sql`的内容
3. 更改数据库配置文件`./includes/common.inc.php`
```
//与数据库操作有关的常量
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PSD','root');
define('DB_NAME','sk_guest');
```

## 效果

### 首页

![首页](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/index_page.png)

### 登录

![登录](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E7%99%BB%E5%BD%95.png)

### 注册

![注册](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E6%B3%A8%E5%86%8C.png)

### 个人中心

![个人中心](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E4%B8%AA%E4%BA%BA%E4%B8%AD%E5%BF%83.png)

### 短信查询

![短信查询](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E7%9F%AD%E4%BF%A1%E6%9F%A5%E8%AF%A2.png)

### 短信详情

![短信详情](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E7%9F%AD%E4%BF%A1%E8%AF%A6%E6%83%85.png)

### 修改资料

![修改资料](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E4%BF%AE%E6%94%B9%E8%B5%84%E6%96%99.png)

### 好友中心

![好友中心](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E5%A5%BD%E5%8F%8B%E4%B8%AD%E5%BF%83.png)

### 博友列表

![博友列表](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E5%8D%9A%E5%8F%8B%E5%88%97%E8%A1%A8.png)

### 发信页面

![发信页面](http://ot2mlpa9d.bkt.clouddn.com/multi-user-message-system/%E5%8F%91%E4%BF%A1%E9%A1%B5%E9%9D%A2.png)