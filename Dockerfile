# Use the official PHP image
FROM php:8.2-apache

# Copy all project files into Apache web root
COPY . /var/www/html/

# Expose the port Render expects
EXPOSE 10000

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
