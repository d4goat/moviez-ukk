import axios from "@/libs/axios";
import { useQuery } from "@tanstack/vue-query";

export function useFilm(options= {}){
    return useQuery({
        queryKey: ['film'],
        queryFn: async () => await axios.get('/master/film').then((res: any) => res.data.data),
        ...options
    })
}