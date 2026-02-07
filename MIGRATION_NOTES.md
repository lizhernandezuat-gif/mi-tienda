Notas de migración - Veterinarias y teléfonos únicos

1) Resumen
- Se agregó la entidad `Veterinaria` y el campo `veterinaria_id` a `clientes`.
- Se planea forzar `telefono` como `UNIQUE` y `NOT NULL` en la tabla `clientes`.

2) Pasos recomendados antes de migrar
- Ejecuta: `php artisan detect:telefono-duplicates` para listar teléfonos duplicados y clientes sin teléfono.
- Resuelve duplicados manualmente (o decide cuál conservar) y rellena teléfonos nulos.

3) Ejecución
- Migrar: `php artisan migrate`
- Sembrar datos de ejemplo: `php artisan db:seed`

4) Notas adicionales
- Si necesitas normalizar formatos de teléfono (eliminar espacios, signos o unificar prefijos), puedo añadir un comando para eso y/o un script SQL para estandarizar los valores existentes.
