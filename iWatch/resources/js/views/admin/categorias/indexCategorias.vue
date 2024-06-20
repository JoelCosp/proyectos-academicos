<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las categorias</h5>
                        <div>
                            <router-link :to="{ name: 'categorias.create' }" class="btn btn-success">Nueva categoria</router-link>
                        </div>
                    </div>

                    {{ categorias }}
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(categoria, index) in categorias" :key="categoria.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ categoria.name }}</td>
                                <td class="text-center">
                                    <router-link :to="{ name: 'categorias.update', params: { id: categoria.id } }" class="btn btn-warning mr-1">Editar</router-link>
                                    <button class="btn btn-danger" @click="deleteCategoria(categoria.id, index)">Eliminar</button>
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

const categorias = ref([]);
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/categorias')
        .then(response => {
            categorias.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching categorias:', error);
        });
});

const deleteCategoria = (id, index) => {
    swal({
        title: '¿Quieres eliminar la categoria?',
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
            categorias.value.splice(index, 1);
            axios.delete(`/api/categorias/${id}`)
            .then( response => {
                swal({
                    title: 'Categoria eliminada',
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
