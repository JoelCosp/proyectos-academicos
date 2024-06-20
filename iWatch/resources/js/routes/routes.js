import Cookies from 'js-cookie'
import store from "../store";

const AuthenticatedLayout = () => import('../layouts/Authenticated.vue')
const GuestLayout = ()  => import('../layouts/Guest.vue');

const PostsIndex  = ()  => import('../views/admin/posts/Index.vue');
const PostsCreate  = ()  => import('../views/admin/posts/Create.vue');
const PostsEdit  = ()  => import('../views/admin/posts/Edit.vue');
const ExercisesIndex  = ()  => import('../views/admin/exercises/Index.vue');
const ExercisesCreate  = ()  => import('../views/admin/exercises/Create.vue');
const ExercisesEdit  = ()  => import('../views/admin/exercises/Edit.vue');
const TasksList  = ()  => import('../views/admin/tasks/index.vue');
const TasksCreate = ()  => import('../views/admin/tasks/Create.vue');
const TasksUpdate = () => import('../views/admin/tasks/Update.vue');


// Peliculas admin
const FilmsList  = ()  => import('../views/admin/films/indexFilms.vue');
const FilmsCreate = ()  => import('../views/admin/films/Create.vue');
const FilmsUpdate = () => import('../views/admin/films/Update.vue');

// Episodios admin
const EpisodesList  = ()  => import('../views/admin/episodes/Index.vue');
const EpisodesCreate = ()  => import('../views/admin/episodes/Create.vue');

// Series admin
const SeriesList  = ()  => import('../views/admin/series/indexSeries.vue');
const SeriesCreate = ()  => import('../views/admin/series/Create.vue');
const SeriesUpdate = () => import('../views/admin/series/Update.vue');

// Temporadas admin
const SeasonsList  = ()  => import('../views/admin/seasons/index.vue');
const SeasonsCreate  = ()  => import('../views/admin/seasons/Create.vue');

// Suscripciones admin
const SuscripcionesList  = ()  => import('../views/admin/suscripciones/indexSuscripciones.vue');
const SuscripcionesCreate = ()  => import('../views/admin/suscripciones/Create.vue');
const SuscripcionesUpdate = () => import('../views/admin/suscripciones/Update.vue');

// Reseñas admin
const ReviewsList  = ()  => import('../views/admin/reviews/indexReviews.vue');
const ReviewsCreate = ()  => import('../views/admin/reviews/Create.vue');
const ReviewsUpdate = () => import('../views/admin/reviews/Update.vue');

const allReviews = () => import('../views/reviews/index.vue');

// Mensajes admin
const MessagesList  = ()  => import('../views/admin/messages/indexMessages.vue');
const MessagesCreate = ()  => import('../views/admin/messages/Create.vue');
const MessagesUpdate = () => import('../views/admin/messages/Update.vue');

// Salas admin
const RoomsList  = ()  => import('../views/admin/rooms/indexRooms.vue');
const RoomsCreate = ()  => import('../views/admin/rooms/Create.vue');
const RoomsUpdate = () => import('../views/admin/rooms/Update.vue');

// Categorias admin
const CategoriasList  = ()  => import('../views/admin/categorias/indexCategorias.vue');
const CategoriasCreate = ()  => import('../views/admin/categorias/Create.vue');
const CategoriasUpdate = () => import('../views/admin/categorias/Update.vue');


// Peliculas home
const HomeFilmsList  = ()  => import('../views/home/index.vue');

const HomeFilms = () => import('../views/films/index.vue');
const HomeSeries = () => import('../views/series/index.vue');
const HomeRooms = () => import('../views/rooms/index.vue');
const HomeNews = () => import('../views/news/index.vue');
const HomeFavorites = () => import('../views/favorites/index.vue');

const AboutUs = () => import('../views/about/index.vue');

const Research = () => import('../views/research/index.vue');

const ProfileSettings = () => import('../views/profile/index.vue');

const player = () => import('../views/player/index.vue');

const Playlist = () => import('../views/playlist/index.vue');

function requireLogin(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}

function guest(to, from, next) {
    let isLogin;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next('/')
    } else {
        next()
    }
}

