<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los episodios</h5>
                        <div>
                            <router-link :to="{ name: 'episodes.create' }" class="btn btn-success">Nuevo episodio</router-link>
                        </div>
                    </div>
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Episode_name</th>
                                <th>Duration</th>
                                <th>Order</th>
                                <th>Season_id</th>
                                <th>Poster</th>
                                <th>Video</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr v-for="(episode, index) in episodes" :key="episode.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ episode.episode_name }}</td>
                                <td>{{ episode.duration }}</td>
                                <td>{{ episode.order }}</td>
                                <td>{{ episode.season_id }}</td>
                                <td><img :src="episode.media.length > 0 ? episode.media[0].original_url : '/images/placeholder.jpg'" :alt="episode.name" style="max-height: 100px;"></td>
                                <td><video controls :src= "episode.media[1].original_url ? episode.media[1].original_url:  ''"  :alt="episode.name" style="max-height: 100px;"></video></td>                             
                                <td class="text-center">
                                    <!-- <router-link :to="{ name: 'episodes.update', params: { id: episode.id } }" class="btn btn-warning mr-1">Editar</router-link> -->
                                    <button class="btn btn-danger" @click="deleteFilm(episode.id, index)">Eliminar</button>
                                </td>
                                <!-- <td>{{ episode.media[0].id}}</td> -->
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

</template>

<script setup>
import axios from "axios";
import { ref, inject, onMounted } from "vue";

const episodes = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/episodes')
        .then(response => {
            episodes.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching episodes:', error);
        });
});

const deleteFilm = (id, index) => {
    swal({
        title: '¿Quieres eliminar la película?',
        text: '¡Esta acción no se puede deshacer!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
    })
    .then(result => {
        if (result.isConfirmed) {
            episodes.value.splice(index, 1);
            axios.delete(`/api/episodes/${id}`)
            .then( response => {
                swal({
                    title: 'Película eliminada',
                    icon: 'success',
                    timer: 10000,
                    timerProgressBar: true,
                })
            })
        }
    });
}
</script>

<style>
/* Estilos CSS aquí si es necesario */
</style>
