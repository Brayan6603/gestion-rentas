Wireframe: layouts/app.blade.php

Objetivo
-------
Wireframe textual / visual simple de la `layout` principal (`resources/views/layouts/app.blade.php`). Incluye estructura principal, componentes y notas de comportamiento responsive.

+---------------------------------------------------------------+
| NAVBAR (barra superior)                                        |
| ----------------------------------------------------------------
| [ ☰ ]  | BRAND - Sistema de Rentas               | User dropdown |
| - Left: hamburger (abre Offcanvas en mobile)                     |
| - Center/left: Brand (link a dashboard)                         |
| - Right: User menu (perfil, logout)                             |
+---------------------------------------------------------------+

+---------------------------------------------------------------+
| OFFCANVAS SIDEBAR (offcanvas-start)                            |
| - Cabezera: título 'Menu' + botón cerrar                       |
| - User info: nombre, email                                      |
| - Nav vertical:                                                 |
|    - Dashboard                                                   |
|    - Departamentos (propiedades)                                 |
|    - Inquilinos                                                   |
|    - Pagos                                                        |
|    - Gastos                                                       |
|    - Reportes (dropdown)                                          |
| - Footer: botón logout                                            |
+---------------------------------------------------------------+

+---------------------------------------------------------------+
| MAIN CONTENT (área principal)                                   |
| - Container central con `@yield('content')`                      |
| - Padding vertical, centrado (max-width)                         |
| - Aquí se inyectan las vistas: dashboard, index propiedades, etc. |
+---------------------------------------------------------------+

+---------------------------------------------------------------+
| SCRIPTS / BOOTSTRAP                                               |
| - Carga de Bootstrap bundle JS                                      |
| - Inicializadores (tooltips, popovers)                             |
+---------------------------------------------------------------+

Notas de diseño
---------------
- Mobile
  - El `navbar-toggler` abre el `offcanvas` (sidebar) en pantallas pequeñas.
  - En mobile no se muestra la barra completa de navegación; se usa offcanvas.

- Desktop
  - Navbar expandible con links visibles; offcanvas puede quedar como alternativa móvil.

- Accesibilidad
  - `aria-controls`, `aria-labelledby` en offcanvas.
  - Botones con `aria-label` para cerrar.

Recomendaciones de clases / estructura Blade
-------------------------------------------
- `layouts/app.blade.php` debe contener:
  - `<nav class="navbar navbar-expand-lg navbar-dark bg-primary">` (topbar)
  - `<div class="offcanvas offcanvas-start" id="offcanvasMenu">` (sidebar)
  - `<main class="py-4"><div class="container">@yield('content')</div></main>` (contenido)
  - Incluir `@vite`/`<link>` y `<script>` para Bootstrap

Comportamiento esperado (UX)
---------------------------
- Usuario hace clic en el hamburguer → abre offcanvas con navegación.
- Desde el offcanvas puede acceder a la lista de propiedades o al listado global de inquilinos.
- El perfil de usuario abre `profile.edit` desde el dropdown (mismo layout y yield).
- Todas las vistas hijas usan `@extends('layouts.app')` y `@section('content')`.

Comentarios adicionales
----------------------
- Actualmente `app.blade.php` usa `@yield('content')` (recomendado para las vistas que usan `@extends`).
- Si utilizas componentes Blade (`<x-app-layout>`), mantén consistencia: o componentes o layouts con `@yield`.


---
Archivo generado: `resources/views/layouts/app-wireframe.md`  
Si quieres, puedo generar también un mock visual en HTML/CSS simple (archivo `public/mock-app-layout.html`) o un PNG con una maqueta básica. ¿Cuál prefieres como siguiente paso?