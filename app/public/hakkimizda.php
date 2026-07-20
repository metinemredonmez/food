<?php
$aktif = 'hakkimizda';
$baslik = 'Hakkımızda — Mantarhane';
require __DIR__ . '/../templates/header.php';
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 pb-6 text-center">
  <span class="text-turuncu font-bold text-sm"><?= e(ic('hikaye_ust', 'Hikayemiz')) ?></span>
  <h1 class="font-display font-bold tracking-tight text-4xl sm:text-5xl mt-2 max-w-3xl mx-auto"><?= e(ic('hk_baslik')) ?></h1>
  <p class="mt-4 max-w-2xl mx-auto text-kahve/65"><?= e(ic('hk_alt')) ?></p>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 grid lg:grid-cols-2 gap-14 items-center">
  <div class="relative" data-reveal>
    <div class="blob overflow-hidden w-full max-w-md mx-auto aspect-square shadow-2xl shadow-kahve/20">
      <img src="<?= e(ic('hikaye_gorsel', 'https://images.unsplash.com/photo-1504545102780-26774c1bb073?w=900&q=80')) ?>" alt="Taze istiridye mantarları" class="w-full h-full object-cover">
    </div>
  </div>
  <div data-reveal>
    <p class="text-kahve/70 leading-relaxed"><?= e(ic('hk_p1')) ?></p>
    <p class="mt-4 text-kahve/70 leading-relaxed"><?= e(ic('hk_p2')) ?></p>
    <div class="grid sm:grid-cols-2 gap-5 mt-8">
      <div class="bg-sut rounded-3xl p-6 border border-kahve/5">
        <span class="text-2xl">🌱</span>
        <h2 class="font-display font-bold text-lg mt-3"><?= e(ic('hk_kart1_baslik')) ?></h2>
        <p class="mt-2 text-kahve/65 text-sm leading-relaxed"><?= e(ic('hk_kart1_metin')) ?></p>
      </div>
      <div class="bg-sut rounded-3xl p-6 border border-kahve/5">
        <span class="text-2xl">🤫</span>
        <h2 class="font-display font-bold text-lg mt-3"><?= e(ic('hk_kart2_baslik')) ?></h2>
        <p class="mt-2 text-kahve/65 text-sm leading-relaxed"><?= e(ic('hk_kart2_metin')) ?></p>
      </div>
    </div>
    <?php if (ic('hk_p3') !== ''): ?>
    <p class="mt-8 text-kahve/70 leading-relaxed"><?= e(ic('hk_p3')) ?></p>
    <?php endif; ?>
    <a href="lezzetlerimiz.php" class="inline-block mt-8 bg-turuncu text-krem font-bold px-8 py-4 rounded-full shadow-lg shadow-turuncu/25 hover:bg-kirmizi transition-colors"><?= e(s('btn_menu')) ?></a>
  </div>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>
