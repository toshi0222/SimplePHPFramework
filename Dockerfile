FROM php:8.2-apache

# Apacheのmod_rewrite有効化（.htaccess使用に必要）
RUN a2enmod rewrite

# .htaccessとアプリ本体をコピー
COPY apache/.htaccess /var/www/html/.htaccess
COPY src/ /var/www/html/

# 推奨：適切な権限設定（開発用途であれば緩めでOK）
RUN chown -R www-data:www-data /var/www/html

