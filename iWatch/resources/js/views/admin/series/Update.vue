<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualiza la serie</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveSerie">


                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="serie.name" placeholder="Nombre película">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Sinopsis</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="serie.synopsis" placeholder="Sinopsis"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Director</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="serie.director" placeholder="Director"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Puntuación</label><span class="text-danger"> *</span>
                    <input v-model="serie.punctuation" type="number" class="form-control" min="0" placeholder="Puntuación">
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

                <div class="form-group mb-2">
                    <label>Video</label>
                    <input v-model="serie.video" type="text" class="form-control" placeholder="Ruta de Video">
                </div>

                <div class="form-group mb-2">
                    <label>Poster</label>
                    <input v-model="serie.poster" type="text" class="form-control" placeholder="Imagen del poster">
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar serie</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import { ref, onMounted, reactive } from "vue";
import { useForm, useField} from "vee-validate";
import { useRoute } from "vue-router";
import * as yup from 'yup';
import { es } from 'yup-locales';
import { setLocale } from 'yup';


const schema =  yup.object({
    name: yup.string().required().label('Nombre'),
})


const { validate, errors } = useForm({ validationSchema: schema })
const route = useRoute()


setLocale(es);




const { value: name } = useField('name', null, { initialValue: '' });
const { value: synopsis } = useField('synopsis', null, { initialValue: '' });
const { value: director } = useField('director', null, { initialValue: '' });
const { value: punctuation } = useField('punctuation', null, { initialValue: '' });
const { value: episodes } = useField('episodes', null, { initialValue: '' });
const { value: duration } = useField('duration', null, { initialValue: '' });
const { value: seasons } = useField('seasons', null, { initialValue: '' });
const { value: video } = useField('video', null, { initialValue: '' });
const { value: poster } = useField('poster', null, { initialValue: '' });


const serie = reactive({
    name,
    synopsis,
    director,
    punctuation,
    episodes,
    duration,
    seasons,
    video,
    poster
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/series/' + route.params.id)
    .then(response => {
        serie.name = response.data.name;
        serie.synopsis = response.data.synopsis;
        serie.director = response.data.director;
        serie.punctuation = response.data.punctuation;
        serie.episodes = response.data.episodes;
        serie.duration = response.data.duration;
        serie.seasons = response.data.seasons;
        serie.video = response.data.video;
        serie.poster = response.data.poster;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveSerie() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.put('/api/series/update/'+route.params.id, serie)
            .then(response => {
                strError.value = ""
                strSuccess.value = response.data.success
            })
            .catch(function (error) {
                strSuccess.value = ""
                strError.value = error.response.data.message
            });
        }
    })

}


</script>


<style>
</style>
