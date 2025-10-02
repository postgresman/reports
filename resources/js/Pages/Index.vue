<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" />
        <div
            class="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full">
                <main class="mt-16 w-full px-4 sm:px-6 lg:px-8">
                    <router-view />
                </main>
            </div>
        </div>
    </div>
</template>