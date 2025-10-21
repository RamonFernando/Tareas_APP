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

- Se importa el archivo includes.php, que contiene la **conexión** activa a la base de datos mediante la **extensión MySQLi**.

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

💻 **Ejemplo de salida de consola**

````php
    ------------------------------
    🆔 Id: 1
    📌 Título: Estudiar PHP
    📝 Descripción: Repasar funciones y POO
    📅 Fecha: 2025-10-25
    📊 Completada: 0
    ------------------------------
````

**🛠️ 4.2_actualizarTareas.php — Actualización de tareas (Tareas_APP)**
El archivo **4.2_actualizarTareas.php** forma parte del proyecto `Tareas_APP`, desarrollado en PHP como aplicación de consola para la gestión de tareas.
Su propósito es **actualizar los datos de una tarea existente** en la base de datos `tareas_db`, utilizando sentencias preparadas con MySQLi para garantizar la seguridad y evitar inyecciones SQL.

1 **Inclusión del archivo principal**

- Se importa el archivo includes.php, que contiene la **conexión** activa a la base de datos mediante la **extensión MySQLi**.

````php
    require_once("includes.php");
````

2 **Definición de la función updateTask()**

- Parámetro: $id → identificador de la tarea que se desea modificar.
- Tipo de retorno: **bool** → true si la actualización fue exitosa, false en caso contrario.

