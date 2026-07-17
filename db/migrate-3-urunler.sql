-- Ürünler + SEO ayarları
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS urunler (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  kategori_id INT UNSIGNED NOT NULL,
  isim        VARCHAR(150) NOT NULL,
  aciklama    VARCHAR(500),
  fiyat       DECIMAL(8,2) NOT NULL DEFAULT 0,
  gorsel_url  VARCHAR(500),
  etiket      VARCHAR(60),
  sira        INT NOT NULL DEFAULT 0,
  aktif       TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_urun_kategori FOREIGN KEY (kategori_id)
    REFERENCES menu_kategorileri(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek ürünler (admin panelden düzenlenir; yalnızca tablo boşken eklenir)
INSERT INTO urunler (kategori_id, isim, aciklama, fiyat, etiket, sira, aktif)
SELECT k.id, t.isim, t.aciklama, t.fiyat, t.etiket, t.sira, 1
FROM (
  SELECT 'Burgerler' kat, 'Mantar Klasik Burger' isim, 'Köz mantar, cheddar, karamelize soğan, gizli sos.' aciklama, 185.00 fiyat, 'Çok satan' etiket, 1 sira UNION ALL
  SELECT 'Burgerler', 'Trüf Mayolu Mantar Burger', 'Trüf mayonezi, rokfor, çıtır soğan halkası.', 215.00, NULL, 2 UNION ALL
  SELECT 'Burgerler', 'Acılı İstiridye Burger', 'Acı marine mantar, jalapeño, chipotle sos.', 195.00, 'Acı sever', 3 UNION ALL
  SELECT 'Kokoreçler', 'Mantar Kokoreç — Yarım Ekmek', 'Köz ateşinde, bol baharatlı klasik.', 140.00, NULL, 1 UNION ALL
  SELECT 'Kokoreçler', 'Mantar Kokoreç — Porsiyon', 'Tereyağlı, közlenmiş biberli, ekmek yanında.', 195.00, 'Efsane', 2 UNION ALL
  SELECT 'Wrapler', 'Mantar Wrap', 'Taze lavaş, marine mantar, közlenmiş sebze.', 155.00, NULL, 1 UNION ALL
  SELECT 'Wrapler', 'Bol Peynirli Mantar Wrap', 'Eriyen kaşar ve cheddar, gizli sos.', 175.00, NULL, 2 UNION ALL
  SELECT 'Friesman Box', 'Friesman Box — Tekli', 'Çıtır patates + soslu mantar lokmaları.', 145.00, NULL, 1 UNION ALL
  SELECT 'Friesman Box', 'Friesman Box — Mega', 'İki kişilik, dört sos seçeneğiyle.', 205.00, 'Doyurucu', 2 UNION ALL
  SELECT 'Soslar', 'Gizli Mantarhane Sosu', 'İmza reçete, kapalı şişede.', 35.00, NULL, 1 UNION ALL
  SELECT 'Soslar', 'Acı Trüf Sos', 'Trüf aromalı, tatlı-acı denge.', 40.00, NULL, 2 UNION ALL
  SELECT 'İçecekler', 'Ev Yapımı Limonata', 'Taze nane ile.', 65.00, NULL, 1 UNION ALL
  SELECT 'İçecekler', 'Ayran', 'Cam şişede.', 35.00, NULL, 2 UNION ALL
  SELECT 'İçecekler', 'Soğuk Çay', 'Şeftali / limon.', 55.00, NULL, 3 UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar', 'Çıtır Lokma', 'Sıcak servis, çikolata sosuyla.', 95.00, NULL, 1 UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar', 'San Sebastian Cheesecake', 'Günlük, dilim.', 145.00, 'Tatlı kapanış', 2
) t
JOIN menu_kategorileri k ON k.isim = t.kat
WHERE NOT EXISTS (SELECT 1 FROM urunler);

INSERT INTO ayarlar (anahtar, deger) VALUES
  ('site_url',     'https://www.mantarhane.co'),
  ('seo_aciklama', 'Mantarhane — istiridye mantarından gurme burger, kokoreç ve wrap. Sıfır hayvansal et, köz ateşi, gizli reçeteler. Maltepe / İstanbul.'),
  ('ga_id',        '')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
