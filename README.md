# Sistema de Gestión de Tareas

## Requisitos

* PHP >= 8.1
* Composer
* MySQL o MariaDB
* Node.js >= 16.x
* npm o yarn
* Laravel CLI (`composer global require laravel/installer`)

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://tu-repo.git
cd tareas-backend
```

### 2. Configurar el entorno Laravel

```bash
cp .env.example .env
```

Editar `.env` con los datos correctos de tu base de datos:

```
DB_DATABASE=tareas
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

### 3. Instalar dependencias Laravel y generar clave

```bash
composer install
php artisan key:generate
php artisan migrate
```

### 4. Configurar Laravel Sanctum y CORS

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Modificar `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'supports_credentials' => true,
```

Modificar `config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost:5173,localhost:5174')),
```

### 5. Levantar servidor Laravel

```bash
php artisan serve
```

Por defecto corre en: [http://localhost:8000](http://localhost:8000)

---

## Configuración del Frontend (Vue 2)

### 6. Instalar dependencias del frontend

```bash
cd resources/frontend
npm install
```

### 7. Configurar Vite para conectarse con Laravel

Editar `vite.config.js`:

```js
server: {
  proxy: {
    '/api': 'http://localhost:8000',
    '/sanctum': 'http://localhost:8000'
  }
}
```

### 8. Levantar servidor frontend

```bash
npm run dev
```

Por defecto corre en: [http://localhost:5173](http://localhost:5173)

---

## Uso del sistema

1. Abrir [http://localhost:5173](http://localhost:5173)
2. Registrar un nuevo usuario
3. Iniciar sesión con el usuario registrado
4. Gestionar tareas (crear, ver, editar, eliminar) desde el dashboard

---

## Notas adicionales

* El panel de control incluye Sidebar fijo, Navbar superior y manejo de sesiones con Laravel Sanctum.
* CRUD completo de tareas implementado.

---
* Pagina de Login, registrarse
* ![image](https://github.com/user-attachments/assets/365cc341-38a7-408a-adf8-d0c120908610)
* ![image](https://github.com/user-attachments/assets/0273301c-9c16-4b49-93c4-8381c254d612)

* Panel principal, registro de tareas.
* ![image](https://github.com/user-attachments/assets/1a3c3754-7100-4e8f-bc99-b9148800f0aa)
* ![image](https://github.com/user-attachments/assets/2239590b-cdad-4246-b5ee-feacea7127b2)



---

Desarrollado con Laravel + Vue 2 + BootstrapVue


## base de datos [Uploadin-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2025 a las 19:28:03
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tareas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` text NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` enum('baja','media','alta') NOT NULL DEFAULT 'media',
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` enum('pendiente','completada') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `user_id`, `titulo`, `descripcion`, `prioridad`, `fecha_vencimiento`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, '', 'Terminar el informe mensual', 'alta', '2025-05-08', 'pendiente', '2025-05-07 16:24:13', '2025-05-07 16:24:13'),
(2, 1, '', 'Revisar correos pendientes', 'media', '2025-05-10', 'completada', '2025-05-07 16:24:13', '2025-05-07 16:24:13'),
(3, 1, '', 'Comprar materiales de oficina', 'baja', '2025-05-12', 'pendiente', '2025-05-07 16:24:13', '2025-05-07 16:24:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
g tareas.sql…]()


