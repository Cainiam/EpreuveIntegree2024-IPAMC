<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon profil') }}
        </h2>
    </x-slot>

    <!-- Adding error to display if user didn't completed his profile before trying to pay -->
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">{{ session('error') }}</div>
    @endif
    <!-- endif error profile not completed-->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

             <!-- Adding form for personnal information (more about in the source livewire) -->
             <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-personnal-information-form />
                </div>
            </div>
            <!-- end -->

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
