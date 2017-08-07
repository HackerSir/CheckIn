#!/usr/bin/env bash
# 切換到腳本所在路徑，防止腳本在其他路徑被執行
cd "$(dirname "$0")"
# 清除之前sudo留下的有效時間，強制重新輸入密碼
sudo -k
# 顯示執行指令
set -x
# 自動更新專案
sudo git pull
sudo composer install --no-dev
sudo php artisan migrate
sudo chown www-data:www-data -R .
