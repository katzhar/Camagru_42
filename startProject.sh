docker run --name camagru_apache -d -p8080:80 -v ~/Desktop/CAM.A.GRU:/app webdevops/php-apache-dev
# прокинуть порты в VirtBOX
docker run --name camagru_db    -d -v camagru_db:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=camagru_db --restart on-failure:5 mysql:5 --default-authentication-plugin=mysql_native_password
docker run --name camagru_phpmyadmin -d --link camagru_db:db -p 8081:80 phpmyadmin/phpmyadmin