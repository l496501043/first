# git提交的第一条信息
实现：获取微信公众平台健康内容自动发布进织梦系统［可进阶为战群，需要多ip服务器加nginx或apache反向代理］

需要：cron任务
      Redis缓存
      dedecms后台
      Linux服务器或vps




＃随手记 ＊Mac下php相关的GD组建不完整，缺少支持FreeType、PNG等，解决方案按照网友提供的shell成功［附上地址］＊
［地址］http://php-osx.liip.ch/install.sh


＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
由于这台Mac配置git生成公钥后，ssh连接就出现来这个问题
Received disconnect from 120.55.x.x: 2: Too many authentication failures for root

出现后只需要在 ssh 后面 加上 -o PubkeyAuthentication=no 这个参数，连接正常。
如果不想每次加－o参数就添加个配置文件（默认没有） ~/.ssh/config
PreferredAuthentications password
测试连接正常。
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
