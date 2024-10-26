interface MenuItem {
    name?: string;
    heading?: string;
    sectionTitle?: string;
    route?: string;
    pages?: Array<MenuItem>;
    sub?: Array<MenuItem>;
}

const MainMenuConfig: Array<MenuItem> = [
    {
        heading: "Admin",
        name: "dashboard", // Sesuaikan dengan permission
        pages: [
            {
                heading: "Dashboard",
                route: "/admin/dashboard",
                name: "admin-dashboard"
            },
        ],
    },
    {
        heading: "Website",
        name: "website",
        pages: [
            {
                sectionTitle: "Master",
                route: "/admin/dashboard/master",
                name: "master",
                sub: [
                    {
                        heading: "Cinema",
                        name: "master-cinema",
                        route: "/admin/dashboard/master/cinema",
                    },
                    {
                        heading: "Film",
                        name: "master-film",
                        route: "/admin/dashboard/master/film",
                    },
                    {
                        heading: "Genre",
                        name: "master-genre",
                        route: "/admin/dashboard/master/genre",
                    },
                    {
                        heading: "Promotion",
                        name: "master-promotion",
                        route: "/admin/dashboard/master/promotion",
                    },
                    {
                        heading: "Studio",
                        name: "master-studio",
                        route: "/admin/dashboard/master/studio",
                    },
                    {
                        heading: 'Users',
                        name: 'master-users',
                        route: '/admin/dashboard/master/users',
                    },
                ]
            }   
        ]
    }
]

export default MainMenuConfig;