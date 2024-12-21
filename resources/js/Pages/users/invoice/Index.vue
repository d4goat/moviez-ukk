<template>
    <main class="text-gray-100 pt-21 pb-10 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-2xl">
            <div ref="invoiceRef" class="bg-dropdown shadow-2xl rounded-lg overflow-hidden">
                <div class="bg-gray-850 p-6 border-b border-gray-700">
                    <h2 class="text-3xl font-bold text-center text-white">Cinema Ticket Invoice</h2>
                    <p class="text-center text-gray-400 mt-2">
                        Booking ID: 
                        <span class="font-semibold text-gray-200">
                            {{ data?.invoice_number || 'Loading...' }}
                        </span>
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 font-medium">Customer Name</p>
                            <p class="text-xl font-semibold text-gray-100">
                                {{ data?.user.name || 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 font-medium">Purchase Date</p>
                            <p class="text-xl font-semibold text-gray-100">
                                {{ data?.tanggal || 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-6">
                        <h3 class="text-2xl font-semibold text-white mb-4">Movie Details</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Movie</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ data?.show_time.film.title || 'Loading...' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Showtime</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ data?.tanggal }} {{ data?.show_time.start_time || 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Seats</span>
                                <div class="text-lg font-semibold text-gray-100">
                                    <template v-if="data?.booked_seats?.length">
                                        {{ data.booked_seats.map(seat => seat.seat.seat_number).join(', ') }}
                                    </template>
                                    <span v-else>No seats selected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-700 py-6">
                        <h3 class="text-2xl font-semibold text-white mb-4">Payment Details</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-medium">Ticket Price ({{ data?.quantity }} seats)</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ currency(data?.quantity * data?.show_time.price) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-semibold">Total Amount</span>
                                <span class="text-gray-100 text-lg font-semibold">{{ currency(data?.quantity * data?.show_time.price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-850 p-6 border-t border-gray-700 text-center">
                    <button 
                        @click="generatePDF" 
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors"
                    >
                        Print Invoice
                    </button>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div v-if="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-indigo-500"></div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { ElMessage } from 'element-plus';
import type { ApiResponse, Booking, ShowTime, Film, BookedSeat, User, Seat } from '@/types';
import { currency } from '@/libs/utils';
import html2pdf from 'html2pdf.js';

interface Showtimes extends ShowTime {
    film: Film
}

interface BookedSeats extends BookedSeat {
    seat: Seat
}

interface Bookings extends Booking {
    booked_seats: BookedSeats[],
    show_time: Showtimes,
    user: User
}

const route = useRoute()
const router = useRouter()
const invoiceRef = ref()

const { data, isLoading, error } = useQuery({
    queryKey: ['invoice', route.params.uuid],
    queryFn: async (): Promise<Bookings> => {
        const response = await axios.get<ApiResponse<Bookings>>(`/master/booking/${route.params.uuid}`)
        return response.data.data
    },
    onError: (err: any) => {
        ElMessage.error(err.response?.data?.message || 'An error occurred')
        router.push('/bookings') // Redirect if error occurs
    }
})

const generatePDF = async () => {
    if (!invoiceRef.value) return;
    
    const element = invoiceRef.value;
    const invoice_number = data.value?.invoice_number || 'ticket';
    
    const options = {
        filename: `cinema-ticket-${invoice_number}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { 
            scale: 2,
            useCORS: true,
            letterRendering: true
        },
        jsPDF: { 
            unit: 'mm', 
            format: 'a4', 
            orientation: 'portrait'
        }
    };

    try {
        ElMessage.info('Generating PDF...');
        await html2pdf().set(options).from(element).save();
        ElMessage.success('PDF generated successfully!');
    } catch (err) {
        ElMessage.error('Failed to generate PDF. Please try again.');
        console.error('PDF generation error:', err);
    }
};

const printInvoice = () => {
    window.print()
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .container {
        visibility: visible;
    }
    main {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>