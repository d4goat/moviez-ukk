<script setup lang="ts">
import { ref, h, watch, onMounted } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { Review } from '@/types';
import Form from './Form.vue'
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
    column.accessor('rating', {
        header: 'Rating'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
                h('button', {
                    class: 'btn btn-md btn-info',
                    onClick: () => {
                        selected.value = cell.getValue()
                        openForm.value = true
                    }
                }, [
                    h('i', { class: 'fa fa-pencil fs-2' })
                ]),
                h('button', {
                    class: 'btn btn-md btn-danger',
                    onClick: () => deleteReview(`/master/review/${cell.getValue()}`)
                }, [
                    h('i', { class: 'fa fa-trash fs-2' })
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
    <main class="border-b pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />
        
    </main>
</template>