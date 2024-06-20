<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una nueva reseña</h5>
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
                  {{ serie }} 
            <form @submit.prevent="addreview">
                <div class="form-group mb-2">
                    <label>Descripcion</label><span class="text-danger"> *</span>
                    <input v-model="review.description" type="text" class="form-control" placeholder="Descripcion">
                </div>

                <div class="form-group mb-2">
                    <label>Puntuacion</label><span class="text-danger"> *</span>
                    <input v-model="review.punctuation" class="form-control" type="integer">
                </div>

                <div class="form-group mb-2">
                    <label>Fecha_creacion</label><span class="text-danger"> *</span>
                    <input v-model="review.creation_date" class="form-control" type="datetime-local"/>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir reseña</button>


            </form>


        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";

    const review = ref({});

    const strError = ref();
    const strSuccess = ref();

    function addreview(){
        axios.post('/api/reviews', review.value)
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
