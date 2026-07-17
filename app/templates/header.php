<?php
require_once __DIR__ . '/../src/bootstrap.php';
$a = ayarlar();
$p = aktif_palet();
$aktif = $aktif ?? '';
$baslik = $baslik ?? $a['site_baslik'];
$nav = [
    'anasayfa'      => ['index.php', 'Ana Sayfa'],
    'lezzetlerimiz' => ['lezzetlerimiz.php', 'Lezzetlerimiz'],
    'hakkimizda'    => ['hakkimizda.php', 'Hakkımızda'],
    'franchise'     => ['franchise.php', 'Franchise'],
    'iletisim'      => ['iletisim.php', 'İletişim'],
];
?>
<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($baslik) ?></title>
<?php $sayfaAciklama = $aciklama ?? $a['seo_aciklama']; ?>
<meta name="description" content="<?= e($sayfaAciklama) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Mantarhane">
<meta property="og:title" content="<?= e($baslik) ?>">
<meta property="og:description" content="<?= e($sayfaAciklama) ?>">
<meta property="og:image" content="<?= e(rtrim($a['site_url'], '/')) ?>/assets/logo.png">
<meta name="theme-color" content="<?= e($p['turuncu']) ?>">
<link rel="icon" href="assets/logo.png">
<?php if ($a['ga_id'] !== ''): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($a['ga_id']) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($a['ga_id']) ?>');</script>
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        turuncu: '<?= e($p['turuncu']) ?>',
        kirmizi: '<?= e($p['kirmizi']) ?>',
        komur:   '<?= e($p['komur']) ?>',
        kahve:   '<?= e($p['kahve']) ?>',
        krem:    '<?= e($p['krem']) ?>',
        sut:     '<?= e($p['sut']) ?>',
        hardal:  '<?= e($p['hardal']) ?>',
      },
      fontFamily: {
        display: ['Space Grotesk', 'sans-serif'],
        sans: ['Manrope', 'sans-serif'],
      },
    }
  }
}
</script>
<link rel="stylesheet" href="assets/style.css">
<style>::selection{background:<?= e($p['turuncu']) ?>;color:<?= e($p['krem']) ?>}</style>
</head>
<body class="bg-krem font-sans text-kahve antialiased overflow-x-hidden" x-data="{menuOpen:false}">

<!-- ÜST ŞERİT -->
<div class="bg-turuncu text-krem text-xs font-semibold">
  <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-center gap-3 text-center">
    <span><?= e(ic('ust_serit', 'Türkiye’nin ilk istiridye mantarı konsepti')) ?></span>
    <span class="hidden sm:inline opacity-60">·</span>
    <span class="hidden sm:inline"><?= e($a['adres_kisa']) ?> — <?= e($a['saatler']) ?></span>
  </div>
</div>

<!-- NAV -->
<header class="sticky top-0 z-50 bg-krem/90 backdrop-blur border-b border-kahve/10">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
    <a href="index.php" class="flex items-center gap-3">
      <img src="assets/logo.png" alt="Mantarhane logo" class="h-11 w-11">
      <div class="leading-tight">
        <span class="font-display font-bold text-lg text-kahve">Mantarhane</span>
        <span class="block text-[11px] font-semibold text-turuncu"><?= e($a['slogan']) ?></span>
      </div>
    </a>
    <div class="hidden lg:flex items-center gap-8 text-[15px] font-semibold">
      <?php foreach ($nav as $anahtar => [$url, $etiket]): ?>
        <a href="<?= e($url) ?>" class="<?= $aktif === $anahtar ? 'text-turuncu' : 'hover:text-turuncu transition-colors' ?>"><?= e($etiket) ?></a>
      <?php endforeach; ?>
      <a href="lezzetlerimiz.php" class="bg-kahve text-krem px-6 py-3 rounded-full hover:bg-turuncu transition-colors">Sipariş Ver</a>
    </div>
    <button class="lg:hidden p-2" @click="menuOpen=!menuOpen" aria-label="Menü">
      <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </nav>
  <div x-show="menuOpen" x-cloak class="lg:hidden border-t border-kahve/10 bg-krem px-6 py-4 flex flex-col gap-4 text-[15px] font-semibold">
    <?php foreach ($nav as $anahtar => [$url, $etiket]): ?>
      <a href="<?= e($url) ?>" @click="menuOpen=false" class="<?= $aktif === $anahtar ? 'text-turuncu' : '' ?>"><?= e($etiket) ?></a>
    <?php endforeach; ?>
  </div>
</header>

<?php if ($flash = flash_al()): ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 mt-6">
  <div class="rounded-2xl px-6 py-4 font-bold <?= $flash['tur'] === 'basari' ? 'bg-green-100 text-green-900 border border-green-300' : 'bg-red-100 text-red-900 border border-red-300' ?>">
    <?= e($flash['mesaj']) ?>
  </div>
</div>
<?php endif; ?>
