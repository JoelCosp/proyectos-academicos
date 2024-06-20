<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas los mensajes</h5>
                        <div>
                            <router-link :to="{ name: 'messages.create' }" class="btn btn-success">Nuevo mensaje</router-link>
                        </div>
                    </div>

                    {{ messages }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Mensaje</th>
                                <th>Fecha_creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(message, index) in messages" :key="message.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ message.message }}</td>
                                <td>{{ message.creation_date }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'messages.update', params: { id: message.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteMessage(message.id, index)">Eliminar</button>
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

const messages = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/messages')
        .then(response => {
            messages.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
});

const deleteMessage = (id, index) => {
    swal({
        title: '¿Quieres eliminar el mensaje?',
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
            messages.value.splice(index, 1);
            axios.delete(`/api/messages/${id}`)
            .then( response => {
                swal({
                    title: 'Mensaje eliminado',
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
