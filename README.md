# Gamified Calorie Tracker

A modern, gamified calorie tracking web application built with Laravel. It helps users track their daily food intake against personalized calorie targets and motivates them with a beautifully designed, responsive, and interactive "Quest Board" dashboard.

## ✨ Features
- **Gamified Dashboard:** Visual progress circles and engaging alerts when approaching or exceeding daily limits.
- **Meal Breakdown:** Categorize food logs by Breakfast, Lunch, Dinner, and Snacks.
- **Historical Progress:** Easily track your performance over the past few days.
- **Responsive UI:** Built with Tailwind CSS, ensuring it looks amazing on any device.

## 🚀 Local Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/ccomp_calorie.git
   cd ccomp_calorie
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies and build assets:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Make sure to configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.*

5. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Serve the application:**
   ```bash
   php artisan serve
   ```

## 🌍 Ubuntu Server Deployment Guide (Nginx + OpenSSH)

Follow these steps to deploy this application to a production Ubuntu server. Ensure you have root or `sudo` access to the server via SSH.

### 1. SSH into your Server
Access your Ubuntu server using OpenSSH:
```bash
ssh username@<YOUR_SERVER_IP>
```

### 2. Install Required Server Packages
Install Nginx, PHP 8.2 (or your preferred version), Composer, Node.js, and Git.
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install nginx git curl unzip -y
sudo apt install php-fpm php-mysql php-mbstring php-xml php-bcmath php-curl php-zip -y

# Install Node.js (for compiling frontend assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 3. Clone the Repository
Navigate to the web root and clone your project:
```bash
cd /var/www/
sudo git clone https://github.com/yourusername/ccomp_calorie.git
cd ccomp_calorie
```

### 4. Install and Configure MySQL
Install the MySQL server:
```bash
sudo apt update
sudo apt install mysql-server -y
```

Access MySQL (using `sudo mysql`) and run the following commands to create your database and user:
```sql
CREATE DATABASE ccomp_calorie2;
CREATE USER 'admin_user'@'localhost' IDENTIFIED BY 'Boy@123';
GRANT ALL PRIVILEGES ON ccomp_calorie2.* TO 'admin_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5. Setup Laravel Environment
```bash
sudo cp .env.example .env
# Edit .env, set APP_ENV=production, APP_DEBUG=false, and update your DB credentials to match the ones created above:
# DB_DATABASE=ccomp_calorie2
# DB_USERNAME=admin_user
# DB_PASSWORD=Boy@123
sudo nano .env

# Install Dependencies
sudo composer install --optimize-autoloader --no-dev
sudo npm install
sudo npm run build

# Generate App Key and Migrate DB
sudo php artisan key:generate
sudo php artisan migrate --force
```

### 6. Set Directory Permissions
Laravel needs write access to the `storage` and `bootstrap/cache` directories.
```bash
sudo chown -R www-data:www-data /var/www/ccomp_calorie
sudo find /var/www/ccomp_calorie -type f -exec chmod 644 {} \;
sudo find /var/www/ccomp_calorie -type d -exec chmod 755 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```

### 7. Configure Nginx
Create a new Nginx server block configuration for the application.
```bash
sudo nano /etc/nginx/sites-available/ccomp_calorie
```

Paste the following configuration (replace `<YOUR_SERVER_IP>` with your actual server IP):
```nginx
server {
    listen 80;
    server_name <YOUR_SERVER_IP>;
    root /var/www/ccomp_calorie/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
*Note: Check your PHP-FPM version in the `fastcgi_pass` directive if you are using a different PHP version. You can verify the exact socket name by running `ls -la /var/run/php/` and looking for the `.sock` file (e.g., `php8.2-fpm.sock`).*

Enable the configuration and restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/ccomp_calorie /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

Your app is now live at `http://<YOUR_SERVER_IP>`.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
