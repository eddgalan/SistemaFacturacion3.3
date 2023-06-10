# Sistema Facturación 3.3
## Instalación
1.- Copiar la carpeta 'SistemaFacturacion3.3' a la ruta donde se muestran los archivos html del servidor ejemplo c:/xampp/htdocs/

2.- En el archivo 'index.php' se indica el hostname, en este caso es http://localhost/ + el nombre de la carpta que se encuentra en el 'htdocs', es decir: 'http://localhost/SistemaFacturacion3.3', si se cambia el nombre de la carpeta igual se debe cambiar el nombre del hostname que se indica en el 'index.php'.

3.- Ahora cree una base de datos y haga el import del archivo que se encuentra en la carpeta: SistemaFacturacion3.3/bd.

4.- Modifique el archivo 'SistemaFacturacion3.3/libs/conexion_db.php' con sus credenciales para su base de datos.

5.- Realizar un composer install.

6.- Abrir en el navegador la siguiente ruta: http://localhost/SistemaFacturacion3.3 y aparecerá el login. Ingresar con las siguientes credenciales:

- Usuario: Admin
- Contraseña: Vector123!

7.- Si ocurre un error al momento de intentar ingresar al sistema los logs se encuentra en la ruta 'SistemaFacturacion3/logs/'. **NOTA**: El log guarda todas las operaciones que se realizan no solo los errores.

8.- Al intentar timbrar el sistema mostrará un error como el siguiente en los logs debido a que el CFDI 3.3 ya no es válido, es necesario actualizar el XML a la versión 4.0 para poder timbrar: Error: Versión de CFDI No Vigente, es necesario migrar a la versión más reciente, dudas o asesoría al correo soporte@profact.com.mx
