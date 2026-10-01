<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/SimpleRedis.php';
require_once __DIR__ . '/SimpleSmtp.php';
require_once __DIR__ . '/sozluk.php';

/** Desteklenen diller. */
function diller(): array
{
    return ['tr' => 'Türkçe', 'en' => 'English', 'ar' => 'العربية', 'ru' => 'Русский', 'de' => 'Deutsch'];
}

/** Aktif dil: ?dil= parametresi > çerez > tr. Admin her zaman TR çalışır. */
function aktif_dil(): string
{
    static $dil = null;
    if ($dil !== null) {
        return $dil;
    }
    if (str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/')) {
        return $dil = 'tr';
    }
    $liste = array_keys(diller());
    if (isset($_GET['dil']) && in_array($_GET['dil'], $liste, true)) {
        $dil = $_GET['dil'];
        setcookie('dil', $dil, time() + 60 * 60 * 24 * 30, '/');
    } elseif (isset($_COOKIE['dil']) && in_array($_COOKIE['dil'], $liste, true)) {
        $dil = $_COOKIE['dil'];
    } else {
        $dil = 'tr';
    }
    return $dil;
}

function rtl(): bool
{
    return aktif_dil() === 'ar';
}

/** Arayüz sözlüğü çevirisi (buton, form etiketi vb.). */
function s(string $anahtar): string
{
    $sozluk = sozluk();
    return $sozluk[aktif_dil()][$anahtar] ?? $sozluk['tr'][$anahtar] ?? $anahtar;
}

/** Aktif dilin içerik çevirileri (tr için boş — ana metinler icerik/ayarlar tablosunda). */
function ceviriler(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    $dil = aktif_dil();
    if ($dil !== 'tr' && ($db = pdo())) {
        try {
            $sorgu = $db->prepare('SELECT anahtar, deger FROM icerik_ceviri WHERE dil = ?');
            $sorgu->execute([$dil]);
            foreach ($sorgu as $satir) {
                $cache[$satir['anahtar']] = (string) $satir['deger'];
            }
        } catch (Throwable $e) {
            error_log('Çeviriler okunamadı: ' . $e->getMessage());
        }
    }
    return $cache;
}

/** Ayarlar gibi TR değeri elde olan metinler için çeviri: varsa çevirisi, yoksa TR. */
function cv(string $anahtar, string $trDeger): string
{
    $c = ceviriler();
    return ($c[$anahtar] ?? '') !== '' ? $c[$anahtar] : $trDeger;
}

/**
 * .env dosyası desteği (prod, Docker'sız kurulum için).
 * Proje kökünde veya app/ içinde .env varsa okunur; Docker/ortam değişkenleri her zaman önceliklidir.
 */
(function (): void {
    foreach ([dirname(__DIR__, 2) . '/.env', dirname(__DIR__) . '/.env'] as $dosya) {
        if (!is_file($dosya)) {
            continue;
        }
        foreach (file($dosya, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $satir) {
            $satir = trim($satir);
            if ($satir === '' || $satir[0] === '#' || !str_contains($satir, '=')) {
                continue;
            }
            [$anahtar, $deger] = explode('=', $satir, 2);
            $anahtar = trim($anahtar);
            $deger = trim(trim($deger), "\"'");
            if ($anahtar !== '' && getenv($anahtar) === false) {
                putenv("$anahtar=$deger");
            }
        }
        break;
    }
})();

function env(string $anahtar, string $varsayilan = ''): string
{
    $deger = getenv($anahtar);
    return $deger === false ? $varsayilan : $deger;
}

function pdo(): ?PDO
{
    static $pdo = null;
    static $denendi = false;
    if ($denendi) {
        return $pdo;
    }
    $denendi = true;
    try {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            env('DB_HOST', 'db'),
            env('DB_PORT', '3306'),
            env('DB_NAME', 'mantarhane')
        );
        $pdo = new PDO($dsn, env('DB_USER', 'mantarhane'), env('DB_PASS', 'mantarhane'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 3,
        ]);
    } catch (Throwable $e) {
        error_log('DB bağlantı hatası: ' . $e->getMessage());
        $pdo = null;
    }
    return $pdo;
}

