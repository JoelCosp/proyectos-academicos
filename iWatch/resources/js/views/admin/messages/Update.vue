<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Actualiza el mensaje</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveMessage">


                <div class="form-group mb-2">
                    <label>Mensaje</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="message.message" placeholder="Mensaje">
                    <div class="text-danger mt-1">
                        {{ errors.message }}
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label>Fecha_creacion</label><span class="text-danger"> *</span>
                    <input type="datetime-local" class="form-control" v-model="message.creation_date">
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4">Actualizar mensaje</button>


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
    message: yup.string().required().label('Mensaje'),
})


const { validate, errors } = useForm({ validationSchema: schema })
const route = useRoute()


setLocale(es);




const { value: messageValue } = useField('message', null, { initialValue: '' });
const { value: creation_date } = useField('creation_date', null, { initialValue: '' });


const message = reactive({
    message: messageValue,
    creation_date
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/messages/' + route.params.id)
    .then(response => {
        message.message = response.data.message;
        message.creation_date = response.data.creation_date;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveMessage() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.put('/api/messages/update/'+route.params.id, message)
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
