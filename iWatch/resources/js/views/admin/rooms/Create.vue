<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un nueva sala</h5>
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
                  {{ room }} 
            <form @submit.prevent="addroom">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="room.name" type="text" class="form-control" placeholder="Mensaje">
                </div>

                <div class="form-group mb-2">
                    <label>Estado</label><span class="text-danger"> *</span>
                    <input v-model="room.state" class="form-control" type="text"/>
                </div>

                <div class="form-group mb-2">
                    <label>Capacidad</label><span class="text-danger"> *</span>
                    <input v-model="room.capacity" class="form-control" type="number"/>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir sala</button>


            </form>


        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";

    const room = ref({});

    const strError = ref();
    const strSuccess = ref();

    function addroom(){
        axios.post('/api/rooms', room.value)
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
