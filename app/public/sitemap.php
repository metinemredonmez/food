<?php
require_once __DIR__ . '/../src/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');
$kok = rtrim(ayarlar()['site_url'], '/');
$sayfalar = [
    ['/', '1.0'],
    ['/lezzetlerimiz.php', '0.9'],
    ['/franchise.php', '0.8'],
    ['/hakkimizda.php', '0.6'],
    ['/iletisim.php', '0.6'],
];
$dilKodlari = array_keys(diller());
$adres = fn (string $yol, string $d): string => $kok . $yol . ($d === 'tr' ? '' : '?dil=' . $d);
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($sayfalar as [$yol, $oncelik]): ?>
<?php foreach ($dilKodlari as $d): ?>
  <url>
    <loc><?= e($adres($yol, $d)) ?></loc>
    <priority><?= $oncelik ?></priority>
<?php foreach ($dilKodlari as $alt): ?>
    <xhtml:link rel="alternate" hreflang="<?= $alt ?>" href="<?= e($adres($yol, $alt)) ?>"/>
<?php endforeach; ?>
  </url>
<?php endforeach; ?>
<?php endforeach; ?>
</urlset>
