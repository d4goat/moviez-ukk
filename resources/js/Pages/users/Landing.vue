<template>
    <div class="text-red-900">
        cok
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { Film } from '@/types';
import axios from '@/libs/axios';

const { data, refetch, isLoading } = useQuery({
    queryKey: ['film', 'top-rate'],
    queryFn: () => axios.get('/master/film/top-film').then((res: any) => res.data.data)
})
</script>