<template>
    <div class="text-red-900">
        <img :src="setting.logo" alt="" srcset="">
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { Film } from '@/types';
import axios from '@/libs/axios';

const { data: review, refetch, isLoading } = useQuery({
    queryKey: ['film', 'top-rate'],
    queryFn: () => axios.get('/master/film/top-film').then((res: any) => res.data.data)
})

const { data: setting, refetch: refetchSetting } = useQuery({
    queryKey: ['setting', 'show'],
    queryFn: async () => await axios.get('/setting').then((res: any) => res.data)
})

onMounted(() => {
    refetch()
    refetchSetting()
})
</script>