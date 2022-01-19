# Descarga dependencias
### Puedes actualizar todos los paquetes que se encuentran en composer.json

```
$ composer update
```

#### Crear el archivo constantes.php un nivel sobre el directorio de la pag. web (Direcctorio actual).
```
constantes.php
```

### Remplazar los * por las credenciales del correo a usar, user and password.

```php
<?php
  define('EMAIL_INVERSALUD_FINANZAS', '******');
  define('EMAIL_INVERSALUD_LABORATORIO', '******');
  define('EMAIL_INVERSALUD_ECOTOMOGRAFIA', '******');
  define('EMAIL_INVERSALUD_RAYOSYMAMO', '******');
  define('EMAIL_INVERSALUD_PABELLON', '******');
  define('EMAIL_INVERSALUD_PROCEDIMIENTOS', '******');
  define('EMAIL_USER', '******');
  define('EMAIL_USER_PASSWORD', '******');
?>
```