<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una nueva película</h5>
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
                  {{ film }} 
            <form @submit.prevent="addfilm">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="film.name" type="text" class="form-control" placeholder="Nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Sinopsis</label><span class="text-danger"> *</span>
                    <textarea v-model="film.synopsis" class="form-control" rows="3" placeholder="Sinopsis"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Director</label><span class="text-danger"> *</span>
                    <textarea v-model="film.director" class="form-control" rows="3" placeholder="Director"></textarea>
                </div>

                <div class="form-gorup mb-2">
                    <label>Duración</label><span class="text-danger">*</span>
                    <input v-model="film.duration" class="form-control" type="time" step="1" name="date_open"/>
                </div>

                <div class="form-gorup mb-2">
                    <label>Episodios</label><span class="text-danger">*</span>
                    <input v-model="film.episodes" class="form-control" type="number" step="1" min="0" name="date_open"/>
                </div>

                <div class="form-gorup mb-2">
                    <label>Temporadas</label><span class="text-danger">*</span>
                    <input v-model="film.seasons" class="form-control" type="number" step="1" min="0" name="date_open"/>
                </div>

                <div class="form-group mb-2">
                    <label for="filmType">Tipo</label><span class="text-danger">*</span>
                    <select v-model="film.type" class="form-control" id="filmType">
                        <option value="film">Película</option>
                        <option value="serie">Serie</option>
                    </select>
                </div>

                <h6 class="mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                    </svg> Suscripcion
                </h6>

                <div class="mb-3">
                    <v-select multiple v-model="film.suscripcion_id" :options="suscripcionList"
                                :reduce="suscripcion => suscripcion.id" label="name" class="form-control" placeholder="Select suscripcion"/>
                    <div class="text-danger mt-1">
                        {{ errors.suscripcions }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.suscripcions">
                            {{ message }}
                        </div>
                    </div>
                </div>

                <h6 class="mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                    </svg> Category
                </h6>

                <div class="mb-3">
                    <v-select multiple v-model="film.categoria_id" :options="categoryList"
                                :reduce="category => category.id" label="name" class="form-control" placeholder="Select category"/>
                    <div class="text-danger mt-1">
                        {{ errors.categories }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.categories">
                            {{ message }}
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Poster</label><span class="text-danger"> *</span>
                    <DropZone v-model="film.thumbnail" />
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.thumbnail">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label>Imagen vertical</label><span class="text-danger"> *</span>
                    <FileUpload class="btn-añadir-img" v-model="film.thumbnail2" mode="basic" name="thumbnail2" accept="image/*" @select="setImageFile" />
                </div>
                


            <!-- Input para el video 
                <div class="form-group mb-2">
                    <label>Video</label><span class="text-danger"> *</span>
                    <VideoDropZone v-model="film.thumbnail2" />
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.thumbnail2">
                            {{ message }}
                        </div>
                    </div>
                </div>
                -->
                
                <div class="form-group mb-2">
                    <label>Video</label><span class="text-danger"> *</span>
                    <FileUpload class="btn-añadir-v" v-model="film.video" mode="basic" name="video" accept="video/*" @select="setVideoFile" />
                </div>                
                
                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir película</button>

            </form>
            <div v-if="film.video">
                <p>URL del video: {{ film.video }}</p>
            </div>

            <div v-if="film.video && typeof film.video === 'object'">
                <p>Nombre del video: {{ film.video.name }}</p>
            </div>

        </div>
    </div>
</template>


<script setup>
    import { onMounted, ref } from "vue";
    import axios from 'axios';
    import DropZone from "@/components/DropZone.vue";
    import ImageDropZone from '@/components/ImageDropZone.vue';
    import VideoDropZone from '@/components/VideoDropZone.vue';
    import { useRouter } from 'vue-router';
    import useCategories from "@/composables/categories";
    import useSuscripcions from "@/composables/suscripcions";
    import {useForm, useField, defineRule} from "vee-validate";
    import {required, min} from "@/validation/rules";
    import FileUpload from 'primevue/fileupload';

    import { useToast } from "primevue/usetoast";
    const toast = useToast();

    const film = ref({
        thumbnail: null,
        thumbnail2: null,
    });
    const strError = ref();
    const lastFilm = ref();
    const strSuccess = ref();
    const router = useRouter();
    const {categoryList, getCategoryList} = useCategories()
    const {suscripcionList, getSuscripcionList} = useSuscripcions()
    const videoFile = ref(null);

    const setVideoFile = (event) => {
        film.value.video = event.files[0];
    };

    const setImageFile = (event) => {
        film.value.thumbnail2 = event.files[0];
    };

    const schema = {
        name: 'required',
        synopsis: 'required',
        director: 'required',
        duration: 'required',
        episodes: 'required|numeric',
        seasons: 'required|numeric',
        type: 'required',
        video: 'required',
        thumbnail1: 'required',
        thumbnail2: 'required',
    };

    const { validate, errors } = useForm();
const { value: name } = useField('name', null, { initialValue: '' });
const { value: synopsis } = useField('synopsis', null, { initialValue: '' });
const { value: director } = useField('director', null, { initialValue: '' });
const { value: duration } = useField('duration', null, { initialValue: '' });
const { value: episodes } = useField('episodes', null, { initialValue: '' });
const { value: seasons } = useField('seasons', null, { initialValue: '' });
const { value: type } = useField('type', null, { initialValue: '' });
const { value: suscripcion_id } = useField('suscripcion_id', null, { initialValue: '' });
const { value: categoria_id } = useField('categoria_id', null, { initialValue: '' });

const isLoading = ref(false); // Agregar esta línea
const validationErrors = ref({}); // Agregar esta línea



function addfilm() {
    validate().then((success) => {
        if (success) {
            const formData = new FormData();
            formData.append('name', film.value.name);
            formData.append('synopsis', film.value.synopsis);
            formData.append('director', film.value.director);
            formData.append('duration', film.value.duration);
            formData.append('episodes', film.value.episodes);
            formData.append('seasons', film.value.seasons);
            formData.append('type', film.value.type);
            //formData.append('categoria_id', film.value.categoria_id);
            formData.append('thumbnail', film.value.thumbnail);
            formData.append('thumbnail2', film.value.thumbnail2);
            formData.append('video', film.value.video);

            film.value.categoria_id.forEach(id => {
                formData.append('categoria_id[]', id);
            });

            film.value.suscripcion_id.forEach(id => {
                formData.append('suscripcion_id[]', id);
            });

            axios.post('/api/films', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then(response => {
                console.log(response);
                strSuccess.value = response.data.success;
                strError.value = "";
                router.push({ name: 'films.indexFilms' }); 
            }).catch(error => {
                console.log(error);
                strSuccess.value = "";
                strError.value = error.response.data.message;
            });
        }
    });
}

    const storeFilm = async (film) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        let serializedFilm = new FormData();
        for (let item in film) {
            if (film.hasOwnProperty(item)) {
                serializedFilm.append(item, film[item]);
            }
        }

        axios.post('/api/films', serializedFilm, {
            headers: {
                "content-type": "multipart/form-data"
            }
        }).then(response => {
            router.push({ name: 'films.indexFilms' });
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
        getCategoryList()
        getSuscripcionList()
    })
</script>



<style>
    .btn-añadir-v{
        margin-top: 10px;
    }

    .btn-añadir-img{
        margin-top: 10px;
    }

    option{
    color: black !important;
    margin: 0;
    padding: 7px 14px;
    }
</style>
