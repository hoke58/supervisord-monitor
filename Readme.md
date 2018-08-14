# Supervisord Multi Server Monitoring Tool

![Screenshot](https://raw.githubusercontent.com/hoke58/supervisord-monitor/master/supervisord-monitor.png)

## Features

* Monitor unlimited supervisord servers and processes
* Start/Stop/Restart process
* Read stderr log
* Start new Redmine ticket when stderr occurs
* Sound alert when stderr occurs
* Mute sound alerts (after some time auto resume)
* Monitor process uptime status

## Install

1.Clone supervisord-monitor to your vhost/webroot:
```
git clone https://github.com/hoke/supervisord-monitor.git
```

2.Copy application/config/supervisor.php.example to application/config/supervisor.php
```
cp supervisord-monitor/application/config/supervisor.php.example supervisord-monitor/application/config/supervisor.php
```

3.Enable/Uncomment inet_http_server (found in supervisord.conf) for all your supervisord servers.
```ini
[inet_http_server]
port=*:9001
username="yourusername"
password="yourpass"
```
Do not forget to restart supervisord service after changing supervisord.conf

4.Edit supervisord-monitor configuration file and add all your supervisord servers
```
vim application/config/supervisor.php
```

```php
$config['supervisor_servers'] = array(
        'JAVA1.ORG11' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9901',
        ),
        'JAVA2.ORG11' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9902'
        ),
        'HBCCCLOUD1.ORG11' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9903'
        ),
        'HBCCCLOUD2.ORG11' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9904'
        ),
        'JAVA1.ORG12' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9901',
        ),
        'JAVA2.ORG12' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9902'
        ),
        'HBCCCLOUD1.ORG12' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9903'
        ),
        'HBCCCLOUD2.ORG12' => array(
                'url' => 'http://11x.253.85.xxx/RPC2',
                'port' => '9904'
        ),

);
```
5.Configure your web server to point one of your vhosts to 'public_html' directory.

6.Open web browser and enter your vhost url.

## 设置nginx

>* supervisord.monitor.conf
```Bash
server {
        listen       8082;
        set $web_root /www/web/supervisord/public_html;
        root $web_root;
        server_name localhost;
        index  index.html index.php index.htm;
        error_page  400 /errpage/400.html;
        error_page  403 /errpage/403.html;
        error_page  404 /errpage/404.html;
        error_page  503 /errpage/503.html;
        location ~ \.php(.*)$ {
                fastcgi_pass  unix:/tmp/php-56-cgi.sock;
                fastcgi_index  index.php;
                fastcgi_param  SCRIPT_FILENAME  $DOCUMENT_ROOT$fastcgi_script_name;
                #fastcgi_param  SCRIPT_FILENAME $web_root$fastcgi_script_name;
                fastcgi_param  SCHEME $scheme;
                fastcgi_param PATH_INFO $2;
                include fcgi.conf;
                #include        fastcgi_params;
                #fastcgi_pass 127.0.0.1:9000;
        }
       # location ~ /\.ht {
       #         deny  all;
       # }
        location / {
               #  try_files $uri $uri/ /index.php;
                 auth_basic "Please input password";
                 auth_basic_user_file /www/web/supervisord/application/config/password;
                 try_files $uri $uri/ /?$args;
        }
}
```
保存后，重启nginx。

## 给网站加密码
到这里我们就做好了服务器集群进程的管理了，但是有一点，这个网站如果不加密的话，任何人都可以在任何浏览器上登录，随便管理我们的服务器，这样太危险了。为此，我们通过htpasswd对该网页进行加密处理，需要登录才能进入网页。

1. 首先，安装httpd-tools：
```Bash
yum -y install httpd-tools
```
2. 然后在指定位置创建密码文件，这里我们创建在supervisord-monitor的配置文件中：
```Bash
htpasswd -c /root/supervisord-monitor/application/config/password admin  #  创建password文件，以及用户的登录名admin
New password: admin
Re-type new password: admin
Adding password for user admin
```
这样我们就创建了一个用户名及密码都为admin的账户。

3. 最后，再将其写入到nginx的配置中即可：
```bash
vim supervisord.monitor.conf
```
添加如下：
```Bash
auth_basic "Please input password"; #这里是验证时的提示信息
auth_basic_user_file /root/supervisord-monitor/application/config/password;  # 刚才配置的password文件
```
4. 再次重启nginx后，登录网站，会弹出登录窗口。登录即可。

这样我们便完成了supervisor的集群式管理。

## Redmine integration
1.Open configuration file:
```Bash
vim application/config/supervisor.php
```
2.Change this lines with your redmine url and auto assigne id:

```php
// Path to Redmine new issue url
$config['redmine_url'] = 'http://redmine.url/path_to_new_issue_url';
// Default Redmine assigne ID
$config['redmine_assigne_id'] = '69';
```

## Troubleshooting
```
Did not receive a '200 OK' response from remote server.
```
Having this messages in most cases means that Supervisord Monitoring tools does not have direct network access to the Supervisord RPC2 http interface. Check your firewall and network conectivity.

---

```
Did not receive a '200 OK' response from remote server. (HTTP/1.0 401 Unauthorized)
```
Having `401 Unauthorized` means that you have connection between Supervisord Monitoring tool and Supervisord but the username or password are wrong.

---

```
UNKNOWN_METHOD
```
Having this message means that your supervisord service doesn't have rpc interface enabled (only for v3+ of Supervisord). 
To enable the rpc interface add this lines to the configuration file:

*From the Supervisord Docs*

In the sample config file, there is a section which is named [rpcinterface:supervisor]. By default it looks like the following:

```
[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface
```

The [rpcinterface:supervisor] section must remain in the configuration for the standard setup of supervisor to work properly. 
If you don’t want supervisor to do anything it doesn’t already do out of the box, this is all you need to know about this type of section.

For more information go to the offitial Supervisord Configuration Docs:
http://supervisord.org/configuration.html#rpcinterface-x-section-settings

---

```
The requested URL /control/ ... was not found on this server.
```

If you are getting this error on every action (stop, start, restart etc) most probably your web server isn't respecting the .htaccess file found in `public_html` directory. 
To test this you can add `AllowOverride All` config to the httpd.conf (if you are using Apache) or to add the rules from the .htaccess file to the httpd.conf file.


## Thanks to ##
- [stvnwrgs](https://github.com/stvnwrgs) - added authentication functionality to supervisord monitor
- [rk295](https://github.com/rk295) - added handling of non authenticated servers
- [All Contributors](https://github.com/mlazarov/supervisord-monitor/contributors) 

## Who uses Supervisord Monitor? ##

[EasyWpress - wordpress hosting company](http://easywpress.com)


If you've used Supervisord Monitor Tool send me email to martin@lazarov.bg to add your project/company to this list.

## License

MIT License

Copyright (C) 2013 Martin Lazarov

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
