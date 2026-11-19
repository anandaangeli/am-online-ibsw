FROM nginx:alpine

# Salin konfigurasi kustom nginx reverse-proxy internal
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Salin source code Frontend (HTML, CSS, JS)
COPY index.html style.css script.js /usr/share/nginx/html/

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
