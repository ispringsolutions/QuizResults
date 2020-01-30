FROM php:7.4-apache

# add source files
ADD ./classes /var/www/html/classes
ADD ./includes /var/www/html/includes

ADD index.php /var/www/html/index.php
# ADD info.php /var/www/html for debug purposes only
ADD QuizReport.xsd /var/www/html
ADD QuizReport_8.xsd /var/www/html

# add directories for quiz processing
ADD ./log /var/www/html/log
ADD ./result /var/www/html/result

# ensure all files&dirs have permissions of apache2 user
RUN chown -R www-data:www-data /var/www/html

# add php config
RUN mkdir -p /var/log/php
ADD docker/apache2/php.ini "$PHP_INI_DIR/php.ini"

# add custom directory config
ADD docker/apache2/result_dir.conf /etc/apache2/conf-available/result_dir.conf
RUN a2enconf result_dir.conf

WORKDIR /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]