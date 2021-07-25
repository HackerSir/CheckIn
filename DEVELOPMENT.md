# Broadcasting
此專案使用 redis 作為 Broadcast Driver

## .env
```
BROADCAST_DRIVER=redis
QUEUE_DRIVER=sync
MIX_ECHO_HOST=http://checkin.localhost:6001
```
* `QUEUE_DRIVER`可以為`sync`，避免一直重啟Queue服務來套用新的code
* `MIX_ECHO_HOST`：給laravel-mix讀取，設定前端JS code連線到laravel-echo-server的位置

## laravel-echo-server
### 安裝
```
npm install -g laravel-echo-server
```

### 初始化
在專案資料夾根目錄
```
vagrant@homestead:~/site/CheckIn$ laravel-echo-server init
? Do you want to run this server in development mode? Yes
? Which port would you like to serve from? 6001
? Which database would you like to use to store presence channel members? redis
? Enter the host of your Laravel authentication server. http://checkin.localhost
? Will you be serving on http or https? http
? Do you want to generate a client ID/Key for HTTP API? No
? Do you want to setup cross domain access to the API? No
Configuration file saved. Run laravel-echo-server start to run server.
```
完成後，會建立`laravel-echo-server.json`
```
{
    "authHost": "http://checkin.localhost",
    "authEndpoint": "/broadcasting/auth",
    "clients": [],
    "database": "redis",
    "databaseConfig": {
        "redis": {},
        "sqlite": {
            "databasePath": "/database/laravel-echo-server.sqlite"
        }
    },
    "devMode": true,
    "host": null,
    "port": "6001",
    "protocol": "http",
    "socketio": {},
    "sslCertPath": "",
    "sslKeyPath": "",
    "sslCertChainPath": "",
    "sslPassphrase": "",
    "apiOriginAllow": {
        "allowCors": false,
        "allowOrigin": "",
        "allowMethods": "",
        "allowHeaders": ""
    }
}
```

要特別注意的是`authHost`  
這是 laravel-echo-server 會去跟 laravel 確認那些 user 可以進入那些 private channel (定義在`routes/channels.php`)
請填上可以訪問到的名稱

# Windows

有些 Composer 套件無法安裝於 Windows 作業系統。  
若須使用 Windows 作業系統進行開發或佈署，  
使用 `composer` 指令時，可能需要加上 `--ignore-platform-req ext-pcntl --ignore-platform-req ext-posix` 參數，使其忽略相關的套件檢查。  
例如：

```bash
composer install --ignore-platform-req ext-pcntl --ignore-platform-req ext-posix
```
