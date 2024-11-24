<template>
    
</template>

<script setup lang="ts">
import { ref, watch, onMounted, computed } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useAuthStore } from '@/stores/auth';
import axios from '@/libs/axios';
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import { ElMessage } from 'element-plus';

const { user } = useAuthStore()
const page = ref(1)

const { data, isLoading, refetch } = useQuery({
    queryKey: ['booking', 'history', user.uuid],
    queryFn: async () => await axios.post('/master/booking/history', { page: page.value }).then((res: any) => res.data),
    onError: (err: any) => ElMessage.error(err.response.data.message),
    onSuccess: (res: any) => {
        if(page.value > res.last_page) page.value = res.last_page
    }
})

const pagination = computed(() => {
    let limit = data.value?.last_page <= page.value + 1 ? 5 : 2;
    return Array.from({ length: data.value?.last_page }, (_, i) => i + 1).filter(
        (i) =>
            i >= (page.value < 3 ? 3 : page.value) - limit && i <= (page.value < 3 ? 3 : page.value) + limit
    );
});
</script>