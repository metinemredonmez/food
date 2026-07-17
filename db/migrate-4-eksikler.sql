-- Hakkımızda kapanış paragrafı (orijinal siteden)
SET NAMES utf8mb4;
INSERT INTO icerik (anahtar, deger) VALUES
  ('hk_p3', 'Türkiye’de yepyeni bir akım başlatan Mantarhane, her tabakta ayrı bir şef dokunuşu ve kusursuz müşteri memnuniyeti felsefesiyle gurme lezzet tutkunlarını ağırlamaya devam ediyor.')
ON DUPLICATE KEY UPDATE anahtar = anahtar;
