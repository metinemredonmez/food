<?php
declare(strict_types=1);

/**
 * Bağımlılıksız, minimal SMTP istemcisi.
 * Lokalde Mailpit (auth yok), prod'da Turhost SMTP (AUTH LOGIN + STARTTLS) ile çalışır.
 */
class SimpleSmtp
{
    /** @var resource */
    private $baglanti;
    private string $kullanici;
    private string $sifre;
    private string $guvenlik; // none | tls (STARTTLS) | ssl (smtps)

    public function __construct(string $host, int $port, string $kullanici = '', string $sifre = '', string $guvenlik = 'none')
    {
        $this->kullanici = $kullanici;
        $this->sifre = $sifre;
        $this->guvenlik = $guvenlik;

        $adres = ($guvenlik === 'ssl' ? 'ssl://' : '') . $host;
        $baglanti = @stream_socket_client("$adres:$port", $hataNo, $hataMetni, 5);
        if ($baglanti === false) {
            throw new RuntimeException("SMTP sunucusuna bağlanılamadı: $hataMetni ($hataNo)");
        }
        stream_set_timeout($baglanti, 8);
        $this->baglanti = $baglanti;
        $this->bekle([220]);
    }

    public function gonder(string $kimden, string $kimdenAd, string $kime, string $konu, string $html): bool
    {
        $this->yaz('EHLO mantarhane.local');
        $this->bekle([250]);

        if ($this->guvenlik === 'tls') {
            $this->yaz('STARTTLS');
            $this->bekle([220]);
            if (!stream_socket_enable_crypto($this->baglanti, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('STARTTLS başlatılamadı');
            }
            $this->yaz('EHLO mantarhane.local');
            $this->bekle([250]);
        }

        if ($this->kullanici !== '') {
            $this->yaz('AUTH LOGIN');
            $this->bekle([334]);
            $this->yaz(base64_encode($this->kullanici));
            $this->bekle([334]);
            $this->yaz(base64_encode($this->sifre));
            $this->bekle([235]);
        }

        $this->yaz("MAIL FROM:<$kimden>");
        $this->bekle([250]);
        $this->yaz("RCPT TO:<$kime>");
        $this->bekle([250, 251]);
        $this->yaz('DATA');
        $this->bekle([354]);

        $basliklar = [
            'From: ' . $this->kodla($kimdenAd) . " <$kimden>",
            "To: <$kime>",
            'Subject: ' . $this->kodla($konu),
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
            'Date: ' . date('r'),
        ];
        $govde = implode("\r\n", $basliklar) . "\r\n\r\n" . chunk_split(base64_encode($html));
        $this->yaz($govde . "\r\n.");
        $this->bekle([250]);
        $this->yaz('QUIT');
        return true;
    }

    private function kodla(string $metin): string
    {
        return '=?UTF-8?B?' . base64_encode($metin) . '?=';
    }

    private function yaz(string $satir): void
    {
        fwrite($this->baglanti, $satir . "\r\n");
    }

    private function bekle(array $beklenenKodlar): void
    {
        $cevap = '';
        while (($satir = fgets($this->baglanti)) !== false) {
            $cevap .= $satir;
            if (strlen($satir) < 4 || $satir[3] !== '-') {
                break; // çok satırlı cevabın son satırı
            }
        }
        $kod = (int) substr($cevap, 0, 3);
        if (!in_array($kod, $beklenenKodlar, true)) {
            throw new RuntimeException('SMTP beklenmeyen cevap: ' . trim($cevap));
        }
    }
}
