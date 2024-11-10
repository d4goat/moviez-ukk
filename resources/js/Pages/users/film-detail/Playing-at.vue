<template>
    <main class="pt-21">
        
    </main>    
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useRoute } from 'vue-router';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';

const route = useRoute()

const { data, isLoading, refetch } = useQuery({
    queryKey: ['show-time', 'playing-at'],
    queryFn: async () => await axios.post('/master/show-time/get-list', { uuid: route.params.uuid }).then((res: any) => res.data.data)
})
</script>