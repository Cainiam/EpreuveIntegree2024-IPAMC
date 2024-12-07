<!-- Script for carousel management -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.querySelector('.carousel .carousel-inner');
        const figures = document.querySelectorAll('.carousel-item');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');
        let index = 0;

        const updateCarousel = () => {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        };

        const showPrev = () => {
            index = (index - 1 + figures.length) % figures.length;
            updateCarousel();
        };

        const showNext = () => {
            index = (index + 1) % figures.length;
            updateCarousel();
        };

        prevBtn.addEventListener('click', showPrev);
        nextBtn.addEventListener('click', showNext);

        setInterval(showNext, 3000); // 3 sec
    });
</script>
<!-- end script -->

<x-app-layout>
    <div class="container mx-auto py-8">
        <!-- Message container -->
        @if(session()->has('message'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Carousel section -->
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Nos nouveautés :</h1>
        <div class="carousel w-full overflow-hidden rounded-lg shadow-lg mb-8 bg-white relative">
            <div class="carousel-inner flex transition-transform duration-500 ease-in-out transform">
                @foreach($carouselFigures as $figure)
                    <div class="carousel-item w-full flex-shrink-0 flex flex-col items-center">
                        <div class="w-full flex items-center justify-center">
                            @if($figure->image_path)
                                <a href="{{ route('figures.show', $figure->id) }}">
                                    <img src="{{ Storage::url($figure->image_path) }}" alt="{{ $figure->name }}" class="max-h-80 w-auto object-contain">
                                </a>
                            @else <!-- if no image_path but better to avoid this view -->
                                <a href="{{ route('figures.show', $figure->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">
                                    Image non-définie, cliquez-ici
                                </a>
                            @endif
                        </div>
                        <div class="bg-white flex flex-col p-4 items-center justify-center">
                            <h2 class="text-lg font-semibold">{{ $figure->name }}</h2>
                            <p class="text-gray-600">{{ number_format($figure->price, 2) }}€</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-prev absolute top-1/2 left-4 transform -translate-y-1/2 bg-blue-700 text-white p-2 rounded-full shadow-lg hover:bg-blue-500">
                🡄
            </button>
            <button class="carousel-next absolute top-1/2 right-4 transform -translate-y-1/2 bg-blue-700 text-white p-2 rounded-full shadow-lg hover:bg-blue-800">
                🡆
            </button>
        </div>

        <!-- Grid section -->
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Nos derniers produits ajoutés :</h1>
        <div class="grid grid-cols-5 gap-4 mb-8">
            @foreach($gridFigures as $figure)
                <div class="border rounded-lg shadow-lg p-4 text-center bg-white">
                    @if($figure->image_path)
                        <a href="{{ route('figures.show', $figure->id) }}">
                            <img src="{{ Storage::url($figure->image_path) }}" alt="{{ $figure->name }}" class="w-full h-auto object-cover mb-4">
                        </a>
                    @else <!-- if no image_path but better to avoid this view -->
                        <a href="{{ route('figures.show', $figure->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">
                            Image non-définie, cliquez-ici
                        </a>
                    @endif
                    <h2 class="text-lg font-semibold">{{ $figure->name }}</h2>
                    <p class="text-gray-600">{{ number_format($figure->price, 2) }}€</p>
                </div>
            @endforeach
        </div>

        <!-- Text section -->
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">À propos de nous :</h1>
        <div class="text-center text-gray-700 leading-relaxed border border-gray-300 bg-white mb-4 p-4 shadow">
            <p class="text-red-600">! CE SITE EST UNE DÉMO DANS LE CADRE D'UNE ÉPREUVE INTÉGRÉE (ÉPREUVE DE FIN D'ÉTUDE) POUR L'IPAM ÉCAUSSINNES, LES INFOS SONT FACTICES !</p>
            <p>Rokuban existe depuis l'hiver 2018 et son site a été créé en novembre 2024. Notre site vous permettra d'acheter en toute sérénité des produits dérivés d'animation japonaise sous licence.</p>
            <p>Nous sommes également présents physiquement à 7130 Binche (Belgique), situé au numéro 86 de l'Avenue Charles Deliège, notre unique magasin physique où vous pourrez retrouver la majorité de notre assortiment de figurines.</p>
        </div>
    </div>
</x-app-layout>
