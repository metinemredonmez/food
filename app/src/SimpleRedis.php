<?php
declare(strict_types=1);

/**
 * Bağımlılıksız, minimal Redis istemcisi (RESP protokolü).
 * Sadece bu projenin ihtiyacı olan komutları içerir.
 */
class SimpleRedis
{
    /** @var resource */
    private $baglanti;

    public function __construct(string $host, int $port, float $zamanAsimi = 1.5)
    {
        $baglanti = @fsockopen($host, $port, $hataNo, $hataMetni, $zamanAsimi);
        if ($baglanti === false) {
            throw new RuntimeException("Redis'e bağlanılamadı: $hataMetni ($hataNo)");
        }
        stream_set_timeout($baglanti, 2);
        $this->baglanti = $baglanti;
    }

    public function incr(string $anahtar): int
    {
        return (int) $this->komut('INCR', $anahtar);
    }

    public function expire(string $anahtar, int $saniye): void
    {
        $this->komut('EXPIRE', $anahtar, (string) $saniye);
    }

    public function get(string $anahtar): ?string
    {
        $deger = $this->komut('GET', $anahtar);
        return $deger === null ? null : (string) $deger;
    }

    public function set(string $anahtar, string $deger): void
    {
        $this->komut('SET', $anahtar, $deger);
    }

    public function ping(): bool
    {
        return $this->komut('PING') === 'PONG';
    }

    /** @return string|int|null */
    private function komut(string ...$parcalar)
    {
        $istek = '*' . count($parcalar) . "\r\n";
        foreach ($parcalar as $parca) {
            $istek .= '$' . strlen($parca) . "\r\n" . $parca . "\r\n";
        }
        fwrite($this->baglanti, $istek);
        return $this->cevapOku();
    }

    /** @return string|int|null */
    private function cevapOku()
    {
        $satir = fgets($this->baglanti);
        if ($satir === false) {
            throw new RuntimeException('Redis cevap vermedi');
        }
        $tur = $satir[0];
        $govde = rtrim(substr($satir, 1), "\r\n");
        switch ($tur) {
            case '+':
                return $govde;
            case ':':
                return (int) $govde;
            case '-':
                throw new RuntimeException('Redis hatası: ' . $govde);
            case '$':
                $uzunluk = (int) $govde;
                if ($uzunluk === -1) {
                    return null;
                }
                $veri = stream_get_contents($this->baglanti, $uzunluk + 2);
                return substr((string) $veri, 0, $uzunluk);
            default:
                throw new RuntimeException('Beklenmeyen Redis cevabı: ' . $satir);
        }
    }
}
