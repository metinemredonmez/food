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
-- Çok dillilik: çeviri tabloları + EN/AR/RU/DE çevirileri
-- TR ana dildir ve mevcut tablolarda kalır; çeviri yoksa site TR'ye düşer.
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS icerik_ceviri (
  anahtar VARCHAR(64) NOT NULL,
  dil     VARCHAR(5)  NOT NULL,
  deger   TEXT,
  PRIMARY KEY (anahtar, dil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS menu_kategorileri_ceviri (
  kategori_id INT UNSIGNED NOT NULL,
  dil         VARCHAR(5) NOT NULL,
  isim        VARCHAR(120),
  ust_baslik  VARCHAR(120),
  aciklama    VARCHAR(500),
  PRIMARY KEY (kategori_id, dil),
  CONSTRAINT fk_katceviri FOREIGN KEY (kategori_id) REFERENCES menu_kategorileri(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS urunler_ceviri (
  urun_id  INT UNSIGNED NOT NULL,
  dil      VARCHAR(5) NOT NULL,
  isim     VARCHAR(150),
  aciklama VARCHAR(500),
  etiket   VARCHAR(60),
  PRIMARY KEY (urun_id, dil),
  CONSTRAINT fk_urunceviri FOREIGN KEY (urun_id) REFERENCES urunler(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================= SİTE METİNLERİ =================
INSERT INTO icerik_ceviri (anahtar, dil, deger) VALUES
-- İNGİLİZCE
('site_baslik','en','Mantarhane — Gourmet Mushroom Kitchen'),
('slogan','en','Flavor, built on mushrooms'),
('saatler','en','Every day 11:00 – 01:00'),
('seo_aciklama','en','Mantarhane — gourmet burgers, kokorec and wraps made from oyster mushrooms. Zero animal meat, ember fire, secret recipes. Maltepe, Istanbul.'),
('ust_serit','en','The first oyster mushroom concept in Türkiye'),
('hero_rozet','en','A new movement in Türkiye'),
('hero_baslik','en','Forget ordinary burgers'),
('hero_slogan','en','We built the flavor on mushrooms.'),
('hero_aciklama','en','Oyster mushrooms marinated over ember fire. Secret recipes, special sauces.'),
('hero_rozet_donen','en','100% oyster mushroom • zero animal meat • '),
('hero_cip1','en','🔥 Ember fire'),
('hero_cip2','en','🤫 Secret recipe'),
('hero_yildiz','en','Guest favorite'),
('serit','en','Zero animal meat,Ember fire,Secret recipes,Gourmet sauces,Legendary kokorec,Giant mushroom burger'),
('neden_ust','en','Why Mantarhane'),
('neden_baslik','en','Three secrets that replace meat'),
('sir1_baslik','en','Zero animal meat'),
('sir1_metin','en','No meat on the menu. Just the juicy, fibrous texture of oyster mushrooms.'),
('sir2_baslik','en','Secret marinade recipe'),
('sir2_metin','en','Secret spice and sauce formulas of our chefs.'),
('sir3_baslik','en','Ember fire'),
('sir3_metin','en','Cooked on sheet iron and embers, with our own techniques.'),
('menu_ust','en','Oyster mushrooms at their finest'),
('menu_baslik','en','Our Menu'),
('menu_aciklama','en','Categories crafted entirely with oyster mushrooms.'),
('hikaye_ust','en','Our story'),
('hikaye_baslik','en','A gourmet mushroom experience'),
('hikaye_p1','en','Mantarhane is the first signature concept in Türkiye blending street food and burger culture with fresh oyster mushrooms — no meat involved.'),
('hikaye_p2','en','Our goal is not a meatless alternative; it is a new movement that makes you forget meat.'),
('fr_ust','en','Franchise'),
('fr_baslik','en','Become a partner of this movement'),
('fr_metin','en','Join the Mantarhane family and own your business.'),
('lz_baslik','en','Our Menu'),
('lz_aciklama','en','All fresh oyster mushrooms, with secret marinade recipes.'),
('hk_baslik','en','Forget ordinary burgers and kokorec'),
('hk_alt','en','We tied flavor to mushrooms and changed the rules.'),
('hk_p1','en','Mantarhane set out to reinterpret traditional street food with modern gastronomy techniques. We placed the oyster mushroom at the very center of our kitchen.'),
('hk_p2','en','We marinate with special sauces and cook on sheet iron and embers, turning mushrooms into an art of flavor.'),
('hk_p3','en','Starting a brand-new movement in Türkiye, Mantarhane keeps welcoming flavor lovers with a chef touch on every plate.'),
('hk_kart1_baslik','en','Zero animal meat'),
('hk_kart1_metin','en','Not a trace of meat in any product. Gourmet burgers, wraps and legendary kokorec with fresh mushrooms.'),
('hk_kart2_baslik','en','Secret marinade recipes'),
('hk_kart2_metin','en','The secret lies in naturalness and the formulas of our chefs. Every mushroom rests for hours.'),
('frs_baslik','en','Become a partner of this movement'),
('frs_aciklama','en','Join the Mantarhane family and own your business.'),
('frs_neden','en','Low operating costs, high profit margins, secret marinade recipes and strong corporate support. The first oyster mushroom signature concept in Türkiye.'),
('frs_kart1_baslik','en','Low operating cost'),
('frs_kart1_metin','en','No meat cost; a lean, efficient kitchen.'),
('frs_kart2_baslik','en','High profit margin'),
('frs_kart2_metin','en','A sustainable, proven business model.'),
('frs_kart3_baslik','en','Corporate infrastructure'),
('frs_kart3_metin','en','Recipes, training and brand support with you.'),
('il_baslik','en','Contact us'),
('il_aciklama','en','Connect with the world of Mantarhane.'),
('footer_tanitim','en','The first oyster mushroom gourmet concept in Türkiye.'),
('footer_franchise','en','Apply to open a Mantarhane in your city.'),
('telif','en','Mantarhane is a brand of Orsa Food Gıda Ltd. Şti.'),
('kdv_notu','en','Prices include VAT. Menu and prices may change.'),
-- ARAPÇA
('site_baslik','ar','مانتارهانة — مطبخ الفطر الفاخر'),
('slogan','ar','نكهة أساسها الفطر'),
('saatler','ar','يوميًا 11:00 – 01:00'),
('seo_aciklama','ar','مانتارهانة — برغر فاخر وكوكوريتش وراب من فطر المحار. بدون لحوم، نار الجمر، وصفات سرية. مالطبة، إسطنبول.'),
('ust_serit','ar','أول مفهوم لفطر المحار في تركيا'),
('hero_rozet','ar','موجة جديدة في تركيا'),
('hero_baslik','ar','انسَ البرغر العادي'),
('hero_slogan','ar','ربطنا النكهة بالفطر.'),
('hero_aciklama','ar','فطر المحار متبل على نار الجمر. وصفات سرية وصلصات خاصة.'),
('hero_rozet_donen','ar','فطر محار 100% • بدون لحوم • '),
('hero_cip1','ar','🔥 نار الجمر'),
('hero_cip2','ar','🤫 وصفة سرية'),
('hero_yildiz','ar','المفضل لدى الضيوف'),
('serit','ar','بدون لحوم,نار الجمر,وصفات سرية,صلصات فاخرة,كوكوريتش أسطوري,برغر الفطر العملاق'),
('neden_ust','ar','لماذا مانتارهانة'),
('neden_baslik','ar','ثلاثة أسرار تُنسيك اللحم'),
('sir1_baslik','ar','بدون لحوم'),
('sir1_metin','ar','لا لحوم في القائمة. فقط قوام فطر المحار الطري والغني.'),
('sir2_baslik','ar','وصفة تتبيل سرية'),
('sir2_metin','ar','تركيبات سرية من التوابل والصلصات من طهاتنا.'),
('sir3_baslik','ar','نار الجمر'),
('sir3_metin','ar','يُطهى على الصاج والجمر بتقنياتنا الخاصة.'),
('menu_ust','ar','فطر المحار في أبهى صوره'),
('menu_baslik','ar','قائمتنا'),
('menu_aciklama','ar','أصناف محضّرة بالكامل من فطر المحار.'),
('hikaye_ust','ar','قصتنا'),
('hikaye_baslik','ar','تجربة فطر فاخرة'),
('hikaye_p1','ar','مانتارهانة هي أول مفهوم مميز في تركيا يمزج ثقافة أكل الشارع والبرغر مع فطر المحار الطازج — دون أي لحوم.'),
('hikaye_p2','ar','هدفنا ليس بديلًا عن اللحم؛ بل موجة جديدة تُنسيك اللحم تمامًا.'),
('fr_ust','ar','فرنشايز'),
('fr_baslik','ar','كن شريكًا في هذه الموجة'),
('fr_metin','ar','انضم إلى عائلة مانتارهانة وامتلك مشروعك الخاص.'),
('lz_baslik','ar','قائمتنا'),
('lz_aciklama','ar','فطر محار طازج بالكامل، بوصفات تتبيل سرية.'),
('hk_baslik','ar','انسَ البرغر والكوكوريتش العادي'),
('hk_alt','ar','ربطنا النكهة بالفطر وغيّرنا القواعد.'),
('hk_p1','ar','انطلقت مانتارهانة لإعادة تقديم أكلات الشارع التقليدية بتقنيات الطهي الحديثة. وضعنا فطر المحار في قلب مطبخنا.'),
('hk_p2','ar','نتبّل بصلصات خاصة ونطهو على الصاج والجمر، لنحوّل الفطر إلى فنّ من النكهات.'),
('hk_p3','ar','مانتارهانة، رائدة موجة جديدة في تركيا، تواصل استقبال عشاق النكهة بلمسة شيف في كل طبق.'),
('hk_kart1_baslik','ar','بدون لحوم'),
('hk_kart1_metin','ar','لا أثر للحوم في أي منتج. برغر فاخر وراب وكوكوريتش أسطوري بالفطر الطازج.'),
('hk_kart2_baslik','ar','وصفات تتبيل سرية'),
('hk_kart2_metin','ar','السر في الطبيعية وتركيبات طهاتنا. كل فطر يرتاح لساعات.'),
('frs_baslik','ar','كن شريكًا في هذه الموجة'),
('frs_aciklama','ar','انضم إلى عائلة مانتارهانة وامتلك مشروعك الخاص.'),
('frs_neden','ar','تكاليف تشغيل منخفضة، هوامش ربح عالية، وصفات سرية ودعم مؤسسي قوي. أول مفهوم مميز لفطر المحار في تركيا.'),
('frs_kart1_baslik','ar','تكلفة تشغيل منخفضة'),
('frs_kart1_metin','ar','لا تكلفة لحوم؛ مطبخ رشيق وفعّال.'),
('frs_kart2_baslik','ar','هامش ربح عالٍ'),
('frs_kart2_metin','ar','نموذج عمل مستدام ومُثبت.'),
('frs_kart3_baslik','ar','بنية مؤسسية'),
('frs_kart3_metin','ar','وصفات وتدريب ودعم للعلامة معك.'),
('il_baslik','ar','تواصل معنا'),
('il_aciklama','ar','تواصل مع عالم مانتارهانة.'),
('footer_tanitim','ar','أول مفهوم فاخر لفطر المحار في تركيا.'),
('footer_franchise','ar','قدّم طلبًا لافتتاح مانتارهانة في مدينتك.'),
('telif','ar','مانتارهانة علامة تجارية لشركة Orsa Food Gıda Ltd. Şti.'),
('kdv_notu','ar','الأسعار شاملة الضريبة. قد تتغير القائمة والأسعار.'),
-- RUSÇA
('site_baslik','ru','Mantarhane — гурме-кухня из грибов'),
('slogan','ru','Вкус, построенный на грибах'),
('saatler','ru','Ежедневно 11:00 – 01:00'),
('seo_aciklama','ru','Mantarhane — гурме-бургеры, кокореч и врапы из вешенок. Ноль мяса, огонь углей, секретные рецепты. Мальтепе, Стамбул.'),
('ust_serit','ru','Первая концепция из вешенок в Турции'),
('hero_rozet','ru','Новое движение в Турции'),
('hero_baslik','ru','Забудьте об обычных бургерах'),
('hero_slogan','ru','Мы доверили вкус грибам.'),
('hero_aciklama','ru','Вешенки, маринованные на углях. Секретные рецепты, фирменные соусы.'),
('hero_rozet_donen','ru','100% вешенки • ноль мяса • '),
('hero_cip1','ru','🔥 Огонь углей'),
('hero_cip2','ru','🤫 Секретный рецепт'),
('hero_yildiz','ru','Любимец гостей'),
('serit','ru','Ноль мяса,Огонь углей,Секретные рецепты,Гурме-соусы,Легендарный кокореч,Гигантский грибной бургер'),
('neden_ust','ru','Почему Mantarhane'),
('neden_baslik','ru','Три секрета вместо мяса'),
('sir1_baslik','ru','Ноль мяса'),
('sir1_metin','ru','В меню нет мяса. Только сочная, волокнистая текстура вешенок.'),
('sir2_baslik','ru','Секретный маринад'),
('sir2_metin','ru','Секретные формулы специй и соусов наших шефов.'),
('sir3_baslik','ru','Огонь углей'),
('sir3_metin','ru','Готовим на саче и углях по собственным технологиям.'),
('menu_ust','ru','Вешенки в лучшем виде'),
('menu_baslik','ru','Наше меню'),
('menu_aciklama','ru','Категории, целиком созданные из вешенок.'),
('hikaye_ust','ru','Наша история'),
('hikaye_baslik','ru','Гурме-опыт из грибов'),
('hikaye_p1','ru','Mantarhane — первая авторская концепция в Турции, соединившая уличную еду и бургер-культуру со свежими вешенками — без мяса.'),
('hikaye_p2','ru','Наша цель — не замена мясу, а новое движение, которое заставит о нём забыть.'),
('fr_ust','ru','Франшиза'),
('fr_baslik','ru','Станьте партнёром движения'),
('fr_metin','ru','Присоединяйтесь к семье Mantarhane и откройте своё дело.'),
('lz_baslik','ru','Наше меню'),
('lz_aciklama','ru','Только свежие вешенки и секретные маринады.'),
('hk_baslik','ru','Забудьте об обычных бургерах и кокорече'),
('hk_alt','ru','Мы доверили вкус грибам и изменили правила.'),
('hk_p1','ru','Mantarhane переосмысливает традиционную уличную еду современными техниками гастрономии. Вешенки — в самом центре нашей кухни.'),
('hk_p2','ru','Маринуем в фирменных соусах, готовим на саче и углях — превращаем грибы в искусство вкуса.'),
('hk_p3','ru','Начав новое движение в Турции, Mantarhane встречает гурманов авторским подходом в каждой тарелке.'),
('hk_kart1_baslik','ru','Ноль мяса'),
('hk_kart1_metin','ru','Ни следа мяса ни в одном продукте. Гурме-бургеры, врапы и легендарный кокореч из свежих грибов.'),
('hk_kart2_baslik','ru','Секретные маринады'),
('hk_kart2_metin','ru','Секрет — в натуральности и формулах шефов. Каждый гриб настаивается часами.'),
('frs_baslik','ru','Станьте партнёром движения'),
('frs_aciklama','ru','Присоединяйтесь к семье Mantarhane и откройте своё дело.'),
('frs_neden','ru','Низкие операционные расходы, высокая маржа, секретные рецепты и сильная корпоративная поддержка. Первая концепция из вешенок в Турции.'),
('frs_kart1_baslik','ru','Низкие расходы'),
('frs_kart1_metin','ru','Нет затрат на мясо; экономичная кухня.'),
('frs_kart2_baslik','ru','Высокая маржа'),
('frs_kart2_metin','ru','Устойчивая, проверенная бизнес-модель.'),
('frs_kart3_baslik','ru','Корпоративная база'),
('frs_kart3_metin','ru','Рецепты, обучение и поддержка бренда.'),
('il_baslik','ru','Свяжитесь с нами'),
('il_aciklama','ru','Откройте для себя мир Mantarhane.'),
('footer_tanitim','ru','Первая гурме-концепция из вешенок в Турции.'),
('footer_franchise','ru','Подайте заявку и откройте Mantarhane в своём городе.'),
('telif','ru','Mantarhane — бренд Orsa Food Gıda Ltd. Şti.'),
('kdv_notu','ru','Цены включают НДС. Меню и цены могут меняться.'),
-- ALMANCA
('site_baslik','de','Mantarhane — Gourmet-Pilzküche'),
('slogan','de','Geschmack, gebaut auf Pilzen'),
('saatler','de','Täglich 11:00 – 01:00'),
('seo_aciklama','de','Mantarhane — Gourmet-Burger, Kokoreç und Wraps aus Austernpilzen. Null Fleisch, Glutfeuer, geheime Rezepte. Maltepe, Istanbul.'),
('ust_serit','de','Das erste Austernpilz-Konzept der Türkei'),
('hero_rozet','de','Ein neuer Trend in der Türkei'),
('hero_baslik','de','Vergiss gewöhnliche Burger'),
('hero_slogan','de','Wir setzen beim Geschmack auf Pilze.'),
('hero_aciklama','de','Über Glut marinierte Austernpilze. Geheime Rezepte, besondere Saucen.'),
('hero_rozet_donen','de','100% Austernpilz • null Fleisch • '),
('hero_cip1','de','🔥 Glutfeuer'),
('hero_cip2','de','🤫 Geheimrezept'),
('hero_yildiz','de','Gäste-Liebling'),
('serit','de','Null Fleisch,Glutfeuer,Geheime Rezepte,Gourmet-Saucen,Legendäres Kokoreç,Riesiger Pilzburger'),
('neden_ust','de','Warum Mantarhane'),
('neden_baslik','de','Drei Geheimnisse statt Fleisch'),
('sir1_baslik','de','Null Fleisch'),
('sir1_metin','de','Kein Fleisch auf der Karte. Nur die saftige, faserige Textur der Austernpilze.'),
('sir2_baslik','de','Geheime Marinade'),
('sir2_metin','de','Geheime Gewürz- und Saucenformeln unserer Köche.'),
('sir3_baslik','de','Glutfeuer'),
('sir3_metin','de','Auf Blech und Glut gegart, mit eigenen Techniken.'),
('menu_ust','de','Austernpilze in Bestform'),
('menu_baslik','de','Unsere Karte'),
('menu_aciklama','de','Kategorien, komplett aus Austernpilzen gefertigt.'),
('hikaye_ust','de','Unsere Geschichte'),
('hikaye_baslik','de','Ein Gourmet-Pilzerlebnis'),
('hikaye_p1','de','Mantarhane ist das erste Signature-Konzept der Türkei, das Streetfood- und Burger-Kultur mit frischen Austernpilzen verbindet — ganz ohne Fleisch.'),
('hikaye_p2','de','Unser Ziel ist keine fleischlose Alternative, sondern ein neuer Trend, der Fleisch vergessen lässt.'),
('fr_ust','de','Franchise'),
('fr_baslik','de','Werde Partner dieses Trends'),
('fr_metin','de','Werde Teil der Mantarhane-Familie und führe dein eigenes Geschäft.'),
('lz_baslik','de','Unsere Karte'),
('lz_aciklama','de','Nur frische Austernpilze, mit geheimen Marinaden.'),
('hk_baslik','de','Vergiss gewöhnliche Burger und Kokoreç'),
('hk_alt','de','Wir setzen auf Pilze und haben die Regeln geändert.'),
('hk_p1','de','Mantarhane interpretiert traditionelles Streetfood mit modernen Gastronomie-Techniken neu. Der Austernpilz steht im Zentrum unserer Küche.'),
('hk_p2','de','Wir marinieren mit besonderen Saucen und garen auf Blech und Glut — Pilze werden zur Geschmackskunst.'),
('hk_p3','de','Als Vorreiter eines neuen Trends in der Türkei empfängt Mantarhane Genießer mit Chef-Handschrift auf jedem Teller.'),
('hk_kart1_baslik','de','Null Fleisch'),
('hk_kart1_metin','de','Keine Spur von Fleisch. Gourmet-Burger, Wraps und legendäres Kokoreç aus frischen Pilzen.'),
('hk_kart2_baslik','de','Geheime Marinaden'),
('hk_kart2_metin','de','Das Geheimnis liegt in Natürlichkeit und den Formeln unserer Köche. Jeder Pilz ruht stundenlang.'),
('frs_baslik','de','Werde Partner dieses Trends'),
('frs_aciklama','de','Werde Teil der Mantarhane-Familie und führe dein eigenes Geschäft.'),
('frs_neden','de','Niedrige Betriebskosten, hohe Margen, geheime Rezepte und starke Unterstützung. Das erste Austernpilz-Konzept der Türkei.'),
('frs_kart1_baslik','de','Niedrige Betriebskosten'),
('frs_kart1_metin','de','Keine Fleischkosten; schlanke, effiziente Küche.'),
('frs_kart2_baslik','de','Hohe Gewinnmarge'),
('frs_kart2_metin','de','Ein nachhaltiges, bewährtes Geschäftsmodell.'),
('frs_kart3_baslik','de','Struktur und Support'),
('frs_kart3_metin','de','Rezepte, Schulung und Markenunterstützung.'),
('il_baslik','de','Kontakt'),
('il_aciklama','de','Tritt in die Welt von Mantarhane ein.'),
('footer_tanitim','de','Das erste Austernpilz-Gourmetkonzept der Türkei.'),
('footer_franchise','de','Bewirb dich und eröffne ein Mantarhane in deiner Stadt.'),
('telif','de','Mantarhane ist eine Marke der Orsa Food Gıda Ltd. Şti.'),
('kdv_notu','de','Preise inkl. MwSt. Karte und Preise können sich ändern.')
ON DUPLICATE KEY UPDATE deger = VALUES(deger);

-- ================= KATEGORİLER =================
INSERT INTO menu_kategorileri_ceviri (kategori_id, dil, isim, ust_baslik, aciklama)
SELECT k.id, t.dil, t.isim, t.ust, t.aciklama FROM (
  SELECT 'Burgerler' kat,'en' dil,'Burgers' isim,'Gourmet flavor' ust,'Giant mushroom burgers that break every rule.' aciklama UNION ALL
  SELECT 'Kokoreçler','en','Kokorec','Legendary flavor','Marinated over embers, a harmony of spices.' UNION ALL
  SELECT 'Wrapler','en','Wraps','Hearty choice','Fresh mushrooms and melting cheese in lavash.' UNION ALL
  SELECT 'Friesman Box','en','Friesman Box','Crispy box','Crispy fries with saucy mushroom bites.' UNION ALL
  SELECT 'Soslar','en','Sauces','Secret recipe','Secret sauces made only in the Mantarhane kitchen.' UNION ALL
  SELECT 'İçecekler','en','Drinks','Refreshing','The best companions to a gourmet menu.' UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar','en','Desserts & Snacks','Sweet finish','Crispy, light gourmet treats after the meal.' UNION ALL
  SELECT 'Burgerler','ar','برغر','نكهة فاخرة','برغر فطر عملاق يكسر كل القواعد.' UNION ALL
  SELECT 'Kokoreçler','ar','كوكوريتش','نكهة أسطورية','متبل على الجمر بتناغم التوابل.' UNION ALL
  SELECT 'Wrapler','ar','راب','خيار مشبع','فطر طازج وجبن ذائب في خبز اللافاش.' UNION ALL
  SELECT 'Friesman Box','ar','فرايزمان بوكس','صندوق مقرمش','بطاطس مقرمشة مع قطع فطر بالصلصة.' UNION ALL
  SELECT 'Soslar','ar','صلصات','وصفة سرية','صلصات سرية تُصنع فقط في مطبخ مانتارهانة.' UNION ALL
  SELECT 'İçecekler','ar','مشروبات','منعش','أفضل رفيق لقائمة فاخرة.' UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar','ar','حلويات ووجبات خفيفة','ختام حلو','قضمات مقرمشة خفيفة بعد الوجبة.' UNION ALL
  SELECT 'Burgerler','ru','Бургеры','Гурме-вкус','Гигантские грибные бургеры, ломающие правила.' UNION ALL
  SELECT 'Kokoreçler','ru','Кокореч','Легендарный вкус','Маринован на углях, гармония специй.' UNION ALL
  SELECT 'Wrapler','ru','Врапы','Сытный выбор','Свежие грибы и тающий сыр в лаваше.' UNION ALL
  SELECT 'Friesman Box','ru','Friesman Box','Хрустящий бокс','Хрустящий картофель с грибами в соусе.' UNION ALL
  SELECT 'Soslar','ru','Соусы','Секретный рецепт','Секретные соусы только из кухни Mantarhane.' UNION ALL
  SELECT 'İçecekler','ru','Напитки','Освежающее','Лучшая пара к гурме-меню.' UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar','ru','Десерты и закуски','Сладкий финал','Хрустящие лёгкие лакомства после еды.' UNION ALL
  SELECT 'Burgerler','de','Burger','Gourmet-Geschmack','Riesige Pilzburger, die alle Regeln brechen.' UNION ALL
  SELECT 'Kokoreçler','de','Kokoreç','Legendärer Geschmack','Über Glut mariniert, Harmonie der Gewürze.' UNION ALL
  SELECT 'Wrapler','de','Wraps','Sättigend','Frische Pilze und schmelzender Käse im Lavash.' UNION ALL
  SELECT 'Friesman Box','de','Friesman Box','Knusperbox','Knusprige Pommes mit Pilzhappen in Sauce.' UNION ALL
  SELECT 'Soslar','de','Saucen','Geheimrezept','Geheime Saucen, nur aus der Mantarhane-Küche.' UNION ALL
  SELECT 'İçecekler','de','Getränke','Erfrischend','Die besten Begleiter zum Gourmet-Menü.' UNION ALL
  SELECT 'Tatlılar & Atıştırmalıklar','de','Desserts & Snacks','Süßer Abschluss','Knusprige, leichte Leckereien nach dem Essen.'
) t JOIN menu_kategorileri k ON k.isim = t.kat
ON DUPLICATE KEY UPDATE isim=VALUES(isim), ust_baslik=VALUES(ust_baslik), aciklama=VALUES(aciklama);

-- ================= ÜRÜNLER =================
INSERT INTO urunler_ceviri (urun_id, dil, isim, aciklama, etiket)
SELECT u.id, t.dil, t.isim, t.aciklama, t.etiket FROM (
  SELECT 'Mantar Klasik Burger' tr_isim,'en' dil,'Classic Mushroom Burger' isim,'Ember mushrooms, cheddar, caramelized onion, secret sauce.' aciklama,'Best seller' etiket UNION ALL
  SELECT 'Trüf Mayolu Mantar Burger','en','Truffle Mayo Mushroom Burger','Truffle mayo, blue cheese, crispy onion rings.',NULL UNION ALL
  SELECT 'Acılı İstiridye Burger','en','Spicy Oyster Burger','Spicy marinated mushrooms, jalapeño, chipotle sauce.','Spice lover' UNION ALL
  SELECT 'Mantar Kokoreç — Yarım Ekmek','en','Mushroom Kokorec — Half Bread','Classic over embers, richly spiced.',NULL UNION ALL
  SELECT 'Mantar Kokoreç — Porsiyon','en','Mushroom Kokorec — Portion','Buttery, with roasted peppers, bread on the side.','Legendary' UNION ALL
  SELECT 'Mantar Wrap','en','Mushroom Wrap','Fresh lavash, marinated mushrooms, roasted veggies.',NULL UNION ALL
  SELECT 'Bol Peynirli Mantar Wrap','en','Extra Cheese Mushroom Wrap','Melting kashar and cheddar, secret sauce.',NULL UNION ALL
  SELECT 'Friesman Box — Tekli','en','Friesman Box — Single','Crispy fries + saucy mushroom bites.',NULL UNION ALL
  SELECT 'Friesman Box — Mega','en','Friesman Box — Mega','For two, with four sauce options.','Filling' UNION ALL
  SELECT 'Gizli Mantarhane Sosu','en','Secret Mantarhane Sauce','Signature recipe, sealed bottle.',NULL UNION ALL
  SELECT 'Acı Trüf Sos','en','Spicy Truffle Sauce','Truffle aroma, sweet-hot balance.',NULL UNION ALL
  SELECT 'Ev Yapımı Limonata','en','Homemade Lemonade','With fresh mint.',NULL UNION ALL
  SELECT 'Ayran','en','Ayran','In a glass bottle.',NULL UNION ALL
  SELECT 'Soğuk Çay','en','Iced Tea','Peach / lemon.',NULL UNION ALL
  SELECT 'Çıtır Lokma','en','Crispy Lokma','Served hot, with chocolate sauce.',NULL UNION ALL
  SELECT 'San Sebastian Cheesecake','en','San Sebastian Cheesecake','Daily, per slice.','Sweet finish' UNION ALL
  SELECT 'Mantar Klasik Burger','ar','برغر الفطر الكلاسيكي','فطر مشوي، شيدر، بصل مكرمل، صلصة سرية.','الأكثر مبيعًا' UNION ALL
  SELECT 'Trüf Mayolu Mantar Burger','ar','برغر الفطر بمايونيز الترافل','مايونيز ترافل، جبنة زرقاء، حلقات بصل مقرمشة.',NULL UNION ALL
  SELECT 'Acılı İstiridye Burger','ar','برغر المحار الحار','فطر متبل حار، هالبينو، صلصة تشيبوتلي.','لعشاق الحار' UNION ALL
  SELECT 'Mantar Kokoreç — Yarım Ekmek','ar','كوكوريتش الفطر — نصف رغيف','كلاسيكي على الجمر بتوابل غنية.',NULL UNION ALL
  SELECT 'Mantar Kokoreç — Porsiyon','ar','كوكوريتش الفطر — وجبة','بالزبدة والفلفل المشوي مع الخبز.','أسطوري' UNION ALL
  SELECT 'Mantar Wrap','ar','راب الفطر','لافاش طازج، فطر متبل، خضار مشوية.',NULL UNION ALL
  SELECT 'Bol Peynirli Mantar Wrap','ar','راب الفطر بجبن إضافي','قشقوان وشيدر ذائبان، صلصة سرية.',NULL UNION ALL
  SELECT 'Friesman Box — Tekli','ar','فرايزمان بوكس — فردي','بطاطس مقرمشة مع قطع فطر بالصلصة.',NULL UNION ALL
  SELECT 'Friesman Box — Mega','ar','فرايزمان بوكس — ميغا','لشخصين مع أربع صلصات.','مشبع' UNION ALL
  SELECT 'Gizli Mantarhane Sosu','ar','صلصة مانتارهانة السرية','وصفة مميزة في زجاجة مغلقة.',NULL UNION ALL
  SELECT 'Acı Trüf Sos','ar','صلصة الترافل الحارة','نكهة ترافل بتوازن حلو وحار.',NULL UNION ALL
  SELECT 'Ev Yapımı Limonata','ar','ليموناضة منزلية','مع نعناع طازج.',NULL UNION ALL
  SELECT 'Ayran','ar','عيران','في زجاجة.',NULL UNION ALL
  SELECT 'Soğuk Çay','ar','شاي مثلج','خوخ / ليمون.',NULL UNION ALL
  SELECT 'Çıtır Lokma','ar','لقمة مقرمشة','تُقدّم ساخنة مع صلصة الشوكولاتة.',NULL UNION ALL
  SELECT 'San Sebastian Cheesecake','ar','تشيز كيك سان سيباستيان','يوميًا، بالشريحة.','ختام حلو' UNION ALL
  SELECT 'Mantar Klasik Burger','ru','Классический грибной бургер','Грибы с углей, чеддер, карамельный лук, секретный соус.','Хит продаж' UNION ALL
  SELECT 'Trüf Mayolu Mantar Burger','ru','Бургер с трюфельным майонезом','Трюфельный майонез, голубой сыр, хрустящий лук.',NULL UNION ALL
  SELECT 'Acılı İstiridye Burger','ru','Острый бургер с вешенками','Острые грибы, халапеньо, соус чипотле.','Для любителей острого' UNION ALL
  SELECT 'Mantar Kokoreç — Yarım Ekmek','ru','Грибной кокореч — полхлеба','Классика с углей, богато приправлен.',NULL UNION ALL
  SELECT 'Mantar Kokoreç — Porsiyon','ru','Грибной кокореч — порция','Со сливочным маслом и печёным перцем, хлеб отдельно.','Легендарный' UNION ALL
  SELECT 'Mantar Wrap','ru','Грибной врап','Свежий лаваш, маринованные грибы, печёные овощи.',NULL UNION ALL
  SELECT 'Bol Peynirli Mantar Wrap','ru','Врап с двойным сыром','Тающий кашар и чеддер, секретный соус.',NULL UNION ALL
  SELECT 'Friesman Box — Tekli','ru','Friesman Box — одинарный','Хрустящий картофель + грибы в соусе.',NULL UNION ALL
  SELECT 'Friesman Box — Mega','ru','Friesman Box — мега','На двоих, четыре соуса на выбор.','Сытный' UNION ALL
  SELECT 'Gizli Mantarhane Sosu','ru','Секретный соус Mantarhane','Фирменный рецепт, в закрытой бутылке.',NULL UNION ALL
  SELECT 'Acı Trüf Sos','ru','Острый трюфельный соус','Аромат трюфеля, сладко-острый баланс.',NULL UNION ALL
  SELECT 'Ev Yapımı Limonata','ru','Домашний лимонад','Со свежей мятой.',NULL UNION ALL
  SELECT 'Ayran','ru','Айран','В стеклянной бутылке.',NULL UNION ALL
  SELECT 'Soğuk Çay','ru','Холодный чай','Персик / лимон.',NULL UNION ALL
  SELECT 'Çıtır Lokma','ru','Хрустящая локма','Подаётся горячей с шоколадным соусом.',NULL UNION ALL
  SELECT 'San Sebastian Cheesecake','ru','Чизкейк Сан-Себастьян','Свежий, порционно.','Сладкий финал' UNION ALL
  SELECT 'Mantar Klasik Burger','de','Klassischer Pilzburger','Glutpilze, Cheddar, karamellisierte Zwiebeln, Geheimsauce.','Bestseller' UNION ALL
  SELECT 'Trüf Mayolu Mantar Burger','de','Pilzburger mit Trüffelmayo','Trüffelmayo, Blauschimmelkäse, knusprige Zwiebelringe.',NULL UNION ALL
  SELECT 'Acılı İstiridye Burger','de','Scharfer Austernpilz-Burger','Scharf marinierte Pilze, Jalapeño, Chipotle-Sauce.','Für Scharf-Fans' UNION ALL
  SELECT 'Mantar Kokoreç — Yarım Ekmek','de','Pilz-Kokoreç — halbes Brot','Klassiker von der Glut, kräftig gewürzt.',NULL UNION ALL
  SELECT 'Mantar Kokoreç — Porsiyon','de','Pilz-Kokoreç — Portion','Mit Butter und Röstpaprika, Brot dazu.','Legendär' UNION ALL
  SELECT 'Mantar Wrap','de','Pilz-Wrap','Frisches Lavash, marinierte Pilze, Röstgemüse.',NULL UNION ALL
  SELECT 'Bol Peynirli Mantar Wrap','de','Pilz-Wrap mit extra Käse','Schmelzender Kashar und Cheddar, Geheimsauce.',NULL UNION ALL
  SELECT 'Friesman Box — Tekli','de','Friesman Box — Einzel','Knusprige Pommes + Pilzhappen in Sauce.',NULL UNION ALL
  SELECT 'Friesman Box — Mega','de','Friesman Box — Mega','Für zwei, mit vier Saucen zur Wahl.','Sättigend' UNION ALL
  SELECT 'Gizli Mantarhane Sosu','de','Geheime Mantarhane-Sauce','Signature-Rezept, versiegelte Flasche.',NULL UNION ALL
  SELECT 'Acı Trüf Sos','de','Scharfe Trüffelsauce','Trüffelaroma, süß-scharfe Balance.',NULL UNION ALL
  SELECT 'Ev Yapımı Limonata','de','Hausgemachte Limonade','Mit frischer Minze.',NULL UNION ALL
  SELECT 'Ayran','de','Ayran','In der Glasflasche.',NULL UNION ALL
  SELECT 'Soğuk Çay','de','Eistee','Pfirsich / Zitrone.',NULL UNION ALL
  SELECT 'Çıtır Lokma','de','Knusprige Lokma','Heiß serviert, mit Schokoladensauce.',NULL UNION ALL
  SELECT 'San Sebastian Cheesecake','de','San Sebastian Cheesecake','Täglich frisch, pro Stück.','Süßer Abschluss'
) t JOIN urunler u ON u.isim = t.tr_isim
ON DUPLICATE KEY UPDATE isim=VALUES(isim), aciklama=VALUES(aciklama), etiket=VALUES(etiket);
-- Telefon + WhatsApp ayarları (adminde Ayarlar sekmesinde düzenlenir)
SET NAMES utf8mb4;
INSERT INTO ayarlar (anahtar, deger) VALUES
  ('telefon',  '+90 532 216 58 14'),
  ('whatsapp', '905322165814')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
