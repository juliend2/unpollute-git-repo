# README

## Installation

```bash
git clone [repo]
cd [dir]
composer install
crontab -e
```

and add something like:

```cron
* * * * * env GIT_BIN_PATH='/usr/local/cpanel/3rdparty/lib/path-bin/git' /usr/local/bin/php /home/user/unpollute.php /home/user/public_html/website_repo
```
