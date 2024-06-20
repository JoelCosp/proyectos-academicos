<template>
    <nav :class="{'navbar-light': !isDarkMode, 'navbar-dark': isDarkMode}" class="navbar navbar-expand-md shadow-sm d-flex justify-content-center align-items-center">
        <div class="container homeContainer">
            <router-link to="/" class="navbar-brand">
                <img src="/images/iWatchLogo.svg" width="100" alt="" :class="{ 'navbar-icon-light': !isDarkMode }">
            </router-link>
            <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div :class="{ 'collapse': true, 'navbar-collapse': true, 'navbar-collapse-light': !isDarkMode }" id="navbarSupportedContent">
                <ul class="navbar-nav mt-2 mt-lg-0 me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'Home'}" class="nav-link" aria-current="page"><i class="pi pi-home pe-2 l-invisible" style="font-size: 1rem"></i>{{ $t('home') }}</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Films'}" class="nav-link" aria-current="page"><i class="pi pi-video pe-2 l-invisible" style="font-size: 1rem"></i>{{ $t('films') }}</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Series'}" class="nav-link" aria-current="page"><i class="pi pi-video pe-2 l-invisible" style="font-size: 1rem"></i>{{ $t('series') }}</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Favorites'}"  class="nav-link" aria-current="page"><i class="pi pi-heart pe-2 l-invisible" style="font-size: 1rem"></i>{{ $t('my_list') }}</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'Playlist'}" class="nav-link" aria-current="page"><i class="pi pi-list pe-2 l-invisible" style="font-size: 1rem"></i>{{ $t('playlists') }}</router-link>
                    </li>
                    
                    <!-- OPCIONES AÑADIDAS VERSION MOBIL  -->
                    
                        <li class="nav-item resp-menu"><router-link :to="{ name: 'subscriptions'}" class="nav-link"><i class="pi pi-verified pe-2" style="font-size: 1rem"></i>Mi plan</router-link></li>
                        <li class="nav-item resp-menu"><router-link class="nav-link" :to="{ name: 'settings.main'}"><i class="pi pi-cog pe-2" style="font-size: 1rem"></i>Configuración</router-link></li>
                        <li class="nav-item resp-menu"><router-link class="nav-link" :to="{ name: 'advices.main'}"><i class="pi pi-info-circle pe-2" style="font-size: 1rem"></i>Aviso legal</router-link></li>
                        <li class="themeLi nav-item resp-menu">
                            <div class="form-check form-switch form-mode">
                                
                                <label class="form-check-label" :for="isDarkMode ? 'darkModeSwitch' : 'lightModeSwitch'">
                                    <span>
                                        <i class="pi pi-moon"></i>
                                    </span>
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch" v-model="isDarkMode">
                                    <span>
                                        <i class="pi pi-sun"></i>
                                    </span>
                                </label>
                            </div>
                        </li>
                        <li class="nav-item resp-menu"><a class="nav-link" href="javascript:void(0)" @click="logout"><i class="pi pi-sign-out pe-2" style="font-size: 1rem"></i>Cerrar sesión</a></li>
                        
                    <!-- ********************************* -->
                
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                    <template v-if="!user?.name">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/login"
                            >{{ $t('login') }}</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/register">{{ $t('register') }}</router-link>
                        </li>
                    </template>
                    <li v-if="user?.name" class="nav-item dropdown rightMenu">
                        <a class="nav-link pe-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="p-overlay-badge profileNavImg" :src="imageProfile" alt="">
                        </a>
                        <div :class="{ 'navbar-drop-light': !isDarkMode }">
                            <ul class="optionsList dropdown-menu dropdown-menu-end">
                                <li>
                                    <router-link class="dropdown-item" to="/profile">
                                        <div class="d-flex align-items-center">
                                            <img class="p-overlay-badge profile-image-link" :src="imageProfile" alt="">
                                            <p class="ml-2">{{ store.state.auth.user.name }}</p>
                                        </div>
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li v-if="isAdmin"><router-link class="dropdown-item" to="/admin">{{ $t('admin') }}</router-link></li>
                                <li><router-link :to="{ name: 'subscriptions'}" class="dropdown-item d-flex align-items-center"><i class="pi pi-verified pe-2" style="font-size: 1rem"></i>{{ $t('my_plan') }}</router-link></li>
                                <li><router-link class="dropdown-item" :to="{ name: 'settings.main'}"><i class="pi pi-cog pe-2" style="font-size: 1rem"></i>{{ $t('settings2') }}</router-link></li>
                                <li><router-link class="dropdown-item" :to="{ name: 'advices.main'}"><i class="pi pi-info-circle pe-2" style="font-size: 1rem"></i>{{ $t('advice') }}</router-link></li>
                                <li class="themeLi">
                                    <div class="form-check form-switch form-mode">
                                        <input class="form-check-input" type="checkbox" id="darkModeSwitch" v-model="isDarkMode">
                                        <label class="form-check-label" :for="isDarkMode ? 'darkModeSwitch' : 'lightModeSwitch'">
                                            <span>
                                                <i class="pi pi-moon"></i>
                                            </span>
                                            <span>
                                                <i class="pi pi-sun"></i>
                                            </span>
                                        </label>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" @click="logout"><i class="pi pi-sign-out pe-2" style="font-size: 1rem"></i>{{ $t('logout') }}</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { useStore} from "vuex";
import useAuth from "@/composables/auth";
import { computed, ref, watchEffect, onMounted } from "vue";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import { createApp } from 'vue';
import 'primeicons/primeicons.css';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

    const store = useStore();
    const user = computed(() => store.getters["auth/user"])
    const { processing, logout } = useAuth();

    /*const isDarkMode = ref(true);*/
    const isDarkMode = ref(localStorage.getItem('isDarkMode') === 'true');

const saveDarkModeState = () => {
  localStorage.setItem('isDarkMode', isDarkMode.value);
};

const imageProfile = ref();

const isAdmin = ref('false');

const userId = store.state.auth.user.id;


    watchEffect(() => {
        if (isDarkMode.value) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }

        saveDarkModeState();
    });


    const redirectToView = (event) => {
        const searchText = event.target.value.trim();
        const currentRoute = router.currentRoute.value;
        console.log(currentRoute.path);
        if (searchText !== '') {
            router.push({ 
                name: 'research', 
                query: { search: searchText } 
            });
        } 
    };

    onMounted(() => {
        redirectToView({ target: { value: '' } });

        axios.get('/api/user-data')
        .then(response => {
            imageProfile.value = response.data.user.profile_image;
            isAdmin.value = response.data.isAdmin;
        })
        .catch(error => {
            // Manejar el error en caso de que ocurra
            console.error('Error al obtener los datos del usuario:', error);
        });
    })

</script>

<style>

    .navbar-drop-light .dropdown-menu {
        background: white !important;
    }

    .navbar-drop-light .dropdown-item {
        color: black !important;
    }

    .navbar-drop-light .pi-sun{
        filter: invert(1) !important;
    }

    .navbar-drop-light .pi-moon{
        filter: invert(1) !important;
    }

    .navbar-collapse-light {
        background: white; 
    }

    .navbar-collapse-light .pi{
        filter: none;
    }

    .form-mode{
        position: relative;
        left: 20px;
    }

    .pi-sun{
        position: relative;
        right: 68px;
    }
</style>