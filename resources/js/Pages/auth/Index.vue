<template>
    <div class="h-full w-full">
        <img src="/images/rows-red-seats-theater.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover saturate-50" alt="">
        <div class="sm:w-[43%] h-full text-white z-10 absolute left-0 items-center justify-center bg-[#171717]">
            <RouterView/>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import SignIn from './SignIn.vue';
import SignUp from './SignUp.vue';
import { useRoute, RouterView } from 'vue-router';

const route = useRoute();
const currentPath = computed(() => route.path);
</script>