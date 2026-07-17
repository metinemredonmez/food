<?php $a = ayarlar(); ?>
<!-- FOOTER -->
<footer id="iletisim-footer" class="bg-kahve text-krem">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16 grid gap-12 md:grid-cols-2 lg:grid-cols-4">
    <div>
      <div class="flex items-center gap-3">
        <img src="assets/logo.png" alt="Mantarhane logo" class="h-12 w-12">
        <span class="font-display font-bold text-lg">Mantarhane</span>
      </div>
      <p class="mt-4 text-krem/60 text-sm leading-relaxed"><?= e($a['slogan']) ?>. <?= e(ic('footer_tanitim', 'Türkiye’nin ilk istiridye mantarı gurme konsepti.')) ?></p>
      <div class="flex gap-3 mt-5">
        <a href="<?= e($a['instagram_url']) ?>" aria-label="Instagram" class="w-10 h-10 rounded-full bg-krem/10 hover:bg-turuncu transition-colors flex items-center justify-center">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.9.2 2.3.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1.1.4 2.3.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 1.9-.4 2.3-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1.1.4-2.3.4-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.9-.2-2.3-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1.1-.4-2.3-.1-1.2-.1-1.6-.1-4.8s0-3.6.1-4.8c.1-1.2.2-1.9.4-2.3.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1.1-.4 2.3-.4 1.2-.1 1.6-.1 4.8-.1zm0 1.8c-3.1 0-3.5 0-4.7.1-1.1.1-1.7.2-2.1.4-.5.2-.9.4-1.2.8-.4.4-.6.7-.8 1.2-.2.4-.3 1-.4 2.1-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c.1 1.1.2 1.7.4 2.1.2.5.4.9.8 1.2.4.4.7.6 1.2.8.4.2 1 .3 2.1.4 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1.1-.1 1.7-.2 2.1-.4.5-.2.9-.4 1.2-.8.4-.4.6-.7.8-1.2.2-.4.3-1 .4-2.1.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c-.1-1.1-.2-1.7-.4-2.1-.2-.5-.4-.9-.8-1.2-.4-.4-.7-.6-1.2-.8-.4-.2-1-.3-2.1-.4-1.2-.1-1.6-.1-4.7-.1zm0 3.1a5 5 0 110 10 5 5 0 010-10zm0 1.8a3.2 3.2 0 100 6.4 3.2 3.2 0 000-6.4zm5.2-2.9a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
        </a>
        <a href="<?= e($a['x_url']) ?>" aria-label="X" class="w-10 h-10 rounded-full bg-krem/10 hover:bg-turuncu transition-colors flex items-center justify-center">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L1.5 2H8l4.4 5.9L18.9 2zm-1.1 18h1.7L7.1 3.9H5.3L17.8 20z"/></svg>
        </a>
      </div>
    </div>
    <div>
      <h4 class="font-display font-bold text-hardal">Menü</h4>
      <ul class="mt-4 space-y-2.5 text-sm text-krem/70">
        <?php foreach (array_slice(kategoriler(), 0, 6) as $fk): ?>
        <li><a href="lezzetlerimiz.php#kat-<?= (int) $fk['id'] ?>" class="hover:text-turuncu transition-colors"><?= e($fk['isim']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <h4 class="font-display font-bold text-hardal">İletişim</h4>
      <ul class="mt-4 space-y-2.5 text-sm text-krem/70">
        <li>📍 <?= e($a['adres']) ?></li>
        <li>🕐 <?= e($a['saatler']) ?></li>
        <li>✉️ <a href="mailto:<?= e($a['email_info']) ?>" class="hover:text-turuncu transition-colors"><?= e($a['email_info']) ?></a></li>
        <li>🤝 <a href="mailto:<?= e($a['email_franchise']) ?>" class="hover:text-turuncu transition-colors"><?= e($a['email_franchise']) ?></a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-display font-bold text-hardal">Franchise</h4>
      <p class="mt-4 text-sm text-krem/70 leading-relaxed"><?= e(ic('footer_franchise', 'Kendi şehrinizde bir Mantarhane açmak için başvurun.')) ?></p>
      <a href="franchise.php" class="inline-block mt-4 bg-turuncu text-krem text-sm font-bold px-6 py-3 rounded-full hover:bg-kirmizi transition-colors">Hemen başvur</a>
    </div>
  </div>
  <div class="border-t border-krem/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 flex flex-wrap items-center justify-between gap-3 text-xs text-krem/50">
      <span>Copyright © <?= date('Y') ?> — <?= e(ic('telif', 'Mantarhane bir Orsa Food Gıda Ltd. Şti. markasıdır.')) ?></span>
      <span><?= e($a['adres_kisa']) ?></span>
    </div>
  </div>
</footer>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
<script src="assets/app.js"></script>
</body>
</html>
