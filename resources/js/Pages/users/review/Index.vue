<template>
    <main class="pt-21">
        <div class="container mx-auto max-w-3xl">
            <div class="bg-dropdown shadow-2xl space-y-3 rounded-lg p-4">
                <div class="flex justify-between mb-2">
                    <span class="text-xl font-medium"> {{ data?.show_time.film.title }} </span>
                    <span class="text-gray-400"> {{ data?.invoice_number }} </span>
                </div>
                <span class="text-gray-300 text-sm"> {{ data?.tanggal }} </span>
                <div class="flex flex-col">
                    <span>Movie Details</span>
                    <span class="text-gray-400">Duration : {{ data?.show_time.film.duration }} | Director : {{
                        data?.show_time.film.director }} </span>
                    <span class="text-gray-400">Show Time : {{ data?.show_time.start_time }} - {{
                        data?.show_time.end_time }} | Seats : <template v-if="data?.booked_seats?.length">
                            {{ data?.booked_seats?.map(seat => seat.seat.seat_number).join(', ') }}
                        </template></span>
                </div>
                <div class="flex flex-col gap-2">
                    <span>Your Review</span>
                    <vue3starRatings starColor="#facc15" v-model="form.rating" />
                    <el-input v-model="form.review"  :rows="3" type="textarea"
                        placeholder="Share your thoughts about the movie..." />
                </div>

                <div class="mt-4 border-t flex justify-end border-gray-500 pt-3">
                    <button @click="review" :disabled="status == 'loading'" class="bg-cinema hover:bg-cinema/70 transition-colors font-medium text-sm p-2.5 rounded-lg">Send Review</button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, defineComponent } from 'vue';
import { useQuery, useMutation } from '@tanstack/vue-query';
import { ElMessage } from 'element-plus';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import type { ApiResponse, Booking, Film, ShowTime, User, BookedSeat } from '@/types';
import vue3starRatings from "vue3-star-ratings";
import { useAuthStore } from '@/stores/auth';

defineComponent({
    components: {
        vue3starRatings
    }
})

interface Showtimes extends ShowTime {
    film: Film
}

interface Bookings extends Booking {
    booked_seats: BookedSeat[]
    show_time: Showtimes,
    user: User
}

const { user } = useAuthStore()
const form = ref({ rating: 0, review: "" })
const route = useRoute()
const router = useRouter()

const { data, isLoading, error } = useQuery({
    queryKey: ['bookings', route.params.uuid],
    queryFn: async (): Promise<Bookings> => {
        const response = await axios.get<ApiResponse<Bookings>>(`/master/booking/${route.params.uuid}`)
        return response.data.data
    },
    onError: (err: any) => {
        ElMessage.error(err.response?.data?.message || 'An error occurred')
    }
})

const { mutate: review, status } = useMutation({
    mutationFn: async () => {
        const formData = new FormData()
        formData.append('user_id', user.id)
        formData.append('film_id', data.value?.show_time.film.id)
        formData.append('rating', form.value.rating)
        formData.append('review', form.value.review)

        return await axios.post('/master/review/store', formData).then((res: any) => res.data)
    },
    onError: (err: any) => ElMessage.error(err.response.data.message),
    onSuccess: () => router.push('/landing/dashboard')
})
</script>