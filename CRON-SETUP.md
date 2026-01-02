# Setup Cron Job untuk Laravel Scheduler

## Masalah
User `u828471719` tidak memiliki akses langsung ke `crontab` command di server. Di shared hosting Hostinger, cron job harus diatur melalui hPanel.

## Cara Setup via hPanel

### 1. Login ke hPanel
- URL: https://hpanel.hostinger.com/
- Login dengan credentials Hostinger

### 2. Buka Advanced → Cron Jobs

### 3. Tambah Cron Job Baru
Isi form dengan data berikut:

**Common Settings:**
- Select: Custom

**Minute:** `*` (setiap menit)
**Hour:** `*` (setiap jam)
**Day:** `*` (setiap hari)
**Month:** `*` (setiap bulan)
**Weekday:** `*` (setiap hari dalam seminggu)

**Command:**
```bash
cd /home/u828471719/domains/donan22.com/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

**PENTING:** Pastikan command dimulai dengan `cd` untuk pindah direktori dulu!

ATAU jika path php berbeda:
```bash
cd /home/u828471719/domains/donan22.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

### 4. Klik "Create"

## Verifikasi

Setelah setup, tunggu 1-2 menit, lalu cek log:

```bash
ssh -p 65002 u828471719@153.92.11.219
cd ~/domains/donan22.com/public_html
tail -f storage/logs/laravel.log
```

## Alternatif: Setup Manual via SSH (jika diizinkan)

Jika ada akses crontab di masa depan:

```bash
# Edit crontab
crontab -e

# Tambahkan baris ini:
* * * * * cd ~/domains/donan22.com/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1

# Simpan dan exit
# Verifikasi
crontab -l
```

## Penjelasan Command

- `* * * * *` = Run setiap menit
- `cd ~/domains/donan22.com/public_html` = Pindah ke direktori project
- `/usr/bin/php artisan schedule:run` = Jalankan Laravel scheduler
- `>> /dev/null 2>&1` = Buang output (tidak perlu log)

## Task Scheduler Laravel

Setelah cron job aktif, Anda bisa mendefinisikan scheduled tasks di `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Contoh: backup database setiap hari jam 2 pagi
    $schedule->command('backup:run')->daily()->at('02:00');
    
    // Contoh: clear cache setiap minggu
    $schedule->command('cache:clear')->weekly();
    
    // Contoh: sitemap generation setiap hari
    $schedule->call(function () {
        // Generate sitemap
    })->daily();
}
```

## Troubleshooting

### Cron tidak jalan
1. Pastikan path PHP benar: `/usr/bin/php` atau `php`
2. Pastikan path project benar
3. Cek permission file artisan: `chmod +x artisan`
4. Cek log Laravel: `storage/logs/laravel.log`

### Test Manual
Untuk test apakah command berfungsi:
```bash
cd ~/domains/donan22.com/public_html
/usr/bin/php artisan schedule:run
```

Jika ada output atau tidak error, berarti command benar.

## Screenshot Guide (via hPanel)

Lokasi menu:
1. hPanel Dashboard
2. Advanced section
3. Cron Jobs
4. Create Cron Job
5. Isi form seperti di atas
6. Save

## Notes

- Cron job Laravel hanya butuh **1 entry** yang run setiap menit
- Laravel scheduler akan handle semua scheduled tasks internal
- Tidak perlu multiple cron entries
- Output di-redirect ke `/dev/null` untuk menghindari email spam dari cron
