<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualiza la sala</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveRoom">


                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="room.name" placeholder="Nombre">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Estado</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="room.state">
                </div>

                <div class="form-group mb-2">
                    <label>Capacidad</label><span class="text-danger"> *</span>
                    <input v-model="room.capacity" class="form-control" type="number"/>
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar sala</button>


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
const { value: state } = useField('state', null, { initialValue: '' });
const { value: capacity } = useField('capacity', null, { initialValue: '' });

const room = reactive({
    name,
    state,
    capacity
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/rooms/' + route.params.id)
    .then(response => {
        room.name = response.data.name;
        room.state = response.data.state;
        room.capacity = response.data.capacity;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveRoom() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.put('/api/rooms/update/'+route.params.id, room)
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
