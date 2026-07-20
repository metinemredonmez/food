<?php
require_once __DIR__ . '/../../src/bootstrap.php';

// Çıkış
if (isset($_GET['cikis'])) {
    unset($_SESSION['admin']);
    header('Location: index.php');
    exit;
}

$girisHatasi = null;

// Giriş
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sifre']) && empty($_SESSION['admin'])) {
    if (csrf_gecerli() && hash_equals(env('ADMIN_PASSWORD', 'mantar2026'), (string) $_POST['sifre'])) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    }
    $girisHatasi = 'Şifre hatalı.';
}

$girisli = !empty($_SESSION['admin']);
$tab = $_GET['tab'] ?? 'basvurular';
$bildirim = null;
$db = pdo();

$dilListesi = diller();
$adminDil = $_POST['ceviri_dil'] ?? $_GET['dil'] ?? 'tr';
if (!array_key_exists($adminDil, $dilListesi)) {
    $adminDil = 'tr';
}

if ($girisli && $db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_gecerli()) {

    // Site ayarları
    if (isset($_POST['ayarlar']) && is_array($_POST['ayarlar'])) {
        $guncelle = $db->prepare('UPDATE ayarlar SET deger = ? WHERE anahtar = ?');
        $mevcutlar = $db->query('SELECT anahtar FROM ayarlar')->fetchAll(PDO::FETCH_COLUMN);
        foreach ($_POST['ayarlar'] as $anahtar => $deger) {
            if (in_array($anahtar, $mevcutlar, true)) {
                $guncelle->execute([trim((string) $deger), $anahtar]);
            }
        }
        $bildirim = 'Ayarlar kaydedildi.';
        $tab = 'ayarlar';
    }

    // Site metinleri
    if (isset($_POST['icerik']) && is_array($_POST['icerik'])) {
        $guncelle = $db->prepare('UPDATE icerik SET deger = ? WHERE anahtar = ?');
        $mevcutlar = $db->query('SELECT anahtar FROM icerik')->fetchAll(PDO::FETCH_COLUMN);
        foreach ($_POST['icerik'] as $anahtar => $deger) {
            if (in_array($anahtar, $mevcutlar, true)) {
                $guncelle->execute([trim((string) $deger), $anahtar]);
            }
        }
        $bildirim = 'Metinler kaydedildi.';
        $tab = 'icerikler';
    }

    // Tema paleti
    if (isset($_POST['tema_palet'])) {
        $secim = (string) $_POST['tema_palet'];
        if (array_key_exists($secim, paletler())) {
            $db->prepare('INSERT INTO ayarlar (anahtar, deger) VALUES ("tema_palet", ?) ON DUPLICATE KEY UPDATE deger = VALUES(deger)')
               ->execute([$secim]);
            $bildirim = 'Renk paleti güncellendi: ' . paletler()[$secim]['ad'];
        }
        $tab = 'gorunum';
    }

    // Menü kategorisi ekle/güncelle
    if (isset($_POST['kategori_kaydet'])) {
        try {
            $yeniGorsel = gorsel_yukle('gorsel_dosya');
        } catch (Throwable $hata) {
            $yeniGorsel = null;
            $bildirimHata = $hata->getMessage();
        }
        $kid    = (int) ($_POST['id'] ?? 0);
        $alanlar = [
            trim((string) ($_POST['isim'] ?? '')),
            trim((string) ($_POST['ust_baslik'] ?? '')),
            trim((string) ($_POST['aciklama'] ?? '')),
            $yeniGorsel ?? trim((string) ($_POST['gorsel_url'] ?? '')),
            (int) ($_POST['sira'] ?? 0),
            isset($_POST['aktif']) ? 1 : 0,
        ];
        if ($alanlar[0] !== '' && empty($bildirimHata)) {
            if ($kid > 0) {
                $db->prepare('UPDATE menu_kategorileri SET isim=?, ust_baslik=?, aciklama=?, gorsel_url=?, sira=?, aktif=? WHERE id=?')
                   ->execute([...$alanlar, $kid]);
                $bildirim = 'Kategori güncellendi.';
            } else {
                $db->prepare('INSERT INTO menu_kategorileri (isim, ust_baslik, aciklama, gorsel_url, sira, aktif) VALUES (?,?,?,?,?,?)')
                   ->execute($alanlar);
                $bildirim = 'Kategori eklendi.';
            }
        }
        $tab = 'menu';
    }

    // Menü kategorisi sil
    if (isset($_POST['kategori_sil'])) {
        $db->prepare('DELETE FROM menu_kategorileri WHERE id = ?')->execute([(int) $_POST['kategori_sil']]);
        $bildirim = 'Kategori silindi.';
        $tab = 'menu';
    }

    // Ürün ekle/güncelle
    if (isset($_POST['urun_kaydet'])) {
        try {
            $yeniGorsel = gorsel_yukle('gorsel_dosya');
        } catch (Throwable $hata) {
            $yeniGorsel = null;
            $bildirimHata = $hata->getMessage();
        }
        $uid = (int) ($_POST['id'] ?? 0);
        $alanlar = [
            (int) ($_POST['kategori_id'] ?? 0),
            trim((string) ($_POST['isim'] ?? '')),
            trim((string) ($_POST['aciklama'] ?? '')),
            (float) str_replace(',', '.', (string) ($_POST['fiyat'] ?? '0')),
            $yeniGorsel ?? trim((string) ($_POST['gorsel_url'] ?? '')),
            trim((string) ($_POST['etiket'] ?? '')),
            (int) ($_POST['sira'] ?? 0),
            isset($_POST['aktif']) ? 1 : 0,
        ];
        if ($alanlar[0] > 0 && $alanlar[1] !== '' && empty($bildirimHata)) {
            if ($uid > 0) {
                $db->prepare('UPDATE urunler SET kategori_id=?, isim=?, aciklama=?, fiyat=?, gorsel_url=?, etiket=?, sira=?, aktif=? WHERE id=?')
                   ->execute([...$alanlar, $uid]);
                $bildirim = 'Ürün güncellendi.';
            } else {
                $db->prepare('INSERT INTO urunler (kategori_id, isim, aciklama, fiyat, gorsel_url, etiket, sira, aktif) VALUES (?,?,?,?,?,?,?,?)')
                   ->execute($alanlar);
                $bildirim = 'Ürün eklendi.';
            }
        }
        $tab = 'urunler';
    }

    // Ürün sil
    if (isset($_POST['urun_sil'])) {
        $db->prepare('DELETE FROM urunler WHERE id = ?')->execute([(int) $_POST['urun_sil']]);
        $bildirim = 'Ürün silindi.';
        $tab = 'urunler';
    }

    // İçerik çevirisi kaydet (EN/AR/RU/DE)
    if (isset($_POST['ceviri']) && is_array($_POST['ceviri']) && $adminDil !== 'tr') {
        $kaydet = $db->prepare('REPLACE INTO icerik_ceviri (anahtar, dil, deger) VALUES (?,?,?)');
        foreach ($_POST['ceviri'] as $anahtar => $deger) {
            $kaydet->execute([substr((string) $anahtar, 0, 64), $adminDil, trim((string) $deger)]);
        }
        $bildirim = strtoupper($adminDil) . ' çevirileri kaydedildi.';
        $tab = 'icerikler';
    }

    // Kategori çevirisi kaydet
    if (isset($_POST['kategori_ceviri_kaydet']) && $adminDil !== 'tr') {
        $db->prepare('REPLACE INTO menu_kategorileri_ceviri (kategori_id, dil, isim, ust_baslik, aciklama) VALUES (?,?,?,?,?)')
           ->execute([(int) ($_POST['id'] ?? 0), $adminDil,
                      trim((string) ($_POST['isim'] ?? '')), trim((string) ($_POST['ust_baslik'] ?? '')), trim((string) ($_POST['aciklama'] ?? ''))]);
        $bildirim = 'Kategori çevirisi kaydedildi (' . strtoupper($adminDil) . ').';
        $tab = 'menu';
    }

    // Ürün çevirisi kaydet
    if (isset($_POST['urun_ceviri_kaydet']) && $adminDil !== 'tr') {
        $db->prepare('REPLACE INTO urunler_ceviri (urun_id, dil, isim, aciklama, etiket) VALUES (?,?,?,?,?)')
           ->execute([(int) ($_POST['id'] ?? 0), $adminDil,
                      trim((string) ($_POST['isim'] ?? '')), trim((string) ($_POST['aciklama'] ?? '')), trim((string) ($_POST['etiket'] ?? ''))]);
        $bildirim = 'Ürün çevirisi kaydedildi (' . strtoupper($adminDil) . ').';
        $tab = 'urunler';
    }

    // Serbest görsel yükleme (metin alanlarında kullanmak için URL üretir)
    if (isset($_POST['genel_gorsel'])) {
        try {
            $yol = gorsel_yukle('gorsel_dosya');
            $bildirim = $yol
                ? 'Görsel yüklendi — adresi: ' . $yol . '  (kopyalayıp hero_gorsel gibi bir alana yapıştırın)'
                : 'Dosya seçilmedi.';
        } catch (Throwable $hata) {
            $bildirimHata = $hata->getMessage();
        }
        $tab = 'icerikler';
    }
}

