<template>
    <main class="pt-19">
        
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { block, unblock } from '@/libs/utils';
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import AOS from 'aos'



onMounted(() => AOS.init({duration: 100, once: false, mirror: true, anchorPlacement: 'top-center',}))

</script>