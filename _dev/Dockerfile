FROM wordpress:latest

RUN apt-get update && apt-get install -y vim

RUN curl "https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar" --output "/tmp/wp-cli.phar"
RUN php /tmp/wp-cli.phar --info
RUN chmod +x /tmp/wp-cli.phar
RUN mv /tmp/wp-cli.phar /usr/local/bin/wp