ARG NGINX_VERSION=1.14

FROM nginx:${NGINX_VERSION}-alpine AS nginx

COPY ./conf.d/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /application
