<?php
$aktif = 'anasayfa';
require __DIR__ . '/../templates/header.php';
$kats = kategoriler();
$seritParcalari = array_filter(array_map('trim', explode(',', ic('serit', 'Sıfır hayvansal et,Köz ateşi,Gizli reçeteler'))));
?>

<!-- HERO -->
<section class="relative noise">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-12 pb-20 lg:pt-20 lg:pb-28 grid lg:grid-cols-2 gap-12 items-center">
    <div id="hero-text">
      <span class="inline-flex items-center gap-2 bg-hardal/25 border border-hardal/60 text-kahve text-xs font-bold px-4 py-2 rounded-full">
        🍄 <?= e(ic('hero_rozet', 'Türkiye’de yeni bir akım')) ?>
      </span>
      <h1 class="font-display font-bold tracking-tight leading-[1.02] mt-6 text-[clamp(2.6rem,5.5vw,4.4rem)]">
        <?= e(ic('hero_baslik', 'Sıradan burgerleri unutun')) ?>
      </h1>
      <p class="mt-4 text-turuncu font-bold text-lg"><?= e(ic('hero_slogan', 'Lezzeti mantara bağladık.')) ?></p>
      <p class="mt-3 max-w-md text-kahve/70 leading-relaxed"><?= e(ic('hero_aciklama')) ?></p>
      <div class="mt-8 flex flex-wrap gap-4">
        <a href="lezzetlerimiz.php" class="bg-turuncu text-krem font-bold px-8 py-4 rounded-full shadow-lg shadow-turuncu/25 hover:bg-kirmizi hover:-translate-y-0.5 transition-all"><?= e(s('btn_menu')) ?></a>
        <a href="franchise.php" class="border-2 border-kahve/80 font-bold px-8 py-4 rounded-full hover:bg-kahve hover:text-krem transition-all"><?= e(s('btn_franchise_ol')) ?></a>
      </div>
      <div class="mt-10 flex flex-wrap items-center gap-x-7 gap-y-3 text-sm font-semibold text-kahve/60">
        <span class="flex items-center gap-2"><span class="text-hardal">★★★★★</span> <?= e(ic('hero_yildiz', 'Misafir favorisi')) ?></span>
        <span><?= e($a['adres_kisa']) ?></span>
        <span><?= e(cv('saatler', $a['saatler'])) ?></span>
      </div>
    </div>
    <div class="relative flex justify-center" id="hero-visual">
      <div class="blob overflow-hidden w-[320px] h-[320px] sm:w-[440px] sm:h-[440px] shadow-2xl shadow-kahve/30">
        <img src="<?= e(ic('hero_gorsel', 'https://images.unsplash.com/photo-1550317138-10000687a72b?w=900&q=80')) ?>" alt="Mantarhane imza burger" class="w-full h-full object-cover">
      </div>
      <div class="absolute -bottom-6 -left-2 sm:bottom-4 sm:left-4 w-28 h-28 sm:w-36 sm:h-36 bg-krem rounded-full shadow-xl flex items-center justify-center">
        <svg viewBox="0 0 100 100" class="w-full h-full spin-slow">
          <defs><path id="circ" d="M 50,50 m -36,0 a 36,36 0 1,1 72,0 a 36,36 0 1,1 -72,0"/></defs>
          <text class="fill-kahve" style="font: 700 9.5px Manrope; letter-spacing:1.8px">
            <textPath href="#circ"><?= e(ic('hero_rozet_donen', '%100 istiridye mantarı • sıfır hayvansal et • ')) ?></textPath>
          </text>
        </svg>
        <span class="absolute text-3xl">🍄</span>
      </div>
      <div class="float-chip absolute top-4 -right-1 sm:top-10 sm:right-2 bg-krem shadow-lg rounded-2xl px-4 py-2 text-sm font-bold"><?= e(ic('hero_cip1', '🔥 Köz ateşi')) ?></div>
      <div class="float-chip absolute top-1/2 -left-3 sm:left-0 bg-krem shadow-lg rounded-2xl px-4 py-2 text-sm font-bold"><?= e(ic('hero_cip2', '🤫 Gizli reçete')) ?></div>
    </div>
  </div>
