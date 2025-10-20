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

````bash
git clone https://github.com/RamonFernando/Tareas_APP.git
````

3️⃣ Iniciar servicios en XAMPP
Abre el panel de control de XAMPP y activa:
✅ **Apache**
✅ **MySQL**

4️⃣ Ejecución
> Abre el Visual Estudio Code 💠
> Busca los 3 puntos en la parte superior de la izquierda ⋯
> Señala "Nueva terminal"
> Dentro de la consola escribe: cd y la direccion del proyecto. 🗂️
    Ej: cd C:\Users\Ramon\Ramon Dropbox\Ramon Perez\PC\Desktop\Tareas_APP
> Una vez dentro escribe php index.php y te saldra el menú principal
    Ej:

````bash
    C:\Users\Ramon\Ramon Dropbox\Ramon Perez\PC\Desktop\Tareas_APP>php index.php
    ✅ Base de datos creada correctamente.

    =========================
    📋 GESTOR DE TAREAS
    =========================
    1. 📜  Listar tareas
    2. ✏️   Crear nueva tarea
    3. 🛠️   Editar tarea
    4. 🗑️   Eliminar tarea
    5. 🔍  Buscar tarea
    6. 🚪  Salir
    👉  Seleccione una opción:

````

## ⚙️ Descripción mas detallada

A continuacion explicacion del proyecto archivo por archivo.

**🗄️ 1_conexion.php — Conexión y Creación de Base de Datos (Tareas_APP)**
Este script PHP forma parte del proyecto **Tareas_APP**, una aplicación de gestión de tareas desarrollada en PHP como práctica del módulo **Entorno Servidor (DAW)**.
Su función principal es **establecer la conexión con MySQL** y **crear la base de datos `tareas_db`** si aún no existe.

---

El archivo `1_conexion.php` realiza los siguientes pasos:

1 **Definición de variables de entorno**
   Configura los datos básicos de conexión:

````php
   $servername = "localhost";
   $username = "root";
   $password = "";
````

2 **Creación de la conexión**
Se establece la conexión con el servidor MySQL mediante la extensión MySQLi:

````php
$conn = new mysqli($servername, $username, $password);
````

3 **Verificación de conexión**
Comprueba si la conexión se ha realizado correctamente.
En caso de error, el programa finaliza mostrando el mensaje correspondiente:

````php
if($conn->connect_error)
    die("❌ Error de conexion: $conn->connect_error");
````

4 **Creación de la base de datos**
Si la base de datos tareas_db no existe, se crea automáticamente:

````php
$sql_db = "CREATE DATABASE IF NOT EXISTS tareas_db";>
````

La función create_db() ejecuta dicha consulta y devuelve true o false según el resultado.

5 **Mostrar mensaje de resultado**
Se utiliza una función separada para mostrar mensajes al usuario, informando del éxito o fallo de la operación:

````php
function showMessageDB($created_db, $conn): void {
    if($created_db)
        echo "✅ Base de datos creada correctamente.\n";
    else
        echo "❌ ERROR: no se pudo realizar la operacion $conn->error\n";
}
````

6 **Selección de la base de datos**
Finalmente, se selecciona la base de datos creada para continuar con el resto del proyecto:

````php
$conn->select_db("tareas_db");
````

**🧱 2_crear_db.php — Creación de la Tabla `tareas` (Tareas_APP)**

Este script PHP pertenece al proyecto **Tareas_APP**, y tiene como objetivo **crear la tabla principal `tareas`** dentro de la base de datos `tareas_db`, previamente creada con `1_conexion.php`.

El archivo `2_crear_db.php` realiza los siguientes pasos:

1 **Importar la conexión existente**

````php
   require_once("1_conexion.php");
````

Se reutiliza la conexión creada en 1_conexion.php para operar sobre la base de datos tareas_db.

2 **Definición de la tabla tareas**

````php
    $sql_table = "CREATE TABLE IF NOT EXISTS tareas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(100) NOT NULL,
        descripcion VARCHAR(255),
        fecha_caducidad DATE,
        completada BOOLEAN DEFAULT FALSE
    )";
````

- id: Clave primaria autoincremental.
- titulo: Texto obligatorio (hasta 100 caracteres).
- descripcion: Texto opcional (hasta 255 caracteres).
- fecha_caducidad: Fecha límite de la tarea.
- completada: Valor booleano (TRUE o FALSE) por defecto en FALSE.

3 **Creación de la tabla**
La función create_table() ejecuta la consulta SQL:

````php
    function create_table($conn, $sql_table){
    if($conn->query($sql_table))
        return true;
    else
        return false;
}
````

4 **Comprobación del resultado**
La función showMessageTable() muestra el mensaje adecuado:

````php
    function showMessageTable($create_table, $conn){
    if($create_table)
        echo "✅ Tabla creada correctamente.\n";
    else
        echo "❌ ERROR: no se pudo realizar la operacion $conn->error \n";
}
````

5 **Cierre de conexión**

````php
    $conn->close();
````

## 🛡️ Buenas prácticas aplicadas

- Uso de **MySQLi** para la conexión y consultas a la base de datos.
- Código estructurado en archivos separados por funcionalidad (CRUD).
- Conexión centralizada (`1_conexion.php`) para evitar duplicación.
- Menú principal claro e intuitivo por consola.
- Scripts automáticos para crear la base de datos y tabla.
- Comentarios en el código explicando el propósito de cada sección.
- Gestión de errores en la conexión y operaciones con la base de datos.

---

## 🔧 Como se podría mejorar

- Implementar **sentencias preparadas** con MySQLi para mejorar la seguridad.
- Añadir validaciones de entrada en las operaciones de CRUD.
- Colorear el texto en consola para mejorar la interfaz.
- Exportar las tareas a **CSV** o **JSON**.
- Incorporar un sistema de **usuarios y autenticación**.
- Añadir un contador o estadísticas de tareas completadas.
- Agregar una interfaz gráfica mas profesional como por ejemplo un index.html

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
