<script>
import { RouterView } from 'vue-router'
import { useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { useAuthStore } from '@/stores/auth';
export default {
    setup(){
        const { data, isLoading } = useQuery({
            queryKey: ['setting'],
            queryFn: async () => axios.get('/setting').then((res) => res.data)
        })

        const { user } = useAuthStore()

        return {
            data, isLoading, user
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
        handleResize(){
            if(window.innerWidth >= 768){
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
                <span class="text-2xl text-cinema font-medium">{{ data?.name }}</span>
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <router-link v-if="!user" to="/sign-in" class="md:flex items-center gap-2 border-[2.3px] rounded-xl py-1 px-2 sm:hidden">
                        <i class="fa-regular fa-circle-user"></i>
                        Login
                    </router-link>
                    <router-link v-else class="md:flex items-center gap-2 border-[2.3px] rounded-xl py-1 px-2 sm:hidden" to="/landing/profile" >
                        <i class="fa-regular fa-circle-user"></i>
                        Account
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
                <div :class="['items-center justify-between w-full md:flex md:w-auto md:order-1', { 'hidden': !isOpen }]" id="navbar-sticky">
                    <ul
                        class="flex flex-col items-center text-base md:font-medium capitalize md:text-lg text-white rounded-lg space-y-3 md:space-y-0  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0">
                        <li>
                            <router-link to="/" class="block relative group">
                                <span>Home</span>
                                <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-gradient-to-r from-blue-500 to-green-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/#now-showing" class="block relative group">
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
                        <router-link to="/sign-in" v-show="isOpen" class="border w-full flex justify-center my-2 rounded py-1">
                            <div class="md:hidden flex items-center gap-2" :to="'/sign-in'">
                                <i class="fa-regular fa-user"></i>
                                Login
                            </div>
                        </router-link>
                    </ul>
                </div>
            </div>
        </nav>
        <RouterView class="bg-component min-h-screen" />
        <footer class="h-30 bg-[#121212] mx-10 flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-title-xl2 font-semibold text-cinema"> {{ data?.name }} </span>
                <span class="text-lg">© 2024 Cinema51. All Rights Reserved.</span>
            </div>
            <div class="flex space-x-11">
                <div class="flex flex-col space-y-2">
                    <router-link to="/" class="">Home</router-link>
                    <router-link to="/" class="">Now Showing</router-link>
                </div>
                <div class="flex flex-col space-y-2">
                    <router-link to="/" class="">Coming Soon</router-link>
                    <router-link to="/" class="">Cinema</router-link>
                </div>
                <div class="flex flex-col space-y-2">
                    <router-link to="/" class="">About Us</router-link>
                    <router-link to="/" class="">Contact Us</router-link>
                </div>
            </div>
        </footer>
    </main>
</template>