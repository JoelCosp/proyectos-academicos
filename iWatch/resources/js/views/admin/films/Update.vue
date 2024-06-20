<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualiza la película</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveFilm">


                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="film.name" placeholder="Nombre película">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Sinopsis</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="film.synopsis" placeholder="Sinopsis"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Director</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="film.director" placeholder="Director"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Puntuación</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="film.punctuation" placeholder="Puntuación"></textarea>
                </div>

                <div class="form-gorup mb-2">
                    <label>Duración</label><span class="text-danger">*</span>
                    <input class="form-control" type="time" step="1" v-model="film.duration" name="date_open" />
                </div>

                <div class="form-group mb-2">
                    <label>Video</label>
                    <input v-model="film.video" type="text" class="form-control" placeholder="Ruta de Video">
                </div>

                <div class="form-group mb-2">
                    <label>Poster</label>
                    <input v-model="film.poster" type="text" class="form-control" placeholder="Imagen del poster">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar película</button>


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
const { value: duration } = useField('duration', null, { initialValue: '' });
const { value: video } = useField('video', null, { initialValue: '' });
const { value: poster } = useField('poster', null, { initialValue: '' });


const film = reactive({
    name,
    synopsis,
    director,
    punctuation,
    duration,
    video,
    poster
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/films/' + route.params.id)
    .then(response => {
        film.name = response.data.name;
        film.synopsis = response.data.synopsis;
        film.director = response.data.director;
        film.punctuation = response.data.punctuation;
        film.duration = response.data.duration;
        film.video = response.data.video;
        film.poster = response.data.poster;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveFilm() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.put('/api/films/update/'+route.params.id, film)
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
