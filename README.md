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

> El archivo `1_conexion.php` realiza los siguientes pasos:

1 **Definición de variables de entorno**

- Configura los datos básicos de conexión:

````php
   $servername = "localhost";
   $username = "root";
   $password = "";
````

2 **Creación de la conexión**

- Se establece la conexión con el servidor MySQL mediante la extensión MySQLi:

````php
$conn = new mysqli($servername, $username, $password);
````

3 **Verificación de conexión**

- Comprueba si la conexión se ha realizado correctamente.
- En caso de error, el programa finaliza mostrando el mensaje correspondiente:

````php
if($conn->connect_error)
    die("❌ Error de conexion: $conn->connect_error");
````

4 **Creación de la base de datos**

- Si la base de datos tareas_db no existe, se crea automáticamente:
- La función create_db() ejecuta dicha consulta y devuelve true o false según el resultado.

````php
$sql_db = "CREATE DATABASE IF NOT EXISTS tareas_db";>
````

5 **Mostrar mensaje de resultado**

- Se utiliza una función separada para mostrar mensajes al usuario, informando del éxito o fallo de la operación:

````php
function showMessageDB($created_db, $conn): void {
    if($created_db)
        echo "✅ Base de datos creada correctamente.\n";
    else
        echo "❌ ERROR: no se pudo realizar la operacion $conn->error\n";
}
````

6 **Selección de la base de datos**

- Finalmente, se selecciona la base de datos creada para continuar con el resto del proyecto:

````php
$conn->select_db("tareas_db");
````

**🧱 2_crear_db.php — Creación de la Tabla `tareas` (Tareas_APP)**

Este script PHP pertenece al proyecto **Tareas_APP**, y tiene como objetivo **crear la tabla principal `tareas`** dentro de la base de datos `tareas_db`, previamente creada con `1_conexion.php`.

El archivo `2_crear_db.php` realiza los siguientes pasos:

1 **Importar la conexión existente**

- Se reutiliza la conexión creada en 1_conexion.php para operar sobre la base de datos tareas_db.

````php
   require_once("1_conexion.php");
````

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

- La función create_table() ejecuta la consulta SQL:

````php
    function create_table($conn, $sql_table){
    if($conn->query($sql_table))
        return true;
    else
        return false;
}
````

4 **Comprobación del resultado**

- La función showMessageTable() muestra el mensaje adecuado:

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

**📝 3_crearTarea.php — Creación de nuevas tareas (Tareas_APP)**
Este script forma parte del proyecto `Tareas_APP`, una aplicación de gestión de tareas en PHP.
Su **objetivo** es **insertar nuevas tareas en la base de datos `tareas_db`**, usando **sentencias preparadas** para prevenir inyecciones SQL.

El archivo `3_crearTarea.php` define una función que **crea tareas** mediante una interacción por consola:

1 **Inclusión del archivo principal**

- El archivo includes.php contiene la conexión activa a la base de datos ($conn).

````php
    require_once("includes.php");
````

2 **Definición de la función createTask()**

- Parámetros:
- $titulo: título de la tarea (string).
- $descripcion: descripción corta (string).
- $fecha_caducidad: fecha límite (string en formato YYYY-MM-DD).
- Tipo devuelto: bool|mysqli_result (retorna true si la inserción fue exitosa).

````php
    function createTask($titulo, $descripcion, $fecha_caducidad): bool|mysqli_result {
        global $conn;
    }
````

3 **Preparación de la consulta (seguridad SQL) y enlace de parametros**

- Se usa una sentencia preparada para proteger la base de datos frente a ataques de inyección SQL
- "sss" indica que los tres valores son strings.
- Si alguno fuera numérico, se usaría "i" (integer), "d" (double) o "b" (blob).

````php
    $sql = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_caducidad) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $titulo, $descripcion, $fecha_caducidad);
````

4 **Entrada de datos desde consola**

- El programa solicita los valores al usuario directamente en la terminal.

````php
    echo "Título: ";
    $titulo = trim(fgets(STDIN));

    echo "Descripción: ";
    $descripcion = trim(fgets(STDIN));

    echo "Fecha (YYYY-MM-DD): ";
    $fecha_caducidad = trim(fgets(STDIN));
````

5 **Ejecución e informe del resultado**

- Se ejecuta la sentencia preparada y se muestra un mensaje de confirmación o error.

````php
    $result = $sql->execute();
    echo $result
        ? "✅  Tarea creada correctamente.\n"
        : "❌  ERROR: no se pudo crear la tarea.\n";
    $sql->close(); // Cierre de la conexion
````

**📋 4.1_leerTareas.php — Lectura y listado de tareas (Tareas_APP)**
El archivo `4.1_leerTareas.php` forma parte del proyecto `Tareas_APP`, una aplicación por consola desarrollada en PHP que implementa un sistema **CRUD** completo para la gestión de tareas.

Su **propósito** principal es **leer todas las tareas almacenadas en la base de datos tareas_db y mostrarlas** de forma ordenada en la consola.
Además, devuelve los resultados como un array asociativo, lo que permite reutilizar la información en otras partes del programa (por ejemplo, para exportar, buscar o filtrar tareas).

1 **Inclusión del archivo principal**

- Se importa el archivo includes.php, que contiene la conexión activa a la base de datos mediante la extensión MySQLi.

````php
    require_once("includes.php");
````

2 **Definición de la función readTask()**

- El uso de la palabra clave **global** permite acceder a la conexión **$conn** establecida previamente.

````php
    function readTask(){
        global $conn;
    }
````

3 **Ejecución de la consulta SQL**

- Se **seleccionan** todas las tareas almacenadas en la `tabla tareas`, ordenadas por su identificador **(id)** de manera ascendente.

````php
    $sql = $conn->query("SELECT * FROM tareas ORDER BY id ASC");
````

4 **Control de errores de consulta**

- Si la **consulta SQL falla**, se muestra un **mensaje** de error y la función devuelve un array vacío.
  
````php
    if(!$sql) {
        echo "❌  ERROR en la consulta $conn->error";
        return [];
    };
````

5 **Almacenamiento de resultados**

- Se **recorre** el resultado con fetch_assoc() para obtener cada fila como un **array asociativo** y se **guardan** todas las tareas en **$tasks**.
- Si la tabla `tareas` está vacía, se **informa** al usuario y se devuelve un array vacío.

````php
    while($row = $sql->fetch_assoc())
    $tasks[] = $row;

    if(empty($tasks)){
    echo "⚠️  No hay tareas registradas";
    return [];
}
````

6 **Visualización de resultados en consola**

- Usamos un foreach donde se **muestran las tareas** con formato visual claro, usando emojis para facilitar la lectura.

````php
    foreach($tasks as $task){
        echo "------------------------------\n";
        echo "🆔 Id: " . $task['id'] . "\n";
        echo "📌 Título: " . $task['titulo'] . "\n";
        echo "📝 Descripción: " . $task['descripcion'] . "\n";
        echo "📅 Fecha: " . $task['fecha_caducidad'] . "\n";
        echo "📊 Completada: " . $task['completada'] . "\n";
    }
````

7 **Retorno del resultado**

- Finalmente, la **función devuelve el array** completo de `tareas` para su posible reutilización.

````php
    return $tasks;
````

> Ejemplo de salida de consola:

````php
    ------------------------------
    🆔 Id: 1
    📌 Título: Estudiar PHP
    📝 Descripción: Repasar funciones y POO
    📅 Fecha: 2025-10-25
    📊 Completada: 0
    ------------------------------
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
