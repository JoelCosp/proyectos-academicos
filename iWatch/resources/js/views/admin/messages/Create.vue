<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un nuevo mensaje</h5>
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
                  {{ message }} 
            <form @submit.prevent="addmessage">
                <div class="form-group mb-2">
                    <label>Mensaje</label><span class="text-danger"> *</span>
                    <input v-model="message.message" type="text" class="form-control" placeholder="Mensaje">
                </div>

                <div class="form-group mb-2">
                    <label>Fecha_creacion</label><span class="text-danger"> *</span>
                    <input v-model="message.creation_date" class="form-control" type="datetime-local"/>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir mensaje</button>


            </form>


        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";

    const message = ref({});

    const strError = ref();
    const strSuccess = ref();

    function addmessage(){
        axios.post('/api/messages', message.value)
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