function redis(): ?SimpleRedis
{
    static $redis = null;
    static $denendi = false;
    if ($denendi) {
        return $redis;
    }
    $denendi = true;
    try {
        $redis = new SimpleRedis(env('REDIS_HOST', 'redis'), (int) env('REDIS_PORT', '6379'));
    } catch (Throwable $e) {
        error_log('Redis bağlantı hatası: ' . $e->getMessage());
        $redis = null;
    }
    return $redis;
}

/** Site ayarları: DB'deki `ayarlar` tablosu; DB yoksa makul varsayılanlar. */
function ayarlar(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $varsayilan = [
        'site_baslik'     => 'Mantarhane — Lezzeti Mantara Bağladık',
        'slogan'          => 'Lezzeti Mantara Bağladık',
        'adres'           => 'Feyzullah Mh. Bostan Sk. No:9/A Maltepe / İstanbul',
        'adres_kisa'      => 'Maltepe / İstanbul',
        'saatler'         => 'Her gün 11:00 – 01:00',
        'telefon'         => '+90 532 216 58 14',
        'whatsapp'        => '905322165814',
        'email_info'      => 'info@mantarhane.co',
        'email_social'    => 'social@mantarhane.co',
        'email_franchise' => 'franchise@mantarhane.co',
        'instagram_url'   => '#',
        'x_url'           => '#',
        'mail_from'       => 'no-reply@mantarhane.co',
        'mail_from_ad'    => 'Mantarhane Web',
        'site_url'        => 'https://www.mantarhane.co',
        'seo_aciklama'    => 'Mantarhane — istiridye mantarından gurme burger, kokoreç ve wrap. Sıfır hayvansal et, köz ateşi, gizli reçeteler.',
        'ga_id'           => '',
    ];
    $dbDegerleri = [];
    if ($db = pdo()) {
        try {
            foreach ($db->query('SELECT anahtar, deger FROM ayarlar') as $satir) {
                $dbDegerleri[$satir['anahtar']] = (string) $satir['deger'];
            }
        } catch (Throwable $e) {
            error_log('Ayarlar okunamadı: ' . $e->getMessage());
        }
    }
    return $cache = array_merge($varsayilan, $dbDegerleri);
}

/** WhatsApp sohbet linki (ayarlar.whatsapp, boşsa telefon). 0532… / 532… / 0090… yazımları 90532… olur; numara yoksa ''. */
function whatsapp_url(): string
{
    $a = ayarlar();
    $no = preg_replace('/\D+/', '', $a['whatsapp'] !== '' ? $a['whatsapp'] : $a['telefon']);
    $no = preg_replace('/^00/', '', $no);
    if (str_starts_with($no, '0')) {
        $no = '9' . $no;
    } elseif (strlen($no) === 10) {
        $no = '90' . $no;
    }
    return $no === '' ? '' : 'https://wa.me/' . $no . '?text=' . rawurlencode(s('wa_mesaj'));
}

function e(?string $metin): string
{
    return htmlspecialchars((string) $metin, ENT_QUOTES, 'UTF-8');
}

/** Site metinleri: DB'deki `icerik` tablosu (adminden düzenlenir). */
function icerikler(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    if ($db = pdo()) {
        try {
            foreach ($db->query('SELECT anahtar, deger FROM icerik') as $satir) {
                $cache[$satir['anahtar']] = (string) $satir['deger'];
            }
        } catch (Throwable $e) {
            error_log('İçerikler okunamadı: ' . $e->getMessage());
        }
    }
    return $cache;
}

/** Tek içerik metni; aktif dilde çevirisi varsa o, yoksa TR, o da yoksa varsayılan. */
function ic(string $anahtar, string $varsayilan = ''): string
{
    $ceviri = ceviriler()[$anahtar] ?? '';
    if ($ceviri !== '') {
        return $ceviri;
    }
    $deger = icerikler()[$anahtar] ?? '';
    return $deger !== '' ? $deger : $varsayilan;
}

