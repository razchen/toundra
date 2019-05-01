# Toundra

Toundra is a platform that allows managing 3d models.

## Installation

1. Pull from github

```bash
git pull origin master
```

2. Install composer

```bash
https://getcomposer.org/download/
```

3. Run composer dependencies 

```bash
composer install
```

4. Install NPM

```bash
https://tecadmin.net/install-latest-nodejs-npm-on-ubuntu/
```

5. Run NPM dependencies

```bash
npm install
```

6. Upload a .env file which should include all the environment variable for the project: 

```bash
APP_NAME=Toundra
APP_ENV=local
APP_KEY=base64:S4CWmzWMVzrq02QybexufvF1AWLpN1tZ3MQW6/1MQ+M=
APP_DEBUG=true
APP_URL=http://www.toundra.io

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=toundra
DB_USERNAME=homestead
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=c7f6d24a7395f9
MAIL_PASSWORD=19aea742d977ae
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```

7. Login to MySQL and create a database

```mysql
CREATE DATABASE toundra;
```

8. Import the DB

```bash
mysql toundra < toundra.sql
```
