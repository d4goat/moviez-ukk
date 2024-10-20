import axios from "@/libs/axios";
import { useQuery } from "@tanstack/vue-query";

export function useCinema(options = {}) {
    return useQuery({
        queryKey: ['cinema'],
        queryFn: async () => 
            await axios.get('/master/cinema').then((res: any) => res.data.data),
        ...options
    })
}