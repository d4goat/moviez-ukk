<script>
import { RouterView } from 'vue-router'
// import { useDark, useToggle } from "@vueuse/core"

// // const isDark = useDark()
// // const toggleDark = useToggle(isDark)
</script>

<template>
    <div class="dark:bg-dark-bg bg-white text-white">
        <nav class="h-20 pb-[0.2rem] bg-gradient-to-r from-gradient-left to-gradient-right">
            <div class="w-full h-full flex items-center justify-between bg-dark-bg">
                <div class="mx-10 w-1/3">
                    <ul class="w-full flex flex-row justify-between capitalize text-lg font-medium">
                        <router-link class="hover:text-green-600 transition-all" :to="'/'">home</router-link>
                        <router-link class="hover:text-green-600 transition-all"
                            :to="'/admin/dashboard'">film</router-link>
                        <router-link class="hover:text-green-600 transition-all" :to="'/'">bioskop</router-link>
                        <router-link class="hover:text-green-600 transition-all" :to="'/'">contact</router-link>
                    </ul>
                </div>
                <div class="mx-10 w-1/5 flex gap-4">
                    <ul>
                        <router-link :to="'/sign-up'">Sign Up</router-link>
                    </ul>
                    <ul>
                        <router-link :to="'/sign-in'" >Sign In</router-link>
                    </ul>
                </div>
            </div>
        </nav>
        <RouterView class="p-5" />
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