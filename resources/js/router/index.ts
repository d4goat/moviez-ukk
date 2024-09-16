import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import { useAuthStore } from '@/stores/auth';

declare module 'vue-router' {
    interface RouteMeta {
        pageTitle?: string
        permission?: string
    }
}

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import("@/Layouts/AdminLayout.vue"),
        meta: {
            pageTitle: 'Dashboard'
        },
        children: [
            {
                path: '/',
                name: 'dashboard',
                meta: {
                    pageTitle: 'Dashboard'
                },
                component: () => import('@/Pages/Dashboard.vue'),
            }
        ]
    },
    {
        path: '/login',
        name: 'login',
        meta: {
            pageTitle: 'Login'
        },
        component: () => import('@/Pages/auth/Index.vue'),
    },
    {
        path: '/register',
        name: 'register',
        meta: {
            pageTitle: 'Register'
        },
        component: () => import('@/Pages/auth/Index.vue'),
    },
    {
        path: '/landing',
        name: 'home',
        component: () => import('@/Layouts/AdminLayout.vue'),
        meta: {
            pageTitle: 'Home'
        },
        children: [
            {
                path: '/landing',
                name: 'dashboard',
                meta: {
                    pageTitle: 'Dashboard'
                },
                component: () => import('@/Pages/Dashboard.vue'),
            },
            {
                path: '/testing',
                name: 'testing',
                component: () => import('@/Layouts/Layoutss.vue'),
            }
        ]
    },
    // {
    //     path: '/landing',
    //     name: 'landing.page',
    //     component: () => import('@/Pages/users/Landing.vue'),
    // },
    {
        path: '/404',
        name: '404',
        component: () => import('@/Pages/errors/Error404.vue'),
    },
    {
        path: "/:pathMatch(.*)*",
        redirect: "/404",
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,

    scrollBehavior(to) {
        if(to.hash) {
            return {
                el: to.hash,
                top: 0,
                behavior: 'smooth'
            };
        } else {
            return {
                top: 0,
                left: 0,
                behavior: 'smooth'
            }
        }
    }
});

router.beforeEach(async (to, from, next) => {
    if(to.name){
        NProgress.start();
    }

    const auth = useAuthStore()

    if (to.meta.pageTitle) {
        document.title = `${to.meta.pageTitle} - ${
            import.meta.env.VITE_APP_NAME
        }`;
    } else {
        document.title = import.meta.env.VITE_APP_NAME as string;
    }


    if (to.meta.middleware == "auth") {
        if (auth.isAuthenticated) {
            if (
                to.meta.permission &&
                !auth.user.permission.includes(to.meta.permission)
            ) {
                next({ name: "404" });
            } else if (to.path == '/') {
                if (auth.user.role?.id == 1) {
                    next({ name: "dashboard" });
                } else {
                    next({ name: "landing.page" });
                }
            } else if (to.meta.checkDetail == false) {
                next();
            }

            next();
        } else {
            next({ name: "sign-in" });
        }
    } else if (to.meta.middleware == "guest" && auth.isAuthenticated) {
        if (auth.user.role?.id == 1) {
            next({ name: "dashboard" });
        } else {
            next({ name: "landing.page" });
        }
    } else {
        next();
    }
});

router.afterEach(() => {
    NProgress.done()
})

export default router;