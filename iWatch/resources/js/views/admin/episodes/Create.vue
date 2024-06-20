<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un nuevo episodio</h5>
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
                  {{ episode }} 
            <form @submit.prevent="addEpisode">
                <div class="form-group mb-2">
                    <label>Nombre del episodio</label><span class="text-danger"> *</span>
                    <input v-model="episode.episode_name" type="text" class="form-control" placeholder="Nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Descripción del episodio</label><span class="text-danger"> *</span>
                    <input v-model="episode.description" type="text" class="form-control" placeholder="Descripcion">
                </div>

                <div class="form-gorup mb-2">
                    <label>Duración</label><span class="text-danger">*</span>
                    <input v-model="episode.duration" class="form-control" type="time" step="1" name="date_open"/>
                </div>

                <div class="form-group mb-2">
                    <label>Orden</label><span class="text-danger"> *</span>
                    <input v-model="episode.order" type="number" class="form-control" placeholder="Orden episodio">
                </div>

                <div class="form-group mb-2">
                    <label>Temporada</label><span class="text-danger"> *</span>
                    <input v-model="episode.season_id" type="number" class="form-control" placeholder="Temporada">
                </div>

                <div class="form-group mb-2">
                    <label>Poster</label><span class="text-danger"> *</span>
                    <DropZone v-model="episode.thumbnail" />
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.thumbnail">
                            {{ message }}
                        </div>
                    </div>
                </div>
                
                <FileUpload v-model="episode.video" mode="basic" name="video" accept="video/*" @select="setVideoFile" />
                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir episodio</button>

            </form>
            <div v-if="episode.video">
                <p>URL del video: {{ episode.video }}</p>
            </div>

            <div v-if="episode.video && typeof episode.video === 'object'">
                <p>Nombre del video: {{ episode.video.name }}</p>
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
    import {useForm, useField, defineRule} from "vee-validate";
    import {required, min} from "@/validation/rules";
    import FileUpload from 'primevue/fileupload';

    import { useToast } from "primevue/usetoast";
    const toast = useToast();

    const episode = ref({
        thumbnail: null,
    });
    const strError = ref();
    const strSuccess = ref();
    const router = useRouter();
    const {categoryList, getCategoryList} = useCategories()
    const videoFile = ref(null);

    const setVideoFile = (event) => {
        episode.value.video = event.files[0];
    };

    const schema = {
        episode_name: 'required',
        duration: 'required',
        order: 'required|numeric',
        season_id: 'required|numeric',
        video: 'required',
        thumbnail1: 'required'
    };

    const { validate, errors } = useForm();
    const { value: episode_name } = useField('episode_name', null, { initialValue: '' });
    const { value: description } = useField('description', null, { initialValue: '' });
    const { value: duration } = useField('duration', null, { initialValue: '' });
    const { value: order } = useField('order', null, { initialValue: '' });
    const { value: season_id } = useField('season_id', null, { initialValue: '' });

    const isLoading = ref(false); // Agregar esta línea
    const validationErrors = ref({}); // Agregar esta línea



function addEpisode() {
    validate().then((success) => {
        if (success) {
            const formData = new FormData();
            formData.append('episode_name', episode.value.episode_name);
            formData.append('description', episode.value.description);
            formData.append('duration', episode.value.duration);
            formData.append('order', episode.value.order);
            formData.append('season_id', episode.value.season_id);
            formData.append('thumbnail', episode.value.thumbnail);
            formData.append('video', episode.value.video);

            axios.post('/api/episodes', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then(response => {
                console.log(response);
                strSuccess.value = response.data.success;
                strError.value = "";
                router.push({ name: 'episodes.index' }); 
            }).catch(error => {
                console.log(error);
                strSuccess.value = "";
                strError.value = error.response.data.message;
            });
        }
    });
}

    const storeEpisode = async (episode) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        let serializedEpisode = new FormData();
        for (let item in episode) {
            if (episode.hasOwnProperty(item)) {
                serializedEpisode.append(item, episode[item]);
            }
        }

        axios.post('/api/episodes', serializedEpisode, {
            headers: {
                "content-type": "multipart/form-data"
            }
        }).then(response => {
            router.push({ name: 'episodes.index' });
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
    })
</script>



<style>
</style>
