// PM2 ile prod çalıştırma (Docker'sız).
// Sunucuda: pm2 start ecosystem.config.js && pm2 save
module.exports = {
  apps: [
    {
      name: 'mantarhane-web',
      script: 'php',
      args: '-d upload_max_filesize=8M -d post_max_size=9M -S 127.0.0.1:8090 -t app/public',
      cwd: __dirname,
      interpreter: 'none',
      autorestart: true,
      max_restarts: 10,
      env: {
        // PHP yerleşik sunucusuna paralel istek işleme (PHP 7.4+)
        PHP_CLI_SERVER_WORKERS: '8',
      },
    },
  ],
};
