# MetaKey v1.0 - osCommerce Add-on

Genera automáticamente los Meta KeyWords y Description de los productos en osCommerce.

<strong>Instalación</strong>

1.- Configurar el archivo includes/meta_tags.php

2.- Modificar y agregar el siguiente código en “includes/header.php” o “includes/template_top.php”.
<pre>
if (file_exists(DIR_WS_INCLUDES . 'meta_tags.php')){
  require(DIR_WS_INCLUDES . 'meta_tags.php');
}
</pre>
