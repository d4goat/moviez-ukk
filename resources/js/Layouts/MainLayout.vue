<script>
import { RouterView } from 'vue-router'
export default {
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        }
    }
}
</script>

<template>
    <div class="dark:bg-dark-bg bg-white text-white">
        <nav class="bg-dark-bg dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b-[3px] border-cinema dark:border-gray-600">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <span class="text-2xl text-cinema font-medium">Cinema51</span>
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <div class="flex items-center gap-2 border-[2.3px] rounded-xl py-1 px-2">
                        <i class="fa-regular fa-circle-user"></i>
                        <router-link :to="'/sign-in'">Login</router-link>
                    </div>
                    <button @click="toggle" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-sticky" :aria-expanded="isOpen">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <div :class="['items-center justify-between w-full md:flex md:w-auto md:order-1', { 'hidden': !isOpen }]" id="navbar-sticky">
                    <ul
                        class="flex flex-col font-medium capitalize text-lg text-white rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Home</span>
                                <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Now Showing</span>
                                <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Coming Soon</span>
                                <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Cinema</span>
                                <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <RouterView class="p-5 min-h-screen bg-dark-bg" />
        <footer class="h-32 bg-zinc-800 p-5">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="mb-6 md:mb-0">
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>