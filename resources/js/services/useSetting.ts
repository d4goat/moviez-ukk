import axios from "@/libs/axios";
import { useQuery } from "@tanstack/vue-query";

export function useSetting(uptions = {}){
    return useQuery({
        queryKey: ['setting'],
        queryFn: () => axios.get('/setting').then((res: any) => res.data),
        ...uptions
    })
}