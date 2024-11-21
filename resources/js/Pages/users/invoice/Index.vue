<template>
    <main class="pt-21">
        {{ data }}
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { ElMessage } from 'element-plus';

const route = useRoute()

const { data, isLoading } = useQuery({
    queryKey: ['invoice', route.params.uuid],
    queryFn: async () => await axios.get(`/master/booking/${route.params.uuid}`).then((res: any) => res.data.data),
    onError: (err: any) => ElMessage.error(err.response.data.message)
})
</script>