$basvurular = $mesajlar = $ayarSatirlari = $icerikSatirlari = $tumKategoriler = $tumUrunler = [];
$icerikCevirileri = $katCevirileri = $urunCevirileri = [];
if ($girisli && $db) {
    try {
        $basvurular      = $db->query('SELECT * FROM franchise_basvurulari ORDER BY id DESC LIMIT 200')->fetchAll();
        $mesajlar        = $db->query('SELECT * FROM iletisim_mesajlari ORDER BY id DESC LIMIT 200')->fetchAll();
        $ayarSatirlari   = $db->query("SELECT anahtar, deger FROM ayarlar WHERE anahtar <> 'tema_palet' ORDER BY anahtar")->fetchAll();
        $icerikSatirlari = $db->query('SELECT anahtar, deger FROM icerik ORDER BY anahtar')->fetchAll();
        $tumKategoriler  = $db->query('SELECT * FROM menu_kategorileri ORDER BY sira, id')->fetchAll();
        if ($adminDil !== 'tr') {
            $s = $db->prepare('SELECT anahtar, deger FROM icerik_ceviri WHERE dil = ?');
            $s->execute([$adminDil]);
            foreach ($s as $satir) { $icerikCevirileri[$satir['anahtar']] = (string) $satir['deger']; }
            $s = $db->prepare('SELECT * FROM menu_kategorileri_ceviri WHERE dil = ?');
            $s->execute([$adminDil]);
            foreach ($s as $satir) { $katCevirileri[(int) $satir['kategori_id']] = $satir; }
            $s = $db->prepare('SELECT * FROM urunler_ceviri WHERE dil = ?');
            $s->execute([$adminDil]);
            foreach ($s as $satir) { $urunCevirileri[(int) $satir['urun_id']] = $satir; }
        }
        $tumUrunler      = $db->query('SELECT u.*, k.isim AS kategori_isim FROM urunler u LEFT JOIN menu_kategorileri k ON k.id = u.kategori_id ORDER BY k.sira, u.sira, u.id')->fetchAll();
    } catch (Throwable $hata) {
        error_log('Admin veri okuma hatası: ' . $hata->getMessage());
    }
}
$aktifPaletAnahtari = ayarlar()['tema_palet'] ?? 'koz';

