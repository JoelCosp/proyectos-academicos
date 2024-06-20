<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un nueva categoria</h5>
            </div>
            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>
<!-- CREAR TAREAS-->

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>
                  {{ categoria }} 
            <form @submit.prevent="addcategoria">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="categoria.name" type="text" class="form-control" placeholder="Nombre">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir categoria</button>


            </form>


        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";

    const categoria = ref({});

    const strError = ref();
    const strSuccess = ref();

    function addcategoria(){
        axios.post('/api/categorias', categoria.value)
        .then(response =>{
            console.log(response);
            strSuccess.value = response.data.success;
            strError.value = "";
        }).catch(error =>{
            console.log(error);
            strSuccess.value = "";
            strError.value = error.response.data.message;
        });
    }
</script>


<style>
</style>
