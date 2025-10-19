# 🧩 Tareas_APP (Aplicación de Consola en PHP con MySQLi)

Proyecto desarrollado en **PHP** utilizando la extensión **MySQLi**, como parte del módulo **Entorno Servidor** del ciclo formativo **Desarrollo de Aplicaciones Web (DAW)**.

La aplicación permite gestionar tareas (crear, listar, actualizar y eliminar) desde la **línea de comandos**, conectándose a una base de datos **MySQL** ejecutada con **XAMPP** y administrada mediante **MySQL Workbench**.

---

## 🧠 Descripción general

**Tareas_APP** es un programa por consola en PHP que implementa un sistema **CRUD completo** (Create, Read, Update, Delete).
Todas las operaciones se realizan mediante el terminal, sin uso de HTML ni interfaz web.

El objetivo es practicar la **programación en PHP del lado del servidor** y la **gestión de bases de datos** con MySQL, reforzando los contenidos del módulo **Entorno Servidor**.

---

## 🚀 Funcionalidades principales

- ➕ **Crear tarea:** Solicita los datos y los inserta en la base de datos.
- 📋 **Listar tareas:** Muestra todas las tareas almacenadas.
- 📝 **Actualizar tarea:** Permite modificar el título, descripción o prioridad.
- ❌ **Eliminar tarea:** Borra una tarea seleccionada por su ID.
- 🧱 **Crear base de datos y tablas:** Scripts automáticos para inicializar la estructura.

---

## ⚙️ Tecnologías utilizadas

| Tecnología | Descripción |
|-------------|-------------|
| **PHP 8+** | Lenguaje de programación principal |
| **MySQL / MariaDB** | Base de datos relacional |
| **MySQLi** | Extensión PHP para la conexión a MySQL |
| **MySQL Workbench** | Herramienta visual de administración de bases de datos |
| **XAMPP (Apache + MySQL)** | Entorno local de desarrollo |
| **CLI (Command Line Interface)** | Interfaz de usuario en consola |

---

📂 Estructura del proyecto
Tareas_APP/
│
├── 1_conexion.php             # Conexión a la base de datos (MySQLi)
├── 2_crear_tabla.php          # Script para crear la tabla principal
├── 3_crear_db.php             # Script para crear la base de datos
│
├── 4_crearTarea.php           # Crear nueva tarea (CREATE)
├── 4.1_leerTareas.php         # Mostrar todas las tareas (READ)
├── 4.2_actualizarTarea.php    # Modificar tarea existente (UPDATE)
├── 4.3_eliminarTarea.php      # Eliminar tarea por ID (DELETE)
│
└── index.php                  # Menú principal de la aplicación

## ⚙️ Instalación y configuración

1️⃣ Requisitos previos
> Tener instalado **XAMPP** (para Apache y MySQL).
> Tener instalado **MySQL Workbench** (para gestionar la base de datos).
> PHP versión **8.0 o superior** añadida al **PATH del sistema** (para ejecutar `php` en terminal).

---

2️⃣ Clonar el repositorio
bash
git clone https://github.com/RamonFernando/Tareas_APP.git

3️⃣ Iniciar servicios en XAMPP
Abre el panel de control de XAMPP y activa:
✅ **Apache**
✅ **MySQL**

---

4️⃣ Crear la base de datos
Desde la terminal, dentro de la carpeta del proyecto, ejecuta:
-- bash --
php 3_crear_db.php
php 2_crear_tabla.php

También puedes comprobar los resultados en **MySQL Workbench**.
Debería aparecer una base de datos llamada `tareas_db` con su tabla correspondiente.

---

5️⃣ Configurar la conexión
Edita el archivo `1_conexion.php` y asegúrate de tener tus credenciales correctas:

```php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "tareas_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
```

---

6️⃣ Ejecutar la aplicación
En la terminal, dentro del proyecto, escribe:
-- bash --
php index.php

Aparecerá un menú como este:

==========================
   GESTIÓN DE TAREAS PHP
==========================

1. Crear tarea
2. Leer tareas
3. Actualizar tarea
4. Eliminar tarea
5. Buscar tarea
6. Salir

---

## 💾 Ejemplo de uso

Seleccione una opción: 1
Introduce el título de la tarea: Estudiar PHP
Introduce la Descripcion: Tarea de PHP
Introduce la Fecha: 2025-10-19
Completada : 1 si / 0 no
Tarea creada correctamente.

- Seleccione una opción: 2
ID | Título        | Descripcion | Fecha | Completada
-----------------------------------------------------
1  | Estudiar PHP  | Tarea de PHP| 2025-10-19 | 1

---

## 🧱 Estructura de la base de datos

**Base de datos:** `tareas_db`
**Tabla:** `tareas`

| Campo | Tipo | Descripción | Completada |
|--------|------|-------------|
| id | INT (AUTO_INCREMENT) | PRYMARY KEY |
| titulo | VARCHAR(100) | Título de la tarea |
| descripcion | VARCHAR(255) | Descripción o detalle |
| fecha_creacion | DATE | Fecha |
| completada | BOOLEAN |

---

## 🛡️ Buenas prácticas aplicadas

- Uso de **MySQLi** para la conexión y consultas a la base de datos.
- Código estructurado en archivos separados por funcionalidad (CRUD).
- Conexión centralizada (`1_conexion.php`) para evitar duplicación.
- Menú principal claro e intuitivo por consola.
- Scripts automáticos para crear la base de datos y tabla.
- Comentarios en el código explicando el propósito de cada sección.
- Gestión de errores en la conexión y operaciones con la base de datos.

---

## 🔧 Mejoras futuras

- Implementar **sentencias preparadas** con MySQLi para mejorar la seguridad.
- Añadir validaciones de entrada en las operaciones de CRUD.
- Colorear el texto en consola para mejorar la interfaz.
- Exportar las tareas a **CSV** o **JSON**.
- Incorporar un sistema de **usuarios y autenticación**.
- Añadir un contador o estadísticas de tareas completadas.

---

## 📘 Evaluación académica

Este proyecto demuestra los conocimientos fundamentales del módulo **Entorno Servidor**, cumpliendo los criterios de evaluación establecidos en el currículo oficial del ciclo **Desarrollo de Aplicaciones Web (DAW)**:

| Criterio | Descripción |
|-----------|-------------|
| **C1.1** | Configura el entorno de desarrollo del servidor (XAMPP, MySQL Workbench). |
| **C1.2** | Utiliza correctamente el intérprete de comandos PHP. |
| **C2.1** | Implementa operaciones de acceso a bases de datos mediante PHP (MySQLi). |
| **C2.2** | Manipula información en una base de datos usando sentencias SQL (INSERT, SELECT, UPDATE, DELETE). |
| **C3.1** | Estructura el código en módulos y archivos reutilizables. |
| **C3.2** | Gestiona errores y valida resultados de conexión o consulta. |
| **C4.1** | Aplica buenas prácticas de programación y comenta adecuadamente el código. |
| **C4.2** | Desarrolla una aplicación funcional de servidor con persistencia de datos. |

✅ **Competencias demostradas:**

- Manejo de bases de datos con PHP.
- Uso de conexiones persistentes con MySQLi.
- Estructura modular y organizada.
- Aplicación funcional y ejecutable desde la consola.
- Capacidad de ampliación y mejora.

---

## 📜 Autor

**Ramon Fernando**
Proyecto del módulo **Entorno Servidor**
Ciclo Formativo de Grado Superior en **Desarrollo de Aplicaciones Web (DAW)**

🔗 [Repositorio en GitHub](https://github.com/RamonFernando/Tareas_APP)
