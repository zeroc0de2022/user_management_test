## User Management API

Проект выполнен в качестве [https://github.com/zeroc0de2022/user_management_test/blob/main/task.md](тестового задания) и представляет собой REST API для управления пользователями, созданный с использованием фреймворка Laravel. API предоставляет возможности для получения списка пользователей,
создания, обновления и удаления пользователей.
 
---

## Требования

- PHP 8.0
- MySQL 8
- Composer
- NGINX (или другой веб-сервер)

---

## Установка

### 1. Клонируйте репозиторий:
```bash
git clone https://github.com/zeroc0de2022/user_management_test.git
cd user_management_test
```

### 2. Установите зависимости:

```bash
composer install
```

### 3. Настройте окружение:

- Скопируйте файл .env.example и переименуйте его в .env:

   ```bash
   cp .env.example .env
   ```
- Настройте подключение к базе данных в файле `.env`:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```

### 4. Сгенерируйте ключ приложения:

```bash
php artisan key:generate
```

### Выполните миграции и сидер:

```bash
php article migrate --seed
```

### Запустите сервер:

```bash
php article serve
```

---

## API Endpoints

### Получение списка пользователей
- **URL**: `/api/users`
- **Метод**: `GET`
- **Параметры**:
    - name (опционально): Поиск по имени.
    - sort (опционально): Сортировка по полю (например, `name`).
    - order (опционально): Направление сортировки (`asc` или `desc`).
- **Пример запроса**:
  ```
  GET https://site.loc/api/users?name=john&sort=name&order=desc
  ```
- **Пример ответа**:
  ```json
  {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "ip": "192.168.1.1",
            "comment": "Test user",
            "created_at": "2023-10-25T12:34:56.000000Z",
            "updated_at": "2023-10-25T12:34:56.000000Z"
        }
    ],
    "first_page_url": "http://site.loc/api/users?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://site.loc/api/users?page=1",
    "next_page_url": null,
    "path": "http://site.loc/api/users",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
  }
  ```

### Получение данных пользователя
- **URL**:  `/api/users/{id}`
- **Метод**:  `GET`
- **Пример запроса**:
```
  GET https://site.loc/api/users/1
```
-**Пример ответа**:
  ```json
  {
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "ip": "192.168.1.1",
  "comment": "Test user",
  "created_at": "2023-10-25T12:34:56.000000Z",
  "updated_at": "2023-10-25T12:34:56.000000Z"
  }
  ```

### Создание пользователя
- **URL**: `/api/users`
- **Метод**: `POST`
- **Тело запроса**:
  ```json
  {
  "name": "Jane Smith",
  "email": "jane@smith.com",
  "password": "password",
  "ip": "192.168.1.2",
  "comment": "Another test user"
  }
  ```
- ### Пример ответа:
  ```json
  {
  "id": 2,
  "name": "Jane Smith",
  "email": "jane@smith.com",
  "ip": "192.168.1.2",
  "comment": "Another test user",
  "created_at": "2023-10-25T12:35:00.000000Z",
  "updated_at": "2023-10-25T12:35:00.000000Z"
  }
  ```

### Обновление пользователя**
 - **URL**: `/api/users/{id}`
 - **Метод**: `PUT`
 - **Тело запроса**:
  ```json
{
  "name": "Jane Updated",
  "email": "jane_updated@example.com",
  "password": "newpassword",
  "ip": "192.168.1.3",
  "comment": "Updated comment"
  }
  ```
-**Пример ответа**:
  ```json
  {
  "id": 2,
  "name": "Jane Updated",
  "email": "jane_updated@example.com",
  "ip": "192.168.1.3",
  "comment": "Updated comment",
  "created_at": "2023-10-25T12:35:00.000000Z",
  "updated_at": "2023-10-25T12:36:00.000000Z"
  }
  ```

### Удаление пользователя
- **URL**: `/api/users/{id}`
- **Метод**: `DELETE`
- **Пример запроса**:
  ```
  DELETE https://userman.lo/api/users/2
  ```
- **Пример ответа**:
  ```json
  {
  "message": "User deleted"
  }
  ```
