<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"> 
        <div class="min-h-screen bg-gray-100 flex flex-col"> <!-- some classes added by Boisdenghien Jordan here to use all screen even if not enough content inside page -->
            @auth <!-- Navigation if auth, added by Boisdenghien Jordan -->
                <div class="sticky top-0 z-50 bg-white shadow-md"> <!-- added by Boisdenghien Jordan, navigation now sticky on top -->
                    <livewire:layout.navigation />
                </div> <!-- added by Boisdenghien Jordan -->
            @else
                <div class="sticky top-0 z-50 bg-white shadow-md">
                    <livewire:layout.navigation-guest />
                </div>
            @endauth

            <!-- Sticky cart, added by Boisdenghien Jordan -->
            @if(in_array(Route::currentRouteName(), ['home', 'figures.index', 'figures.show']))
                <livewire:cart-summary wire:key="cart-summary" />
            @endif
            <!-- End of added by Boisdenghien Jordan -->

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow"> <!-- class added by Boisdenghien Jordan here to use all screen even if not enough content inside page -->
                {{ $slot }}
            </main>

            <!-- Footer Content (Added by Boisdenghien Jordan in Laravel auto created app blade php) -->
            <footer class="bg-blue-950 text-white py-8">
                <div class="container mx-auto grid grid-cols-3 gap-8">
                    <div> <!-- Left -->
                        <h3 class="font-bold text-lg mb-4">Liens utiles :</h3>
                        <ul>
                            <li><a href="{{ route('legal') }}" class="hover:underline">Mentions légales</a></li>
                            <li><a href="{{ route('retract') }}" class="hover:underline">Délais de 14 jours</a></li>
                            <li><a href="{{ route('polconf') }}" class="hover:underline">Politique de confidentialité</a></li>
                        </ul>
                    </div>

                    <div class="text-center"> <!-- Center -->
                        <h3 class="font-bold text-lg mb-4">Mon compte :</h3>
                        <ul>
                            @auth
                                <li><a href="{{ route('profile') }}" class="hover:underline">Informations personnelles</a></li>
                                <li><a href="{{ route('orders.index') }}" class="hover:underline">Mes commandes</a></li>
                                <li><a href="{{ route('cart') }}" class="hover:underline">Mon panier</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="hover:underline">Connexion</a></li>
                                <li><a href="{{ route('register') }}" class="hover:underline">Inscription</a></li>
                                <li><a href="{{ route('cart') }}" class="hover:underline">Mon panier</a></li>
                            @endauth
                        </ul>
                    </div>

                    <div class="text-right"> <!-- Right -->
                        <h3 class="font-bold text-lg mb-4">Notre magasin :</h3>
                        <p>Av. Charles Deliège 86<br>7130 Binche (BELGIQUE)<br><span class="font-semibold">Téléphone:</span> 0475/11.22.33</p>
                        <p>admin@rokuban.com<br>TVA BE 0123 456 789</p>
                        <p><span class="font-semibold">Horaire d'ouverture :</span><br>Lun - Ven, 8h30 - 18h30</p>
                    </div>
                </div>
                <div class="bg-blue-950 text-white text-center"> <!-- Copyright bottom -->
                    © 2024 - {{now()->format('Y')}} Rokuban SRL
                </div>
            </footer>
            <!-- End (of added by) Boisdenghien Jordan -->
        </div>
    </body>
</html>
