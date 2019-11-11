FROM php:7.3

COPY composer.json /app/
COPY Classes /app/Classes

RUN useradd -ms /bin/bash application

RUN apt-get update && \
  apt-get install -y sudo vim nano less git zip unzip && \
  usermod -aG sudo application && \
  echo "%sudo ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers && \
  curl -fsSL https://get.docker.com/ | sh && \
  rm -rf /var/lib/apt/lists/*

EXPOSE 80

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:80", "-t", ".", "index.php"]
