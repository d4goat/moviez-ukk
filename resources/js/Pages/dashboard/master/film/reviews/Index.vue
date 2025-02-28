<script setup lang="ts">
import { ref, h, watch, onMounted } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { Review } from '@/types';
import { useDelete } from '@/libs/hooks';
import { useRouter, useRoute } from 'vue-router';
import { useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';

const column = createColumnHelper<Review>()

const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)
const route = useRoute()
const router = useRouter()

const { delete: deleteReview } = useDelete({
    onSuccess: paginateRef.value?.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('film.title', {
        header: 'Film'
    }),
    column.accessor('user.name', {
        header: 'User'
    }),
    column.accessor('rating', {
        header: 'Rating'
    }),
    column.accessor('review', {
        header: 'Review'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
                h('button', {
                    class: 'btn btn-md bg-red-600 hover:bg-red-700',
                    onClick: () => deleteReview(`/master/review/${cell.getValue()}`)
                }, [
                    h('i', { class: 'fa fa-trash text-sm' })
                ])
            ])
    }) 
]

const refresh = () => paginateRef.value?.refetch()

watch(openForm, (val: any) => {
    if(!val){
        selected.value = ''
    }
    window.scrollTo(0, 0)
})

const { data, isLoading, refetch } = useQuery({
    queryKey: ['films'],
    queryFn: async () => axios.get(`/master/film/${route.params.uuid}`).then((res: any) => res.data.data)
})

onMounted(() => refetch())
</script>

<template>
    <main class="border-b border-body pb-3">
        <div class="w-full h-full flex flex-col rounded-lg space-y-4">
            <!-- Title -->
            <div class="border-b border-body flex items-center p-4">
                <h2 class="text-xl"> {{ data?.title }} Reviews </h2>
            </div>
            <div class="w-full h-full py-2 px-4">
                <paginate
                    ref="paginateRef"
                    id="table-reviews"
                    url="/master/review"
                    :columns="columns"
                    :payload="{uuid_film: $route.params.uuid}"
                ></paginate>
            </div>
        </div>
    </main>
</template>