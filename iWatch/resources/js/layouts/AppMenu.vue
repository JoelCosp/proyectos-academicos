
<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<script setup>
import { ref } from 'vue';
import AppMenuItem from './AppMenuItem.vue';
import {useAbility} from '@casl/vue'
const {can} = useAbility();

const vela = "pepe";

// Opciones menu lateral
const model = ref([
    {
        label: 'Home',
        items: [
            { label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/admin', permision: 'all'},
            { label: 'Iwatch', icon: 'pi pi-fw pi-home', to: '/home', permision: 'all'}
        ]
    },
    {
        label: 'Usuarios',
        items: [
            { label: 'Users', icon: 'pi pi-fw pi-id-card', to: '/admin/users', permision: 'user-list' },
            { label: 'Roles', icon: 'pi pi-fw pi-check-square', to: '/admin/roles', permision:'role-list' },
            { label: 'Permisos', icon: 'pi pi-fw pi-bookmark', to: '/admin/permissions', permision:'permission-list' }
        ]
    },
    {
        label: 'Películas',
        items: [
            { label: 'Listar peliculas', icon: 'pi pi-fw pi-id-card', to: '/admin/films', permision: 'post-list' },
            { label: 'Crear peliculas', icon: 'pi pi-fw pi-id-card', to: '/admin/films/createFilm', permision: 'post-list' }
        ]
    },
    {
        label: 'Series',
        items: [
            { label: 'Listar series', icon: 'pi pi-fw pi-id-card', to: '/admin/series', permision: 'post-list' },
            { label: 'Crear series', icon: 'pi pi-fw pi-id-card', to: '/admin/series/createSerie', permision: 'post-list' }
        ]
    },
    {
        label: 'Temporadas',
        items: [
            { label: 'Listar temporadas', icon: 'pi pi-fw pi-id-card', to: '/admin/seasons', permision: 'post-list' },
            { label: 'Crear temporadas', icon: 'pi pi-fw pi-id-card', to: '/admin/seasons/createSeason', permision: 'post-list' }
        ]
    },
    {
        label: 'Episodios',
        items: [
            { label: 'Listar episodios', icon: 'pi pi-fw pi-id-card', to: '/admin/episodes', permision: 'post-list' },
            { label: 'Crear episodios', icon: 'pi pi-fw pi-id-card', to: '/admin/episodes/createEpisode', permision: 'post-list' }
        ]
    },
    {
        label: 'Suscripciones',
        items: [
            { label: 'Listar suscripciones', icon: 'pi pi-fw pi-id-card', to: '/admin/suscripciones', permision: 'post-list' },
            { label: 'Crear suscripciones', icon: 'pi pi-fw pi-id-card', to: '/admin/suscripciones/createSuscripcion', permision: 'post-list' }

        ]
    },
    {
        label: 'Categorías',
        items: [
            { label: 'Listar categorias', icon: 'pi pi-fw pi-id-card', to: '/admin/categories', permision: 'post-list' },
            { label: 'Crear categorias', icon: 'pi pi-fw pi-id-card', to: '/admin/categories/create', permision: 'post-list' }

        ]
    },
    /*{
        label: 'Salas',
        items: [
            { label: 'Ver salas', icon: 'pi pi-fw pi-id-card', to: '/admin/rooms', permision: 'post-list' }
        ]
    }*/
]);
</script>


<style lang="scss" scoped></style>
