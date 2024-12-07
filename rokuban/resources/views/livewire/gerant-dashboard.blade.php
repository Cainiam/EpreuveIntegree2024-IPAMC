<div class="container mx-auto py-8">
    <!-- Selection -->
    <div class="mb-4">
        <label for="crudSelection" class="bloc text-gray-700 text-sm font-bold mb-2">Choissisez la table :</label>
        <select wire:model.live="selectedCrud" id="crudSelection" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
            <option value="users">Utilisateurs</option>
            <option value="figures">Figurines</option>
            <option value="orders">Commandes</option>
            <option value="scales">Echelles</option>
            <option value="categories">Catégories</option>
            <option value="tvas">TVAs</option>
            <option value="shippingcompanies">Sociétés de transport</option>
            <option value="shippings">Moyens de livraison</option>
            <option value="brands">Marques</option>
            <option value="paypaltransactions">Transactions PayPal</option>
        </select>
    </div>

    <!-- Message container -->
    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- All DBtables view -->
    <div class="mb-4">
        @if($selectedCrud == 'users')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des utilisateurs</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.users.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter un utilisateur</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Pseudo</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Prénom</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Adresse</th>
                        <th class="border border-gray-300 px-4 py-2">Complément</th>
                        <th class="border border-gray-300 px-4 py-2">Code postal</th>
                        <th class="border border-gray-300 px-4 py-2">Ville</th>
                        <th class="border border-gray-300 px-4 py-2">Actif</th>
                        <th class="border border-gray-300 px-4 py-2">Date d'ajout</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $user->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->first_name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->last_name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($user->address_line_1, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($user->address_line_2, 0, 20, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->postal_code }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($user->city, 0, 20, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($user->isActive)
                                    Oui
                                @else
                                    Non
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.users.edit', $user->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                @if($user->role_id == 2)
                                    <button wire:click="confirmDeactiveUser({{ $user->id }})" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-2 rounded">
                                        @if($user->isActive)
                                            Désactiver
                                        @else
                                            Activer
                                        @endif
                                    </button>
                                    <button hidden wire:click="confirmDeletion({{ $user->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @elseif($selectedCrud == 'figures')
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des figurines</h1>
        <div class="mb-4">
            <p class="text-gray-700">Vous pouvez défiler de gauche à droite !</p>
        </div>
        <div class="mb-4">
            <button onclick="window.location.href='{{ route('gerant.figures.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une figurine</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">ID</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Nom de la figurine</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Description</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Image</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Prix TTC</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">TVA (ID)</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Marque (ID)</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Collection</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Personnage</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Nom de la série</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Sculpteur</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Matériel</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Hauteur</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Echelle (ID)</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Sortie</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Stock</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Ref.</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">EAN</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Etat</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Catégorie (ID)</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Visible?</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Ajoutée le</th>
                        <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($figures as $figure)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $figure->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($figure->name, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($figure->description, 0, 20, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">@if($figure->image_path)<img src="{{ Storage::url(''.$figure->image_path.'') }}" alt="{{ $figure->image_path }}" class="w-12 h-12 object-cover rounded-md">@else Pas d'image @endif</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($figure->price, 2) }}€</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($figure->tva_purcent * 100) }}% ({{$figure->tva_id}})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->brand_name }} ({{ $figure->brand_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->collection }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->character_name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($figure->series_title, 0, 20, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->sculptor_name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->material }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->height }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->scale_name }} ({{ $figure->scale_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->release_date }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->stock_qty }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->reference }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->ean }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->state }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->category_name }} ({{ $figure->category_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($figure->isVisible)
                                    Oui
                                @else
                                    Non
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $figure->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center whitespace-nowrap">
                                <button onclick="window.location.href='{{ route('gerant.figures.edit', $figure->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmChangingVisible({{ $figure->id }})" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-2 rounded">
                                    @if($figure->isVisible)
                                        Invisible
                                    @else
                                        Visible
                                    @endif
                                </button>
                                <button wire:click="confirmDeletion({{ $figure->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $figures->links() }}
            </div>
        </div>
        @elseif($selectedCrud == 'orders')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des commandes</h1>
            <!--<div class="mb-4">
                <button onclick="window.location.href=#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une commande</button>
            </div>-->
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Client (ID)</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
                        <th class="border border-gray-300 px-4 py-2">Prix HT</th>
                        <th class="border border-gray-300 px-4 py-2">Prix TTC</th>
                        <th class="border border-gray-300 px-4 py-2">Prix transport</th>
                        <th class="border border-gray-300 px-4 py-2">Paypal ?</th>
                        <th class="border border-gray-300 px-4 py-2">Transport (ID)</th>
                        <th class="border border-gray-300 px-4 py-2">URL Tracker</th>
                        <th class="border border-gray-300 px-4 py-2">Visible?</th>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $order->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{$order->client_first_name}} {{$order->client_last_name}} ({{ $order->user_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->status }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($order->price, 2) }}€</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($order->pricettc, 2) }}€</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($order->shipping_at_date, 2) }}€</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($order->paypal_status)
                                    {{ $order->paypal_status }}
                                @else
                                    Non utilisé
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->transport_name }} ({{ $order->shipping_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->tracker }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($order->isVisible)
                                    Oui
                                @else
                                    Non
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <a href="{{ route('gerant.orders.manage', $order->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Gérer</a>
                                <a href="{{ route('gerant.orders.invoice', $order->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded">Facture</a>
                                <a href="{{ route('gerant.orders.shipping-label', $order->id)}}" class="bg-green-700 hover:bg-green-800 text-white px-2 py-2 rounded">Etiquette</a>
                                <button wire:click="confirmDeletion({{ $order->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @elseif($selectedCrud == 'scales')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des échelles</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.scales.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une échelle</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Ajouté le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scales as $scale)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $scale->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $scale->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($scale->description, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $scale->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.scales.edit', $scale->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmDeletion({{ $scale->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $scales->links() }}
            </div>
            @elseif($selectedCrud == 'categories')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des catégories</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.categories.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une catégorie</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Ajouté le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $category->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($category->description, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $category->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.categories.edit', $category->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmDeletion({{ $category->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
            @elseif($selectedCrud == 'tvas')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des TVAs</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.tvas.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une TVA</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Pourcentage (encodé "0,XX")</th>
                        <th class="border border-gray-300 px-4 py-2">Ajoutée le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tvas as $tva)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $tva->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $tva->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($tva->purcent * 100) }}%</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $tva->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.tvas.edit', $tva->id) }}'" class="bg-blue-500 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmDeletion({{ $tva->id }})" class="bg-red-500 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $tvas->links() }}
            </div>
            @elseif($selectedCrud == 'shippingcompanies')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des sociétés de transport</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.shippingcompanies.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une société</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Ajoutée le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shippingcompanies as $shippingcompany)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $shippingcompany->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $shippingcompany->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($shippingcompany->description, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $shippingcompany->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.shippingcompanies.edit', $shippingcompany->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmDeletion({{ $shippingcompany->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $shippingcompanies->links() }}
            </div>
            @elseif($selectedCrud == 'shippings')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des moyens de livraison</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.shippings.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une livraison</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Société (ID)</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Prix</th>
                        <th class="border border-gray-300 px-4 py-2">Visible?</th>
                        <th class="border border-gray-300 px-4 py-2">Ajouté le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shippings as $shipping)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $shipping->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $shipping->shippingcompany_name }} ({{ $shipping->shippingcompany_id }})</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $shipping->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($shipping->description, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($shipping->price, 2) }}€</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($shipping->isVisible)
                                    Oui
                                @else
                                    Non
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $shipping->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.shippings.edit', $shipping->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmChangingVisible({{ $shipping->id }})" class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-2 rounded">
                                    @if($shipping->isVisible)
                                        Invisible
                                    @else
                                        Visible
                                    @endif
                                </button>
                                <button wire:click="confirmDeletion({{ $shipping->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $shippings->links() }}
            </div>
            @elseif($selectedCrud == 'brands')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des marques</h1>
            <div class="mb-4">
                <button onclick="window.location.href='{{ route('gerant.brands.add') }}'" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Ajouter une marque</button>
            </div>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Ajoutée le</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $brand->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $brand->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ mb_strimwidth($brand->description, 0, 30, "...") }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $brand->created_at->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <button onclick="window.location.href='{{ route('gerant.brands.edit', $brand->id) }}'" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded">Editer</button>
                                <button wire:click="confirmDeletion({{ $brand->id }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        @elseif($selectedCrud == 'paypaltransactions')
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Liste des transactions avec PayPal :</h1>
            <table class="min-w-full bg-white shadow">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">ID de paypal</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
                        <th class="border border-gray-300 px-4 py-2">Prix</th>
                        <th class="border border-gray-300 px-4 py-2">Devise</th>
                        <th class="border border-gray-300 px-4 py-2">ID de la commande</th>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paypaltransactions as $paypaltransaction)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2 bg-blue-50">{{ $paypaltransaction->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->paypal_transactions_id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->paypal_transactions_status }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->paypal_pricewtax }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->paypal_currency_code }} </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->order_id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $paypaltransaction->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $paypaltransactions->links() }}
            </div>
        @else
            <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 shadow">Non-géré</h1>
        @endif

        <!-- Confirmation box for deletion of an item -->
        @if ($confirmingDeletion)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-red-50 rounded-lg shadow-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Êtes vous sur de vouloir supprimer
                                @if($selectedCrud == 'users')
                                    cet utilisateur
                                @elseif($selectedCrud == 'figures')
                                    cette figurine
                                @elseif($selectedCrud == 'orders')
                                    cette commande
                                @elseif($selectedCrud == 'scales')
                                    cette échelle
                                @elseif($selectedCrud == 'categories')
                                    cette catégorie
                                @elseif($selectedCrud == 'tvas')
                                    cette tva
                                @elseif($selectedCrud == 'shippingcompanies')
                                    cette société de transport
                                @elseif($selectedCrud == 'shippings')
                                    ce moyen de transport
                                @else <!-- last is brands -->
                                    cette marque
                                @endif
                                ?
                            </h3>
                            <div class="mt-4 flex space-x-4">
                                <button wire:click="deleteById" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Supprimer</button>
                                <button wire:click="$set('confirmingDeletion', false)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($confirmingVisible)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-red-50 rounded-lg shadow-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Êtes vous sur de vouloir rendre
                                @if($selectedCrud == 'figures')
                                    @if($figure->isVisible)
                                        invisible
                                    @else
                                        visible
                                    @endif
                                    cette figurine
                                @elseif($selectedCrud == 'shippings')
                                    @if($shipping->isVisible)
                                        invisible
                                    @else
                                        visible
                                    @endif
                                    ce moyen de transport
                                @else <!-- last is orders if we decided to use isVisible -->
                                    @if($order->isVisible)
                                        invisible
                                    @else
                                        visible
                                    @endif
                                    cette commande
                                @endif
                                ?
                            </h3>
                            <div class="mt-4 flex space-x-4">
                                <button wire:click="changingVisibleById" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Changer visibilité</button>
                                <button wire:click="$set('confirmingVisible', false)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($confirmingDeactivation)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-red-50 rounded-lg shadow-xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Êtes vous sur de vouloir rendre
                                @if($user->isActive)
                                    inactif
                                @else
                                    actif
                                @endif
                                cet utilisateur ?
                            </h3>
                            <div class="mt-4 flex space-x-4">
                                <button wire:click="deactiveUserById" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Modifier</button>
                                <button wire:click="$set('confirmingDeactivation', false)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>