</section>

<!-- ŞERİT -->
<div class="bg-kahve text-krem/90 overflow-hidden py-3">
  <div class="marquee-track flex whitespace-nowrap text-sm font-semibold tracking-[0.15em] uppercase">
    <?php for ($i = 0; $i < 2; $i++): ?>
    <span class="flex shrink-0" <?= $i ? 'aria-hidden="true"' : '' ?>>
      <?php foreach ($seritParcalari as $parca): ?>
        <span class="mx-5"><?= e($parca) ?></span><span class="text-turuncu">·</span>
      <?php endforeach; ?>
    </span>
    <?php endfor; ?>
  </div>
</div>

<!-- NEDEN -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28">
  <div class="text-center max-w-2xl mx-auto" data-reveal>
    <span class="text-turuncu font-bold text-sm"><?= e(ic('neden_ust', 'Neden Mantarhane')) ?></span>
    <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl mt-2"><?= e(ic('neden_baslik', 'Eti unutturan üç sır')) ?></h2>
  </div>
  <div class="grid md:grid-cols-3 gap-6 mt-12">
    <?php foreach ([['🌱', 'sir1'], ['🤫', 'sir2'], ['🔥', 'sir3']] as [$ikon, $on]): ?>
    <div class="bg-sut rounded-3xl p-8 border border-kahve/5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all" data-reveal>
      <div class="w-14 h-14 rounded-2xl bg-turuncu/10 flex items-center justify-center text-2xl"><?= $ikon ?></div>
      <h3 class="font-display font-bold text-xl mt-5"><?= e(ic($on . '_baslik')) ?></h3>
      <p class="mt-2.5 text-kahve/65 text-[15px] leading-relaxed"><?= e(ic($on . '_metin')) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- MENÜ -->
