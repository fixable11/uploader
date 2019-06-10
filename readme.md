## Установка

```bash
git clone https://github.com/fixable11/uploader.git
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate
npm run dev
```

Опционально меняем прокси в .env для запуска `npm run watch'
```
MIX_PROXY="localhost"
```
