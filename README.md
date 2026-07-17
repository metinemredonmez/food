# Mantarhane — Lokal Geliştirme Ortamı

Mantarhane web sitesinin PHP + HTML + CSS + JS (React yok) lokal sürümü.
Stack: PHP 8.3 (Apache) · MySQL 8.4 · Redis 7 · Mailpit (lokal e-posta) · Tailwind (CDN) + Alpine.js.

## Başlatma

```bash
docker compose up -d --build
```

## Adresler (diğer projelerle çakışmayan portlar)

| Servis                         | Adres                  |
|--------------------------------|------------------------|
| **Web sitesi**                 | http://localhost:8090  |
| **Yönetim paneli**             | http://localhost:8090/admin/ (şifre: `mantar2026`, `docker-compose.yml` → `ADMIN_PASSWORD`) |
| **Mailpit** (giden e-postalar) | http://localhost:8095  |
| **Adminer** (veritabanı arayüzü) | http://localhost:8096 (sunucu: `db`, kullanıcı: `mantarhane`, şifre: `mantarhane`) |
| MySQL (dışarıdan)              | localhost:3390         |
| Redis (dışarıdan)              | localhost:6390         |

Container adları `mantarhane-*` önekiyle başlar; printy/workpulse/luca projelerinden tamamen bağımsızdır.

## Yapı

```
app/
  public/          # Apache docroot
    index.php      # Ana sayfa
    lezzetlerimiz.php
    hakkimizda.php
    franchise.php  # Başvuru formu → DB + e-posta
    iletisim.php   # İletişim formu → DB + e-posta
    admin/         # Yönetim: başvurular, mesajlar, metinler, kategoriler, ürünler, palet, ayarlar
    assets/        # logo, style.css, app.js
    uploads/       # adminden yüklenen görseller
    sitemap.php    # dinamik sitemap (site_url ayarından)
    robots.txt
  src/             # bootstrap (DB/Redis/ayarlar/CSRF/hız limiti), SimpleRedis, SimpleSmtp
  templates/       # header.php, footer.php
db/init.sql        # Şema + başlangıç ayarları (ilk açılışta otomatik yüklenir)
site/index.html    # İlk statik tasarım taslağı (referans)
```

## E-posta

Formlardan gönderilen e-postalar lokalde **Mailpit**'e düşer (http://localhost:8095) — gerçek posta gitmez.
Prod'a (Turhost) geçerken `docker-compose.yml`'deki SMTP ortam değişkenlerini gerçek değerlerle değiştirin:
`SMTP_HOST`, `SMTP_PORT=587`, `SMTP_USER`, `SMTP_PASS`, `SMTP_SECURE=tls`.

## Site ayarları

Adres, çalışma saatleri, e-posta adresleri, sosyal medya linkleri DB'deki `ayarlar` tablosunda tutulur ve
**/admin → Site Ayarları** sekmesinden değiştirilir; sitede anında yansır.

## Prod kurulumu (Docker YOK — PM2 ile)

Prod'da Docker kullanılmaz. Ayarlar `.env` dosyasından okunur, süreç PM2 ile yönetilir.

### 1. Sunucu gereksinimleri

```bash
# Ubuntu/Debian örneği
sudo apt install php8.3-cli php8.3-mysql mysql-server redis-server   # redis opsiyonel
npm install -g pm2
```

### 2. Projeyi at ve ayarla

```bash
# Projeyi sunucuya kopyala (git veya scp), sonra:
cd mantarhane
cp .env.example .env
nano .env        # DB, SMTP ve admin şifrelerini doldur

# Veritabanını kur
mysql -u root -p -e "CREATE DATABASE mantarhane CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mantarhane'@'localhost' IDENTIFIED BY 'SIFRENIZ';
GRANT ALL ON mantarhane.* TO 'mantarhane'@'localhost';"
mysql -u mantarhane -p mantarhane < db/init.sql
```

### 3. PM2 ile başlat

```bash
pm2 start ecosystem.config.js   # php -S 127.0.0.1:8090 (8 worker) çalıştırır
pm2 save && pm2 startup         # sunucu yeniden açılınca otomatik başlar
```

Site artık `127.0.0.1:8090`'da. Dışarıya açmak için önüne nginx koyun:

```nginx
server {
    listen 80;
    server_name mantarhane.co www.mantarhane.co;
    location / { proxy_pass http://127.0.0.1:8090; proxy_set_header Host $host; }
}
```

SSL için: `sudo certbot --nginx -d mantarhane.co -d www.mantarhane.co`

> Not: Trafik büyürse PHP yerleşik sunucusu yerine nginx + PHP-FPM'e geçilmeli
> (kod değişikliği gerekmez, sadece sunucu yapılandırması).

### Alternatif: Turhost paylaşımlı hosting (PM2 de gerekmez)

Paylaşımlı hostingde PHP zaten Apache ile çalışır: `app/` içeriğini FTP ile atın
(docroot `app/public` olacak şekilde), `db/init.sql`'i phpMyAdmin'den içeri alın,
`.env` dosyasını `app/` klasörünün yanına koyup doldurun. Bitti.

Redis prod'da yoksa sorun değil — kod Redis'siz de çalışır (yalnızca form hız limiti devre dışı kalır).
