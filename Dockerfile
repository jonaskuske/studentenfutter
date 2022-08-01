FROM node:16.13.2-alpine as build
WORKDIR /usr/src/app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run css:build

FROM webdevops/php-nginx:8.1-alpine
COPY nginx.conf 10-php.conf /opt/docker/etc/nginx/vhost.common.d/
COPY --chown=1000:1000 src /app
COPY --chown=1000:1000 --from=build /usr/src/app/src/assets/css/tailwind.min.css /app/assets/css/tailwind.min.css
