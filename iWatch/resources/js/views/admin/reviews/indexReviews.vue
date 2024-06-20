<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las reseñas</h5>
                        <div>
                            <router-link :to="{ name: 'reviews.create' }" class="btn btn-success">Nueva reseña</router-link>
                        </div>
                    </div>

                    {{ reviews }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Descripcion</th>
                                <th>Puntuacion</th>
                                <th>Fecha_creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(review, index) in reviews" :key="review.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ review.description }}</td>
                                <td>{{ review.punctuation }}</td>
                                <td>{{ review.creation_date }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'reviews.update', params: { id: review.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteReview(review.id, index)">Eliminar</button>
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

const reviews = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/reviews')
        .then(response => {
            reviews.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching reviews:', error);
        });
});

const deleteReview = (id, index) => {
    swal({
        title: '¿Quieres eliminar la reseña?',
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
            reviews.value.splice(index, 1);
            axios.delete(`/api/reviews/${id}`)
            .then( response => {
                swal({
                    title: 'Reseña eliminada',
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
