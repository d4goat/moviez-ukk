<template>
    <div class="flex flex-col justify-center mr-3 flex-wrap">
        <template v-if="pageTitle">
            <h1 class="flex text-gray-500 font-medium text-xl flex-col justify-center my-0"> {{ pageTitle }} </h1>

            <ul v-if="breadcrumb" class="breadcrumb breadcrumb-separatorless fw-semibold text-sm my-0 pt-2">
                <!-- Begin:Item -->
                <li class="breadcrumb-item">
                    <router-link to="/" class="text-hover-primary">Dashboard</router-link>
                </li>

                <template v-for="(item, i) in breadcrumb" :key="i">
                    <li class="breadcrumb-item ">{{ item }}</li>
                </template>
            </ul>
        </template>
    </div>
</template>

<script lang="ts">
import { useRoute } from 'vue-router';
import { defineComponent, computed } from 'vue';

export default defineComponent({
    name: 'layout-page-title',
    components: {},
    setup (){
        const route = useRoute()
        
        const pageTitle = computed(() => {
            return route.meta.pageTitle
        })

        const breadcrumb = computed(() => {
            return route.meta.breadcrumbs
        })

        return {
            pageTitle,
            breadcrumb
        }
    }
})
</script>