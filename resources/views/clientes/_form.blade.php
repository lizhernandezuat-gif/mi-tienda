<div class="bg-white rounded-2xl shadow-2xl p-6 border-4 border-white">
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700">Nombre del cliente</label>
            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:ring-2 focus:ring-purple-300" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Veterinaria / Sucursal</label>
            @if(isset($veterinarias) && $veterinarias->isNotEmpty())
                <select name="veterinaria_id" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" required>
                    @foreach($veterinarias as $v)
                        <option value="{{ $v->id }}" {{ old('veterinaria_id', $cliente->veterinaria_id ?? $selectedVeterinaria ?? '') == $v->id ? 'selected' : '' }}>{{ $v->nombre }}</option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="veterinaria_id" value="">
                <div class="mt-2 text-sm text-yellow-600">No hay veterinarias registradas. Crea una en <a class="underline" href="{{ route('veterinarias.index') }}">Veterinarias</a>.</div>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Correo</label>
                <input type="email" name="email" value="{{ old('email', $cliente->email ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" placeholder="correo@ejemplo.com">
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
                <div class="text-gray-400 text-xs mt-1">Usa un correo válido para recibir notificaciones.</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" required pattern="^\+?[0-9]{7,15}$" title="Incluye el prefijo de país, sólo números y un '+' opcional. Sin espacios ni guiones">
                @error('telefono')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
                <div class="text-gray-400 text-xs mt-1">Incluye el prefijo de país y evita espacios o guiones (ej: +34123456789).</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Teléfono alterno</label>
                <input type="text" name="telefono_alterno" value="{{ old('telefono_alterno', $cliente->telefono_alterno ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Preferencia de contacto</label>
                <input type="text" name="preferencia_contacto" value="{{ old('preferencia_contacto', $cliente->preferencia_contacto ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" placeholder="teléfono / correo / whatsapp">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Domicilio</label>
                <input type="text" name="domicilio" value="{{ old('domicilio', $cliente->domicilio ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nombre de la mascota</label>
                <input type="text" name="nombre_mascota" value="{{ old('nombre_mascota', $cliente->nombre_mascota ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" required minlength="2">
                @error('nombre_mascota')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
                <div class="text-gray-400 text-xs mt-1">Ej: 'Firulais' — el nombre ayuda a localizar registros rápidamente.</div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Notas</label>
                <textarea name="notas" class="w-full border border-gray-200 p-3 rounded-lg shadow-sm">{{ old('notas', $cliente->notas ?? '') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Raza</label>
                <input type="text" name="raza_mascota" value="{{ old('raza_mascota', $cliente->raza_mascota ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Edad (años)</label>
                <input type="number" name="edad_mascota" value="{{ old('edad_mascota', $cliente->edad_mascota ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" min="0">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Fecha nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', isset($cliente) && $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('Y-m-d') : '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Contacto de emergencia</label>
            <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia', $cliente->contacto_emergencia ?? '') }}" class="w-full border border-gray-200 p-3 rounded-full shadow-sm" placeholder="Nombre y teléfono">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Notas</label>
            <textarea name="notas" class="w-full border border-gray-200 p-3 rounded-lg shadow-sm">{{ old('notas', $cliente->notas ?? '') }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <label class="inline-flex items-center gap-3">
                <input type="checkbox" name="activo" value="1" {{ old('activo', $cliente->activo ?? true) ? 'checked' : '' }} class="h-5 w-5 text-indigo-600">
                <span class="font-semibold text-gray-700">Activo</span>
            </label>
        </div>
    </div>
</div>

<script>
    (function(){
        // Simple frontend validation for email, telefono, nombre_mascota
        document.addEventListener('DOMContentLoaded', function(){
            var form = document.getElementById('cliente-form');
            if (!form) return;

            function showError(el, message){
                var next = el.nextElementSibling;
                // If it's our error node (text-red), replace it
                if (next && next.classList && next.classList.contains('client-error')){
                    next.textContent = message;
                    return;
                }
                var d = document.createElement('div');
                d.className = 'text-red-600 text-sm mt-1 client-error';
                d.textContent = message;
                el.parentNode.insertBefore(d, el.nextSibling);
            }

            function clearError(el){
                var next = el.nextElementSibling;
                if (next && next.classList && next.classList.contains('client-error')){
                    next.remove();
                }
            }

            form.addEventListener('submit', function(e){
                var email = form.querySelector('[name="email"]');
                var telefono = form.querySelector('[name="telefono"]');
                var nombreMascota = form.querySelector('[name="nombre_mascota"]');
                var valid = true;

                // Clear previous
                [email, telefono, nombreMascota].forEach(function(el){ if (el) clearError(el); });

                // nombre_mascota required
                if (nombreMascota && nombreMascota.value.trim().length < 2){
                    showError(nombreMascota, 'El nombre de la mascota es obligatorio (mínimo 2 caracteres).');
                    valid = false;
                }

                // telefono required and pattern
                if (telefono){
                    var t = telefono.value.trim();
                    if (t.length === 0){
                        showError(telefono, 'El teléfono es obligatorio.');
                        valid = false;
                    } else {
                        var re = /^\+?[0-9]{7,15}$/;
                        if (! re.test(t)){
                            showError(telefono, 'Formato de teléfono inválido. Usa prefijo de país y sólo números (ej: +34123456789).');
                            valid = false;
                        }
                    }
                }

                // email format if present
                if (email && email.value.trim().length > 0){
                    var reEmail = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
                    if (! reEmail.test(email.value.trim())){
                        showError(email, 'Formato de correo inválido.');
                        valid = false;
                    }
                }

                if (! valid){
                    e.preventDefault();
                    window.scrollTo({ top: form.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth' });
                }
            });
        });
    })();
</script>