/** <img> src'si + yedek: adminden girilen görsel yüklenemezse (silinmiş dosya, süresi dolmuş CDN) varsayılana düşer. */
function gorsel_src(string $anahtar, string $varsayilan): string
{
    $src = ic($anahtar, $varsayilan);
    $html = 'src="' . e($src) . '"';
    if ($src !== $varsayilan) {
        $html .= ' onerror="' . e('this.onerror=null;this.src=' . json_encode($varsayilan, JSON_UNESCAPED_SLASHES)) . '"';
    }
    return $html;
}

/** Aktif menü kategorileri (sira'ya göre), aktif dilin çevirileriyle. */
function kategoriler(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    if ($db = pdo()) {
        try {
            $dil = aktif_dil();
            if ($dil === 'tr') {
                $cache = $db->query('SELECT * FROM menu_kategorileri WHERE aktif = 1 ORDER BY sira, id')->fetchAll();
            } else {
                $sorgu = $db->prepare(
                    'SELECT k.id, k.gorsel_url, k.sira, k.aktif,
                            COALESCE(NULLIF(c.isim, ""), k.isim) AS isim,
                            COALESCE(NULLIF(c.ust_baslik, ""), k.ust_baslik) AS ust_baslik,
                            COALESCE(NULLIF(c.aciklama, ""), k.aciklama) AS aciklama
                     FROM menu_kategorileri k
                     LEFT JOIN menu_kategorileri_ceviri c ON c.kategori_id = k.id AND c.dil = ?
                     WHERE k.aktif = 1 ORDER BY k.sira, k.id'
                );
                $sorgu->execute([$dil]);
                $cache = $sorgu->fetchAll();
            }
        } catch (Throwable $e) {
            error_log('Kategoriler okunamadı: ' . $e->getMessage());
        }
    }
    return $cache;
}

/** Aktif ürünler, kategori id'sine göre gruplu: [kategori_id => [urun, ...]] */
function urunler(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    if ($db = pdo()) {
        try {
            $dil = aktif_dil();
            if ($dil === 'tr') {
                $satirlar = $db->query(
                    'SELECT u.* FROM urunler u
                     JOIN menu_kategorileri k ON k.id = u.kategori_id
                     WHERE u.aktif = 1 AND k.aktif = 1
                     ORDER BY k.sira, u.sira, u.id'
                )->fetchAll();
            } else {
                $sorgu = $db->prepare(
                    'SELECT u.id, u.kategori_id, u.fiyat, u.gorsel_url, u.sira, u.aktif,
                            COALESCE(NULLIF(c.isim, ""), u.isim) AS isim,
                            COALESCE(NULLIF(c.aciklama, ""), u.aciklama) AS aciklama,
                            COALESCE(NULLIF(c.etiket, ""), u.etiket) AS etiket
                     FROM urunler u
                     JOIN menu_kategorileri k ON k.id = u.kategori_id
                     LEFT JOIN urunler_ceviri c ON c.urun_id = u.id AND c.dil = ?
                     WHERE u.aktif = 1 AND k.aktif = 1
                     ORDER BY k.sira, u.sira, u.id'
                );
                $sorgu->execute([$dil]);
                $satirlar = $sorgu->fetchAll();
            }
            foreach ($satirlar as $u) {
                $cache[(int) $u['kategori_id']][] = $u;
            }
        } catch (Throwable $e) {
            error_log('Ürünler okunamadı: ' . $e->getMessage());
        }
    }
    return $cache;
}

/** 185.00 -> "185 ₺", 42.50 -> "42,50 ₺" */
function fiyat_goster($fiyat): string
{
    $f = (float) $fiyat;
    $tam = fmod($f, 1.0) == 0.0;
    return number_format($f, $tam ? 0 : 2, ',', '.') . ' ₺';
}

/**
 * Adminden görsel dosyası yükler; başarıda "uploads/..." yolunu, dosya seçilmemişse null döner.
 * Hatalı dosyada RuntimeException fırlatır.
 */
