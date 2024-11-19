<template>
    <main class="pt-21">
        <section class="flex flex-col mx-18 gap-5">
            <div class="flex flex-row justify-between">
                <div class="col-md-2">
                    <el-select-v2
                v-model="kota"
                    style="width: 240px;"
                    filterable
                    remote
                    clearable
                    :remote-method="remoteMethod"
                    :options="options"
                    :loading="loading"
                    size="large"
                    placeholder="Search city"
                >
                <template #loading>
                    <svg class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path class="opacity-50" fill="cyan" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                  </template>
            </el-select-v2>
                </div>
                <div class="flex gap-2 items-center bg-dropdown border-none  focus:ring-dropdown rounded px-2">
                    <Field name="search" v-model="search" autocomplete="off"
                        class="bg-dropdown border-none  focus:ring-dropdown rounded-xl p-2.5"
                        placeholder="Search Cinema" />
                    <Search />
                </div>
            </div>

            <div v-if="!isFetching">
                <TransitionRoot appear :show="!isFetching" as="div">
                    <TransitionChild enter="transform transition-all duration-700 delay-300 ease-out"
                    enter-from="opacity-0 -translate-x-8" enter-leave="opacity-100 translate-x-0"
                    leave="transform transition-all duration-500 delay-300 ease-in"
                    leave-from="opacity-100 translate-x-0" leave-to="opacity-0 -translate-x-8">
                    <div v-if="filtered.length > 0" class="w-full h-full flex flex-col space-y-4">
                        <div v-for="(item, index) in filtered" :key="item.uuid"
                            class="flex flex-row p-3 rounded space-x-4 bg-dropdown"
                            :style="{ transition: 'all 0.7s ease', transitionDelay: `${600 + (index * 100)}ms` }">
                            <Film />
                            <span class="text-lg">{{ item.name }}</span>
                        </div>
                        <ul class="flex gap-2 justify-end">
                            <li class="py-1 px-[12px] rounded-md"
                                :class="{ 'opacity-50 pointer-events-none': data?.current_page == 1 || !data }">
                                <span @click="page = data?.current_page - 1" class="page-link cursor-pointer">
                                    <i class="fa fa-angle-left"></i>
                                </span>
                            </li>
                            <li v-for="item in pagination" :key="item" @click="page = item"
                                class="py-1 px-[12px] rounded-md" :class="{ 'bg-blue-600 text-white': item === page }">
                                <span class="page-link cursor-pointer">{{ item }}</span>
                            </li>
                            <li class="py-1 px-[12px] rounded-md"
                                :class="{ 'opacity-50 pointer-events-none': data?.current_page == data?.last_page || !data }">
                                <span @click="page = data?.current_page + 1" class="page-link cursor-pointer">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div v-else class="flex justify-center items-center min-h-64">
                        <span class="text-xl">No Data Found</span>
                    </div>
                </TransitionChild>
            </TransitionRoot>
            </div>

            <div v-else class="flex flex-col space-y-5 animate-pulse">
                <div v-for="i in 4" :key="i" class="">
                    <div class="flex flex-row items-center space-x-3 p-3 w-full bg-zinc-800 rounded">
                        <div class="h-5 w-5 bg-zinc-700 rounded"></div>
                        <div class="h-2.5 w-1/2 rounded bg-zinc-700"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup lang="ts">
import { onMounted, computed, ref, watch } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { toast } from 'vue3-toastify';
import axios from '@/libs/axios';
import { useCities } from '@/services';
import { Search, Film } from 'lucide-vue-next'
import { TransitionRoot, TransitionChild } from '@headlessui/vue';

const kota = ref()
const search = ref('')
const page = ref(1)

const { data, refetch, isFetching } = useQuery({
    queryKey: ['cinema'],
    queryFn: async () => await axios.post(`/master/cinema`, { page: page.value, search: kota.value }).then((res: any) => res.data),
    onError: (err: any) => {
        toast.error(err.response?.data.message);
    },
    onSuccess: (data: any) => {
        if (page.value > data.last_page) page.value = data.last_page
    },
    networkMode: 'always',
})

const pagination = computed(() => {
    let limit = data.value?.last_page <= page.value + 1 ? 5 : 2;
    return Array.from({ length: data.value?.last_page }, (_, i) => i + 1).filter(
        (i) =>
            i >= (page.value < 3 ? 3 : page.value) - limit && i <= (page.value < 3 ? 3 : page.value) + limit
    );
});

watch(kota, () => refetch())

watch(page, () => refetch())

const filtered = computed(() => {
    if (!search.value) return data.value.data

    const query = search.value.toLowerCase()

    return data.value.data.filter((item: any) => {
        return (
            item.name.toLowerCase().includes(query) ||
            item.city.toLowerCase().includes(query) ||
            item.address.toLowerCase().includes(query)
        )
    })
})

interface ListItem {
    label: string,
    value: string
}

const options = ref<ListItem[]>([])
const loading = ref(false)


const city = useCities()
const cities = computed(() =>
    city.data.value?.map((item: any) => ({
        value: item.code,
        label: item.name
    }))
)

const remoteMethod = (query: string) => {
  if (query !== '') {
    loading.value = true
    setTimeout(() => {
      loading.value = false
      options.value = cities.value.filter((item: any) => {
        return item.label.toLowerCase().includes(query.toLowerCase())
      })
    }, 1000)
  } else {
    options.value = []
  }
}

onMounted(() => refetch())
</script>