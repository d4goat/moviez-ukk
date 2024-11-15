<template>
    <div class="seat-selection">
      <div class="w-1/2 border-y border-zinc-700 py-3 text-2xl text-center font-medium">
        Screen
      </div>
      <div class="mt-4 mx-14 flex flex-col gap-4">
        <div v-for="(seatGroup, groupName) in filteredSeats" :key="groupName" class="flex flex-col items-center">
          <div class="text-lg font-medium mb-2">{{ groupName }}</div>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="seat in seatGroup"
              :key="seat.uuid"
              :class="['rounded bg-gray-200 h-10 w-10', { 'bg-orange-500': isSelected(seat) }]"
              @click="toggleSeat(seat)"
            >
              {{ seat.seat_number }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script setup lang="ts">
  import { computed, ref } from 'vue';
  import { useQuery } from '@tanstack/vue-query';
  import { useRoute } from 'vue-router';
  import axios from '@/libs/axios';
  import { Seat } from '@/types';
  import { toast } from 'vue3-toastify';
  
  const route = useRoute();

  const isSelected = ref([])
  
  const { data, refetch, isLoading } = useQuery({
    queryKey: ['seat', route.params.uuid, route.query.uuid_studio],
    queryFn: async () =>
      (
        await axios.get(`/master/seat/by-studio?uuid_studio=${route.query.uuid_studio}`)
      ).data.data,
    onError: (err: any) => {
      toast.error(err.response.data.message);
      console.log(err.response.data.message);
    },
    enabled: Boolean(route.params.uuid) && Boolean(route.query.uuid_studio),
    cacheTime: 0,
  });
  
const filteredSeats = computed(() => {
  const seatGroups: { [key: string]: Seat[] } = {};

  data.value?.forEach((seat: Seat) => {
    const group = seat.seat_number.charAt(0);
    if (!seatGroups[group]) {
      seatGroups[group] = [];
    }
    seatGroups[group].push(seat);
  });

  return Object.values(seatGroups);
});
  </script>