# Solución: Error de versión de PHP en cPanel

## Error:
"Your Composer dependencies require a PHP version >= 8.2.0"

## Causa:
Laravel 11 requiere PHP 8.2 o superior, pero tu servidor tiene una versión anterior.

## Soluciones:

### Opción 1: Cambiar la versión de PHP en cPanel (RECOMENDADO)

1. **En cPanel**, busca "Select PHP Version" o "MultiPHP Manager"
2. Selecciona tu dominio `fondosolidario.jaeccba.org`
3. Cambia la versión de PHP a **8.2** o **8.3**
4. Guarda los cambios

### Opción 2: Usar .htaccess para cambiar PHP

Agrega esto al archivo `.htaccess` en la carpeta `public`:

```apache
# Para PHP 8.2
AddHandler application/x-httpd-php82 .php

# O si tu hosting usa otro formato:
# AddHandler application/x-httpd-ea-php82 .php
```

### Opción 3: Verificar versión actual de PHP

Crea un archivo `info.php` en la carpeta `public` con:

```php
<?php
phpinfo();
```

Accede a `https://fondosolidario.jaeccba.org/info.php` para ver la versión actual.
**IMPORTANTE**: Elimina este archivo después de verificar.

### Opción 4: Si no puedes actualizar PHP

Si tu hosting no permite PHP 8.2+, tienes estas alternativas:

#### A. Downgrade a Laravel 10 (requiere PHP 8.1+)
```bash
composer require laravel/framework:^10.0
```

#### B. Downgrade a Laravel 9 (requiere PHP 8.0+)
```bash
composer require laravel/framework:^9.0
```

**NOTA**: Hacer downgrade puede requerir ajustes en el código.

### Opción 5: Contactar al soporte del hosting

Si no encuentras la opción para cambiar PHP:
1. Contacta al soporte técnico
2. Solicita actualización a PHP 8.2 o superior
3. Pregunta si tienen planes con PHP 8.2+

## Verificación después del cambio:

1. Crea un archivo `test.php` en public:
```php
<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Laravel puede ejecutarse: " . (version_compare(PHP_VERSION, '8.2.0', '>=') ? 'SÍ' : 'NO');
```

2. Accede a `https://fondosolidario.jaeccba.org/test.php`

3. Si muestra "SÍ", tu sitio debería funcionar.

## Extensiones PHP requeridas:

Asegúrate de que estas extensiones estén habilitadas:
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML

En cPanel, busca "Select PHP Extensions" para habilitarlas.

## Si el error persiste después de actualizar PHP:

1. Limpia la caché:
   - Elimina todo el contenido de `bootstrap/cache/` (excepto .gitignore)
   - Elimina todo el contenido de `storage/framework/cache/`

2. Regenera el autoloader:
   - Si tienes acceso SSH: `composer dump-autoload`
   - Si no, sube nuevamente la carpeta `vendor` desde local

¡Con PHP 8.2+ tu aplicación debería funcionar correctamente!