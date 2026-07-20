<?php
require_once __DIR__ . '/../src/bootstrap.php';
$a = ayarlar();
$p = aktif_palet();
$dil = aktif_dil();
$aktif = $aktif ?? '';
$baslik = $baslik ?? cv('site_baslik', $a['site_baslik']);
$sayfaAciklama = $aciklama ?? cv('seo_aciklama', $a['seo_aciklama']);
$sayfaAdi = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$nav = [
    'anasayfa'      => ['index.php', s('nav_anasayfa')],
    'lezzetlerimiz' => ['lezzetlerimiz.php', s('nav_menu')],
    'hakkimizda'    => ['hakkimizda.php', s('nav_hakkimizda')],
    'franchise'     => ['franchise.php', s('nav_franchise')],
    'iletisim'      => ['iletisim.php', s('nav_iletisim')],
];
?>
<!DOCTYPE html>
<html lang="<?= e($dil) ?>" dir="<?= rtl() ? 'rtl' : 'ltr' ?>" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($baslik) ?></title>
<meta name="description" content="<?= e($sayfaAciklama) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Mantarhane">
<meta property="og:title" content="<?= e($baslik) ?>">
<meta property="og:description" content="<?= e($sayfaAciklama) ?>">
<meta property="og:image" content="<?= e(rtrim($a['site_url'], '/')) ?>/assets/logo.png">
<meta name="theme-color" content="<?= e($p['turuncu']) ?>">
<?php foreach (array_keys(diller()) as $hrefDil): ?>
<link rel="alternate" hreflang="<?= e($hrefDil) ?>" href="<?= e(rtrim($a['site_url'], '/') . '/' . $sayfaAdi . '?dil=' . $hrefDil) ?>">
<?php endforeach; ?>
<link rel="alternate" hreflang="x-default" href="<?= e(rtrim($a['site_url'], '/') . '/' . $sayfaAdi) ?>">
<link rel="icon" href="assets/logo.png">
<?php if ($a['ga_id'] !== ''): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($a['ga_id']) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($a['ga_id']) ?>');</script>
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Manrope:wght@400;500;600;700;800<?= rtl() ? '&family=Tajawal:wght@400;500;700;800' : '' ?>&display=swap" rel="stylesheet">
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
        display: [<?= rtl() ? "'Tajawal', 'Space Grotesk'" : "'Space Grotesk'" ?>, 'sans-serif'],
        sans: [<?= rtl() ? "'Tajawal', 'Manrope'" : "'Manrope'" ?>, 'sans-serif'],
      },
    }
  }
}
</script>
<link rel="stylesheet" href="assets/style.css">
<style>::selection{background:<?= e($p['turuncu']) ?>;color:<?= e($p['krem']) ?>}</style>
</head>
<body class="bg-krem font-sans text-kahve antialiased overflow-x-hidden" x-data="{menuOpen:false}">

<!-- ÜST ŞERİT + DİL SEÇİCİ -->
<div class="bg-turuncu text-krem text-xs font-semibold">
  <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between gap-3">
    <div class="flex items-center gap-3 min-w-0">
      <span class="truncate"><?= e(ic('ust_serit', 'Türkiye’nin ilk istiridye mantarı konsepti')) ?></span>
      <span class="hidden sm:inline opacity-60">·</span>
      <span class="hidden sm:inline whitespace-nowrap"><?= e($a['adres_kisa']) ?> — <?= e(cv('saatler', $a['saatler'])) ?></span>
    </div>
    <div class="flex items-center gap-1.5 shrink-0">
      <?php foreach (array_keys(diller()) as $d): ?>
      <a href="?dil=<?= $d ?>" class="px-1.5 py-0.5 rounded uppercase <?= $d === $dil ? 'bg-krem text-turuncu font-extrabold' : 'opacity-80 hover:opacity-100' ?>"><?= $d ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- NAV -->
<header class="sticky top-0 z-50 bg-krem/90 backdrop-blur border-b border-kahve/10">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
    <a href="index.php" class="flex items-center gap-3">
      <img src="assets/logo.png" alt="Mantarhane logo" class="h-11 w-11">
      <div class="leading-tight">
        <span class="font-display font-bold text-lg text-kahve">Mantarhane</span>
        <span class="block text-[11px] font-semibold text-turuncu"><?= e(cv('slogan', $a['slogan'])) ?></span>
      </div>
    </a>
    <div class="hidden lg:flex items-center gap-8 text-[15px] font-semibold">
      <?php foreach ($nav as $anahtar => [$url, $etiket]): ?>
        <a href="<?= e($url) ?>" class="<?= $aktif === $anahtar ? 'text-turuncu' : 'hover:text-turuncu transition-colors' ?>"><?= e($etiket) ?></a>
      <?php endforeach; ?>
      <a href="lezzetlerimiz.php" class="bg-kahve text-krem px-6 py-3 rounded-full hover:bg-turuncu transition-colors"><?= e(s('nav_siparis')) ?></a>
    </div>
    <button class="lg:hidden p-2" @click="menuOpen=!menuOpen" aria-label="Menu">
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
