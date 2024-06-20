<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las suscripciones</h5>
                        <div>
                            <router-link :to="{ name: 'suscripciones.create' }" class="btn btn-success">Nueva suscripcion</router-link>
                        </div>
                    </div>

                    {{ suscripciones }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Duracion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(suscripcion, index) in suscripciones" :key="suscripcion.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ suscripcion.name }}</td>
                                <td>{{ suscripcion.description }}</td>
                                <td>{{ suscripcion.price }}</td>
                                <td>{{ suscripcion.duration }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'suscripciones.update', params: { id: suscripcion.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteSuscripcion(suscripcion.id, index)">Eliminar</button>
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

const suscripciones = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/suscripciones')
        .then(response => {
            suscripciones.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching series:', error);
        });
});

const deleteSuscripcion = (id, index) => {
    swal({
        title: '¿Quieres eliminar esta suscripcion?',
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
            suscripciones.value.splice(index, 1);
            axios.delete(`/api/suscripciones/${id}`)
            .then( response => {
                swal({
                    title: 'Suscripcion eliminada',
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
