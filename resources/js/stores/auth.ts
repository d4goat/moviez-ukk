import { ref } from "vue";
import { defineStore } from "pinia";
import JwtService from "@/core/services/JwtService";
import ApiService from "@/core/services/ApiService";

export interface User {
    id: number;
    uuid: string;
    name: string;
    email: string;
    phone: string;
    photo?: string;
    password?: string
    permission?: Array<string>;
    role: {
        name: string;
        full_name: string
    };
}

export const useAuthStore = defineStore("auth", () => {
    const error = ref<null | string>(null)
    const user = ref<User>({} as User)
    const isAuthenticated = ref<boolean>(false)

    function setAuth(authUser: User, token = ""){
        isAuthenticated.value = true
        user.value = authUser;
        error.value = null
        
        if(token){
            JwtService.saveToken(token);
        }
    }

    function purgeAuth(){
        isAuthenticated.value = false
        user.value = {} as User
        error.value = null
        JwtService.destroyToken()
    }

    async function login (credentials: User){
        return ApiService.post("auth/login", credentials)
        .then(({data}) => {
            setAuth(data.user, data.token)
        })
        .catch(({ response }) => {
            error.value = response.data.message
        })
    }

    async function logout(){
        if(JwtService.getToken()){
            ApiService.setHeader();
            await ApiService.delete("auth/logout");
            purgeAuth();
        } 
    }

    async function verifyAuth(){
        if(JwtService.getToken()){
            ApiService.setHeader();
            await ApiService.get("auth/me")
            .then(( { data }) => {
                setAuth(data.user)
            })
            .catch(({ response }) => {
                error.value = response.data.message;
                purgeAuth();
            })
        } else {
            purgeAuth();
        }
    }

    return {
        error,
        user,
        isAuthenticated,
        setAuth,
        purgeAuth,
        login,
        logout,
        verifyAuth
    }
})