````php
    function updateTask($id){
        global $conn;
    
````

2.1 **Obtención de la tarea actual**

- Antes de modificar, se recuperan los datos originales mediante la función getTaskById($id).
- Esto permite mostrar los valores actuales al usuario para que decida cuáles cambiar.

````php
    $task = getTaskById($id);
    if(!$task) {
        echo "⚠️  No se encontro la tarea con Id $id";
        return false;
    }
````

2.2 **Entrada de datos por consola**

- El usuario puede dejar un campo vacío si no desea modificarlo.
- El programa tomará entonces el valor anterior por defecto.
- El mismo proceso se repite para descripción, fecha y estado de completada.

````php
    echo "Título actual:" . $task['titulo'] . "\nNuevo título: ";
    $titulo = trim(fgets(STDIN));
    if ($titulo === '') $titulo = $task['titulo'];
    echo "Descripción actual:" . $task['descripcion'] . "\nNueva descripción: ";
    $descripcion = trim(fgets(STDIN));
    if ($descripcion === '') $descripcion = $task['descripcion'];

    echo "Fecha actual: " . $task['fecha_caducidad'] . "\nNueva fecha (YYYY-MM-DD): ";
    $fecha = trim(fgets(STDIN));
    if ($fecha === '') $fecha = $task['fecha_caducidad'];

    echo "Completada actualmente (1 = sí✅, 0 = no❌): " . $task['completada'] . "\nNuevo valor (1 o 0): ";
    $completada_task = trim(fgets(STDIN));
    ($completada_task === '')
        ? $completada = $task['completada']
        : $completada = intval($completada_task);
````

2.3 **Confirmación antes de aplicar cambios**

- Por seguridad, el usuario debe confirmar si desea realizar la actualización:

````php
    echo "¿Estás seguro de que deseas actualizar la tarea con ID $id? (s/n): ";
    $answer = trim(fgets(STDIN));

    if (strtolower($answer) !== 's') {
        echo "❌ Actualización cancelada.\n";
        return false;
    }
````

2.4 **Ejecución de la sentencia SQL preparada**

- Se **actualizan** los campos de la tarea usando una sentencia preparada con **bind_param()** para evitar inyecciones SQL.

````php
    $sql = $conn->prepare("UPDATE tareas SET titulo = ?, descripcion = ?,
        fecha_caducidad = ?, completada = ? WHERE id = ?");
    $sql->bind_param("sssii", $titulo, $descripcion, $fecha, $completada, $id);
    $result = $sql->execute();
````

2.5 **Verificación del resultado**

- Se comprueba si la operación afectó alguna fila, mostrando el mensaje correspondiente.
- Finalmente, se cierra la consulta y se devuelve el resultado.
  
````php
    echo ($sql->affected_rows > 0)
    ? "✅  Actualización realizada correctamente\n"
    : "⚠️  No se encontró el id: ($id) o ha ocurrido un error al actualizar.\n";

    $sql->close();
    return $result;
````

**🗑️ 4.3_eliminarTarea.php — Eliminación de tareas (`Tareas_APP`)**
El archivo `4.3_eliminarTarea.php` forma parte del proyecto `Tareas_APP`, una aplicación de consola desarrollada en PHP que implementa un sistema **CRUD** completo sobre la base de datos `tareas_db`.
Su objetivo es **eliminar una tarea existente de la tabla `tareas`**, tras una confirmación por parte del usuario, utilizando sentencias preparadas (MySQLi) para garantizar la seguridad y evitar inyecciones SQL.

1 **Inclusión del archivo principal**

- Se importa el archivo includes.php, que contiene la **conexión** activa a la base de datos mediante la **extensión MySQLi**.

````php
    require_once("includes.php");
````

2 **Definición de la función deleteTask()**

- Parámetro: $id → identificador de la tarea que se desea eliminar.
- Tipo de retorno: **bool** → true si la tarea se elimina correctamente, false en caso contrario.

````php
    function deleteTask($id){
        global $conn;
````

2.1 **Verificación de la existencia de la tarea**

- Antes de intentar eliminar, el programa **comprueba que la tarea realmente exista** en la base de datos mediante la función getTaskById($id).
- Esto evita ejecutar una eliminación sobre un ID inexistente.

````php
    $task = getTaskById($id);
    if (!$task) {
        echo "⚠️  No se encontró la tarea con ID $id.\n";
        return false;
    }
````

2.2 **Confirmación del usuario**

- Por seguridad, el sistema **solicita confirmación** antes de proceder con la eliminación:
- De este modo, el usuario puede cancelar la operación **escribiendo** cualquier letra diferente de **“s”**.

````php
    echo "¿Estás seguro de que deseas eliminar la tarea con ID $id? (s/n): ";
    $answer = trim(fgets(STDIN));

    if (strtolower($answer) !== 's') {
        echo "❌  Eliminación cancelada.\n";
        return false;
    }
````

2.3 **Ejecución de la sentencia SQL preparada**

- Si el **usuario confirma**, se **ejecuta una sentencia preparada DELETE**, con un parámetro entero (i), para eliminar de forma segura la tarea indicada.
- El uso de prepare() y bind_param() asegura que el valor recibido se procese correctamente, previniendo inyección SQL.

````php
    $sql = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $sql->bind_param("i", $id);
    $result = $sql->execute();
````

2.4 **Verificación del resultado**

- Tras **ejecutar la consulta**, el sistema **informa** si la tarea fue eliminada correctamente o si no se encontró el registro.

````php
    echo ($sql->affected_rows > 0)
        ? "✅  Tarea eliminada correctamente\n"
        : "⚠️  Tarea no encontrada o ya eliminada\n";
````

2.5 **La conexión se cierra**

- La conexión preparada se cierra automaticamente después y se devuelve el resultado de la consulta.

````php
    $sql->close();
    return $result;
````

💻 **Ejemplo de ejecución en consola**

- Ejemplo en consola que muestra una consulta cuyo ID no se encontró.

````bash
    ¿Estás seguro de que deseas eliminar la tarea con ID 4? (s/n): n
    ❌  Eliminación cancelada.

    ⚠️  No se encontró la tarea con ID 99.
````

**🔍 4.4_buscarTareas.php — Búsqueda avanzada de tareas (Tareas_APP)**
El archivo **4.4_buscarTareas.php** pertenece al proyecto `Tareas_APP`, una aplicación desarrollada en PHP por consola que gestiona tareas mediante operaciones CRUD sobre una base de datos MySQL.
Su **función principal es buscar tareas según distintos criterios**, ofreciendo un menú interactivo en la terminal.
Esta funcionalidad amplía las capacidades del sistema permitiendo consultas dinámicas por:

- ID
- Título (búsqueda parcial con LIKE)
- Fecha de caducidad (por año, mes o día)
- Estado de completada o pendiente

1 **Inclusión del archivo principal**

- Se importa el archivo includes.php, que contiene la **conexión** activa a la base de datos mediante la **extensión MySQLi**.

````php
    require_once("includes.php");
````

2 **Definición de la función searchTask()**

- Esta función **despliega un menú interactivo** para que el usuario seleccione el tipo de búsqueda que desea realizar.

````php
    function searchTask() {
    global $conn;
````

3 **Menú principal del buscador**

- El usuario **introduce un número del 1 al 5** para seleccionar la operación deseada.

````php
    echo "\n=========================\n";
    echo " 🔍 BUSCADOR DE TAREAS\n";
    echo "=========================\n";
    echo "1. 🆔 Buscar por ID\n";
    echo "2. 📌 Buscar por Título\n";
    echo "3. 📅 Buscar por Fecha de caducidad\n";
    echo "4. 📊 Buscar por Estado (completada o no)\n";
    echo "5. ↩️  Volver al menú principal\n";
    echo "👉  Seleccione una opción: ";
````

🔸 **Caso 1: Buscar por ID**

- Permite **localizar una tarea** exacta a partir de su **identificador numérico (ID)**.
- El resultado se muestra mediante la función auxiliar displayData().

````php
    $id = intval(trim(fgets(STDIN)));
    $task = getTaskById($id);
    if ($task)
        displayData([$task]);
    else
        echo "\n⚠️  No se encontró ninguna tarea con el ID $id.\n";
````

🔸 **Caso 2: Buscar por título (LIKE)**

- Permite realizar una **búsqueda parcial del título**, sin distinguir mayúsculas/minúsculas, usando comodines SQL.
- La función likeParam() genera una cadena segura para búsquedas con LIKE.
- Se muestran los resultados y el número total de coincidencias.

````php
    function likeParam($param) {
        $param = trim($param);
        $param = addcslashes($param, '%_');
        $param = strtolower($param);
        return "%$param%";
    }

    $sql = $conn->prepare("SELECT * FROM tareas WHERE LOWER(titulo) LIKE ?");
    $param = likeParam($titulo);
    $sql->bind_param("s", $param);
````

🔸 **Caso 3: Buscar por fecha de caducidad**

- El programa admite tres formatos distintos de búsqueda:
| Formato introducido | Interpretación
| Ejemplo
| ----------- | -------------------------------------------------------- | ------------|
| `YYYY-MM-DD`| Muestra tareas con fecha anterior o igual a la ingresada |`2025-10-19` |
| `YYYY-MM`   | Muestra tareas con fecha dentro de ese mes               | `2025-10`   |
| `YYYY`      | Muestra tareas de todo ese año                           | `2025`      |
- El código detecta automáticamente el formato mediante expresiones regulares:
- Luego ejecuta la consulta correspondiente con prepare() y bind_param().

````php
    $fullDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha);
    $yearAndMonth = preg_match('/^\d{4}-\d{2}$/', $fecha);
    $yearDate = preg_match('/^\d{4}$/', $fecha);
````

🔸 **Caso 4: Buscar por estado (completada o no)**

- Permite filtrar tareas según su estado lógico:

1 → ✅ completada
0 → ❌ pendiente

- El resultado incluye el total de tareas encontradas según el filtro seleccionado.

````php
    echo "¿Desea ver tareas completadas (1)✅ o no completadas (0)❌?: ";
    $completada = trim(fgets(STDIN));

    $sql = $conn->prepare("SELECT * FROM tareas WHERE completada = ?");
    $sql->bind_param("i", $completada);
    $sql->execute();
````

🔸 **Caso 5: Volver al menú principal**

- Permite regresar al archivo index.php (menú principal del programa).

````php
    case 5:
        echo "↩️  Volviendo al menú principal...\n";
        return;
````

📋 **Función auxiliar displayData()**

- Para mantener coherencia visual con la función readTask(), displayData() **muestra los resultados** de forma organizada:

````php
    function displayData(array $tasks) {
        if (empty($tasks)) {
            echo "⚠️  No se encontraron tareas que coincidan con la búsqueda.\n";
            return;
        }

        echo "\n📋 Resultados encontrados:\n";
        foreach ($tasks as $task) {
            echo "------------------------------\n";
            echo "🆔 Id: " . $task['id'] . "\n";
            echo "📌 Título: " . $task['titulo'] . "\n";
            echo "📝 Descripción: " . $task['descripcion'] . "\n";
            echo "📅 Fecha: " . $task['fecha_caducidad'] . "\n";
            echo "📊 Completada: " . $task['completada'] . "\n";
        }
    }

````

💻 **Ejemplo de ejecución en consola**

- Mostramos el resultado de una busqueda.
  
````php
    =========================
    🔍 BUSCADOR DE TAREAS
    =========================
    1. 🆔 Buscar por ID
    2. 📌 Buscar por Título
    3. 📅 Buscar por Fecha de caducidad
    4. 📊 Buscar por Estado (completada o no)
    5. ↩️  Volver al menú principal
    👉  Seleccione una opción: 2
    Ingrese el título o parte del título: PHP
    📋 Resultados encontrados:
    ------------------------------
    🆔 Id: 1
    📌 Título: Estudiar PHP
    📝 Descripción: Repasar funciones y POO
    📅 Fecha: 2025-10-25
    📊 Completada: 0

    ✅ Se han encontrado 1 coincidencias.
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
