<template>
    <main class="pt-19 pb-5 flex flex-row space-x-6 px-2">
        <div class="w-1/3 h-full p-3 rounded card bg-component text-white shadow-3 shadow-cyan-500/30">
            <div class="card-body flex flex-col">
                <img :src="user.photo ?? '/images/user/blank.png'" class="h-44 w-44 object-cover rounded-lg" alt="">
                <div class="flex flex-col mt-3 space-y-2">
                    <span class="text-lg font-medium"> {{ user.name }} </span>
                    <span class="font-medium text-gray-400"> <i class="fa-solid fa-envelope mr-1"></i> {{ user.email }}
                    </span>
                    <span class="font-medium text-gray-400"> <i class="fa-solid fa-phone mr-1"></i> {{ user.phone }}
                    </span>
                    <div @click="logout" class="flex gap-3 border-t border-gray-700 mt-4 py-3 text-gray-300 font-medium cursor-pointer">
                        <LogOut />
                        <span>Log Out</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-2/3 h-full p-3 rounded card bg-component text-white shadow-3 shadow-cyan-500/30 flex flex-row">
            <TabGroup>
                <TabList class="flex flex-col w-1/3 p-4 space-y-3">
                    <TransitionGroup enter-active-class="transition duration-300 ease-out"
                        enter-from-class="transform opacity-0 -translate-x-4"
                        enter-to-class="transform opacity-100 translate-x-0"
                        leave-active-class="transition duration-300 ease-in"
                        leave-from-class="transform opacity-100 translate-x-0"
                        leave-to-class="transform opacity-0 -translate-x-4">
                        <Tab v-for="category in categories" :key="category" as="div" v-slot="{ selected }"
                            class="focus:outline-none focus:ring-0">
                            <button
                                :class="['w-full flex items-center py-2 px-3 rounded-lg md:text-sm lg:text-base font-medium', selected ? 'bg-cyan-300/30 text-cyan-500' : 'bg-gray-300/10 text-gray-300']">
                                <i :class="['la fs-5 mr-2', category == 'Akun' ? 'la-user' : category == 'Password' ? 'la-key' : 'la-history']"></i>
                                {{ category }}
                            </button>
                        </Tab>
                    </TransitionGroup>
                </TabList>
                <TabPanels class="w-full">
                    <TransitionGroup enter-active-class="transition duration-500 ease-out"
                        enter-from-class="transform opacity-0 translate-y-4"
                        enter-to-class="transform opacity-100 translate-y-0"
                        leave-active-class="transition duration-500 ease-in"
                        leave-from-class="transform opacity-100 translate-y-0"
                        leave-to-class="transform opacity-0 translate-y-4">
                        <TabPanel v-for="(category, index) in categories" :key="category" class="tab-panel">
                            <Personal v-if="index === 0" />
                            <Security v-else-if="index === 1" />
                            <History v-else/>
                        </TabPanel>
                    </TransitionGroup>
                </TabPanels>
            </TabGroup>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import Personal from './tabs/Personal.vue';
import Security from './tabs/Security.vue';
import History from './tabs/History.vue';
import { useAuthStore } from '@/stores/auth';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import { LogOut } from 'lucide-vue-next';
import Swal from 'sweetalert2';

const categories = ref(['Akun', 'Password', 'History'])

const { user } = useAuthStore();

const logout = () => {
    return Swal.fire({
        title: "Are you sure to logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Logout",
        cancelButtonText: "Cancel",
        reverseButtons: true,
        customClass: {
            confirmButton: "btn btn-danger btn-md py-2 ml-3 font-medium",
            cancelButton: "btn btn-secondary btn-md py-2 mr-3 font-medium",
        },
    }).then((result: Object) => {
        if (result.isConfirmed) {
            useAuthStore().purgeAuth();
            Swal.fire({
                icon: "success",
                text: "Success logout",
            }).then(() => {
                window.location.reload()
            });
        }
    });
}
</script>
