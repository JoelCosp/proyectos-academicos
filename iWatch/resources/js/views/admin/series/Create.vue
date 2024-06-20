<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una nueva serie</h5>
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
            <form @submit.prevent="addserie">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="serie.name" type="text" class="form-control" placeholder="Nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Sinopsis</label><span class="text-danger"> *</span>
                    <textarea v-model="serie.synopsis" class="form-control" rows="3" placeholder="Sinopsis"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Director</label><span class="text-danger"> *</span>
                    <textarea v-model="serie.director" class="form-control" rows="3" placeholder="Director"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Episodios</label><span class="text-danger"> *</span>
                    <input v-model="serie.episodes" type="number" class="form-control" min="0" placeholder="Episodios">
                </div>

                <div class="form-gorup mb-2">
                    <label>Duración</label><span class="text-danger">*</span>
                    <input v-model="serie.duration" class="form-control" type="time" step="1" name="date_open"/>
                </div>

                <div class="form-group mb-2">
                    <label>Temporadas</label><span class="text-danger"> *</span>
                    <input v-model="serie.seasons" type="number" class="form-control" min="0" placeholder="Temporadas">
                </div>

                <h6 class="mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                    </svg> Thumbnail
                </h6>
                <DropZone v-model="serie.thumbnail"/>
                <div class="text-danger mt-1">
                    <div v-for="message in validationErrors?.thumbnail">
                        {{ message }}
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir serie</button>


            </form>


        </div>
    </div>
</template>


<script setup>
    import { onMounted, ref } from "vue";
    import axios from 'axios';
    import DropZone from "@/components/DropZone.vue";
    import { useRouter } from 'vue-router';
    import useCategories from "@/composables/categories";
    import {useForm, useField, defineRule} from "vee-validate";
    import {required, min} from "@/validation/rules";

    const serie = ref({});

    const strError = ref();
    const strSuccess = ref();
    const router = useRouter();
    const schema = {
        name: 'required',
        synopsis: 'required',
        director: 'required',
        duration: 'required',
        episodes: 'required|numeric',
        seasons: 'required|numeric',
        thumbnail: 'required'
    };

const { validate, errors } = useForm();
const { value: name } = useField('name', null, { initialValue: '' });
const { value: synopsis } = useField('synopsis', null, { initialValue: '' });
const { value: director } = useField('director', null, { initialValue: '' });
const { value: duration } = useField('duration', null, { initialValue: '' });
const { value: episodes } = useField('episodes', null, { initialValue: '' });
const { value: seasons } = useField('seasons', null, { initialValue: '' });
const isLoading = ref(false); // Agregar esta línea
const validationErrors = ref({}); // Agregar esta línea

    function addserie() {
    validate().then((success) => {
        if (success) {
            const formData = new FormData();
            formData.append('name', serie.value.name);
            formData.append('synopsis', serie.value.synopsis);
            formData.append('director', serie.value.director);
            formData.append('duration', serie.value.duration);
            formData.append('episodes', serie.value.episodes);
            formData.append('seasons', serie.value.seasons);
            formData.append('thumbnail', serie.value.thumbnail);

            axios.post('/api/series', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then(response => {
                console.log(response);
                strSuccess.value = response.data.success;
                strError.value = "";
                router.push({ name: 'series.indexSeries' }); 
            }).catch(error => {
                console.log(error);
                strSuccess.value = "";
                strError.value = error.response.data.message;
            });
        }
    });
}

    const storeSerie = async (serie) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        let serializedSerie = new FormData();
        for (let item in film) {
            if (serie.hasOwnProperty(item)) {
                serializedSerie.append(item, serie[item]);
            }
        }

        axios.post('/api/series', serializedSerie, {
            headers: {
                "content-type": "multipart/form-data"
            }
        }).then(response => {
            router.push({ name: 'series.indexSeries' });
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
</script>


<style>
</style>
