FROM nginx:alpine

LABEL maintainer="Levente-Balazs Molnar <levente.molnar91@gmail.com>"

RUN rm /etc/nginx/conf.d/default.conf
COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/service.conf /etc/nginx/conf.d/service.conf

EXPOSE 80
