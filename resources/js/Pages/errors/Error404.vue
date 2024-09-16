<template>
    <div class="flex flex-col items-center justify-center min-h-screen p-10 bg-dark-bg">
        <!-- Content -->
        <div class="flex flex-col items-center text-center w-full max-w-2xl p-5 bg-grey rounded-xl">
            <!-- Title -->
            <h1 class="text-4xl font-bold text-gray-200 mb-4">Oops!</h1>
            <!-- Text -->
            <p class="text-lg text-gray-300 mb-7">We can't find that page.</p>
            <!-- Illustration -->
            <div class="mb-3">
                <img
                    src="images/auth/404-error-dark.png"
                    class="max-w-full h-96 block"
                    alt=""
                />
            </div>
            <!-- Link -->
            <router-link to="/" class="text-white py-2 px-4 rounded-md bg-cinema ">
                Return Home
            </router-link>
        </div>
    </div>
</template>