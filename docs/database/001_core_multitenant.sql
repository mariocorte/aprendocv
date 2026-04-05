-- Proyecto: AprendoCV
-- Documento: Esbozo inicial de base de datos (PostgreSQL 9.2.24)
-- Enfoque: multi-establecimiento educativo con base administrativa
-- Nota de compatibilidad: se usan tipos/DDL compatibles con PostgreSQL 9.2.x.

BEGIN;

-- =========================================================
-- 1) Localidades
--    Catálogo geográfico base para instituciones y usuarios.
-- =========================================================
CREATE TABLE localidades (
    id                      SERIAL PRIMARY KEY,
    codigo_pais             CHAR(2) NOT NULL DEFAULT 'AR',
    nombre_provincia        VARCHAR(120) NOT NULL,
    nombre_ciudad           VARCHAR(120) NOT NULL,
    codigo_postal           VARCHAR(20),
    esta_activa             BOOLEAN NOT NULL DEFAULT TRUE,
    fecha_creacion          TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion     TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_localidades_lugar_unico UNIQUE (codigo_pais, nombre_provincia, nombre_ciudad, COALESCE(codigo_postal, ''))
);

CREATE INDEX idx_localidades_pais_provincia_ciudad
    ON localidades (codigo_pais, nombre_provincia, nombre_ciudad);

-- =========================================================
-- 2) Instituciones
--    Entidad tenant principal del sistema.
-- =========================================================
CREATE TABLE instituciones (
    id                          SERIAL PRIMARY KEY,
    codigo                      VARCHAR(30) NOT NULL,
    razon_social                VARCHAR(255) NOT NULL,
    nombre_mostrar              VARCHAR(255) NOT NULL,
    cuit                        VARCHAR(30),
    correo_electronico          VARCHAR(255),
    telefono                    VARCHAR(50),
    direccion                   VARCHAR(255),
    localidad_id                INTEGER NOT NULL,
    esta_activa                 BOOLEAN NOT NULL DEFAULT TRUE,
    fecha_creacion              TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion         TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_instituciones_codigo UNIQUE (codigo),
    CONSTRAINT fk_instituciones_localidad
        FOREIGN KEY (localidad_id) REFERENCES localidades (id)
        ON UPDATE NO ACTION ON DELETE RESTRICT
);

CREATE INDEX idx_instituciones_localidad_id
    ON instituciones (localidad_id);

-- =========================================================
-- 3) Roles de usuario
--    Roles funcionales para permisos de acceso.
-- =========================================================
CREATE TABLE roles_usuario (
    id                      SERIAL PRIMARY KEY,
    codigo                  VARCHAR(50) NOT NULL,
    nombre                  VARCHAR(120) NOT NULL,
    descripcion             TEXT,
    es_sistema              BOOLEAN NOT NULL DEFAULT FALSE,
    esta_activo             BOOLEAN NOT NULL DEFAULT TRUE,
    fecha_creacion          TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion     TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_roles_usuario_codigo UNIQUE (codigo)
);

-- =========================================================
-- 4) Usuarios
--    Usuario global del sistema, asociado a una institución base.
-- =========================================================
CREATE TABLE usuarios (
    id                                  SERIAL PRIMARY KEY,
    institucion_id                      INTEGER NOT NULL,
    localidad_id                        INTEGER,
    nombres                             VARCHAR(120) NOT NULL,
    apellidos                           VARCHAR(120) NOT NULL,
    tipo_documento                      VARCHAR(20),
    numero_documento                    VARCHAR(40),
    correo_electronico                  VARCHAR(255) NOT NULL,
    hash_contrasena                     VARCHAR(255) NOT NULL,
    telefono                            VARCHAR(50),
    fecha_nacimiento                    DATE,
    esta_activo                         BOOLEAN NOT NULL DEFAULT TRUE,
    debe_cambiar_contrasena             BOOLEAN NOT NULL DEFAULT FALSE,
    fecha_ultimo_acceso                 TIMESTAMP WITHOUT TIME ZONE,
    fecha_creacion                      TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion                 TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_usuarios_correo_electronico UNIQUE (correo_electronico),
    CONSTRAINT uq_usuarios_documento UNIQUE (tipo_documento, numero_documento),
    CONSTRAINT fk_usuarios_institucion
        FOREIGN KEY (institucion_id) REFERENCES instituciones (id)
        ON UPDATE NO ACTION ON DELETE RESTRICT,
    CONSTRAINT fk_usuarios_localidad
        FOREIGN KEY (localidad_id) REFERENCES localidades (id)
        ON UPDATE NO ACTION ON DELETE SET NULL
);

CREATE INDEX idx_usuarios_institucion_id ON usuarios (institucion_id);
CREATE INDEX idx_usuarios_localidad_id ON usuarios (localidad_id);
CREATE INDEX idx_usuarios_apellidos_nombres ON usuarios (apellidos, nombres);

-- =========================================================
-- 5) Tabla sugerida adicional (básica y recomendada):
--    asignaciones_rol_usuario
--    Permite que un usuario tenga uno o varios roles.
-- =========================================================
CREATE TABLE asignaciones_rol_usuario (
    usuario_id                  INTEGER NOT NULL,
    rol_usuario_id              INTEGER NOT NULL,
    institucion_id              INTEGER NOT NULL,
    fecha_asignacion            TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    asignado_por_usuario_id     INTEGER,
    esta_activa                 BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (usuario_id, rol_usuario_id, institucion_id),
    CONSTRAINT fk_aru_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON UPDATE NO ACTION ON DELETE CASCADE,
    CONSTRAINT fk_aru_rol_usuario
        FOREIGN KEY (rol_usuario_id) REFERENCES roles_usuario (id)
        ON UPDATE NO ACTION ON DELETE RESTRICT,
    CONSTRAINT fk_aru_institucion
        FOREIGN KEY (institucion_id) REFERENCES instituciones (id)
        ON UPDATE NO ACTION ON DELETE RESTRICT,
    CONSTRAINT fk_aru_asignado_por_usuario
        FOREIGN KEY (asignado_por_usuario_id) REFERENCES usuarios (id)
        ON UPDATE NO ACTION ON DELETE SET NULL
);

CREATE INDEX idx_aru_rol_usuario_id ON asignaciones_rol_usuario (rol_usuario_id);
CREATE INDEX idx_aru_institucion_id ON asignaciones_rol_usuario (institucion_id);

COMMIT;
