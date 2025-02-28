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
        redirect: '/landing/dashboard',
        component: () => import('@/Pages/auth/Index.vue'),
        children: [
            {
                path: 'sign-in',
                name: 'sign-in',
                component: () => import('@/Pages/auth/SignIn.vue'),
                meta: {
                    pageTitle: 'Sign-In',
                    middleware: 'guest'
                }
            },
            {
                path: 'sign-up',
                name: 'sign-up',
                component: () => import('@/Pages/auth/SignUp.vue'),
                meta: {
                    pageTitle: 'Sign-Up',
                    middleware: 'guest'
                }
            },
            {
                path: 'forgot-password',
                name: 'forgot-password',
                component: () => import('@/Pages/auth/Forgot-Password.vue')
            }
        ]
    },
    {
        path: '/',
        name: 'dashboard',
        component: () => import('@/Layouts/AdminLayout.vue'),
        meta: {
            middleware: 'auth'
        },
        children: [
            {
                path: '/admin/dashboard',
                name: 'dashboard',
                meta: {
                    pageTitle: 'Dashboard',
                },
                component: () => import('@/Pages/dashboard/Dashboard.vue'),
            },
            {
                path: '/admin/dashboard/master/users',
                name: 'master.users',
                meta: {
                    pageTitle: 'Users',
                    breadcrumbs: ['Master', 'Users']
                },
                component: () => import('@/Pages/dashboard/master/users/Index.vue'),
            },
            {
                path: '/admin/dashboard/master/cinema',
                name: 'master.cinema',
                meta: {
                    pageTitle: 'Cinema',
                    breadcrumbs: ['Master', 'Cinema']
                },
                component: () => import('@/Pages/dashboard/master/cinema/Index.vue'),
            },
            {
                path: '/admin/dashboard/master/film',
                name: 'master.film',
                meta: {
                    pageTitle: 'Film',
                    breadcrumbs: ['Master', 'Films']
                },
                component: () => import('@/Pages/dashboard/master/film/Index.vue'),
            },
            {
                path: '/admin/dashboard/master/film/:uuid/review',
                name: 'master.film.review',
                meta: {
                    pageTitle: 'Film-Review',
                    breadcrumbs: ['Master', 'Films', 'Review']
                },
                component: () => import('@/Pages/dashboard/master/film/reviews/Index.vue')
            },
            {
                path: '/admin/dashboard/master/film/:uuid/cast',
                name: 'master.film.cast',
                meta: {
                    pageTitle: 'Film-Cast',
                    breadcrumbs: ['Master', 'Films', 'Cast']
                },
                component: () => import('@/Pages/dashboard/master/film/cast/Index.vue')
            },
            {
                path: '/admin/dashboard/master/film/:uuid_film/:uuid_studio/show-time',
                name: 'master.film.show-time',
                meta: {
                    pageTitle: 'Film-Showtime',
                    breadcrumbs: ['Master', 'Films', 'Showtime'],
                },
                component: () => import('@/Pages/dashboard/master/film/show_time/Index.vue')
            },
            {
                path: '/admin/dashboard/master/genre',
                name: 'master.genre',
                meta: {
                    pageTitle: 'Genre',
                    breadcrumbs: ['Master', 'Genre']
                },
                component: () => import('@/Pages/dashboard/master/genre/Index.vue')
            },
            {
                path: '/admin/dashboard/master/promotion',
                name: 'master.promotion',
                meta: {
                    pageTitle: 'Promotion',
                    breadcrumbs: ['Master', 'Promotion']
                },
                component: () => import('@/Pages/dashboard/master/promotion/Index.vue')
            },
            {
                path: '/admin/dashboard/master/studio',
                name: 'master.studio',
                meta: {
                    pageTitle: 'Studio',
                    breadcrumbs: ['Master', 'Studio']
                },
                component: () => import('@/Pages/dashboard/master/studio/Index.vue')
            },
            {
                path: '/admin/dashboard/master/studio/:uuid/seat',
                name: 'master.studio.seat',
                meta: {
                    pageTitle: 'Studio-Seat',
                    breadcrumbs: ['Master', 'Studio', 'Seat']
                },
                component: () => import('@/Pages/dashboard/master/studio/seat/Index.vue')
            },
            {
                path: '/admin/dashboard/booking',
                name: 'booking',
                meta: {
                    pageTitle: 'Booking',
                    breadcrumbs: ['Booking']
                },
                component: () => import('@/Pages/dashboard/booking/Index.vue')
            },
            {
                path: '/admin/dashboard/setting',
                name: 'setting',
                meta: {
                    pageTitle: 'Setting',
                    breadcrumbs: ['Setting']
                },
                component: () => import('@/Pages/dashboard/setting/Index.vue')
            },
        ]
    },
    {
        path: '/',
        redirect: '/landing/dashboard',
        component: () => import('@/Layouts/MainLayout.vue'),
        children: [
            {
                path: '/landing/dashboard',
                name: 'landing.page',
                component: () => import('@/Pages/users/Landing.vue'),
            },
            {
                path: '/landing/profile',
                name: 'landing.profile',
                component: () => import('@/Pages/users/profile/Index.vue'),
                meta: {
                    middleware: 'auth'
                }
            },
            {
                path: '/landing/coming-soon',
                name: 'landing.coming-soon',
                component: () => import('@/Pages/users/coming-soon/Index.vue')
            },
            {
                path: '/landing/film-detail/:uuid',
                name: 'landing.film-detail',
                component: () => import('@/Pages/users/film-detail/Index.vue')
            },
            {
                path: '/landing/cinema',
                name: 'landing.cinema',
                component: () => import('@/Pages/users/cinema/Index.vue')
            },
            {
                path: '/landing/film-detail/:uuid/playing-at',
                name: 'landing.playing-at',
                component: () => import('@/Pages/users/film-detail/Playing-at.vue'),
                meta: {
                    middleware: 'auth'
                }
            },
            {
                path: '/landing/film-detail/playing-at/booking/:uuid/select-seat',
                name: 'landing.booking.select-seat',
                component: () => import('@/Pages/users/film-detail/select-seat/Index.vue'),
                meta: {
                    middleware: 'auth'
                }
            },
            {
                path: '/landing/invoice/:uuid',
                name: 'landing.invoice',
                component: () => import('@/Pages/users/invoice/Index.vue')
            },
            {
                path: "/landing/review/:uuid",
                name: "landing.review",
                component: () => import('@/Pages/users/review/Index.vue')
            },
            {
                path: "/landing/contact-us",
                name: "landing.contact-us",
                component: () => import('@/Pages/users/contact/Index.vue')
            },
        ]
    },
    {
        path: '/',
        component: () => import('@/Layouts/SystemLayout.vue'),
        children: [
            {
                path: '/404',
                name: '404',
                component: () => import('@/Pages/errors/Error404.vue'),
            },

        ]
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

    if (!auth.isAuthenticated) await auth.verifyAuth();

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
