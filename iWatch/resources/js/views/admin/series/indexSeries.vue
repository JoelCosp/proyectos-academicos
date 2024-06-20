<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las series</h5>
                        <div>
                            <router-link :to="{ name: 'series.create' }" class="btn btn-success">Nueva serie</router-link>
                        </div>
                    </div>

                    {{ series }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Sinopsis</th>
                                <th>Director</th>
                                <th>Puntuación</th>
                                <th>Nº de episodios</th>
                                <th>Duración</th>
                                <th>Nº de temporadas</th>
                                <th>Video</th>
                                <th>Poster</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(serie, index) in series" :key="serie.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ serie.name }}</td>
                                <td>{{ serie.synopsis }}</td>
                                <td>{{ serie.director }}</td>
                                <td>{{ serie.punctuation }}</td>
                                <td>{{ serie.episodes }}</td>
                                <td>{{ serie.duration }}</td>
                                <td>{{ serie.seasons }}</td>
                                <td>{{ serie.video }}</td>
                                <td><img :src="serie.media.length > 0 ? serie.media[0].original_url : '/images/placeholder.jpg'" :alt="serie.name" style="max-height: 100px;"></td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'series.update', params: { id: serie.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteSerie(serie.id, index)">Eliminar</button>
                                </td>
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

const series = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/series')
        .then(response => {
            series.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching series:', error);
        });
});

const deleteSerie = (id, index) => {
    swal({
        title: '¿Quieres eliminar esta serie?',
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
            series.value.splice(index, 1);
            axios.delete(`/api/series/${id}`)
            .then( response => {
                swal({
                    title: 'Serie eliminada',
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
