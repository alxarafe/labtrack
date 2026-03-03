# Manual de funcionamiento de la aplicación original.

Tras hacer login con un usuario administrador, se habilita un menú superior con las siguientes opciones:
- Configuración: /configuracion
- Supervisión: /supervision
- Informes: /informes
- Usuario: /auth/edit/<usuario>

La aplicación está pensada para utilizarse en una tablet u ordenador con pantalla táctil, ya que la usan los operarios de un laboratorio para registrar el trabajo realizado.

El operario tiene un pin (que bien podría ser una tarjeta con un código), y tras introducirlo (no tiene más verificación de seguridad), permite inforamar del trabajo realizado.

La mayoría de pantallas están pensadas para trabajar de ese modo, así que tienen botones grandes, preferiblemente cuadrados antes que alargados para que sean fáciles y rápidos de pulsar sin tener que hacer malabares.

## Configuración

Configuración presenta 6 botones: 5 botones de acción en azul y 1 botón rojo para salir de la opción de configuración.

- Usuarios: /configuracion/usuarios
- Centros de costes: /configuracion/centros
- Familias: /configuracion/familias
- Procesos: /configuracion/procesos
- Secuencias: /configuracion/secuencias
- Salir: /

Cada apartartado de los citados tiene un listado de opciones y 3 botones:

- Nueva línea.
- Aceptar.
- Cancelar.

### Configuración de usuarios

Permite definir usuarios para el laboratorio. Un usuario tiene un pin y un nombre. Se puede marcar como administrador, supervisor o desactivado.

### Gestión de centros de costes

Permite definir los centros de costes para poder sacar estadísticas de las tareas. Permite definir un orden, un nombre, el texto que aparece en el botón del centro de coste y si está desactivado.

### Gestión de familias

Permite definir las familias de los procesos. Permite definir un orden, el centro de coste asociado, un nombre y un texto para el botón de familia, y por último si está desactivado.

### Gestión de procesos

Permite definir los procesos que se realizan y facturan en el laboratorio. Permite definir un orden, un botón que nos permite seleccionar las familias a las que está asociado el proceso (/configuracion/procesos/<id_familia>), un nombre y un texto para el botón, y por último si el proceso está o no desactivado.

### Gestión de secuencias

Permite definir las secuencias que componen cada proceso. Permite definir un orden, un botón que nos permite seleccionar los procesos a los que está asociada la secuencia (/configuracion/secuencias/<id_proceso>), un nombre y un texto para el botón, Los minutos que por defecto lleva el proceso, si se pueden editar o es un tiempo fijo y predeterminado y por último si la secuencia está o no desactivada.

## Supervisión

El proceso de supervisión, muestra un listado de las secuencias introducidas por los operarios que no están supervisadas, permitiendo validarlas por un supervisor.

Dicho listado muestra los siguientes campos:
- Órden y operario
- Secuencia
- Observaciones (Si existe aparece un icono informativo y la podemos leer al colocar el cursor sobre él)
- Unidades de secuencia
- ID del operario
- Fecha y hora
- Minutos de duracion de la secuencia
- Si la secuencia es una repetición de otra que no finalizó satisfatoriamente
- ID del supervisor (0 para las no supervisadas aún)
- Botón de validar

Al pulsar sobre validar, la secuencia desaparece automáticamente del listado y pasa al estado de validada.

Clicando sobre una secuencia, se permite ver la orden completa:

- /ordenes/index/<p1>/<p2>/<p3>/<p4>/<p5>/<p6>

**Pendiente de revisar lo que es cada parámetro**

Cuando un supervisor visualiza una orden, en la lista de secuencias tiene un checkbox para las no supervisadas, pudiéndolas supervisar las pendientes de una vez marcando el checkbox.

## Informes

Pemite obtener informes:

- Usuarios: Informe de productividad por usuarios de fecha a fecha
- Orden: Listado de secuencias de una orden de trabajo

## Usuario

Al clicar sobre el nombre del usuario activo, se permite editar el nombre de usuario, el correo electrónico, aplicarle un código de acceso rápido o cambiar la contraseña.

## Inicio

Permite introducir una orden.

Se introduce el código de la orden y se pulsa intro.
También se puede pulsar en el botón "Editar" para cambiar el nombre del cliente asociado a la orden.

Vea el apartado de zona pública para más información sobre el proceso de creación de una orden.

# Zona pública

Cuando no hay ningún usuario identificado, la tablet muestra un campo para introducir el código del usuario (PIN) que permite acceder a la "zona privada". No existe autenticación. Si se desea mayor seguridad, lo suyo es utilizar un código largo y establecerlo en una tarjeta que el usuario tenga que pasar para poder registrar su trabajo.

*La aplicación requiere un código numérico, pero se puede cambiar para que acepte un UUID o alfanumérico*

Tras introducir un PIN válido y pulsar intro, se pedirá el número de orden (igual que lo indicado en el anterior apartado de *Inicio*), sólo que en este caso, no se permitirá editar la orden.

Al introducir una orden, si no existe, nos pedirá el nombre del cliente.

El proceso de creación de una orden es muy sencillo. Tras introducir la orden aparecen una serie de botones. Tras ir pulsando en cada uno de ellos se va avanzando en el proceso:

- Botones con los centros de costo. Hay que seleccionar uno, o cancelar el proceso.
- Botones con las familias del centro de costo seleccionado. Hay que seleccionar uno, o cancelar el proceso.
- Botones con los procesos de la familia seleccionada. Hay que seleccionar una, o cancelar el proceso.
- Botones con las secuencias del proceso seleccionado. Hay que seleccionar uno, o cancelar el proceso.

Conforme se va avanzando, va quedando un registro de lo seleccionado con un botón indicando lo que ha seleccionado. Si clicamos en uno de esos botones, se retrocede hasta ese punto por si nos hemos equivocado en la selección.

Una vez seleccionado todo, nos pide cantidad, si la secuencia está repetida, si es un fallo interno, posibles observaciones de la secuencia y dos botones **aceptar** y **aceptar y repetir**.

Si clicamos en aceptar volvemos a la solicitud de un centro de costo para añadir una nueva secuencia.
Si clicamos en aceptar y repetir, nos pide duplicar la secuenca en otra orden.

En cualquier momento, podemos editar una secuencia clicando sobre ella. En ese momento podemos duplicarla con facilidad en otra orden distinta.