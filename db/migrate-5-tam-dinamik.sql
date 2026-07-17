-- Kodda gömülü kalan son metin ve görseller de adminden yönetilsin
SET NAMES utf8mb4;
INSERT INTO icerik (anahtar, deger) VALUES
  ('ust_serit',        'Türkiye’nin ilk istiridye mantarı konsepti'),
  ('hero_gorsel',      'https://images.unsplash.com/photo-1550317138-10000687a72b?w=900&q=80'),
  ('hero_rozet_donen', '%100 istiridye mantarı • sıfır hayvansal et • '),
  ('hero_cip1',        '🔥 Köz ateşi'),
  ('hero_cip2',        '🤫 Gizli reçete'),
  ('hero_yildiz',      'Misafir favorisi'),
  ('hikaye_gorsel',    'https://images.unsplash.com/photo-1504545102780-26774c1bb073?w=900&q=80'),
  ('franchise_gorsel', 'https://images.unsplash.com/photo-1608767221051-2b9d18f35a2f?w=1600&q=70'),
  ('footer_tanitim',   'Türkiye’nin ilk istiridye mantarı gurme konsepti.'),
  ('footer_franchise', 'Kendi şehrinizde bir Mantarhane açmak için başvurun.'),
  ('telif',            'Mantarhane bir Orsa Food Gıda Ltd. Şti. markasıdır.'),
  ('kdv_notu',         'Fiyatlarımıza KDV dahildir. Menü ve fiyatlar güncellenebilir.')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
