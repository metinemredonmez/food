-- Telefon + WhatsApp ayarları (adminde Ayarlar sekmesinde düzenlenir) ve kırık görsel düzeltmesi
SET NAMES utf8mb4;

INSERT INTO ayarlar (anahtar, deger) VALUES
  ('telefon',  '+90 532 216 58 14'),
  ('whatsapp', '905322165814')
ON DUPLICATE KEY UPDATE anahtar = anahtar;

-- Telefon artık ayrı alan ve üst şeritte tıklanabilir: adres_kisa'ya elle yazılmış numarayı temizle
UPDATE ayarlar SET deger = 'Maltepe / İstanbul' WHERE anahtar = 'adres_kisa' AND deger LIKE '%532%';

-- imgix sandbox linkleri 402 dönüyor (görseller boş görünüyordu):
-- hero → sunucudaki kendi burger fotoğrafımız, diğerleri → kod içindeki varsayılan görsel
UPDATE icerik SET deger = 'uploads/g20260805-023455-ec1d149d.png' WHERE anahtar = 'hero_gorsel' AND deger LIKE '%imgix.net%';
UPDATE icerik SET deger = '' WHERE deger LIKE '%imgix.net%';
UPDATE icerik_ceviri SET deger = '' WHERE deger LIKE '%imgix.net%';
