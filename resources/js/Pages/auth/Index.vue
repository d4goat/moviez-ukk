<template>
    <div class="h-screen w-full">
        <img src="/images/rows-red-seats-theater.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover" alt="">
        <div class="w-[43%] h-full bg-dark-bg text-white z-10 absolute top-0 left-0 items-center justify-center">
            <SignIn v-if="currentPath === '/sign-in'" />
            <SignUp v-if="currentPath === '/sign-up'" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import SignIn from './SignIn.vue';
import SignUp from './SignUp.vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const currentPath = computed(() => route.path);
</script>