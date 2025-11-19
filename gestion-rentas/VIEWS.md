# VIEWS - Sistema de Gestión de Rentas

Este documento lista las vistas (Blade) por módulo, con el nombre de archivo y una breve descripción.

---

## Autenticación
- `login.blade.php` — Formulario de inicio de sesión (Laravel Breeze).
- `register.blade.php` — Registro de usuario (opcional).
- `passwords/email.blade.php` — Solicitar restablecer contraseña.
- `passwords/reset.blade.php` — Formulario para nueva contraseña.

## Dashboard
- `dashboard.blade.php` — Vista principal con métricas y accesos rápidos.
- `dashboard/widgets/_summary.blade.php` — Partial: resumen ingresos/gastos.
- `dashboard/widgets/_recent-activity.blade.php` — Partial: actividad reciente.

## Propiedades
- `propiedades/index.blade.php` — Listado de propiedades (tabla/tiles).
- `propiedades/show.blade.php` — Detalle de propiedad (inquilinos, pagos, gastos, depósitos).
- `propiedades/create.blade.php` — Formulario creación.
- `propiedades/edit.blade.php` — Formulario edición.
- `propiedades/_card.blade.php` — Partial tarjeta reutilizable.
- `propiedades/_form.blade.php` — Partial del formulario (create/edit).

## Inquilinos
- `inquilinos/index-all.blade.php` — Listado global de inquilinos (cards + buscador).
- `propiedades/inquilinos/index.blade.php` — Listado de inquilinos por propiedad (anidado).
- `propiedades/inquilinos/show.blade.php` — Detalle de inquilino (pagos y depósitos).
- `propiedades/inquilinos/create.blade.php` — Formulario creación (anidado).
- `propiedades/inquilinos/edit.blade.php` — Formulario edición (anidado).
- `inquilinos/_card.blade.php` — Card para listado global.
- `inquilinos/_modal-create.blade.php` — Modal de creación rápido (incluido en `index-all`).

## Pagos
- `pagos/index.blade.php` — Listado de pagos (por propiedad / filtro global).
- `pagos/create.blade.php` — Formulario creación pago (o modal en inquilino.show).
- `pagos/show.blade.php` — Detalle de pago / recibo.
- `pagos/_table-row.blade.php` — Partial: fila reutilizable para tablas.

## Gastos
- `gastos/index.blade.php` — Listado de gastos por propiedad.
- `gastos/create.blade.php` — Formulario creación gasto.
- `gastos/edit.blade.php` — Formulario edición gasto.
- `gastos/_category-form.blade.php` — Partial para seleccionar/crear categoría.
- `categoria_gastos/index.blade.php` — Listado de categorías.
- `categoria_gastos/create.blade.php` — Crear categoría.

## Depósitos
- `depositos/index.blade.php` — Listado de depósitos (por propiedad o global).
- `depositos/show.blade.php` — Detalle de depósito (devoluciones/retenciones).
- `depositos/create.blade.php` — Formulario creación depósito.
- `depositos/_modal-devolucion.blade.php` — Modal para registrar devolución/retención.

## Reportes
- `reportes/balance.blade.php` — Balance general por periodo.
- `reportes/mensual.blade.php` — Reporte mensual (filtros por propiedad).
- `reportes/estado-cuenta.blade.php` — Estado de cuenta por propiedad.
- `reportes/_export-controls.blade.php` — Partial para exportar PDF/CSV.

## Perfil y Configuración
- `profile/edit.blade.php` — Editar perfil / contraseña (ya adaptado).
- `settings/notifications.blade.php` — Preferencias de notificaciones (opcional).
- `settings/account.blade.php` — Ajustes de la cuenta (opcional).

## Componentes Compartidos / Layouts
- `layouts/app.blade.php` — Layout principal (navbar + offcanvas).
- `layouts/guest.blade.php` — Layout público (login/register).
- `components/alerts.blade.php` — Flash messages / toasts.
- `components/pagination.blade.php` — Paginación personalizada (opcional).
- `components/search-filter.blade.php` — Barra buscadora y filtros.

---

## Notas
- Las vistas anidadas (por ejemplo `propiedades/inquilinos/*`) mantienen la relación lógica: un inquilino siempre pertenece a una propiedad.
- Los partials (`_form`, `_card`, `_modal`) deben crearse para evitar duplicación entre `create`/`edit` y listados.
- Prioridad MVP recomendada: Dashboard, Propiedades CRUD, Inquilinos CRUD, Pagos/Gastos/Depósitos básicos, Perfil.

Si quieres, creo los archivos `blade` vacíos (plantillas) para los módulos de Dashboard, Propiedades e Inquilinos ahora.
