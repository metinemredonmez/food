<?php
require_once __DIR__ . '/../src/bootstrap.php';

$hatalar = [];
$eski = ['ad' => '', 'eposta' => '', 'konu' => '', 'mesaj' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($eski as $alan => $_) {
        $eski[$alan] = trim((string) ($_POST[$alan] ?? ''));
    }

    if (!csrf_gecerli()) {
        $hatalar[] = 'Oturum doğrulaması başarısız oldu, lütfen tekrar deneyin.';
    } elseif (!hiz_limiti('hiz:iletisim:' . ($_SERVER['REMOTE_ADDR'] ?? 'bilinmiyor'), 5, 3600)) {
        $hatalar[] = 'Çok fazla deneme yaptınız. Lütfen bir süre sonra tekrar deneyin.';
    } else {
        if ($eski['ad'] === '') $hatalar[] = 'Adınızı yazın.';
        if (!filter_var($eski['eposta'], FILTER_VALIDATE_EMAIL)) $hatalar[] = 'Geçerli bir e-posta adresi girin.';
        if ($eski['mesaj'] === '') $hatalar[] = 'Mesajınızı yazın.';
    }

    if (!$hatalar) {
        $db = pdo();
        if ($db === null) {
            $hatalar[] = 'Sistemde geçici bir sorun var, lütfen daha sonra tekrar deneyin.';
        } else {
            try {
                $db->prepare('INSERT INTO iletisim_mesajlari (ad, eposta, konu, mesaj, ip) VALUES (?,?,?,?,?)')
                   ->execute([$eski['ad'], $eski['eposta'], $eski['konu'], $eski['mesaj'], $_SERVER['REMOTE_ADDR'] ?? null]);

                $a = ayarlar();
                $html = '<h2>Yeni İletişim Mesajı</h2>'
                      . '<p><b>Ad:</b> ' . e($eski['ad']) . '</p>'
                      . '<p><b>E-posta:</b> ' . e($eski['eposta']) . '</p>'
                      . '<p><b>Konu:</b> ' . e($eski['konu']) . '</p>'
                      . '<p><b>Mesaj:</b><br>' . nl2br(e($eski['mesaj'])) . '</p>';
                eposta_gonder($a['email_info'], 'Yeni İletişim Mesajı — ' . $eski['ad'], $html);

                flash_koy('basari', 'Mesajınız alındı! En kısa sürede dönüş yapacağız. 🍄');
                header('Location: iletisim.php');
                exit;
            } catch (Throwable $hata) {
                error_log('İletişim mesajı kaydedilemedi: ' . $hata->getMessage());
                $hatalar[] = 'Mesajınız kaydedilemedi, lütfen daha sonra tekrar deneyin.';
            }
        }
    }
}

$aktif = 'iletisim';
$baslik = 'İletişim — Mantarhane';
require __DIR__ . '/../templates/header.php';
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 pb-6 text-center">
  <span class="text-turuncu font-bold text-sm">İletişim</span>
  <h1 class="font-display font-bold tracking-tight text-4xl sm:text-5xl mt-2"><?= e(ic('il_baslik', 'Bize ulaşın')) ?></h1>
  <p class="mt-4 max-w-xl mx-auto text-kahve/65"><?= e(ic('il_aciklama')) ?></p>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid lg:grid-cols-2 gap-14">
  <div class="space-y-5" data-reveal>
    <div class="bg-sut rounded-3xl p-7 border border-kahve/5">
      <span class="text-2xl">📍</span>
      <h2 class="font-display font-bold text-lg mt-3">Restoran adresimiz</h2>
      <p class="mt-2 text-kahve/70"><?= e($a['adres']) ?></p>
      <a class="inline-block mt-3 text-sm font-extrabold text-turuncu underline underline-offset-4" target="_blank" rel="noopener"
         href="https://maps.google.com/?q=<?= rawurlencode($a['adres']) ?>">Haritada aç →</a>
    </div>
    <div class="bg-sut rounded-3xl p-7 border border-kahve/5">
      <span class="text-2xl">🕐</span>
      <h2 class="font-display font-bold text-lg mt-3">Çalışma saatleri</h2>
      <p class="mt-2 text-kahve/70"><?= e($a['saatler']) ?></p>
    </div>
    <div class="bg-sut rounded-3xl p-7 border border-kahve/5">
      <span class="text-2xl">✉️</span>
      <h2 class="font-display font-bold text-lg mt-3">E-posta adreslerimiz</h2>
      <ul class="mt-2 space-y-1.5 text-kahve/70 text-sm">
        <li><b>Genel iletişim:</b> <a href="mailto:<?= e($a['email_info']) ?>" class="text-turuncu font-bold"><?= e($a['email_info']) ?></a></li>
        <li><b>Sosyal medya &amp; basın:</b> <a href="mailto:<?= e($a['email_social']) ?>" class="text-turuncu font-bold"><?= e($a['email_social']) ?></a></li>
        <li><b>Franchise &amp; yatırım:</b> <a href="mailto:<?= e($a['email_franchise']) ?>" class="text-turuncu font-bold"><?= e($a['email_franchise']) ?></a></li>
      </ul>
    </div>
  </div>

  <div data-reveal>
    <form method="post" class="bg-sut border border-kahve/5 rounded-3xl p-8 shadow-sm">
      <h2 class="font-display font-bold tracking-tight text-2xl">Mesaj gönderin</h2>

      <?php if ($hatalar): ?>
      <div class="mt-4 bg-red-100 border border-red-300 text-red-900 rounded-2xl px-5 py-4 text-sm font-bold space-y-1">
        <?php foreach ($hatalar as $hata): ?><p>• <?= e($hata) ?></p><?php endforeach; ?>
      </div>
      <?php endif; ?>

      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <label class="block mt-6">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60">Adınız *</span>
        <input name="ad" value="<?= e($eski['ad']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
      </label>
      <label class="block mt-4">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60">E-posta *</span>
        <input name="eposta" type="email" value="<?= e($eski['eposta']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
      </label>
      <label class="block mt-4">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60">Konu</span>
        <input name="konu" value="<?= e($eski['konu']) ?>" class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
      </label>
      <label class="block mt-4">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60">Mesajınız *</span>
        <textarea name="mesaj" rows="5" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu"><?= e($eski['mesaj']) ?></textarea>
      </label>
      <button type="submit" class="mt-6 w-full bg-turuncu text-krem font-bold px-8 py-4 rounded-full shadow-lg shadow-turuncu/25 hover:bg-kirmizi transition-colors">Mesajı gönder</button>
    </form>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 pb-20" data-reveal>
  <iframe src="https://maps.google.com/maps?q=<?= rawurlencode($a['adres']) ?>&z=15&output=embed"
          class="w-full h-80 rounded-3xl border border-kahve/10 shadow-sm" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Mantarhane konum"></iframe>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>
