FROM ocasta/docker-nginx-hhvm-4wp
MAINTAINER Ocasta Studios

ADD ["public_html", "/var/www/public_html"]
ADD ["plugins", "/var/www/plugins"]

WORKDIR /var/www/public_html
RUN composer update

ENTRYPOINT ["supervisord"]
CMD ["--configuration=/etc/supervisor.conf"]
