<script>
import { useSetting } from '@/services';
import { RouterView } from 'vue-router';
import { useDarkModeStore } from '@/stores/darkMode';
import { useAuthStore } from '@/stores/auth';

export default {
    setup() {
        const { data: setting = {} } = useSetting()

        const auth = localStorage.getItem('auth_key')
        const darkModeStore = useDarkModeStore()
        const { user } = useAuthStore()
        return {
            setting, auth, darkModeStore, user
        }
    },
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        },
        handleResize() {
            if (window.innerWidth >= 768) {
                this.isOpen = false
            }
        },
    },
    mounted() {
        window.addEventListener('resize', this.handleResize)
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize)
    },
}
</script>

<template>
    <main class="text-white">
        <nav class="bg-dark-bg/20 backdrop-blur-md fixed w-full z-20 top-0 start-0">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-3">
                <router-link to="/" class="text-2xl text-cinema font-semibold">{{ setting?.name }}</router-link>
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <router-link v-if="!auth" to="/sign-in"
                        class="md:flex items-center gap-2 border-[2.5px] rounded-xl py-1 px-2 hidden">
                        <i class="fa-regular fa-circle-user"></i>
                        <span class="mb-1 font-medium">Login</span>
                    </router-link>
                    <router-link v-else class="md:flex items-center gap-2 border-[2.5px] rounded-xl py-1 px-2 hidden"
                        to="/landing/profile">
                        <i class="fa-regular fa-circle-user"></i>
                        <span class="mb-1 font-medium">Account</span>
                    </router-link>
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
                <div :class="['items-center justify-between w-full md:flex md:w-auto mt-2 md:order-1', { 'hidden': !isOpen }]"
                    id="navbar-sticky">
                    <ul
                        class="flex flex-col items-center text-base md:font-medium capitalize md:text-lg text-white rounded-lg space-y-3 md:space-y-0  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Home</span>
                                <span
                                    class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/#now-showing" class="block relative group">
                                <span>Now Showing</span>
                                <span
                                    class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/#coming-soon" class="block relative group">
                                <span>Coming Soon</span>
                                <span
                                    class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/landing/cinema" class="block relative group">
                                <span>Cinema</span>
                                <span
                                    class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link v-if="user.role?.full_name == 'Administrator'" to="/admin/dashboard" class="block relative group">
                                <span>Admin</span>
                                <span
                                    class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <router-link v-if="!auth" to="/sign-in" v-show="isOpen"
                            class="border w-full flex justify-center my-2 rounded py-1">
                            <div class="md:hidden flex items-center gap-2" :to="'/sign-in'">
                                <i class="fa-regular fa-user"></i>
                                Login
                            </div>
                        </router-link>
                        <router-link v-else to="/landing/profile" v-show="isOpen"
                            class="border w-full flex justify-center my-2 rounded py-1">
                            <div class="md:hidden flex items-center gap-2" :to="'/sign-in'">
                                <i class="fa-regular fa-user"></i>
                                Account
                            </div>
                        </router-link>
                    </ul>
                </div>
            </div>
        </nav>
        <RouterView class="bg-component min-h-screen" />
        <footer class="py-8 bg-[#121212] text-white">
            <div class="container mx-auto px-6 lg:px-16">
              <!-- Upper Section -->
              <div class="flex flex-wrap justify-between items-center gap-8 lg:gap-0">
                <!-- Logo and Description -->
                <div class="flex flex-col space-y-3">
                  <span class="text-2xl lg:text-4xl font-semibold text-cinema">
                    {{ setting?.name }}
                  </span>
                  <span class="text-sm lg:text-base text-gray-400">
                    Experience movies like never before. Your perfect cinema partner.
                  </span>
                </div>
        
                <!-- Navigation Links -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                  <router-link to="/" class="hover:text-cinema transition">Home</router-link>
                  <router-link to="/#now-showing" class="hover:text-cinema transition">Now Showing</router-link>
                  <router-link to="/landing/coming-soon" class="hover:text-cinema transition">Coming Soon</router-link>
                  <router-link to="/landing/cinema" class="hover:text-cinema transition">Cinema</router-link>
                  <router-link to="/about" class="hover:text-cinema transition">About Us</router-link>
                  <router-link to="/contact" class="hover:text-cinema transition">Contact Us</router-link>
                </div>
              </div>
        
              <!-- Divider -->
              <div class="my-6 border-t border-gray-700"></div>
        
              <!-- Lower Section -->
              <div class="flex flex-wrap justify-between items-center gap-4 lg:gap-0">
                <!-- Copyright -->
                <span class="text-sm lg:text-base text-gray-400">
                  © 2024 Matix Cineplex. All Rights Reserved.
                </span>
        
                <!-- Social Media Links -->
                <div class="flex space-x-4">
                  <a href="https://facebook.com" target="_blank" class="hover:text-cinema transition">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                  <a href="https://twitter.com" target="_blank" class="hover:text-cinema transition">
                    <i class="fab fa-twitter"></i>
                  </a>
                  <a href="https://instagram.com" target="_blank" class="hover:text-cinema transition">
                    <i class="fab fa-instagram"></i>
                  </a>
                  <a href="https://youtube.com" target="_blank" class="hover:text-cinema transition">
                    <i class="fab fa-youtube"></i>
                  </a>
                </div>
              </div>
            </div>
          </footer>
    </main>
</template>