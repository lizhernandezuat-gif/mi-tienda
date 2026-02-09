<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeterinariaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// 1. Ruta Principal (Decide si mostrar Bienvenida o Registro)
// RUTA PRINCIPAL (PLAN SOFT: LANDING PAGE)
Route::get('/', function () {
    return view('welcome'); // Muestra la página de venta
})->name('home');

// 2. Rutas para Configuración Inicial (Registro de la Veterinaria)
Route::get('/setup', [VeterinariaController::class, 'setup'])->name('veterinarias.setup');
Route::post('/setup', [VeterinariaController::class, 'store'])->name('veterinarias.store');

// 3. Rutas de Clientes (Solo accesibles si ya hay veterinaria)
Route::resource('clientes', ClienteController::class);
Route::get('/perfil', [VeterinariaController::class, 'show'])->name('veterinarias.show');
// Rutas para editar la veterinaria
Route::get('/perfil/editar', [App\Http\Controllers\VeterinariaController::class, 'edit'])->name('veterinarias.edit');
Route::put('/perfil/actualizar', [App\Http\Controllers\VeterinariaController::class, 'update'])->name('veterinarias.update');
// Rutas de Mascotas
Route::get('/clientes/{cliente}/mascotas/crear', [App\Http\Controllers\MascotaController::class, 'create'])->name('mascotas.create');
Route::post('/clientes/{cliente}/mascotas', [App\Http\Controllers\MascotaController::class, 'store'])->name('mascotas.store');
// Rutas para Editar y Eliminar Mascotas
Route::get('/mascotas/{mascota}/editar', [App\Http\Controllers\MascotaController::class, 'edit'])->name('mascotas.edit');
Route::put('/mascotas/{mascota}', [App\Http\Controllers\MascotaController::class, 'update'])->name('mascotas.update');
Route::delete('/mascotas/{mascota}', [App\Http\Controllers\MascotaController::class, 'destroy'])->name('mascotas.destroy');

// Rutas de Cartilla de Vacunación
Route::get('/mascotas/{mascota}/cartilla', [App\Http\Controllers\VacunaController::class, 'index'])->name('vacunas.index');
Route::post('/mascotas/{mascota}/vacunas', [App\Http\Controllers\VacunaController::class, 'store'])->name('vacunas.store');
Route::delete('/vacunas/{vacuna}', [App\Http\Controllers\VacunaController::class, 'destroy'])->name('vacunas.destroy');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// RUTA PARA CERRAR SESIÓN (LOGOUT)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login'); // Te manda al login después de salir
})->name('logout');
// RUTA QUE FALTABA: Muestra la pantalla de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 1. Mostrar la pantalla de Login (Ya la tienes)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 2. PROCESAR EL LOGIN (¡ESTA ES LA QUE TE FALTA!)
// Esto conecta el botón "Entrar" con la lógica de Laravel
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// 3. Cerrar Sesión (Ya la tienes)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// --- HERRAMIENTA DE REPARACIÓN DE CONTRASEÑAS (PLAN KOK) ---
Route::get('/reparar-passwords', function () {
    
    // 1. Reparar al Dueño de DogCat
    $user1 = User::where('email', 'contacto@dogcat.com')->first();
    if ($user1) {
        $user1->password = Hash::make('dogcat123'); // La encriptamos
        $user1->save();
        echo "DogCat arreglado.<br>";
    }

    // 2. Reparar a la Competencia (Exótica)
    $user2 = User::where('email', 'contacto@exotica.com')->first();
    if ($user2) {
        $user2->password = Hash::make('exotica123'); // La encriptamos
        $user2->save();
        echo "Exótica arreglada.<br>";
    }

    // 3. Reparar al Admin
    $user3 = User::where('email', 'admin@plataforma.com')->first();
    if ($user3) {
        $user3->password = Hash::make('adminMaster2026'); // La encriptamos
        $user3->save();
        echo "Admin arreglado.<br>";
    }

    return "¡Listo! Contraseñas encriptadas. Ahora intenta hacer Login.";
});


// --- HERRAMIENTA DE REPARACIÓN TOTAL (SI NO EXISTEN, LOS CREA) ---
Route::get('/reparar-urgente', function () {
    
    // 1. REPARAR O CREAR A DOGCAT
    $dogcat = User::updateOrCreate(
        ['email' => 'contacto@dogcat.com'], // Busca por este email
        [
            'name' => 'Dueño DogCat',
            'password' => Hash::make('dogcat123'), // Contraseña segura
            'rol' => 'owner',
            'veterinaria_id' => 1 // ID 1 a la fuerza
        ]
    );

    // 2. REPARAR O CREAR AL SUPER ADMIN
    $admin = User::updateOrCreate(
        ['email' => 'admin@plataforma.com'], // Busca por este email
        [
            'name' => 'Super Admin',
            'password' => Hash::make('adminMaster2026'), // Contraseña segura
            'rol' => 'super_admin',
            'veterinaria_id' => null // Admin no tiene veterinaria
        ]
    );

    // 3. REPARAR O CREAR A LA COMPETENCIA (Por si acaso)
    $exotica = User::updateOrCreate(
        ['email' => 'contacto@exotica.com'],
        [
            'name' => 'Dueño Exótica',
            'password' => Hash::make('exotica123'),
            'rol' => 'owner',
            'veterinaria_id' => 2
        ]
    );

    return "✅ ¡LISTO! Usuarios creados o reparados. <br>
            DogCat: contacto@dogcat.com / dogcat123 <br>
            Admin: admin@plataforma.com / adminMaster2026 <br>
            Exótica: contacto@exotica.com / exotica123";
});

// --- RUTA DEL SUPER ADMIN (PLAN KOK) ---
Route::get('/admin/dashboard', function () {
    // 1. Seguridad: Si no es admin, lo mandamos a su clínica
    if (Auth::user()->rol !== 'super_admin') {
        return redirect('/clientes');
    }
    // 2. Si sí es admin, mostramos el panel
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');