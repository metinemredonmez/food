-- Mantarhane lokal veritabanı şeması + başlangıç ayarları
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS ayarlar (
  anahtar VARCHAR(64) NOT NULL PRIMARY KEY,
  deger   TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO ayarlar (anahtar, deger) VALUES
  ('site_baslik',     'Mantarhane — Lezzeti Mantara Bağladık'),
  ('slogan',          'Lezzeti Mantara Bağladık'),
  ('adres',           'Feyzullah Mh. Bostan Sk. No:9/A Maltepe / İstanbul'),
  ('adres_kisa',      'Maltepe / İstanbul'),
  ('saatler',         'Her gün 11:00 – 01:00'),
  ('email_info',      'info@mantarhane.co'),
  ('email_social',    'social@mantarhane.co'),
  ('email_franchise', 'franchise@mantarhane.co'),
  ('instagram_url',   '#'),
  ('x_url',           '#'),
  ('mail_from',       'no-reply@mantarhane.co'),
  ('mail_from_ad',    'Mantarhane Web')
ON DUPLICATE KEY UPDATE anahtar = anahtar;

CREATE TABLE IF NOT EXISTS franchise_basvurulari (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ad         VARCHAR(100) NOT NULL,
  soyad      VARCHAR(100) NOT NULL,
  telefon    VARCHAR(40)  NOT NULL,
  eposta     VARCHAR(190) NOT NULL,
  sehir      VARCHAR(120) NOT NULL,
  mesaj      TEXT,
  ip         VARCHAR(45),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS iletisim_mesajlari (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ad         VARCHAR(150) NOT NULL,
  eposta     VARCHAR(190) NOT NULL,
  konu       VARCHAR(190),
  mesaj      TEXT NOT NULL,
  ip         VARCHAR(45),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- CMS katmanı: site metinleri + menü kategorileri + tema paleti
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS icerik (
  anahtar VARCHAR(64) NOT NULL PRIMARY KEY,
  deger   TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO icerik (anahtar, deger) VALUES
  ('hero_rozet',      'Türkiye’de yeni bir akım'),
  ('hero_baslik',     'Sıradan burgerleri unutun'),
  ('hero_slogan',     'Lezzeti mantara bağladık.'),
  ('hero_aciklama',   'Köz ateşinde marine edilmiş istiridye mantarı. Gizli reçeteler, özel soslar.'),
  ('serit',           'Sıfır hayvansal et,Köz ateşi,Gizli reçeteler,Gurme soslar,Efsane kokoreç,Dev mantar burger'),
  ('neden_ust',       'Neden Mantarhane'),
  ('neden_baslik',    'Eti unutturan üç sır'),
  ('sir1_baslik',     'Sıfır hayvansal et'),
  ('sir1_metin',      'Menüde et yok. İstiridye mantarının sulu, lifli dokusu var.'),
  ('sir2_baslik',     'Gizli marine reçetesi'),
  ('sir2_metin',      'Şeflerimizin gizli baharat ve sos formülleri.'),
  ('sir3_baslik',     'Köz ateşi'),
  ('sir3_metin',      'Sac ve köz ateşinde, kendimize has tekniklerle.'),
  ('menu_ust',        'İstiridye mantarının en özel hali'),
  ('menu_baslik',     'Lezzetlerimiz'),
  ('menu_aciklama',   'Tamamı istiridye mantarıyla hazırlanan kategoriler.'),
  ('hikaye_ust',      'Hikayemiz'),
  ('hikaye_baslik',   'Gurme mantar deneyimi'),
  ('hikaye_p1',       'Mantarhane, sokak lezzetlerini ve burger kültürünü et kullanmadan, taze istiridye mantarıyla harmanlayan Türkiye’nin ilk imza konseptidir.'),
  ('hikaye_p2',       'Amacımız etsiz alternatif değil; eti unutturacak yeni bir akım.'),
  ('fr_ust',          'Franchise'),
  ('fr_baslik',       'Bu akımın ortağı olun'),
  ('fr_metin',        'Mantarhane ailesine katılın, kendi işinizin sahibi olun.'),
  ('lz_baslik',       'Lezzetlerimiz'),
  ('lz_aciklama',     'Tamamı taze istiridye mantarıyla, gizli marine reçeteleriyle.'),
  ('hk_baslik',       'Sıradan burgerleri ve kokoreçleri unutun'),
  ('hk_alt',          'Lezzeti mantara bağladık, kuralları değiştirdik.'),
  ('hk_p1',           'Mantarhane, geleneksel sokak lezzetlerini modern gastronomi teknikleriyle yeniden yorumlamak için yola çıktı. İstiridye mantarını mutfağın tam merkezine koyduk.'),
  ('hk_p2',           'Özel soslarla marine ettiğimiz, sac ve köz ateşinde pişirdiğimiz mantarları birer lezzet sanatına dönüştürüyoruz.'),
  ('hk_kart1_baslik', 'Sıfır hayvansal et'),
  ('hk_kart1_metin',  'Hiçbir üründe et kırıntısı yok. Taze mantarla gurme burgerler, wrapler, kokoreçler.'),
  ('hk_kart2_baslik', 'Gizli marine reçeteleri'),
  ('hk_kart2_metin',  'Sır; doğallıkta ve şeflerin gizli formüllerinde. Her mantar saatlerce dinlendirilir.'),
  ('frs_baslik',      'Bu akımın ortağı olun'),
  ('frs_aciklama',    'Mantarhane ailesine katılarak kendi işinizin sahibi olun.'),
  ('frs_neden',       'Düşük işletme maliyeti, yüksek kâr marjı, gizli marine reçeteleri ve güçlü kurumsal altyapı. Türkiye’nin ilk istiridye mantarı imza konsepti.'),
  ('frs_kart1_baslik','Düşük işletme maliyeti'),
  ('frs_kart1_metin', 'Et maliyeti yok; yalın ve verimli mutfak.'),
  ('frs_kart2_baslik','Yüksek kâr marjı'),
  ('frs_kart2_metin', 'Sürdürülebilir, kanıtlanmış iş modeli.'),
  ('frs_kart3_baslik','Kurumsal altyapı'),
  ('frs_kart3_metin', 'Reçeteler, eğitim ve marka desteği sizinle.'),
  ('il_baslik',       'Bize ulaşın'),
  ('il_aciklama',     'Mantarhane lezzet dünyasıyla bağ kurun.')
ON DUPLICATE KEY UPDATE anahtar = anahtar;

CREATE TABLE IF NOT EXISTS menu_kategorileri (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  isim       VARCHAR(120) NOT NULL,
  ust_baslik VARCHAR(120),
  aciklama   VARCHAR(500),
  gorsel_url VARCHAR(500),
  sira       INT NOT NULL DEFAULT 0,
  aktif      TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO menu_kategorileri (isim, ust_baslik, aciklama, gorsel_url, sira, aktif)
SELECT * FROM (SELECT
  'Burgerler' AS isim, 'Gurme lezzet' AS ust_baslik,
  'Sıradan burger ezberini bozan dev mantar burgerler.' AS aciklama,
  'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1200&q=80' AS gorsel_url, 1 AS sira, 1 AS aktif) t
WHERE NOT EXISTS (SELECT 1 FROM menu_kategorileri);

INSERT INTO menu_kategorileri (isim, ust_baslik, aciklama, gorsel_url, sira, aktif)
SELECT * FROM (
  SELECT 'Kokoreçler','Efsane lezzet','Köz ateşinde marine, baharatların uyumu.','https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=700&q=80',2,1 UNION ALL
  SELECT 'Wrapler','Doyurucu durum','Lavaş arasında taze mantar, eriyen peynir.','https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=700&q=80',3,1 UNION ALL
  SELECT 'Friesman Box','Çıtır kutu','Çıtır patates, soslu mantar lokmaları.','https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=700&q=80',4,1 UNION ALL
  SELECT 'Soslar','Gizli reçete','Mantarhane mutfağına özel gizli soslar.','https://images.unsplash.com/photo-1472476443507-c7a5948772fc?w=700&q=80',5,1 UNION ALL
  SELECT 'İçecekler','Ferahlatıcı','Menülerin yanına en çok yakışanlar.','https://images.unsplash.com/photo-1544145945-f90425340c7e?w=700&q=80',6,1 UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar','Tatlı kapanış','Yemek sonrası çıtır, hafif gurme atıştırmalıklar.','https://images.unsplash.com/photo-1551024506-0bccd828d307?w=900&q=80',7,1
) t
WHERE (SELECT COUNT(*) FROM menu_kategorileri) = 1;

INSERT INTO ayarlar (anahtar, deger) VALUES ('tema_palet', 'koz')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
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
-- Hakkımızda kapanış paragrafı (orijinal siteden)
SET NAMES utf8mb4;
INSERT INTO icerik (anahtar, deger) VALUES
  ('hk_p3', 'Türkiye’de yepyeni bir akım başlatan Mantarhane, her tabakta ayrı bir şef dokunuşu ve kusursuz müşteri memnuniyeti felsefesiyle gurme lezzet tutkunlarını ağırlamaya devam ediyor.')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
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
