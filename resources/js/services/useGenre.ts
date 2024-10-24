import axios from "@/libs/axios";
import { useQuery } from "@tanstack/vue-query";

export function useGenre(options = {}){
    return useQuery({
        queryKey: ['genre'],
        queryFn: () => axios.get('/master/genre').then((res: any) => res.data.data),
        ...options
    })
}