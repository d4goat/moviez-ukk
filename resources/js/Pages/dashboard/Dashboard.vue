<template>
    <main class="container mx-auto p-6 space-y-6">
        <el-date-picker type="month" size="large" @change="refetch" v-model="date" />
        <div v-if="!isFetching">
            <TransitionRoot :show="!isFetching" appear as="div">
                <TransitionChild as="div" class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    enter="trasition-opacity duration-500" enter-from="opacity-0" enter-to="opacity-100"
                    leave="transition-opacity duration-500" leave-from="opacity-100" leave-to="opacity-0">
                    <!-- Total Bookings Card -->
                    <div class="bg-dropdown/40 shadow-md shadow-cyan-500/30 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <CalendarCheck2 class="text-blue-500" />
                            <span class="text-sm text-gray font-medium">
                                {{ date.toLocaleDateString('id-ID', { month: 'long' }) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">
                                Total Booking
                            </h3>
                            <p class="text-2xl font-extrabold text-blue-600">
                                {{ data?.data_booking || 0 }}
                            </p>
                        </div>
                    </div>

                    <!-- Total Amount Card -->
                    <div class="bg-dropdown/40 shadow-md shadow-cyan-500/30 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <CreditCard class="text-green-500" :size="28" />
                            <span class="text-sm text-gray font-medium">
                                {{ date.toLocaleDateString('id-ID', { month: 'long' }) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">
                                Total Amount
                            </h3>
                            <p class="text-2xl font-extrabold text-green-600">
                                {{ currency(data?.data_payment) }}
                            </p>
                        </div>
                    </div>
                </TransitionChild>
                <TransitionChild as="div" class="mt-10 grid grid-cols-1 gap-5">
                    <Chart type="line" :data="data?.chart" :options="chartOptions" class="h-[30rem]" />
                    <Chart type="line" :data="data?.chart_amount" :options="chartOptions" class="h-[30rem]" />
                </TransitionChild>
            </TransitionRoot>
        </div>
        <div v-else class="animate-pulse">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-dropdown/70 rounded-2xl w-full h-40"></div>
                <div class="bg-dropdown/70 rounded-2xl w-full h-40"></div>
            </div>
        </div>
    </main>
</template>
<script setup lang="ts">
import { defineComponent, h, onMounted, ref } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { ElMessage } from 'element-plus';
import moment from 'moment';
import { TransitionChild, TransitionRoot } from '@headlessui/vue';
import { currency } from '@/libs/utils';
import { CalendarCheck2, CreditCard } from 'lucide-vue-next';

const date = ref(new Date())

const chartOptions = ref()

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--p-text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
    const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}

onMounted(() => chartOptions.value = setChartOptions())

const { data, isFetching, refetch } = useQuery({
    queryKey: ['dashboard', 'admin'],
    queryFn: async () => await axios.get(`/master/dashboard?year=${moment(date.value).format('YYYY')}&month=${moment(date.value).format('MM')}`).then((res: any) => res.data),
    onError: (err: any) => ElMessage.error(err.response.data.message)
})
</script>
