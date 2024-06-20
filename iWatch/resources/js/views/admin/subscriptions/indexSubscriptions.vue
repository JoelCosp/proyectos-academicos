<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las suscripciones</h5>
                        <div>
                            <router-link :to="{ name: 'subscriptions.create' }" class="btn btn-success">Nueva suscripcion</router-link>
                        </div>
                    </div>

                    {{ subscriptions }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Duracion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(subscription, index) in subscriptions" :key="subscription.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ subscription.name }}</td>
                                <td>{{ subscription.price }}</td>
                                <td>{{ subscription.duration }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'subscriptions.update', params: { id: subscription.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deletesubscription(subscription.id, index)">Eliminar</button>
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

const subscriptions = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/subscriptions')
        .then(response => {
            subscriptions.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching series:', error);
        });
});

const deletesubscription = (id, index) => {
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
            subscriptions.value.splice(index, 1);
            axios.delete(`/api/subscriptions/${id}`)
            .then( response => {
                swal({
                    title: 'suscripcion eliminada',
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
