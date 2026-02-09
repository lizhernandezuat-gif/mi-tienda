<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> DogCat SaaS | El SaaS Veterinario del Futuro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Animación suave para el degradado */
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #9333ea, #db2777);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-purple-200 selection:text-purple-900">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <div class="bg-gradient-to-br from-purple-600 to-pink-500 text-white p-2 rounded-lg shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">DogCat<span class="text-purple-600">SaaS</span></span>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-500 hover:text-purple-600 font-medium transition">Funcionalidades</a>
                    <a href="#demo" class="text-gray-500 hover:text-purple-600 font-medium transition">Demo</a>
                    <a href="#precios" class="text-gray-500 hover:text-purple-600 font-medium transition">Precios</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-700 font-semibold px-4 py-2 transition">
                        Iniciar Sesión
                    </a>
                    
                    <a href="{{ route('veterinarias.setup') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-bold rounded-full text-white bg-gray-900 hover:bg-gray-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Prueba Gratis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-purple-100 text-purple-700 text-sm font-semibold mb-8 shadow-sm border border-purple-200">
                <span class="flex h-2 w-2 relative mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                v1.0 Lanzamiento Oficial
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-6">
                Gestiona tu veterinaria <br>
                <span class="gradient-text">sin el caos del papel.</span>
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10">
                La plataforma todo-en-uno para clínicas modernas. Historias clínicas, control de pacientes y seguridad nivel bancario en un solo lugar.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('veterinarias.setup') }}" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-1 transition-all duration-300 text-lg">
                     Empezar Ahora Gratis
                </a>
                <a href="#demo" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-xl shadow-md border border-gray-200 hover:bg-gray-50 transition-all duration-300 text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-1.5a1 1 0 000-1.764l-3-1.5z" clip-rule="evenodd" />
                    </svg>
                    Ver Demo
                </a>
            </div>

        </div>

        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        </div>
        <div class="mt-16 relative max-w-5xl mx-auto">
                <div class="relative rounded-2xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4 transform hover:scale-105 transition-transform duration-500 ease-out">
                    <img src="{{ asset('img/dashboard-demo.png') }}" 
     alt="Captura del Sistema DogCat" 
     class="rounded-xl shadow-2xl ring-1 ring-gray-900/10 w-full object-cover">
                    
                    <div class="absolute -top-4 -right-4 bg-white p-4 rounded-lg shadow-xl border border-gray-100 animate-bounce hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Nuevo Paciente</p>
                                <p class="font-bold text-gray-800">"Firulais" Agregado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
   <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center mb-16">
                <h2 class="text-base font-semibold leading-7 text-purple-600">Todo lo que necesitas</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Deja de sufrir con Excel</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">DogCat SaaS está diseñado específicamente para veterinarias que quieren crecer, no solo sobrevivir.</p>
            </div>
            
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    
                    <div class="flex flex-col bg-gray-50 p-8 rounded-2xl transition-all hover:-translate-y-2 hover:shadow-lg border border-gray-100">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-purple-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            Seguridad Blindada
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Tus datos son solo tuyos. Usamos aislamiento Multi-Tenant para que ninguna otra clínica pueda ver tu información.</p>
                        </dd>
                    </div>

                    <div class="flex flex-col bg-gray-50 p-8 rounded-2xl transition-all hover:-translate-y-2 hover:shadow-lg border border-gray-100">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-pink-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            Expedientes Digitales
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Olvídate del papel. Registra dueños, mascotas e historiales clínicos en segundos desde cualquier dispositivo.</p>
                        </dd>
                    </div>

                    <div class="flex flex-col bg-gray-50 p-8 rounded-2xl transition-all hover:-translate-y-2 hover:shadow-lg border border-gray-100">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-blue-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Acceso 24/7
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Tu clínica no duerme (bueno, a veces). Accede a tu información desde casa, celular o tablet cuando lo necesites.</p>
                        </dd>
                    </div>

                </dl>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 py-12 text-center text-gray-400">
        <p>© 2026 DogCat SaaS. Creado con ❤️ para la clase de Desarrollo Web.</p>
    </footer>
</body>
</html>