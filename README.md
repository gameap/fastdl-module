Manage FastDL in the GameAP

## Installation

### Via Composer

Install fastdl module:
```bash
composer require --update-no-dev gameap/fastdl-module
```

Update migrations:
```bash
php artisan module:migrate Fastdl
```

### Without access to CLI (SSH or other)

Copy files to `/path/to/gameap/modules/Fastdl/`

Update migrations. Go to **GameAP** -> **Modules** and click **"Run Migration"**
