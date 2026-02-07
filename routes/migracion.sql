-- =======================================================
-- SCRIPT FINAL: SOLUCIÓN ERROR CLIENTE.MASCOTA
-- =======================================================

-- 1. LIMPIEZA TOTAL (Borrar intentos fallidos de la competencia)
DELETE FROM mascotas WHERE veterinaria_id = 2;
DELETE FROM clientes WHERE veterinaria_id = 2;
DELETE FROM users WHERE veterinaria_id = 2;
DELETE FROM veterinarias WHERE id = 2;

-- 2. CREAR VETERINARIA EXÓTICA
INSERT INTO veterinarias (id, nombre, direccion, telefono, created_at, updated_at)
VALUES (2, 'Veterinaria Exótica', 'Av. Las Palmas 404', '555-999-8888', datetime('now'), datetime('now'));

-- 3. CREAR USUARIO DUEÑO
INSERT INTO users (name, email, password, rol, veterinaria_id, created_at, updated_at)
VALUES ('Dueño Exótica', 'contacto@exotica.com', 'exotica123', 'owner', 2, datetime('now'), datetime('now'));

-- 4. CREAR CLIENTE (CORREGIDO)
-- Agregamos la columna 'mascota' y el valor 'Rango' para que no falle
INSERT INTO clientes (nombre, email, telefono, veterinaria_id, mascota, created_at, updated_at)
VALUES ('Juan Pérez', 'juan@cliente.com', '555-777-1234', 2, 'Rango', datetime('now'), datetime('now'));

-- 5. INSERTAR A LA MASCOTA RANGO
INSERT INTO mascotas (nombre, especie, raza, edad, veterinaria_id, user_id, cliente_id, created_at, updated_at)
VALUES ('Rango', 'Reptil', 'Iguana Verde', '2 años', 2,
    (SELECT id FROM users WHERE email='contacto@exotica.com'), -- El Usuario (Vet)
    (SELECT id FROM clientes WHERE email='juan@cliente.com'),  -- El Cliente (Dueño)
    datetime('now'), datetime('now')
);