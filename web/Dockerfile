FROM httpd:2.4-buster

COPY ./vhosts/000-default.conf /usr/local/apache2/conf/000-default.conf
RUN echo "Include /usr/local/apache2/conf/000-default.conf" \
    >> /usr/local/apache2/conf/httpd.conf