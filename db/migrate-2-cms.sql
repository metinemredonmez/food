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
