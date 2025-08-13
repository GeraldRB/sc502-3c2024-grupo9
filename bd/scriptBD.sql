CREATE DATABASE guarderia;
USE guarderia;

-- Tabla de Roles
CREATE TABLE ROLES (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);

-- Tabla de Usuarios
CREATE TABLE USUARIOS (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    id_rol INT,
    estado BOOLEAN DEFAULT TRUE,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES ROLES(id_rol)
);

-- Tabla de Niños
CREATE TABLE NINOS (
    id_nino INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    id_usuario_padre INT,
    FOREIGN KEY (id_usuario_padre) REFERENCES USUARIOS(id_usuario)
);

-- Tabla de Programas Educativos
CREATE TABLE PROGRAMAS_EDUCATIVOS (
    id_programa INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    nivel VARCHAR(50),
    fecha_inicio DATE,
    fecha_fin DATE,
    estado BOOLEAN DEFAULT TRUE
);

-- Tabla de Matrícula
CREATE TABLE MATRICULA (
    id_matricula INT AUTO_INCREMENT PRIMARY KEY,
    id_nino INT,
    id_programa INT,
    fecha_matricula DATE NOT NULL,
    FOREIGN KEY (id_nino) REFERENCES NINOS(id_nino),
    FOREIGN KEY (id_programa) REFERENCES PROGRAMAS_EDUCATIVOS(id_programa)
);

-- Tabla de Historial de Matrícula
CREATE TABLE HISTORIAL_MATRICULA (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_matricula INT,
    fecha_cambio DATE NOT NULL,
    observaciones TEXT,
    estado VARCHAR(50),
    FOREIGN KEY (id_matricula) REFERENCES MATRICULA(id_matricula)
);

-- Tabla de Citas
CREATE TABLE CITAS (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_cita DATETIME,
    motivo TEXT,
    estado VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario)
);

-- Tabla de Asistencia
CREATE TABLE ASISTENCIA (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    id_nino INT,
    fecha DATE NOT NULL,
    presente BOOLEAN DEFAULT FALSE,
    observaciones TEXT,
    FOREIGN KEY (id_nino) REFERENCES NINOS(id_nino)
);

-- Tabla de Contacto
CREATE TABLE CONTACTO (
    id_contacto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100),
    mensaje TEXT,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Auditoría
CREATE TABLE AUDITORIA (
    id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    accion VARCHAR(100),
    modulo VARCHAR(100),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario)
);

--Modificaciones para Padres
ALTER TABLE NINOS
  MODIFY id_usuario_padre INT NOT NULL;

ALTER TABLE NINOS
  ADD INDEX idx_ninos_padre (id_usuario_padre);

INSERT INTO ROLES (nombre_rol)
SELECT 'Padre'
WHERE NOT EXISTS (SELECT 1 FROM ROLES WHERE nombre_rol = 'Padre');


