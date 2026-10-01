<?php
$a = ayarlar();
$wa = whatsapp_url();
$waIkon = '<path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.59-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.28-.2-.57-.35m-5.42 7.4a9.87 9.87 0 01-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 01-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 012.89 6.99c0 5.45-4.44 9.88-9.89 9.88m8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 00-3.48-8.41z"/>';
?>
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
      <h4 class="font-display font-bold text-hardal"><?= e(s('footer_menu')) ?></h4>
      <ul class="mt-4 space-y-2.5 text-sm text-krem/70">
        <?php foreach (array_slice(kategoriler(), 0, 6) as $fk): ?>
        <li><a href="lezzetlerimiz.php#kat-<?= (int) $fk['id'] ?>" class="hover:text-turuncu transition-colors"><?= e($fk['isim']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <h4 class="font-display font-bold text-hardal"><?= e(s('footer_iletisim')) ?></h4>
      <ul class="mt-4 space-y-2.5 text-sm text-krem/70">
        <?php if ($wa): ?>
        <li><a href="<?= e($wa) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 font-bold text-krem hover:text-turuncu transition-colors">
          <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><?= $waIkon ?></svg>
          <span dir="ltr"><?= e($a['telefon']) ?></span>
        </a></li>
        <?php endif; ?>
        <li>📍 <?= e($a['adres']) ?></li>
        <li>🕐 <?= e(cv('saatler', $a['saatler'])) ?></li>
        <li>✉️ <a href="mailto:<?= e($a['email_info']) ?>" class="hover:text-turuncu transition-colors"><?= e($a['email_info']) ?></a></li>
        <li>🤝 <a href="mailto:<?= e($a['email_franchise']) ?>" class="hover:text-turuncu transition-colors"><?= e($a['email_franchise']) ?></a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-display font-bold text-hardal"><?= e(s('footer_franchise')) ?></h4>
      <p class="mt-4 text-sm text-krem/70 leading-relaxed"><?= e(ic('footer_franchise', 'Kendi şehrinizde bir Mantarhane açmak için başvurun.')) ?></p>
      <a href="franchise.php" class="inline-block mt-4 bg-turuncu text-krem text-sm font-bold px-6 py-3 rounded-full hover:bg-kirmizi transition-colors"><?= e(s('btn_hemen_basvur')) ?></a>
    </div>
  </div>
  <div class="border-t border-krem/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 flex flex-wrap items-center justify-between gap-3 text-xs text-krem/50">
      <span>Copyright © <?= date('Y') ?> — <?= e(ic('telif', 'Mantarhane bir Orsa Food Gıda Ltd. Şti. markasıdır.')) ?></span>
      <span><?= e($a['adres_kisa']) ?></span>
    </div>
  </div>
</footer>

<?php if ($wa): ?>
<!-- WHATSAPP: sabit buton + birkaç saniye sonra açılan balon (kapatılınca oturum boyunca gelmez) -->
<div x-data="{ balon: false }"
     x-init="setTimeout(() => { try { balon = !sessionStorage.getItem('wa-balon') } catch (e) { balon = true } }, 4000)"
     class="fixed bottom-5 end-5 z-50 flex items-end gap-3">
  <div x-show="balon" x-cloak x-transition.opacity.scale.90
       class="relative w-56 bg-sut text-kahve rounded-2xl rounded-ee-sm shadow-xl border border-kahve/10 p-4 pe-9 text-sm font-semibold leading-snug">
    <button type="button" @click="balon = false; try { sessionStorage.setItem('wa-balon', '1') } catch (e) {}"
            aria-label="<?= e(s('kapat')) ?>"
            class="absolute top-2 end-2 w-6 h-6 rounded-full text-kahve/50 hover:bg-kahve/10 hover:text-kahve flex items-center justify-center">✕</button>
    <a href="<?= e($wa) ?>" target="_blank" rel="noopener" class="block hover:text-turuncu transition-colors"><?= e(s('wa_balon')) ?></a>
  </div>
  <a href="<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="<?= e(s('wa_yaz')) ?>"
     class="wa-buton relative shrink-0 w-14 h-14 rounded-full bg-[#25D366] text-white shadow-lg shadow-black/25 flex items-center justify-center hover:scale-105 transition-transform">
    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><?= $waIkon ?></svg>
  </a>
</div>
<?php endif; ?>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
<script src="assets/app.js"></script>
</body>
</html>
