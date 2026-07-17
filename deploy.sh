#!/usr/bin/env bash
# Mantarhane prod deploy (rsync + PM2). Kullanım:
#   1) Aşağıdaki SUNUCU ve HEDEF değerlerini doldurun
#   2) ./deploy.sh
set -euo pipefail

SUNUCU="kullanici@SUNUCU_IP"          # örn: root@203.0.113.10
HEDEF="/var/www/mantarhane"           # sunucudaki proje klasörü

if [[ "$SUNUCU" == *"SUNUCU_IP"* ]]; then
  echo "Önce deploy.sh içindeki SUNUCU değişkenini doldurun."; exit 1
fi

echo "→ Dosyalar gönderiliyor..."
rsync -az --delete \
  --exclude '.git' \
  --exclude 'site/' \
  --exclude '.env' \
  --exclude 'app/public/uploads/' \
  ./ "$SUNUCU:$HEDEF/"

echo "→ Uploads klasörü korunuyor, PM2 yeniden yükleniyor..."
ssh "$SUNUCU" "mkdir -p $HEDEF/app/public/uploads && cd $HEDEF && (pm2 reload mantarhane-web || pm2 start ecosystem.config.js) && pm2 save"

echo "✓ Bitti. İlk kurulumsa: sunucuda 'cp .env.example .env' deyip doldurmayı ve db/init.sql'i içeri almayı unutmayın."
