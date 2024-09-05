## Crear las tablas y migrarlas la BBDD del contenedor teniendo en cuenta la imagen de las tablas y los siguientes comentarios:
- El nombre de usuario será único y no se podrá repetir. Ni el segundo apellido, la fecha de nacimiento, el peso o la altura, son necesarios
- Cuando se registra una ip nueva, el status por defecto será bloqueada (false), al igual que la ip debe ser única.
- Los roles de usuario tendrán un nombre único y por defecto status, admin y usuario serán false e invitado será true.
- En conexiones fin será opcional.
## Añadir mediante una Fixtures los siguientes datos:
- Crear un rol que llamaremos registrado, status:true, admin y usuario:false, invitado:true
- Crear un rol llamado bloqueado, status, admin, usuario e invitado:false
- Como usuario deberéis rellenar todos los datos posibles, el usuario tendrá un rol tipo registrado
## Crear un controlador para la ruta user
- Debe implementarse únicamente el método POST
- Devolveremos un código de estado 201 y con la fecha y el mensaje
- Deberá comprobarse que los datos son correctos, de forma que si salta un fallo deberemos recogerlo y devolver un código de error 5XX junto con la fecha, el mensaje y status:404
## Crear una ruta :\user\{id}
- Si lo recibimos por GET, mostraremos los datos de usuario
- Si lo recibimos por el método PUT o PATCH, recibiremos un JSON, con los datos que se quieran modificar
- Si lo recibimos por el método DELETE, cambiar el rol de usuario a bloqueado

