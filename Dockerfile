# Utiliza a imagem oficial do php + apache
FROM php:8.3-apache

# Seleciona o diretorio atual de trabalho dentro do container
WORKDIR /var/www/html

# Copia a raiz do projeto pra dentro do container, no path do WORKDIR
COPY . .

# Atualizacao de repositorios de pacote da imagem do php utilizada + instalacao de prerequisitos iniciais git e zip
RUN apt update && apt upgrade -y && apt install git zip -y

# Instalando composer via curl, colocando o script executavel no PATH do sistema
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalando extensoes PHP requeridas
RUN docker-php-ext-install pdo_mysql

# Alterando o DocumentRoot do vhost padrao do apache para a pasta public do projeto
RUN sed -i 's/html/html\/public/g' /etc/apache2/sites-enabled/000-default.conf

# Aplicando permissoes requeridas na pasta storage
RUN chown -R www-data:www-data ./storage/

# Composer install
RUN composer install

# Habilitando requisto mod_rewrite do apache
RUN a2enmod rewrite

# Restart do apache para pegar configuracoes de DocumentRoot
RUN service apache2 restart