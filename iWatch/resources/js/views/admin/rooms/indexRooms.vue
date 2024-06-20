<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las salas</h5>
                        <div>
                            <router-link :to="{ name: 'rooms.create' }" class="btn btn-success">Nueva sala</router-link>
                        </div>
                    </div>

                    {{ rooms }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Capacidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(room, index) in rooms" :key="room.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ room.name }}</td>
                                <td>{{ room.state }}</td>
                                <td>{{ room.capacity }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'rooms.update', params: { id: room.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteReview(room.id, index)">Eliminar</button>
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

const rooms = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/rooms')
        .then(response => {
            rooms.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching rooms:', error);
        });
});

const deleteReview = (id, index) => {
    swal({
        title: '¿Quieres eliminar la sala?',
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
            rooms.value.splice(index, 1);
            axios.delete(`/api/rooms/${id}`)
            .then( response => {
                swal({
                    title: 'Sala eliminada',
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
