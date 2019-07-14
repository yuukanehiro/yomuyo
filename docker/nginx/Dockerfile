FROM nginx:latest

ADD ./docker/nginx/site.conf /etc/nginx/conf.d/default.conf
ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