<section class="bg-sut border-y border-kahve/5 py-20 lg:py-28">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="flex flex-wrap items-end justify-between gap-6" data-reveal>
      <div>
        <span class="text-turuncu font-bold text-sm"><?= e(ic('menu_ust')) ?></span>
        <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl mt-2"><?= e(ic('menu_baslik', 'Lezzetlerimiz')) ?></h2>
      </div>
      <p class="max-w-sm text-kahve/55 text-sm leading-relaxed"><?= e(ic('menu_aciklama')) ?></p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-12">
      <?php foreach ($kats as $i => $k):
        $ilk = $i === 0;
        $son = $i === count($kats) - 1 && $i > 0;
        $sinif = $ilk ? 'sm:col-span-2 sm:row-span-2 min-h-[320px]' : ($son ? 'sm:col-span-2 min-h-[220px]' : 'min-h-[220px]');
      ?>
      <a href="lezzetlerimiz.php#kat-<?= (int) $k['id'] ?>" class="menu-card group relative rounded-3xl overflow-hidden <?= $sinif ?>" data-reveal>
        <img src="<?= e((string) $k['gorsel_url']) ?>" alt="<?= e($k['isim']) ?>" class="card-img absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-komur/90 via-komur/25 to-transparent"></div>
        <div class="absolute bottom-0 <?= $ilk ? 'p-7' : 'p-5' ?> text-krem">
          <span class="text-hardal text-[11px] font-bold tracking-wider"><?= e((string) $k['ust_baslik']) ?></span>
          <h3 class="font-display font-bold <?= $ilk ? 'text-2xl' : 'text-lg' ?> mt-0.5"><?= e($k['isim']) ?></h3>
          <?php if ($ilk): ?>
            <p class="text-krem/75 text-sm mt-1 max-w-xs"><?= e((string) $k['aciklama']) ?></p>
            <span class="inline-flex items-center gap-2 mt-3 text-sm font-bold text-hardal group-hover:gap-3 transition-all"><?= e(s('incele')) ?></span>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HİKAYE -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-14 items-center">
  <div class="relative" data-reveal>
    <div class="blob overflow-hidden w-full max-w-md mx-auto aspect-square shadow-2xl shadow-kahve/20">
      <img src="<?= e(ic('hikaye_gorsel', 'https://images.unsplash.com/photo-1504545102780-26774c1bb073?w=900&q=80')) ?>" alt="Taze mantarlar" class="w-full h-full object-cover">
    </div>
    <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 lg:left-auto lg:right-8 lg:translate-x-0 bg-turuncu text-krem rounded-2xl px-6 py-4 shadow-xl text-center">
      <span class="font-display font-bold text-2xl block leading-none">%100</span>
      <span class="text-[11px] font-bold"><?= e(s('taze_mantar')) ?></span>
    </div>
  </div>
  <div data-reveal>
    <span class="text-turuncu font-bold text-sm"><?= e(ic('hikaye_ust', 'Hikayemiz')) ?></span>
    <h2 class="font-display font-bold tracking-tight text-3xl sm:text-4xl mt-2"><?= e(ic('hikaye_baslik')) ?></h2>
    <p class="mt-5 text-kahve/70 leading-relaxed"><?= e(ic('hikaye_p1')) ?></p>
    <p class="mt-3 text-kahve/70 leading-relaxed"><?= e(ic('hikaye_p2')) ?></p>
    <div class="grid grid-cols-3 gap-4 mt-9 text-center">
      <div class="bg-sut border border-kahve/5 rounded-2xl py-5">
        <span class="font-display font-bold text-2xl text-turuncu block">0</span>
        <span class="text-[11px] font-bold text-kahve/55"><?= e(s('istat_et')) ?></span>
      </div>
      <div class="bg-sut border border-kahve/5 rounded-2xl py-5">
        <span class="font-display font-bold text-2xl text-turuncu block"><?= count($kats) ?></span>
        <span class="text-[11px] font-bold text-kahve/55"><?= e(s('istat_kategori')) ?></span>
      </div>
      <div class="bg-sut border border-kahve/5 rounded-2xl py-5">
        <span class="font-display font-bold text-2xl text-turuncu block">1.</span>
        <span class="text-[11px] font-bold text-kahve/55"><?= e(s('istat_ilk')) ?></span>
      </div>
    </div>
    <a href="hakkimizda.php" class="inline-block mt-9 bg-kahve text-krem font-bold px-8 py-4 rounded-full hover:bg-turuncu transition-colors"><?= e(s('btn_hikaye')) ?></a>
  </div>
</section>

<!-- FRANCHISE CTA -->
<section class="relative bg-komur text-krem overflow-hidden noise">
  <img src="<?= e(ic('franchise_gorsel', 'https://images.unsplash.com/photo-1608767221051-2b9d18f35a2f?w=1600&q=70')) ?>" alt="" class="absolute inset-0 w-full h-full object-cover opacity-15">
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28">
    <div class="max-w-2xl" data-reveal>
      <span class="text-hardal font-bold text-sm"><?= e(ic('fr_ust', 'Franchise')) ?></span>
      <h2 class="font-display font-bold tracking-tight text-3xl sm:text-5xl mt-2"><?= e(ic('fr_baslik')) ?></h2>
      <p class="mt-5 text-krem/70 leading-relaxed max-w-xl"><?= e(ic('fr_metin')) ?></p>
      <a href="franchise.php" class="inline-block mt-8 bg-turuncu text-krem font-bold px-9 py-4 rounded-full shadow-lg shadow-turuncu/30 hover:bg-kirmizi transition-colors"><?= e(s('btn_basvuru_formu')) ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../templates/footer.php'; ?>
