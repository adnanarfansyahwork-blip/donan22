# Laravel Production Deployment Guide

## Setup Document Root di cPanel/Hosting

### Opsi 1: Ubah Document Root (RECOMMENDED)
1. Login ke cPanel
2. Masuk ke **"Domains"** atau **"Document Root"**
3. Ubah document root domain donan22.com dari:
   - ❌ `/public_html/` 
   - ✅ `/public_html/public/`
4. Save

### Opsi 2: Pindahkan File (Jika tidak bisa ubah document root)
```bash
# Di server, pindahkan semua file Laravel ke folder atas
cd /home/u828471719/
mv public_html/public/* public_html/
mv public_html/public/.htaccess public_html/
```

## Setup Files di Server

### 1. Upload semua files ke server
Upload ke: `/home/u828471719/public_html/`

### 2. Setup Environment
```bash
# Copy .env.production jadi .env
cp .env.production .env

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache
```

### 3. Install Dependencies & Optimize
```bash
# Install composer dependencies
php composer2.phar install --optimize-autoloader --no-dev

# Create storage link
php artisan storage:link

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (jika belum)
php artisan migrate --force
```

### 4. Setup Storage Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/uploads
```

## Troubleshooting

### Jika CSS/JS tidak muncul:
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Rebuild assets
npm run build
```

### Jika masih /public/ di URL:
- Pastikan .htaccess di root sudah ter-upload
- Atau ubah document root di hosting panel

### Check Laravel logs:
`storage/logs/laravel.log`
