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
        pages: [
            {
                heading: "Dashboard",
                route: "/dashboard",
                name: "/admin/dashboard"
            },
        ],
    },
    {
        heading: "Website",
        route: '/admin/dashboard',
        name: 'website',
        pages: [
            {
                sectionTitle: "Master",
                route: "/admin/dashboard",
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
                        sub: [
                            {
                                heading: "Film Cast",
                                name: "master-film-cast",
                                route: "/admin/dashboard/master/film/cast",
                            },
                            {
                                heading: "Review",
                                name: "master-film-review",
                                route: "/admin/dashboard/master/film/review",
                            }
                        ]
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
                        name: "Studio",
                        route: "/admin/dashboard/master/studio",
                        sub: [
                            {
                                heading: "Seat",
                                name: "master-studio-seat",
                                route: "/admin/dashboard/master/studio/seat",
                            },
                            {
                                heading: "Show Time",
                                name: "master-studio-show-time",
                                route: "/admin/dashboard/master/studio/show-time",
                            }
                        ]
                    },
                    {
                        heading: "User",
                        name: "master-user",
                        route: "/admin/dashboard/master/user",
                    }
                ]
            }   
        ]
    }
]

export default MainMenuConfig;