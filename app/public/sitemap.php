<?php
require_once __DIR__ . '/../src/bootstrap.php';
header('Content-Type: application/xml; charset=UTF-8');
$kok = rtrim(ayarlar()['site_url'], '/');
$sayfalar = [
    ['', '1.0'],
    ['/lezzetlerimiz.php', '0.9'],
    ['/franchise.php', '0.8'],
    ['/hakkimizda.php', '0.6'],
    ['/iletisim.php', '0.6'],
];
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($sayfalar as [$yol, $oncelik]): ?>
  <url><loc><?= e($kok . $yol) ?></loc><priority><?= $oncelik ?></priority></url>
<?php endforeach; ?>
</urlset>
