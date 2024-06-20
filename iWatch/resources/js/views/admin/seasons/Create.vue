<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una nueva temporada</h5>
            </div>
            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>
                  <p>TEMPORADAS: {{ season }}</p>
                  <p>SERIES: {{ series }}</p>
            <form @submit.prevent="addSeason">

                <div class="form-group mb-2">
                    <label>Content ID</label><span class="text-danger"> *</span>
                    <input v-model="season.content_id" type="text" class="form-control" placeholder="Content ID">
                </div>


                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="season.season_name" type="text" class="form-control" placeholder="Nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Orden</label><span class="text-danger"> *</span>
                    <input v-model="season.order" type="number" class="form-control" placeholder="Orden temporada">
                </div>

                <h6 class="mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                    </svg> Serie
                </h6>

                <div class="mb-3">
                    <v-select multiple v-model="season.series" :options="series" label="name" :reduce="series => series.id" class="form-control" placeholder="Select your serie"/>
                    <div class="text-danger mt-1">
                        {{ errors.series }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.seasons">
                            {{ message }}
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir temporada</button>

            </form>

        </div>
    </div>
</template>


<script setup>
    import { onMounted, ref } from "vue";
    import axios from 'axios';
    import DropZone from "@/components/DropZone.vue";
    import { useRouter } from 'vue-router';
    import {useForm, useField, defineRule} from "vee-validate";
    import {required, min} from "@/validation/rules";

    import { useToast } from "primevue/usetoast";
    const toast = useToast();
    const series = ref([]);

    const season = ref({});
    const strError = ref();
    const strSuccess = ref();
    const router = useRouter();

    const schema = {
        season_name: 'required',
        content_id: 'required',
    };

    const { validate, errors } = useForm();
    const { value: season_name } = useField('season_name', null, { initialValue: '' });
    const { value: order } = useField('order', null, { initialValue: '' });
    const { value: content_id } = useField('content_id', null, { initialValue: '' });
    const isLoading = ref(false); // Agregar esta línea
    const validationErrors = ref({}); // Agregar esta línea



function addSeason(){
        axios.post('/api/seasons', season.value)
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

    const storeSeason = async (season) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        let serializedSeason = new FormData();
        for (let item in season) {
            if (season.hasOwnProperty(item)) {
                serializedSeason.append(item, season[item]);
            }
        }

        axios.post('/api/seasons', serializedSeason, {
            headers: {
                "content-type": "multipart/form-data"
            }
        }).then(response => {
            router.push({ name: 'seasons.index' });
            swal({
                icon: 'success',
                title: 'Exercise saved successfully'
            });
        }).catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors;
            }
        }).finally(() => isLoading.value = false);
    }


    onMounted(() => {
        axios.get('/api/seriesAllNames')
        .then(response => {
            series.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching series:', error);
        });
    })
</script>



<style>
</style>