$sekmeler = [
    'basvurular' => ['Başvurular',        'Franchise başvuruları',                        count($basvurular)],
    'mesajlar'   => ['Mesajlar',          'İletişim formundan gelenler',                  count($mesajlar)],
    'icerikler'  => ['Site Metinleri',    'Sitedeki tüm yazılar',                         null],
    'menu'       => ['Menü Kategorileri', 'Ekle, düzenle, sırala',                        null],
    'urunler'    => ['Ürünler',           'Fiyatlar ve ürün listesi',                     null],
    'gorunum'    => ['Görünüm',           'Renk paleti',                                  null],
    'ayarlar'    => ['Ayarlar',           'Adres, saatler, e-posta, sosyal medya',        null],
];

$ikonlar = [
    'basvurular' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13h4l2 3h6l2-3h4M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/>',
    'mesajlar'   => '<rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9 6 9-6"/>',
    'icerikler'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4a1 1 0 0 0 1 1h4M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2zM9 12h6M9 16h6"/>',
    'menu'       => '<rect x="4" y="4" width="6" height="6" rx="1.5"/><rect x="14" y="4" width="6" height="6" rx="1.5"/><rect x="4" y="14" width="6" height="6" rx="1.5"/><rect x="14" y="14" width="6" height="6" rx="1.5"/>',
    'urunler'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16l-1.5 9a2 2 0 0 1-2 1.7h-9A2 2 0 0 1 5.5 14L4 5zM4 5 3.3 3H2"/><circle cx="9" cy="19.5" r="1.3"/><circle cx="16" cy="19.5" r="1.3"/>',
    'gorunum'    => '<circle cx="8" cy="9" r="2"/><circle cx="15" cy="7" r="2"/><circle cx="16.5" cy="14" r="2"/><path stroke-linecap="round" d="M12 21a9 9 0 1 1 9-9c0 2-1.5 3-3 3h-2a2 2 0 0 0-1.5 3.3c.6.7.2 2.7-2.5 2.7z"/>',
    'ayarlar'    => '<path stroke-linecap="round" d="M4 8h10M18 8h2M4 16h2M10 16h10"/><circle cx="16" cy="8" r="2"/><circle cx="8" cy="16" r="2"/>',
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mantarhane Yönetim</title>
<link rel="icon" href="../assets/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script>
tailwind.config = { theme: { extend: {
  colors: { turuncu:'#FF5A00', koyu:'#16100C', koyu2:'#241A14', zemin:'#F4F2EF' },
  fontFamily: { display:['Space Grotesk','sans-serif'], sans:['Manrope','sans-serif'] },
}}}
</script>
</head>
<body class="bg-zemin font-sans text-stone-800 antialiased min-h-screen">

<?php if (!$girisli): ?>
<div class="min-h-screen flex items-center justify-center px-4">
  <form method="post" class="bg-white border border-stone-200 rounded-3xl p-10 w-full max-w-sm shadow-sm text-center">
    <img src="../assets/logo.png" alt="Mantarhane" class="h-16 w-16 mx-auto">
    <h1 class="font-display font-bold text-2xl mt-4">Yönetim paneli</h1>
    <?php if ($girisHatasi): ?><p class="mt-3 text-sm font-bold text-red-600"><?= e($girisHatasi) ?></p><?php endif; ?>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="password" name="sifre" placeholder="Şifre" autofocus
           class="mt-6 w-full rounded-xl border-stone-300 bg-zemin focus:border-turuncu focus:ring-turuncu">
    <button class="mt-4 w-full bg-turuncu text-white font-bold py-3.5 rounded-xl hover:bg-koyu transition-colors">Giriş</button>
  </form>
</div>
<?php else: ?>

<div class="flex min-h-screen">

  <!-- YAN MENÜ -->
  <aside class="hidden md:flex md:flex-col w-64 shrink-0 bg-koyu text-stone-300">
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/10">
      <img src="../assets/logo.png" alt="" class="h-9 w-9">
      <div class="leading-tight">
        <span class="font-display font-bold text-white block">Mantarhane</span>
        <span class="text-[11px] text-stone-400">Yönetim paneli</span>
      </div>
    </div>
    <nav class="flex-1 px-3 py-4 space-y-1">
      <?php foreach ($sekmeler as $anahtar => [$etiket, $altyazi, $sayi]): $secili = $tab === $anahtar; ?>
      <a href="?tab=<?= $anahtar ?>"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors <?= $secili ? 'bg-white/10 text-white' : 'hover:bg-white/5 hover:text-white' ?>">
        <span class="w-1 h-6 rounded-full <?= $secili ? 'bg-turuncu' : 'bg-transparent' ?>"></span>
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><?= $ikonlar[$anahtar] ?></svg>
        <span class="flex-1"><?= e($etiket) ?></span>
        <?php if ($sayi !== null && $sayi > 0): ?>
        <span class="text-[11px] font-bold bg-turuncu text-white rounded-full px-2 py-0.5"><?= $sayi ?></span>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </nav>
    <div class="px-3 py-4 border-t border-white/10 space-y-1">
      <a href="../index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold hover:bg-white/5 hover:text-white transition-colors">
        <span class="w-1 h-6"></span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></svg>
        Siteyi gör
      </a>
      <a href="?cikis=1" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-300 hover:bg-red-500/10 transition-colors">
        <span class="w-1 h-6"></span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
        Çıkış
      </a>
    </div>
  </aside>

  <!-- İÇERİK -->
  <div class="flex-1 min-w-0">

    <!-- Mobil üst menü -->
    <div class="md:hidden bg-koyu text-stone-300 px-4 py-3 flex items-center gap-3 overflow-x-auto">
      <img src="../assets/logo.png" alt="" class="h-8 w-8 shrink-0">
      <?php foreach ($sekmeler as $anahtar => [$etiket, $altyazi, $sayi]): ?>
      <a href="?tab=<?= $anahtar ?>" class="shrink-0 text-xs font-bold px-3 py-1.5 rounded-full <?= $tab === $anahtar ? 'bg-turuncu text-white' : 'bg-white/10' ?>"><?= e($etiket) ?></a>
      <?php endforeach; ?>
      <a href="?cikis=1" class="shrink-0 text-xs font-bold px-3 py-1.5 rounded-full bg-white/10 text-red-300">Çıkış</a>
    </div>

    <main class="p-5 sm:p-8 max-w-6xl">
      <div class="flex items-end justify-between gap-4">
        <div>
          <h1 class="font-display font-bold text-2xl"><?= e($sekmeler[$tab][0] ?? '') ?></h1>
          <p class="text-sm text-stone-500 mt-0.5"><?= e($sekmeler[$tab][1] ?? '') ?></p>
        </div>
      </div>

      <?php if ($bildirim): ?>
      <div class="mt-5 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3.5 text-sm font-semibold"><?= e($bildirim) ?></div>
      <?php endif; ?>

      <?php if (!empty($bildirimHata)): ?>
      <div class="mt-5 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-3.5 text-sm font-semibold"><?= e($bildirimHata) ?></div>
      <?php endif; ?>

      <?php if ($db === null): ?>
      <div class="mt-5 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-3.5 text-sm font-semibold">Veritabanına bağlanılamadı.</div>
      <?php endif; ?>

      <?php if (in_array($tab, ['icerikler', 'menu', 'urunler'], true)): ?>
      <div class="mt-5 flex items-center gap-2">
        <span class="text-xs font-bold text-stone-400">Dil:</span>
        <?php foreach ($dilListesi as $dKod => $dAd): ?>
        <a href="?tab=<?= $tab ?>&dil=<?= $dKod ?>"
           class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase <?= $adminDil === $dKod ? 'bg-turuncu text-white' : 'bg-white border border-stone-200 hover:border-turuncu' ?>"
           title="<?= e($dAd) ?>"><?= $dKod ?></a>
        <?php endforeach; ?>
        <?php if ($adminDil !== 'tr'): ?>
        <span class="text-xs text-stone-400">— <?= e($dilListesi[$adminDil]) ?> çevirilerini düzenliyorsunuz; boş bırakılan alanlar sitede Türkçe görünür.</span>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <?php if ($tab === 'basvurular'): ?>
      <div class="mt-6 overflow-x-auto bg-white border border-stone-200 rounded-2xl shadow-sm">
        <table class="w-full text-sm">
          <thead class="text-left text-xs uppercase tracking-wide text-stone-400 border-b border-stone-100">
            <tr><th class="px-5 py-3.5">#</th><th class="px-5 py-3.5">Ad soyad</th><th class="px-5 py-3.5">Telefon</th><th class="px-5 py-3.5">E-posta</th><th class="px-5 py-3.5">Şehir</th><th class="px-5 py-3.5">Mesaj</th><th class="px-5 py-3.5">Tarih</th></tr>
          </thead>
          <tbody class="divide-y divide-stone-100">
            <?php if (!$basvurular): ?><tr><td colspan="7" class="px-5 py-10 text-center text-stone-400">Henüz başvuru yok.</td></tr><?php endif; ?>
            <?php foreach ($basvurular as $b): ?>
            <tr class="align-top hover:bg-stone-50">
              <td class="px-5 py-3.5 text-stone-400"><?= (int) $b['id'] ?></td>
              <td class="px-5 py-3.5 font-bold"><?= e($b['ad'] . ' ' . $b['soyad']) ?></td>
              <td class="px-5 py-3.5"><?= e($b['telefon']) ?></td>
              <td class="px-5 py-3.5"><a class="text-turuncu font-semibold" href="mailto:<?= e($b['eposta']) ?>"><?= e($b['eposta']) ?></a></td>
              <td class="px-5 py-3.5"><?= e($b['sehir']) ?></td>
              <td class="px-5 py-3.5 max-w-xs text-stone-500"><?= nl2br(e((string) $b['mesaj'])) ?></td>
              <td class="px-5 py-3.5 whitespace-nowrap text-stone-400"><?= e($b['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php elseif ($tab === 'mesajlar'): ?>
      <div class="mt-6 overflow-x-auto bg-white border border-stone-200 rounded-2xl shadow-sm">
        <table class="w-full text-sm">
          <thead class="text-left text-xs uppercase tracking-wide text-stone-400 border-b border-stone-100">
            <tr><th class="px-5 py-3.5">#</th><th class="px-5 py-3.5">Ad</th><th class="px-5 py-3.5">E-posta</th><th class="px-5 py-3.5">Konu</th><th class="px-5 py-3.5">Mesaj</th><th class="px-5 py-3.5">Tarih</th></tr>
          </thead>
          <tbody class="divide-y divide-stone-100">
            <?php if (!$mesajlar): ?><tr><td colspan="6" class="px-5 py-10 text-center text-stone-400">Henüz mesaj yok.</td></tr><?php endif; ?>
            <?php foreach ($mesajlar as $m): ?>
            <tr class="align-top hover:bg-stone-50">
              <td class="px-5 py-3.5 text-stone-400"><?= (int) $m['id'] ?></td>
              <td class="px-5 py-3.5 font-bold"><?= e($m['ad']) ?></td>
              <td class="px-5 py-3.5"><a class="text-turuncu font-semibold" href="mailto:<?= e($m['eposta']) ?>"><?= e($m['eposta']) ?></a></td>
              <td class="px-5 py-3.5"><?= e((string) $m['konu']) ?></td>
              <td class="px-5 py-3.5 max-w-md text-stone-500"><?= nl2br(e($m['mesaj'])) ?></td>
              <td class="px-5 py-3.5 whitespace-nowrap text-stone-400"><?= e($m['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php elseif ($tab === 'icerikler' && $adminDil !== 'tr'): ?>
      <?php
      $gorselAnahtarlari = ['hero_gorsel', 'hikaye_gorsel', 'franchise_gorsel'];
      $cevrilebilir = [];
      foreach ($ayarSatirlari as $satir) {
          if (in_array($satir['anahtar'], ['site_baslik', 'slogan', 'saatler', 'seo_aciklama'], true)) {
              $cevrilebilir[] = $satir;
          }
      }
      foreach ($icerikSatirlari as $satir) {
          if (!in_array($satir['anahtar'], $gorselAnahtarlari, true)) {
              $cevrilebilir[] = $satir;
          }
      }
      ?>
      <form method="post" class="mt-6 bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8" <?= $adminDil === 'ar' ? '' : '' ?>>
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="ceviri_dil" value="<?= e($adminDil) ?>">
        <div class="grid md:grid-cols-2 gap-4">
          <?php foreach ($cevrilebilir as $satir): ?>
          <div>
            <span class="text-xs font-bold text-stone-400"><?= e($satir['anahtar']) ?></span>
            <p class="text-[11px] text-stone-400 mt-0.5 line-clamp-1">TR: <?= e((string) $satir['deger']) ?></p>
            <textarea name="ceviri[<?= e($satir['anahtar']) ?>]" rows="2" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?>
                      class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 focus:border-turuncu focus:ring-turuncu text-sm"><?= e($icerikCevirileri[$satir['anahtar']] ?? '') ?></textarea>
          </div>
          <?php endforeach; ?>
        </div>
        <button class="mt-6 bg-turuncu text-white font-bold px-8 py-3 rounded-xl hover:bg-koyu transition-colors"><?= strtoupper($adminDil) ?> çevirilerini kaydet</button>
      </form>

      <?php elseif ($tab === 'icerikler'): ?>
      <form method="post" enctype="multipart/form-data" class="mt-6 bg-white border border-stone-200 rounded-2xl shadow-sm p-5 flex flex-wrap items-center gap-3">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <span class="text-sm font-bold text-stone-600">Görsel yükle, adresini al:</span>
        <input type="file" name="gorsel_dosya" accept="image/jpeg,image/png,image/webp" class="text-xs text-stone-500 file:mr-2 file:rounded-lg file:border-0 file:bg-stone-100 file:px-3 file:py-1.5 file:text-xs file:font-bold">
        <button name="genel_gorsel" value="1" class="bg-stone-800 text-white text-xs font-bold px-5 py-2 rounded-lg hover:bg-turuncu transition-colors">Yükle</button>
        <span class="text-xs text-stone-400">Çıkan "uploads/…" adresini hero_gorsel, hikaye_gorsel gibi alanlara yapıştırabilirsiniz.</span>
      </form>

      <form method="post" class="mt-4 bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="grid md:grid-cols-2 gap-4">
          <?php foreach ($icerikSatirlari as $satir): ?>
          <label class="block">
            <span class="text-xs font-bold text-stone-400"><?= e($satir['anahtar']) ?></span>
            <textarea name="icerik[<?= e($satir['anahtar']) ?>]" rows="2"
                      class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 focus:border-turuncu focus:ring-turuncu text-sm"><?= e((string) $satir['deger']) ?></textarea>
          </label>
          <?php endforeach; ?>
        </div>
        <button class="mt-6 bg-turuncu text-white font-bold px-8 py-3 rounded-xl hover:bg-koyu transition-colors">Kaydet</button>
      </form>

      <?php elseif ($tab === 'menu' && $adminDil !== 'tr'): ?>
      <div class="mt-6 space-y-4">
        <?php foreach ($tumKategoriler as $k): $c = $katCevirileri[(int) $k['id']] ?? []; ?>
        <form method="post" class="bg-white border border-stone-200 rounded-2xl shadow-sm p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="ceviri_dil" value="<?= e($adminDil) ?>">
          <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
          <div class="md:col-span-2">
            <span class="text-xs font-bold text-stone-400">TR</span>
            <p class="font-bold text-sm mt-1"><?= e($k['isim']) ?></p>
          </div>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">İsim (<?= strtoupper($adminDil) ?>)</span>
            <input name="isim" value="<?= e((string) ($c['isim'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Üst başlık</span>
            <input name="ust_baslik" value="<?= e((string) ($c['ust_baslik'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" value="<?= e((string) ($c['aciklama'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1">
            <button name="kategori_ceviri_kaydet" value="1" class="bg-turuncu text-white text-xs font-bold px-5 py-2.5 rounded-lg hover:bg-koyu transition-colors">Kaydet</button>
          </div>
        </form>
        <?php endforeach; ?>
        <p class="text-xs text-stone-400">Fiyat, görsel, sıra ve aktiflik yalnızca TR sekmesinde yönetilir.</p>
      </div>

      <?php elseif ($tab === 'menu'): ?>
      <div class="mt-6 space-y-4">
        <?php foreach ($tumKategoriler as $k): ?>
        <form method="post" enctype="multipart/form-data" class="bg-white border border-stone-200 rounded-2xl shadow-sm p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
          <div class="md:col-span-1 flex items-center">
            <?php if ($k['gorsel_url']): ?><img src="<?= e((string) $k['gorsel_url']) ?>" alt="" class="w-12 h-12 rounded-xl object-cover border border-stone-200"><?php endif; ?>
          </div>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">İsim</span>
            <input name="isim" value="<?= e($k['isim']) ?>" required class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Üst başlık</span>
            <input name="ust_baslik" value="<?= e((string) $k['ust_baslik']) ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" value="<?= e((string) $k['aciklama']) ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Görsel URL</span>
            <input name="gorsel_url" value="<?= e((string) $k['gorsel_url']) ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Sıra</span>
            <input name="sira" type="number" value="<?= (int) $k['sira'] ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1 flex items-center gap-2 pb-2.5">
            <input type="checkbox" name="aktif" <?= $k['aktif'] ? 'checked' : '' ?> class="rounded border-stone-300 text-turuncu focus:ring-turuncu">
            <span class="text-xs font-bold">Aktif</span>
          </div>
          <div class="md:col-span-12 flex flex-wrap items-center gap-2 -mt-1">
            <button name="kategori_kaydet" value="1" class="bg-stone-800 text-white text-xs font-bold px-5 py-2 rounded-lg hover:bg-turuncu transition-colors">Kaydet</button>
            <button name="kategori_sil" value="<?= (int) $k['id'] ?>" onclick="return confirm('<?= e($k['isim']) ?> silinsin mi? İçindeki ürünler de silinir.')"
                    class="bg-white text-red-600 border border-red-200 text-xs font-bold px-5 py-2 rounded-lg hover:bg-red-50 transition-colors">Sil</button>
            <label class="ml-auto text-xs font-bold text-stone-500 flex items-center gap-2">Görsel yükle:
              <input type="file" name="gorsel_dosya" accept="image/jpeg,image/png,image/webp" class="text-xs text-stone-500 file:mr-2 file:rounded-lg file:border-0 file:bg-stone-100 file:px-3 file:py-1.5 file:text-xs file:font-bold">
            </label>
          </div>
        </form>
        <?php endforeach; ?>

        <form method="post" enctype="multipart/form-data" class="bg-white/60 border-2 border-dashed border-stone-300 rounded-2xl p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <h3 class="md:col-span-12 font-display font-bold text-sm text-stone-500">Yeni kategori ekle</h3>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">İsim</span>
            <input name="isim" required class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Üst başlık</span>
            <input name="ust_baslik" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Görsel URL</span>
            <input name="gorsel_url" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Sıra</span>
            <input name="sira" type="number" value="99" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1 flex items-center gap-2 pb-2.5">
            <input type="checkbox" name="aktif" checked class="rounded border-stone-300 text-turuncu focus:ring-turuncu">
            <span class="text-xs font-bold">Aktif</span>
          </div>
          <div class="md:col-span-12 flex flex-wrap items-center gap-2">
            <button name="kategori_kaydet" value="1" class="bg-turuncu text-white text-xs font-bold px-5 py-2 rounded-lg hover:bg-koyu transition-colors">Ekle</button>
            <label class="ml-auto text-xs font-bold text-stone-500 flex items-center gap-2">Görsel yükle:
              <input type="file" name="gorsel_dosya" accept="image/jpeg,image/png,image/webp" class="text-xs text-stone-500 file:mr-2 file:rounded-lg file:border-0 file:bg-stone-100 file:px-3 file:py-1.5 file:text-xs file:font-bold">
            </label>
          </div>
        </form>
      </div>

      <?php elseif ($tab === 'urunler' && $adminDil !== 'tr'): ?>
      <div class="mt-6 space-y-4">
        <?php foreach ($tumUrunler as $u): $c = $urunCevirileri[(int) $u['id']] ?? []; ?>
        <form method="post" class="bg-white border border-stone-200 rounded-2xl shadow-sm p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="ceviri_dil" value="<?= e($adminDil) ?>">
          <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
          <div class="md:col-span-3">
            <span class="text-xs font-bold text-stone-400">TR · <?= e((string) $u['kategori_isim']) ?></span>
            <p class="font-bold text-sm mt-1"><?= e($u['isim']) ?> — <?= e(fiyat_goster($u['fiyat'])) ?></p>
          </div>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">İsim (<?= strtoupper($adminDil) ?>)</span>
            <input name="isim" value="<?= e((string) ($c['isim'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" value="<?= e((string) ($c['aciklama'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Etiket</span>
            <input name="etiket" value="<?= e((string) ($c['etiket'] ?? '')) ?>" <?= $adminDil === 'ar' ? 'dir="rtl"' : '' ?> class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1">
            <button name="urun_ceviri_kaydet" value="1" class="bg-turuncu text-white text-xs font-bold px-5 py-2.5 rounded-lg hover:bg-koyu transition-colors">Kaydet</button>
          </div>
        </form>
        <?php endforeach; ?>
        <p class="text-xs text-stone-400">Fiyat, görsel, sıra ve aktiflik yalnızca TR sekmesinde yönetilir.</p>
      </div>

      <?php elseif ($tab === 'urunler'): ?>
      <div class="mt-6 space-y-4">
        <?php foreach ($tumUrunler as $u): ?>
        <form method="post" enctype="multipart/form-data" class="bg-white border border-stone-200 rounded-2xl shadow-sm p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
          <div class="md:col-span-1 flex items-center">
            <?php if ($u['gorsel_url']): ?><img src="../<?= e(ltrim((string) $u['gorsel_url'], '/')) ?>" alt="" class="w-12 h-12 rounded-xl object-cover border border-stone-200"
              onerror="this.src='<?= e((string) $u['gorsel_url']) ?>'"><?php endif; ?>
          </div>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Kategori</span>
            <select name="kategori_id" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu">
              <?php foreach ($tumKategoriler as $k): ?>
              <option value="<?= (int) $k['id'] ?>" <?= (int) $u['kategori_id'] === (int) $k['id'] ? 'selected' : '' ?>><?= e($k['isim']) ?></option>
              <?php endforeach; ?>
            </select></label>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">İsim</span>
            <input name="isim" value="<?= e($u['isim']) ?>" required class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" value="<?= e((string) $u['aciklama']) ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Fiyat ₺</span>
            <input name="fiyat" value="<?= e(rtrim(rtrim(number_format((float) $u['fiyat'], 2, '.', ''), '0'), '.')) ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Etiket</span>
            <input name="etiket" value="<?= e((string) $u['etiket']) ?>" placeholder="Çok satan" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Sıra</span>
            <input name="sira" type="number" value="<?= (int) $u['sira'] ?>" class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1 flex items-center gap-2 pb-2.5">
            <input type="checkbox" name="aktif" <?= $u['aktif'] ? 'checked' : '' ?> class="rounded border-stone-300 text-turuncu focus:ring-turuncu">
            <span class="text-xs font-bold">Aktif</span>
          </div>
          <div class="md:col-span-12 flex flex-wrap items-center gap-2 -mt-1">
            <button name="urun_kaydet" value="1" class="bg-stone-800 text-white text-xs font-bold px-5 py-2 rounded-lg hover:bg-turuncu transition-colors">Kaydet</button>
            <button name="urun_sil" value="<?= (int) $u['id'] ?>" onclick="return confirm('<?= e($u['isim']) ?> silinsin mi?')"
                    class="bg-white text-red-600 border border-red-200 text-xs font-bold px-5 py-2 rounded-lg hover:bg-red-50 transition-colors">Sil</button>
            <label class="ml-auto text-xs font-bold text-stone-500 flex items-center gap-2">Görsel yükle:
              <input type="file" name="gorsel_dosya" accept="image/jpeg,image/png,image/webp" class="text-xs text-stone-500 file:mr-2 file:rounded-lg file:border-0 file:bg-stone-100 file:px-3 file:py-1.5 file:text-xs file:font-bold">
            </label>
          </div>
        </form>
        <?php endforeach; ?>

        <form method="post" enctype="multipart/form-data" class="bg-white/60 border-2 border-dashed border-stone-300 rounded-2xl p-5 grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <h3 class="md:col-span-12 font-display font-bold text-sm text-stone-500">Yeni ürün ekle</h3>
          <label class="md:col-span-2 block"><span class="text-xs font-bold text-stone-400">Kategori</span>
            <select name="kategori_id" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu">
              <?php foreach ($tumKategoriler as $k): ?>
              <option value="<?= (int) $k['id'] ?>"><?= e($k['isim']) ?></option>
              <?php endforeach; ?>
            </select></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">İsim</span>
            <input name="isim" required class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-3 block"><span class="text-xs font-bold text-stone-400">Açıklama</span>
            <input name="aciklama" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Fiyat ₺</span>
            <input name="fiyat" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Etiket</span>
            <input name="etiket" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <label class="md:col-span-1 block"><span class="text-xs font-bold text-stone-400">Sıra</span>
            <input name="sira" type="number" value="99" class="mt-1 w-full rounded-xl border-stone-200 bg-white text-sm focus:border-turuncu focus:ring-turuncu"></label>
          <div class="md:col-span-1 flex items-center gap-2 pb-2.5">
            <input type="checkbox" name="aktif" checked class="rounded border-stone-300 text-turuncu focus:ring-turuncu">
            <span class="text-xs font-bold">Aktif</span>
          </div>
          <div class="md:col-span-12 flex flex-wrap items-center gap-2">
            <button name="urun_kaydet" value="1" class="bg-turuncu text-white text-xs font-bold px-5 py-2 rounded-lg hover:bg-koyu transition-colors">Ekle</button>
            <label class="ml-auto text-xs font-bold text-stone-500 flex items-center gap-2">Görsel yükle:
              <input type="file" name="gorsel_dosya" accept="image/jpeg,image/png,image/webp" class="text-xs text-stone-500 file:mr-2 file:rounded-lg file:border-0 file:bg-stone-100 file:px-3 file:py-1.5 file:text-xs file:font-bold">
            </label>
          </div>
        </form>
      </div>

      <?php elseif ($tab === 'gorunum'): ?>
      <form method="post" class="mt-6">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="grid sm:grid-cols-2 gap-5">
          <?php foreach (paletler() as $anahtar => $pl): $secili = $anahtar === $aktifPaletAnahtari; ?>
          <label class="cursor-pointer bg-white rounded-2xl shadow-sm p-5 border-2 transition-colors has-[:checked]:border-turuncu <?= $secili ? 'border-turuncu' : 'border-stone-200 hover:border-stone-300' ?>">
            <div class="flex items-center justify-between gap-3">
              <div class="flex items-center gap-3">
                <input type="radio" name="tema_palet" value="<?= e($anahtar) ?>" <?= $secili ? 'checked' : '' ?> class="text-turuncu focus:ring-turuncu">
                <span class="font-display font-bold"><?= e($pl['ad']) ?></span>
              </div>
              <?php if ($secili): ?>
              <span class="text-[11px] font-bold bg-orange-100 text-orange-700 rounded-full px-2.5 py-1">Aktif</span>
              <?php endif; ?>
            </div>

            <div class="mt-4 rounded-xl overflow-hidden border border-stone-200" style="background:<?= e($pl['krem']) ?>">
              <div class="h-2" style="background:<?= e($pl['turuncu']) ?>"></div>
              <div class="px-4 py-3.5">
                <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full border" style="background:<?= e($pl['hardal']) ?>33;border-color:<?= e($pl['hardal']) ?>;color:<?= e($pl['kahve']) ?>">yeni bir akım</span>
                <p class="font-display font-bold text-[15px] mt-2" style="color:<?= e($pl['kahve']) ?>">Sıradan burgerleri unutun</p>
                <div class="flex gap-2 mt-2.5">
                  <span class="inline-block text-[11px] font-bold px-3 py-1.5 rounded-full" style="background:<?= e($pl['turuncu']) ?>;color:<?= e($pl['krem']) ?>">Menüyü keşfet</span>
                  <span class="inline-block text-[11px] font-bold px-3 py-1.5 rounded-full border" style="border-color:<?= e($pl['kahve']) ?>66;color:<?= e($pl['kahve']) ?>">Franchise</span>
                </div>
              </div>
              <div class="h-3.5" style="background:<?= e($pl['komur']) ?>"></div>
            </div>

            <div class="flex gap-1.5 mt-3.5">
              <?php foreach (['turuncu', 'hardal', 'kahve', 'krem', 'komur'] as $slot): ?>
              <span class="flex-1 h-6 rounded-md border border-black/10" style="background:<?= e($pl[$slot]) ?>" title="<?= e($pl[$slot]) ?>"></span>
              <?php endforeach; ?>
            </div>
            <p class="text-[11px] text-stone-400 mt-1.5 font-mono"><?= e(implode(' · ', [$pl['turuncu'], $pl['hardal'], $pl['kahve'], $pl['krem'], $pl['komur']])) ?></p>
          </label>
          <?php endforeach; ?>
        </div>
        <div class="flex items-center gap-4 mt-6">
          <button class="bg-turuncu text-white font-bold px-8 py-3 rounded-xl hover:bg-koyu transition-colors">Seçili paleti uygula</button>
          <a href="../index.php" target="_blank" class="text-sm font-bold text-stone-500 underline underline-offset-4 hover:text-turuncu">Siteyi yeni sekmede aç →</a>
        </div>
      </form>

      <?php else: ?>
      <form method="post" class="mt-6 bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8 max-w-2xl">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="space-y-4">
          <?php foreach ($ayarSatirlari as $satir): ?>
          <label class="block">
            <span class="text-xs font-bold text-stone-400"><?= e($satir['anahtar']) ?></span>
            <input name="ayarlar[<?= e($satir['anahtar']) ?>]" value="<?= e((string) $satir['deger']) ?>"
                   class="mt-1 w-full rounded-xl border-stone-200 bg-zemin/60 focus:border-turuncu focus:ring-turuncu">
          </label>
          <?php endforeach; ?>
        </div>
        <button class="mt-6 bg-turuncu text-white font-bold px-8 py-3 rounded-xl hover:bg-koyu transition-colors">Kaydet</button>
      </form>
      <?php endif; ?>
    </main>
  </div>
</div>
<?php endif; ?>
</body>
</html>
