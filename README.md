# Billing / Invoicing Web App

This is version 3 of the billing app built on Laravel 11.x and </> htmx.

### Quick installation directions...
To install, clone repo, then update composer, configure database, migrate, and configure your webserver.  

### Detailed installation...
1. Create a suitable directory for serving web content. for example:
```
sudo cd /var/www
sudo mkdir billing
sudo chown my_username:my_group billing
``` 
2. Clone the project inside that directory:
```
git clone git@github.com:drewbertola/billing_v3.git ./billing
```
3. cd in and fix up perms and selinux
```
cd ./billing
chcon -R -t httpd_sys_rw_content_t ./storage
find ./storage -type d | xargs chmod 777
find ./storage -type f | xargs chmod 666
```
4. While in the root director of the project, copy the .env.example file to .env.  Edit the fields starting with INVOICE_*.  These are used when generating your invoice PDFs.  Also, set up your database connection.
5. Update composer...
```
composer update
```
6. Generate the app key, clear the config cache, run migrations, and add your login (follow prompts):
```
php artisan key:generate
php artisan config:clear
php artisan migrate
php artisan app:register
```
7. Set up a DNS pointer to your configured ServerName
8. Configure your webserver and restart
9. Grab certificates from Letsencrypt
10. Re-configure your webserver for running SSL
11. Test from a browser
