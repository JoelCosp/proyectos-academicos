<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las películas</h5>
                        <div>
                            <router-link :to="{ name: 'films.create' }" class="btn btn-success">Nueva película</router-link>
                        </div>
                        <!-- {{ films }} -->
                    </div>
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Sinopsis</th>
                                <th>Director</th>
                                <th>Puntuación</th>
                                <th>Duración</th>
                                <th>Episodios</th>
                                <th>Temporadas</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>Nivel de suscripción</th>
                                <th>Poster</th>
                                <th>Poster h</th>
                                <th>Video</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(film, index) in films" :key="film.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ film.name }}</td>
                                <td>{{ film.synopsis }}</td>
                                <td>{{ film.director }}</td>
                                <td>{{ film.punctuation }}</td>
                                <td>{{ film.duration }}</td>
                                <td>{{ film.episodes }}</td>
                                <td>{{ film.seasons }}</td>
                                <td>{{ film.categoria_id }}</td>
                                <td>{{ film.type }}</td>
                                <td>{{ film.suscripcion_id }}</td>
                                <td><img :src="film.media.length > 0 ? film.media[0].original_url : '/images/placeholder.jpg'" :alt="film.name" style="max-height: 100px;"></td>
                                <td><img :src="film.media.length > 0 ? film.media[1].original_url : '/images/placeholder.jpg'" :alt="film.name" style="max-height: 100px;"></td>
                                <td><video controls :src= "film.media[2].original_url ? film.media[2].original_url:  ''"  :alt="film.name" style="max-height: 100px;"></video></td>                             
                                <td class="text-center">
                                    <router-link :to="{ name: 'films.update', params: { id: film.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteFilm(film.id, index)">Eliminar</button>
                                </td>
                                <!-- <td>{{ film.media[0].id}}</td> -->
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

const films = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/films')
        .then(response => {
            films.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching films:', error);
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
            films.value.splice(index, 1);
            axios.delete(`/api/films/${id}`)
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
