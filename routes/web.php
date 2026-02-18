<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// --- IMPORTACIÓN DE CONTROLADORES ---
use App\Http\Controllers\VeterinariaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\VacunaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Cualquiera puede entrar)
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Login (Mostrar Pantalla)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Login (Procesar datos)
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Configuración Inicial (Setup de Veterinaria)
Route::get('/setup', [VeterinariaController::class, 'setup'])->name('veterinarias.setup');
Route::post('/setup', [VeterinariaController::class, 'store'])->name('veterinarias.store');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Solo usuarios logueados con veterinaria validada)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'veterinaria'])->group(function () {

    // 1. Cerrar Sesión
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // 2. Dashboard Principal (Redirección inteligente)
    Route::get('/dashboard', function () {
        return redirect()->route('clientes.index');
    })->name('dashboard');

    // 3. MÓDULO DE CLIENTES
    Route::resource('clientes', ClienteController::class);

    // 4. MÓDULO DE CITAS (CRUD)
    Route::resource('citas', CitaController::class);

    // ========== RUTAS API PARA CITAS (AJAX) ==========
    
    /**
     * Búsqueda avanzada de clientes (actualizada para CitaController)
     */
    Route::get('/api/buscar-clientes', [CitaController::class, 'buscarClientes'])
        ->name('api.buscar-clientes');

    /**
     * Obtener mascotas de un cliente
     */
    Route::get('/api/cliente/{clienteId}/mascotas', [CitaController::class, 'mascotasDelCliente'])
        ->name('api.cliente.mascotas');

    /**
     * Obtener configuración de la veterinaria
     */
    Route::get('/api/veterinaria/config', [CitaController::class, 'obtenerConfig'])
        ->name('api.veterinaria.config');

    /**
     * Enviar mensaje WhatsApp
     */
    Route::post('/citas/{cita}/enviar-whatsapp', [CitaController::class, 'enviarWhatsApp'])
        ->name('citas.enviar-whatsapp');

    // 5. PERFIL DE LA VETERINARIA
    Route::get('/perfil', [VeterinariaController::class, 'show'])->name('veterinarias.show');
    Route::get('/perfil/editar', [VeterinariaController::class, 'edit'])->name('veterinarias.edit');
    Route::put('/perfil/actualizar', [VeterinariaController::class, 'update'])->name('veterinarias.update');

    // 6. MÓDULO DE MASCOTAS
    Route::get('/clientes/{cliente}/mascotas/crear', [MascotaController::class, 'create'])->name('mascotas.create');
    Route::post('/clientes/{cliente}/mascotas', [MascotaController::class, 'store'])->name('mascotas.store');
    Route::get('/mascotas/{mascota}/editar', [MascotaController::class, 'edit'])->name('mascotas.edit');
    Route::put('/mascotas/{mascota}', [MascotaController::class, 'update'])->name('mascotas.update');
    Route::delete('/mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');

    // 7. CARTILLA DE VACUNACIÓN
    Route::get('/mascotas/{mascota}/cartilla', [VacunaController::class, 'index'])->name('vacunas.index');
    Route::post('/mascotas/{mascota}/vacunas', [VacunaController::class, 'store'])->name('vacunas.store');
    Route::delete('/vacunas/{vacuna}', [VacunaController::class, 'destroy'])->name('vacunas.destroy');

    // 8. PANEL DE SUPER ADMIN
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->rol !== 'super_admin') {
            return redirect('/clientes');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

});


/*
|--------------------------------------------------------------------------
| HERRAMIENTAS DE DESARROLLO (SOLO EMERGENCIAS)
|--------------------------------------------------------------------------
*/

// Reparar Contraseñas
Route::get('/reparar-passwords', function () {
    $usuarios = [
        'contacto@dogcat.com' => 'dogcat123',
        'contacto@exotica.com' => 'exotica123',
        'admin@plataforma.com' => 'adminMaster2026'
    ];
    
    foreach ($usuarios as $email => $pass) {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($pass);
            $user->save();
            echo "Usuario $email reparado.<br>";
        }
    }
    return "Proceso terminado. Intenta hacer Login.";
});

// Reparar Urgente (Crear usuarios si no existen)
Route::get('/reparar-urgente', function () {
    // DogCat
    User::updateOrCreate(
        ['email' => 'contacto@dogcat.com'],
        ['name' => 'Dueño DogCat', 'password' => Hash::make('dogcat123'), 'rol' => 'owner', 'veterinaria_id' => 1]
    );
    // Super Admin
    User::updateOrCreate(
        ['email' => 'admin@plataforma.com'],
        ['name' => 'Super Admin', 'password' => Hash::make('adminMaster2026'), 'rol' => 'super_admin', 'veterinaria_id' => null]
    );

    return "Usuarios creados/reparados correctamente.";
});