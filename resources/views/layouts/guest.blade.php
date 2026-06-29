<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MR RO POS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="font-sans antialiased h-full text-slate-900">
        
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            
            <div class="hidden lg:block relative bg-slate-900">
                <img 
                    src="{{ asset('images/pos-hardware.png') }}" 
                    alt="POS Hardware Ecosystem" 
                    class="absolute inset-0 h-full w-full object-cover opacity-85"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/40 to-transparent flex flex-col justify-end p-12">
                    <h2 class="text-3xl font-bold text-white tracking-tight">
                        Streamline Your Business Operations
                    </h2>
                    <p class="mt-2 text-base text-slate-300 max-w-md">
                        An all-in-one Point of Sale solution engineered for reliability, lightning-fast transactions, and seamless inventory management.
                    </p>
                </div>
            </div>

            <div class="flex flex-col justify-center px-6 py-12 sm:px-16 lg:px-20 bg-slate-50/50 backdrop-blur-sm">
                
                <div class="mx-auto w-full max-w-md">
                    <div class="text-center lg:text-center mb-10">
                        <a href="/" class="inline-flex items-center gap-2 group focus:outline-none">
                            <span class="text-4xl font-black tracking-wider text-slate-800 group-hover:text-indigo-600 transition-colors duration-200">
                                MR <span class="text-indigo-600">RO</span>
                            </span>
                        </a>
                        <p class="mt-3 text-sm text-slate-500 font-medium">
                            Point of Sale Dashboard Login
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
                        {{ $slot }}
                    </div>
                    
                </div>

            </div>

        </div>

    </body>
</html>