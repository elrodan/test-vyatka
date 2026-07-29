# Тестовое задание

Интернет-каталог товаров с фильтрацией, пагинацией, блогом и адаптивным дизайном.
Стек: **Laravel 13**, **PHP 8.4**, **MySQL**, **Tailwind CSS**, **Alpine.js**.

## 📋 Требования

Для запуска проекта локально понадобятся:
- [Docker](https://www.docker.com/) и [Docker Compose](https://docs.docker.com/compose/)
- Git

## 🚀 Быстрый старт

Выполни эти команды по очереди в терминале:

### 1. Клонируй репозиторий
```bash
git clone https://github.com/elrodan/test-vyatka.git
cd <имя-папки-проекта>
```

### 2. Настрой окружение
Скопируй файл конфигурации и при необходимости отредактируй его (для стандартного Docker-окружения обычно ничего менять не нужно):

```bash
cp .env.example .env
```

### 3. Запусти контейнеры

```bash
docker-compose up -d --build
```

### 4. Установи зависимости PHP

```bash
docker-compose exec app composer install
```

### 5. Сгенерируй ключ приложения

```bash
docker-compose exec app php artisan key:generate
```

### 6. Миграции и сиды

База данных заполняется тестовыми данными (категории, товары, атрибуты, новости), которые необходимы для корректного отображения фильтров и пагинации:

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

Сайт откроется по адресу http://localhost:8080
