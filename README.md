# 🐾 Huellas Felices

Aplicación web desarrollada para la gestión de una protectora de animales.

## 📋 Descripción

**Huellas Felices** es una aplicación web desarrollada como proyecto final del **Curso Superior en Programación de Páginas Web**.

La aplicación permite a los usuarios registrarse, iniciar sesión, gestionar su perfil y solicitar citas. Los usuarios con permisos de administrador pueden gestionar usuarios, citas y noticias desde el sistema.

## 🚀 Funcionalidades

### 👤 Usuarios

* Registro de usuarios.
* Inicio de sesión.
* Gestión del perfil.
* Solicitud de citas.
* Consulta de noticias.

### 🔐 Administradores

* Gestión de usuarios.
* Gestión de roles.
* Gestión de citas.
* Creación, modificación y eliminación de noticias.

## 🛠️ Tecnologías utilizadas

* PHP
* MySQL / MariaDB
* SQL
* HTML5
* CSS3
* JavaScript
* Bootstrap
* PDO
* Sesiones PHP

## 🌐 Demo

La aplicación está desplegada y disponible online:

**https://protectora-huellas-felices.infinityfree.me**

## 📂 Estructura del proyecto

```text
huellas-felices/
├── database/
├── web/
│   ├── assets/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── index.php
├── .gitignore
└── README.md
```

## 🔒 Seguridad

Las credenciales reales de conexión a la base de datos no se incluyen en el repositorio.

El archivo de configuración con las credenciales de conexión se mantiene fuera de GitHub mediante `.gitignore`.

Las contraseñas de los usuarios se almacenan utilizando `password_hash()` y se verifican mediante `password_verify()`.

## 👨‍💻 Autor

**Pablo Guerrero Linares**

Desarrollador Web Junior

* GitHub: https://github.com/PabloEstopero
* LinkedIn: https://linkedin.com/in/pablo-guerrero-linares
