<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Mes commandes :</h1>
        <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border border-gray-300 px-4 py-2">Commande</th>
                    <th class="border border-gray-300 px-4 py-2">Statut</th>
                    <th class="border border-gray-300 px-4 py-2">Date</th>
                    <th class="border border-gray-300 px-4 py-2">Prix TTC</th>
                    <th class="border border-gray-300 px-4 py-2">Transport</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">#{{ $order->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->status }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($order->pricettc, 2) }}€</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($order->shipping_at_date, 2) }}€</td>
                        <td class="border border-gray-300 px-2 py-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">🛈 Détails</a>
                            <a href="{{route('orders.invoice', $order->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg">⇓ Facture</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Vous n'avez encore réalisée aucune commande.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>