function gorsel_yukle(string $alanAdi): ?string
{
    if (empty($_FILES[$alanAdi]) || $_FILES[$alanAdi]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $dosya = $_FILES[$alanAdi];
    if ($dosya['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Dosya yüklenemedi (hata kodu ' . $dosya['error'] . ').');
    }
    if ($dosya['size'] > 6 * 1024 * 1024) {
        throw new RuntimeException('Dosya 6 MB sınırını aşıyor.');
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($dosya['tmp_name']);
    $uzantilar = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($uzantilar[$mime])) {
        throw new RuntimeException('Sadece JPG, PNG veya WebP yüklenebilir.');
    }
    // Normal düzende public/, cPanel'de public_html farklı konumda olabilir — docroot'a göre bul
    $publicKlasoru = is_dir(dirname(__DIR__) . '/public')
        ? dirname(__DIR__) . '/public'
        : rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? dirname(__DIR__)), '/');
    $klasor = $publicKlasoru . '/uploads';
    if (!is_dir($klasor)) {
        mkdir($klasor, 0775, true);
    }
    $ad = 'g' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $uzantilar[$mime];
    if (!move_uploaded_file($dosya['tmp_name'], "$klasor/$ad")) {
        throw new RuntimeException('Dosya kaydedilemedi.');
    }
    return 'uploads/' . $ad;
}

/** Hazır renk paletleri. Slotlar sabittir; sayfalar hep aynı sınıf adlarını kullanır. */
function paletler(): array
{
    return [
        'koz' => [
            'ad' => 'Köz — sıcak turuncu (marka rengi)',
            'turuncu' => '#FF5A00', 'kirmizi' => '#C8232C', 'komur' => '#201007',
            'kahve' => '#3D240F', 'krem' => '#FFF6E8', 'sut' => '#FFFDF4', 'hardal' => '#FFC93C',
        ],
        'toprak' => [
            'ad' => 'Toprak — kiremit & haki, sakin',
            'turuncu' => '#C4501B', 'kirmizi' => '#A03A10', 'komur' => '#1C140D',
            'kahve' => '#2A2018', 'krem' => '#F6F1E8', 'sut' => '#FCF9F3', 'hardal' => '#8A9B68',
        ],
        'orman' => [
            'ad' => 'Orman — mantar yeşili, doğal',
            'turuncu' => '#257A57', 'kirmizi' => '#1C5A40', 'komur' => '#0F1F18',
            'kahve' => '#16281F', 'krem' => '#F2F4EE', 'sut' => '#FAFBF7', 'hardal' => '#E4B23A',
        ],
        'gurme' => [
            'ad' => 'Gurme — siyah/beyaz + tek vurgu, en minimal',
            'turuncu' => '#E8380D', 'kirmizi' => '#C42B06', 'komur' => '#111111',
            'kahve' => '#1A1A1A', 'krem' => '#FAF8F4', 'sut' => '#FFFFFF', 'hardal' => '#D9C9A3',
        ],
    ];
}

function aktif_palet(): array
{
    $paletler = paletler();
    $secim = ayarlar()['tema_palet'] ?? 'koz';
    return $paletler[$secim] ?? $paletler['koz'];
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_gecerli(): bool
{
    return hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''));
}

/** Redis tabanlı basit hız limiti. Redis yoksa engellemez (fail-open). */
function hiz_limiti(string $anahtar, int $limit, int $saniye): bool
{
    $r = redis();
    if ($r === null) {
        return true;
    }
    try {
        $sayi = $r->incr($anahtar);
        if ($sayi === 1) {
            $r->expire($anahtar, $saniye);
        }
        return $sayi <= $limit;
    } catch (Throwable $e) {
        return true;
    }
}

/** Bildirim e-postası gönderir; başarı durumunu döner. */
function eposta_gonder(string $kime, string $konu, string $html): bool
{
    $a = ayarlar();
    try {
        $smtp = new SimpleSmtp(
            env('SMTP_HOST', 'mailpit'),
            (int) env('SMTP_PORT', '1025'),
            env('SMTP_USER'),
            env('SMTP_PASS'),
            env('SMTP_SECURE', 'none')
        );
        return $smtp->gonder($a['mail_from'], $a['mail_from_ad'], $kime, $konu, $html);
    } catch (Throwable $e) {
        error_log('E-posta gönderilemedi: ' . $e->getMessage());
        return false;
    }
}

function flash_koy(string $tur, string $mesaj): void
{
    $_SESSION['flash'] = ['tur' => $tur, 'mesaj' => $mesaj];
}

function flash_al(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
