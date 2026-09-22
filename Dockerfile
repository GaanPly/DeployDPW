FROM php:8.2-apache

# Extension yang dibutuhkan untuk koneksi PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html/

# Render kasih tau port lewat env $PORT saat container jalan (bukan saat build),
# jadi port di-set di entrypoint, bukan di-bake ke image.
RUN printf '#!/bin/sh\nset -e\nPORT="${PORT:-80}"\nsed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf\nsed -i "s/:80/:$PORT/" /etc/apache2/sites-available/000-default.conf\nexec apache2-foreground\n' > /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

EXPOSE 80
CMD ["/usr/local/bin/start-apache.sh"]
