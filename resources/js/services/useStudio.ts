import axios from "@/libs/axios";
import { useQuery } from "@tanstack/vue-query";

export function useStudio(options = {}){
    return useQuery({
        queryKey: ['studio'],
        queryFn: async () => await axios.get('/master/studio').then((res: any) => res.data.data),
        ...options
    })
}