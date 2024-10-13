<template>
    <div class="h-full w-full">
        <img src="/images/rows-red-seats-theater.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover" alt="">
        <div class="sm:w-[43%] h-full text-white z-10 absolute left-0 items-center justify-center">
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