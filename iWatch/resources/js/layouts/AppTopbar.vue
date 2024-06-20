<template>
    <div class="layout-topbar">
        <router-link to="/" class="layout-topbar-logo">
            <img src="/images/iWatchLogo.svg" alt="logo" class="navbar-icon-light" />
            <span></span>
        </router-link>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle()">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>


        <div class="dropdown">
            <i class="pi pi-user"></i>
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Hola, {{ user.name }}
            </button>
            <ul class="dropdown-menu">
                <li>
                    <router-link :to="{ name: 'profile.index' }" class="dropdown-item">Perfil</router-link>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Preferencias</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                        href="javascript:void(0)" @click="logout">Cerrar sessión</a>
                </li>
            </ul>
        </div>

        <!--ANTIGUO DROP DOWN BUTTON DEL PERFIL-->
        
        <!--
        <div class="layout-topbar-menu" :class="topbarMenuClasses">

            <div class="dropdown">
            <i class="pi pi-user"></i>
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Hola, {{ user.name }}
            </button>
            <ul class="dropdown-menu">
                <li>
                    <router-link :to="{ name: 'profile.index' }" class="dropdown-item">Perfil</router-link>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Preferencias</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                        href="javascript:void(0)" @click="logout">Cerrar sessión</a>
                </li>
            </ul>
        </div>
        </div>
        -->
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { useLayout } from '../composables/layout';
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";

const { onMenuToggle } = useLayout();
const store = useStore();
const user = computed(() => store.state.auth.user)
const { processing, logout } = useAuth();

const topbarMenuActive = ref(false);

const onTopBarMenuButton = () => {
    topbarMenuActive.value = !topbarMenuActive.value;
};

const topbarMenuClasses = computed(() => {
    return {
        'layout-topbar-menu-mobile-active': topbarMenuActive.value
    };
});


</script>

<style lang="scss" scoped>
.layout-topbar-button-c,
.layout-topbar-button-c:hover {
    width: auto;
    background-color: rgb(255, 255, 255, 0);
    border: 0;
    border-radius: 0%;
    padding: 1em;
}
</style>
