<template>
    <main class="pt-19 flex flex-row space-x-6 px-2">
        <div class="w-1/3 h-full p-3 rounded card bg-component text-white shadow-3 shadow-cyan-500/30">
            <div class="card-body flex flex-col">
                <img :src="user.photo ?? '/images/user/blank.png'" class="h-44 w-44 object-cover rounded-lg" alt="">
                <div class="flex flex-col mt-3 space-y-2">
                    <span class="text-lg font-medium"> {{ user.name }} </span>
                    <span class="font-medium text-gray-400"> <i class="fa-solid fa-envelope mr-1"></i> {{ user.email }} </span>
                    <span class="font-medium text-gray-400"> <i class="fa-solid fa-phone mr-1"></i> {{ user.phone }} </span>
                </div>
            </div>
        </div>
        <div class="w-2/3 h-full p-3 rounded card bg-component text-white shadow-3 shadow-cyan-500/30 flex flex-row">
            <div class="flex flex-col w-1/3 p-4 space-y-3">
                <div @click="activeTab = 1" role="button" class="flex items-center space-x-3 py-2 px-3 rounded-lg" :class="activeTab === 1 ? 'bg-cyan-300/30 text-cyan-500' : 'bg-gray-300/10 text-gray-300'">
                    <i class="la la-user fs-5"></i>
                    <span class="font-medium">Akun</span>
                </div>
                <div @click="activeTab = 2" role="button" class="flex items-center space-x-3 py-2 px-3 rounded-lg" :class="activeTab === 2 ? 'bg-cyan-300/30 text-cyan-500' : 'bg-gray-300/10 text-gray-300'">
                    <i class="la la-key fs-5"></i>
                    <span class="font-medium">Password</span>
                </div>
            </div>
            <transition name="fade" mode="out-in">
                <component :is="activeTabComponent" />
            </transition>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import Personal from './tabs/Personal.vue';
import Security from './tabs/Security.vue';
import { useAuthStore } from '@/stores/auth';

const { user } = useAuthStore();

const activeTab = ref(1);

const activeTabComponent = computed(() => {
    return activeTab.value === 1 ? Personal : Security;
});
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
