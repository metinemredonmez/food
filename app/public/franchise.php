<?php
require_once __DIR__ . '/../src/bootstrap.php';

$hatalar = [];
$eski = ['ad' => '', 'soyad' => '', 'telefon' => '', 'eposta' => '', 'sehir' => '', 'mesaj' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($eski as $alan => $_) {
        $eski[$alan] = trim((string) ($_POST[$alan] ?? ''));
    }

    if (!csrf_gecerli()) {
        $hatalar[] = s('err_oturum');
    } elseif (!hiz_limiti('hiz:franchise:' . ($_SERVER['REMOTE_ADDR'] ?? 'bilinmiyor'), 5, 3600)) {
        $hatalar[] = s('err_hiz');
    } else {
        if ($eski['ad'] === '' || $eski['soyad'] === '') $hatalar[] = s('err_adsoyad');
        if ($eski['telefon'] === '') $hatalar[] = s('err_telefon');
        if (!filter_var($eski['eposta'], FILTER_VALIDATE_EMAIL)) $hatalar[] = s('err_eposta');
        if ($eski['sehir'] === '') $hatalar[] = s('err_sehir');
    }

    if (!$hatalar) {
        $db = pdo();
        if ($db === null) {
            $hatalar[] = s('err_sistem');
        } else {
            try {
                $db->prepare('INSERT INTO franchise_basvurulari (ad, soyad, telefon, eposta, sehir, mesaj, ip) VALUES (?,?,?,?,?,?,?)')
                   ->execute([$eski['ad'], $eski['soyad'], $eski['telefon'], $eski['eposta'], $eski['sehir'], $eski['mesaj'], $_SERVER['REMOTE_ADDR'] ?? null]);

                $a = ayarlar();
                $html = '<h2>Yeni Franchise Başvurusu</h2>'
                      . '<p><b>Ad Soyad:</b> ' . e($eski['ad'] . ' ' . $eski['soyad']) . '</p>'
                      . '<p><b>Telefon:</b> ' . e($eski['telefon']) . '</p>'
                      . '<p><b>E-posta:</b> ' . e($eski['eposta']) . '</p>'
                      . '<p><b>Şehir/Semt:</b> ' . e($eski['sehir']) . '</p>'
                      . '<p><b>Mesaj:</b><br>' . nl2br(e($eski['mesaj'])) . '</p>';
                eposta_gonder($a['email_franchise'], 'Yeni Franchise Başvurusu — ' . $eski['ad'] . ' ' . $eski['soyad'], $html);

                flash_koy('basari', s('flash_basvuru'));
                header('Location: franchise.php');
                exit;
            } catch (Throwable $hata) {
                error_log('Franchise başvurusu kaydedilemedi: ' . $hata->getMessage());
                $hatalar[] = s('err_kayit');
            }
        }
    }
}

$aktif = 'franchise';
$baslik = 'Franchise — Mantarhane';
require __DIR__ . '/../templates/header.php';
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 pb-6 text-center">
  <span class="text-turuncu font-bold text-sm"><?= e(s('franchise_basvurusu')) ?></span>
  <h1 class="font-display font-bold tracking-tight text-4xl sm:text-5xl mt-2"><?= e(ic('frs_baslik', 'Bu akımın ortağı olun')) ?></h1>
  <p class="mt-4 max-w-2xl mx-auto text-kahve/65"><?= e(ic('frs_aciklama')) ?></p>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid lg:grid-cols-2 gap-14">
  <div data-reveal>
    <h2 class="font-display font-bold tracking-tight text-2xl"><?= e(s('neden_mantarhane')) ?></h2>
    <p class="mt-4 text-kahve/70 leading-relaxed"><?= e(ic('frs_neden')) ?></p>
    <div class="space-y-4 mt-8">
      <?php foreach ([['📉', 'frs_kart1'], ['📈', 'frs_kart2'], ['🏛️', 'frs_kart3']] as [$ikon, $on]): ?>
      <div class="flex gap-4 bg-sut rounded-2xl p-5 border border-kahve/5">
        <span class="text-2xl"><?= $ikon ?></span>
        <div><h3 class="font-display font-bold text-lg"><?= e(ic($on . '_baslik')) ?></h3>
        <p class="text-kahve/65 text-sm mt-1"><?= e(ic($on . '_metin')) ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div data-reveal>
    <form method="post" class="bg-sut border border-kahve/5 rounded-3xl p-8 shadow-sm">
      <h2 class="font-display font-bold tracking-tight text-2xl"><?= e(s('basvuru_formu')) ?></h2>

      <?php if ($hatalar): ?>
      <div class="mt-4 bg-red-100 border border-red-300 text-red-900 rounded-2xl px-5 py-4 text-sm font-bold space-y-1">
        <?php foreach ($hatalar as $hata): ?><p>• <?= e($hata) ?></p><?php endforeach; ?>
      </div>
      <?php endif; ?>

      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="grid sm:grid-cols-2 gap-4 mt-6">
        <label class="block">
          <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_ad')) ?> *</span>
          <input name="ad" value="<?= e($eski['ad']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
        </label>
        <label class="block">
          <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_soyad')) ?> *</span>
          <input name="soyad" value="<?= e($eski['soyad']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
        </label>
        <label class="block">
          <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_telefon')) ?> *</span>
          <input name="telefon" value="<?= e($eski['telefon']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
        </label>
        <label class="block">
          <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_eposta')) ?> *</span>
          <input name="eposta" type="email" value="<?= e($eski['eposta']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
        </label>
      </div>
      <label class="block mt-4">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_sehir')) ?> *</span>
        <input name="sehir" value="<?= e($eski['sehir']) ?>" required class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu">
      </label>
      <label class="block mt-4">
        <span class="text-xs font-extrabold tracking-wider uppercase text-kahve/60"><?= e(s('frm_dusunce')) ?></span>
        <textarea name="mesaj" rows="4" class="mt-1.5 w-full rounded-xl border-kahve/15 bg-krem focus:border-turuncu focus:ring-turuncu"><?= e($eski['mesaj']) ?></textarea>
      </label>
      <button type="submit" class="mt-6 w-full bg-turuncu text-krem font-bold px-8 py-4 rounded-full shadow-lg shadow-turuncu/25 hover:bg-kirmizi transition-colors"><?= e(s('btn_basvur_gonder')) ?></button>
      <p class="mt-3 text-xs text-kahve/50 text-center"><?= e(sprintf(s('basvuru_notu'), ayarlar()['email_franchise'])) ?></p>
    </form>
  </div>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>