export default [
    {
        path: '/login',
        name: 'auth.login',
        component: () => import('../views/login/Login.vue'),
        beforeEnter: guest
    },
    {
        path: '/register',
        name: 'auth.register',
        component: () => import('../views/register/index.vue'),
        beforeEnter: guest,
    },
    {
        path: '/',
        // redirect: { name: 'login' },
        component: AuthenticatedLayout,
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: requireLogin,
        component: GuestLayout,
        children: [
            {
                path: '/settings',
                name: 'settings.main',
                component: () => import('../views/settings/index.vue'),
            },
            {
                path: '/advices',
                name: 'advices.main',
                component: () => import('../views/advices/index.vue'),
            },
            {
                path: '/',
                name: 'Home',
                component: () => import('../views/home/index.vue'),
            },
            {
                path: '/about',
                name: 'about-us',
                component: () => import('../views/about/index.vue'),
            },
            {
                path: '/support',
                name: 'help-and-support',
                component: () => import('../views/support/index.vue'),
            },
            {
                path: '/research/:search?',
                name: 'research',
                component: Research,
            },
            {
                path: '/playlist',
                name: 'Playlist',
                component: Playlist,
            },
            {
                path: '/subscriptions',
                name: 'subscriptions',
                component: () => import('../views/subscriptions/index.vue'),
            },
            {
                path: '/filmsHome',
                name: 'home-films',
                component: HomeFilmsList,
            },
            {
                path: '/films',
                name: 'Films',
                component: HomeFilms,
              },
              {
                path: '/series',
                name: 'Series',
                component: HomeSeries,
              },
              {
                path: '/news',
                name: 'News',
                component: HomeNews,
              },
              {
                path: '/favorites',
                name: 'Favorites',
                component: HomeFavorites,
              },
              {
                path: '/allReviews/:id',
                name: 'all.reviews',
                component: allReviews,
              },
              {
                path: '/profile',
                name: 'edit-profile',
                component: ProfileSettings,
              },
              {
                path: '/rooms',
                name: 'Rooms',
                component: HomeRooms,
              },
            {
                path: 'posts',
                name: 'public-posts.index',
                component: () => import('../views/posts/index.vue'),
            },
            {
                path: 'posts/:id',
                name: 'public-posts.details',
                component: () => import('../views/posts/details.vue'),
            },
            {
                path: 'category/:id',
                name: 'category-posts.index',
                component: () => import('../views/category/posts.vue'),
            },
            // {
            //     path: 'login',
            //     name: 'auth.login',
            //     component: () => import('../views/login/Login.vue'),
            //     beforeEnter: guest,
            // },
            {
                path: '/home',
                name: 'home.index',
                component: HomeFilmsList,
                beforeEnter: requireLogin,
            },
            {
                path: 'forgot-password',
                name: 'auth.forgot-password',
                component: () => import('../views/auth/passwords/Email.vue'),
                beforeEnter: guest,
            },
            {
                path: 'reset-password/:token',
                name: 'auth.reset-password',
                component: () => import('../views/auth/passwords/Reset.vue'),
                beforeEnter: guest,
            },
        ]
    },
    {
        path: '/player/:id',
        name: 'player-films',
        component: player,
      },
    {
        path: '/admin',
        component: AuthenticatedLayout,
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: requireLogin,
        meta: { breadCrumb: 'Dashboard' },
        children: [
            {
                name: 'admin.index',
                path: '',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'profile.index',
                path: 'profile',
                component: () => import('../views/admin/profile/index.vue'),
                meta: { breadCrumb: 'Profile' }
            },
            {
                name: 'posts.index',
                path: 'posts',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                name: 'posts.create',
                path: 'posts/create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                name: 'posts.edit',
                path: 'posts/edit/:id',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },
            {
                name: 'tasks',
                path: 'tasks',
                meta: { breadCrumb: 'Tareas'},
                children: [
                    {
                        name: 'tasks.index',
                        path: '',
                        component: TasksList,
                        meta: {breadCrumb: 'Listado tareas'}

                    },
                    {
                        name: 'tasks.create',
                        path: 'create',
                        component: TasksCreate,
                        meta: {breadCrumb: 'Crear tarea'}
                    },
                    {
                        name: 'tasks.update',
                        path: 'update/:id',
                        component: TasksUpdate,
                        meta: {breadCrumb: 'Actualizar tarea'}
                    }
                ]
            },
            {
                name: 'films',
                path: 'films',
                meta: { breadCrumb: 'Peliculas'},
                children: [
                    {
                        name: 'films.indexFilms',
                        path: '',
                        component: FilmsList,
                        meta: {breadCrumb: 'Listado peliculas'}

                    },
                    {
                        name: 'films.create',
                        path: 'createFilm',
                        component: FilmsCreate,
                        meta: {breadCrumb: 'Crear pelicula'}
                    },
                    {
                        name: 'films.update',
                        path: 'update/:id',
                        component: FilmsUpdate,
                        meta: {breadCrumb: 'Actualizar pelicula'}
                    }
                ]
            },
            {
                name: 'episodes',
                path: 'episodes',
                meta: { breadCrumb: 'Episodios'},
                children: [
                    {
                        name: 'episodes.index',
                        path: '',
                        component: EpisodesList,
                        meta: {breadCrumb: 'Listado de episodios'}

                    },
                    {
                        name: 'episodes.create',
                        path: 'createEpisode',
                        component: EpisodesCreate,
                        meta: {breadCrumb: 'Crear episodio'}
                    },
                ]
            },
            {
                name: 'seasons',
                path: 'seasons',
                meta: { breadCrumb: 'Temporadas'},
                children: [
                    {
                        name: 'seasons.index',
                        path: '',
                        component: SeasonsList,
                        meta: {breadCrumb: 'Listado de temporadas'}

                    },
                    {
                        name: 'seasons.create',
                        path: 'createSeason',
                        component: SeasonsCreate,
                        meta: {breadCrumb: 'Crear temporada'}
                    },
                    {
                        name: 'seasons.update',
                        path: 'update/:id',
                        component: FilmsUpdate,
                        meta: {breadCrumb: 'Actualizar temporada'}
                    }
                ]
            },
            {
                name: 'series',
                path: 'series',
                meta: { breadCrumb: 'Series'},
                children: [
                    {
                        name: 'series.indexSeries',
                        path: '',
                        component: SeriesList,
                        meta: {breadCrumb: 'Listado de series'}

                    },
                    {
                        name: 'series.create',
                        path: 'createSerie',
                        component: SeriesCreate,
                        meta: {breadCrumb: 'Crear series'}
                    },
                    {
                        name: 'series.update',
                        path: 'update/:id',
                        component: SeriesUpdate,
                        meta: {breadCrumb: 'Actualizar serie'}
                    }
                ]
            },
            {
                name: 'suscripciones',
                path: 'suscripciones',
                meta: { breadCrumb: 'Suscripciones'},
                children: [
                    {
                        name: 'suscripciones.indexSuscripciones',
                        path: '',
                        component: SuscripcionesList,
                        meta: {breadCrumb: 'Listado de suscripciones'}

                    },
                    {
                        name: 'suscripciones.create',
                        path: 'createSuscripcion',
                        component: SuscripcionesCreate,
                        meta: {breadCrumb: 'Crear suscripciones'}
                    },
                    {
                        name: 'suscripciones.update',
                        path: 'update/:id',
                        component: SuscripcionesUpdate,
                        meta: {breadCrumb: 'Actualizar suscripcion'}
                    }
                ]
            },
            {
                name: 'reviews',
                path: 'reviews',
                meta: { breadCrumb: 'Reseñas'},
                children: [
                    {
                        name: 'reviews.indexReviews',
                        path: '',
                        component: ReviewsList,
                        meta: {breadCrumb: 'Listado de reseñas'}

                    },
                    {
                        name: 'reviews.create',
                        path: 'createReview',
                        component: ReviewsCreate,
                        meta: {breadCrumb: 'Crear reseñas'}
                    },
                    {
                        name: 'reviews.update',
                        path: 'update/:id',
                        component: ReviewsUpdate,
                        meta: {breadCrumb: 'Actualizar reseña'}
                    }
                ]
            },
            {
                name: 'messages',
                path: 'messages',
                meta: { breadCrumb: 'Mensajes'},
                children: [
                    {
                        name: 'messages.indexMessages',
                        path: '',
                        component: MessagesList,
                        meta: {breadCrumb: 'Listado de mensajes'}

                    },
                    {
                        name: 'messages.create',
                        path: 'createMessage',
                        component: MessagesCreate,
                        meta: {breadCrumb: 'Crear mensaje'}
                    },
                    {
                        name: 'messages.update',
                        path: 'update/:id',
                        component: MessagesUpdate,
                        meta: {breadCrumb: 'Actualizar mensaje'}
                    }
                ]
            },
            {
                name: 'rooms',
                path: 'rooms',
                meta: { breadCrumb: 'Salas'},
                children: [
                    {
                        name: 'rooms.indexRooms',
                        path: '',
                        component: RoomsList,
                        meta: {breadCrumb: 'Listado de salas'}

                    },
                    {
                        name: 'rooms.create',
                        path: 'createRoom',
                        component: RoomsCreate,
                        meta: {breadCrumb: 'Crear sala'}
                    },
                    {
                        name: 'rooms.update',
                        path: 'update/:id',
                        component: RoomsUpdate,
                        meta: {breadCrumb: 'Actualizar sala'}
                    }
                ]
            },
            {
                name: 'categorias',
                path: 'categorias',
                meta: { breadCrumb: 'Categorias'},
                children: [
                    {
                        name: 'categorias.indexCategorias',
                        path: '',
                        component: CategoriasList,
                        meta: {breadCrumb: 'Listado de categorias'}

                    },
                    {
                        name: 'categorias.create',
                        path: 'createCategoria',
                        component: CategoriasCreate,
                        meta: {breadCrumb: 'Crear categoria'}
                    },
                    {
                        name: 'categorias.update',
                        path: 'update/:id',
                        component: CategoriasUpdate,
                        meta: {breadCrumb: 'Actualizar categoria'}
                    }
                ]
            },
            {
                name: 'exercises',
                path: 'exercises',
                meta: { breadCrumb: 'Exercises'},
                children: [
                    {
                        name: 'exercises.index',
                        path: '',
                        component: ExercisesIndex,
                        meta: { breadCrumb: 'View' }
                    },
                    {
                        name: 'exercises.create',
                        path: 'create',
                        component: ExercisesCreate,
                        meta: { breadCrumb: 'Add new exercise' ,
                        linked: false, }
                    },
                    {
                        name: 'exercises.edit',
                        path: 'edit/:id',
                        component: ExercisesEdit,
                        meta: {
                            breadCrumb: 'Edit exercise',
                            linked: false,
                        }
                    }
                ]
            },
        
            {
                name: 'categories',
                path: 'categories',
                meta: { breadCrumb: 'Categories'},
                children: [
                    {
                        name: 'categories.index',
                        path: '',
                        component: () => import('../views/admin/categories/Index.vue'),
                        meta: { breadCrumb: 'View category' }
                    },
                    {
                        name: 'categories.create',
                        path: 'create',
                        component: () => import('../views/admin/categories/Create.vue'),
                        meta: { 
                            breadCrumb: 'Add new category' ,
                            linked: false, 
                        }
                    },
                    {
                        name: 'categories.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/categories/Edit.vue'),
                        meta: {
                            breadCrumb: 'Edit category',
                            linked: false,
                        }
                    }
                ]
            },

            {
                name: 'permissions',
                path: 'permissions',
                meta: { breadCrumb: 'Permisos'},
                children: [
                    {
                        name: 'permissions.index',
                        path: '',
                        component: () => import('../views/admin/permissions/Index.vue'),
                        meta: { breadCrumb: 'Permissions' }
                    },
                    {
                        name: 'permissions.create',
                        path: 'create',
                        component: () => import('../views/admin/permissions/Create.vue'),
                        meta: { 
                            breadCrumb: 'Create Permission',
                            linked: false,  
                        }
                    },
                    {
                        name: 'permissions.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/permissions/Edit.vue'),
                        meta: { 
                            breadCrumb: 'Permission Edit',
                            linked: false,
                        }
                    }
                ]
            },

            //TODO Organizar rutas
            {
                name: 'roles.index',
                path: 'roles',
                component: () => import('../views/admin/roles/Index.vue'),
                meta: { breadCrumb: 'Roles' }
            },
            {
                name: 'roles.create',
                path: 'roles/create',
                component: () => import('../views/admin/roles/Create.vue'),
                meta: { breadCrumb: 'Create Role' }
            },
            {
                name: 'roles.edit',
                path: 'roles/edit/:id',
                component: () => import('../views/admin/roles/Edit.vue'),
                meta: { breadCrumb: 'Role Edit' }
            },
            {
                name: 'users.index',
                path: 'users',
                component: () => import('../views/admin/users/Index.vue'),
                meta: { breadCrumb: 'Users' }
            },
            {
                name: 'users.create',
                path: 'users/create',
                component: () => import('../views/admin/users/Create.vue'),
                meta: { breadCrumb: 'Add New' }
            },
            {
                name: 'users.edit',
                path: 'users/edit/:id',
                component: () => import('../views/admin/users/Edit.vue'),
                meta: { breadCrumb: 'User Edit' }
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
