<div>
    @if ($totalItems > 0)
        <div class="sticky top-16 py-2 px-4 flex justify-end">
            <a href="{{ route('cart') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md">🧺 Panier ({{ $totalItems }}, {{ number_format($totalPrice, 2) }}€)</a>
        </div>
    @endif
</div>