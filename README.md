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

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－
回头再push origin的时候又出现了这样的问题

git push origin master

Warning: Permanently added the RSA host key for IP address '192.30.252.128' to the list of known hosts.

Permission denied (publickey).

fatal: Could not read from remote repository.

 

Please make sure you have the correct access rights

and the repository exists.


－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－
   vi ~/.ssh/config

      注释掉

      ＃PreferredAuthentications password
      提交正常

      git push origin master

      Counting objects: 3, done.

      Delta compression using up to 4 threads.

      Compressing objects: 100% (3/3), done.

      Writing objects: 100% (3/3), 992 bytes | 0 bytes/s, done.

      Total 3 (delta 0), reused 0 (delta 0)

      To git@github.com:l496501043/first.git

      d0cff78..8399039  master -> master

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－
      又回去 ssh 120.55.x.x -l root 

      连接不上，继续push origin到github也正常

      那就接着加参数连接ssh 120.55.x.x -l root -o PubkeyAuthentication=no
－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－

－－－－－－－－－－－－－－－－－－－－－－－－－－－－－分割线－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－
