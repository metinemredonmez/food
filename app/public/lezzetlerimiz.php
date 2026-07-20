<?php
$aktif = 'lezzetlerimiz';
$baslik = 'Lezzetlerimiz — Mantarhane';
require __DIR__ . '/../templates/header.php';
$kats = kategoriler();
$urunGruplari = urunler();
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 pb-6 text-center">
  <span class="text-turuncu font-bold text-sm"><?= e(ic('menu_ust')) ?></span>
  <h1 class="font-display font-bold tracking-tight text-4xl sm:text-5xl mt-2"><?= e(ic('lz_baslik', 'Lezzetlerimiz')) ?></h1>
  <p class="mt-4 max-w-xl mx-auto text-kahve/65"><?= e(ic('lz_aciklama')) ?></p>
</section>

<!-- Kategori hızlı geçiş -->
<nav class="sticky top-20 z-40 bg-krem/90 backdrop-blur border-y border-kahve/10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex gap-2 overflow-x-auto">
    <?php foreach ($kats as $k): ?>
    <a href="#kat-<?= (int) $k['id'] ?>" class="shrink-0 text-sm font-semibold px-4 py-2 rounded-full bg-sut border border-kahve/10 hover:border-turuncu hover:text-turuncu transition-colors"><?= e($k['isim']) ?></a>
    <?php endforeach; ?>
  </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 pb-24">
  <?php foreach ($kats as $k): $grup = $urunGruplari[(int) $k['id']] ?? []; ?>
  <section id="kat-<?= (int) $k['id'] ?>" class="pt-14 scroll-mt-36">
    <div class="flex items-center gap-5">
      <?php if ($k['gorsel_url']): ?>
      <img src="<?= e((string) $k['gorsel_url']) ?>" alt="<?= e($k['isim']) ?>" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
      <?php endif; ?>
      <div>
        <span class="text-turuncu font-bold text-xs"><?= e((string) $k['ust_baslik']) ?></span>
        <h2 class="font-display font-bold tracking-tight text-2xl sm:text-3xl"><?= e($k['isim']) ?></h2>
        <p class="text-kahve/60 text-sm mt-0.5"><?= e((string) $k['aciklama']) ?></p>
      </div>
    </div>

    <?php if ($grup): ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-7">
      <?php foreach ($grup as $u): ?>
      <div class="bg-sut border border-kahve/5 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all" data-reveal>
        <?php if ($u['gorsel_url']): ?>
        <img src="<?= e((string) $u['gorsel_url']) ?>" alt="<?= e($u['isim']) ?>" class="w-full h-44 object-cover" loading="lazy">
        <?php endif; ?>
        <div class="p-5">
          <?php if ($u['etiket']): ?>
          <span class="inline-block bg-hardal/25 border border-hardal/60 text-kahve text-[11px] font-bold px-2.5 py-0.5 rounded-full mb-2"><?= e($u['etiket']) ?></span>
          <?php endif; ?>
          <div class="flex items-start justify-between gap-3">
            <h3 class="font-display font-bold text-lg leading-snug"><?= e($u['isim']) ?></h3>
            <span class="shrink-0 text-turuncu font-display font-bold text-lg"><?= e(fiyat_goster($u['fiyat'])) ?></span>
          </div>
          <?php if ($u['aciklama']): ?>
          <p class="text-kahve/60 text-sm mt-1.5 leading-relaxed"><?= e((string) $u['aciklama']) ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="mt-6 text-kahve/45 text-sm"><?= e(s('yakinda')) ?></p>
    <?php endif; ?>
  </section>
  <?php endforeach; ?>

  <p class="text-center text-kahve/45 text-xs mt-16"><?= e(ic('kdv_notu', 'Fiyatlarımıza KDV dahildir. Menü ve fiyatlar güncellenebilir.')) ?></p>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
