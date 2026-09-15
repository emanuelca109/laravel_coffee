# Módulo de Autenticación de Clientes (Login y Registro)

Controla el acceso de usuarios, creación de cuentas y recuperación de contraseñas de forma ágil e interactiva.

---

## 1. Vistas y Componentes
- **Modal Integrado:** `resources/views/cliente/partials/auth-modals.blade.php`
- **Páginas Standalone:** `resources/views/auth/login.blade.php`, `register.blade.php`, `forgot-password.blade.php`
- **Controladores:**
  - `App\Http\Controllers\Auth\AuthenticatedSessionController.php`
  - `App\Http\Controllers\Auth\RegisteredUserController.php`
  - `App\Http\Controllers\Auth\PasswordResetLinkController.php`

---

## 2. Características del Sistema de Autenticación

### A. Ventana Modal sin Recarga de Página
- El cliente puede abrir el modal de autenticación desde cualquier vista pulsando el botón de perfil o al intentar realizar una acción protegida (favoritos, comprar).
- El inicio de sesión y registro se envían por AJAX:
  - Valida credenciales al instante.
  - Cierra el modal automáticamente y actualiza la sesión en vivo.
  - Si hay errores, los resalta directamente bajo los campos correspondientes.

### B. Persistencia de Intención de Compra
- Si un usuario no registrado hace clic en **"Comprar Ahora"** o **"Añadir a Favoritos"**:
  1. El sistema recuerda qué producto y cantidad intentaba comprar.
  2. Tras iniciar sesión o registrarse, se reanuda inmediatamente la compra o se guarda el favorito sin que el usuario tenga que buscarlo de nuevo.
