<template>
    <div class="div-salas">
        <h1>SALAS</h1>
        <!-- Itera sobre cada película -->
        <div v-for="filmId in FilmsIds" :key="filmId">
            <h2>Película ID: {{ filmId }}</h2>
            <ul>
                <!-- Itera sobre cada sala asociada a la película -->
                <li v-for="room in rooms" :key="room.id">
                    <p>Nombre: {{ room.name }}</p>
                    <p>Estado: {{ room.state }}</p>
                    <p>Capacidad: {{ room.capacity }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

let rooms = ref([]);
let FilmsIds = ref([]);

const getFilmIds = async () => { 
    try {
        const response = await axios.get('/api/filmsIds');
        FilmsIds.value = response.data; // Actualizamos el valor de FilmsIds con la respuesta
    } catch (error) {
        console.error('Error fetching movie IDs:', error);
    }
}

const getRooms = async (movieId) => { 
    try {
        const response = await axios.get(`/api/movies/${movieId}/rooms`);
        rooms.value = response.data; // Actualizamos el valor de rooms con la respuesta
    } catch (error) {
        console.error('Error fetching rooms:', error);
    }
}

onMounted(async () => { 
    await getFilmIds();
    // Iteramos sobre cada película y obtenemos las salas asociadas
    for (const movieId of FilmsIds.value) {
        await getRooms(movieId);
    }
})
</script>

<style scoped>
.div-salas{
    position: relative;
    top: 50px;
}


</style>