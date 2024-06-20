<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualiza la suscripcion</h5>
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
                    <input type="text" class="form-control" v-model="suscripcion.name" placeholder="Nombre">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Precio</label><span class="text-danger"> *</span>
                    <input v-model="suscripcion.price" class="form-control" type="decimal">
                </div>

                <div class="form-gorup mb-2">
                    <label>Duración</label><span class="text-danger">*</span>
                    <input v-model="suscripcion.duration" class="form-control" type="time" step="1" name="date_open"/>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar suscripcion</button>


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
const { value: price } = useField('price', null, { initialValue: '' });
const { value: duration } = useField('duration', null, { initialValue: '' });


const suscripcion = reactive({
    name,
    price,
    duration
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/suscripciones/' + route.params.id)
    .then(response => {
        suscripcion.name = response.data.name;
        suscripcion.price = response.data.price;
        suscripcion.duration = response.data.duration;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveSerie() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.put('/api/suscripciones/update/'+route.params.id, suscripcion)
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
