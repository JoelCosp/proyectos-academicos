<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una tarea nueva</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveTask">


                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="task.name" placeholder="Nombre tarea">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                </div>


                <div class="form-group mb-2">
                    <label>Descripción</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="task.description" placeholder="Descripción"></textarea>
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha inicio</label><span class="text-danger">*</span>
                    <input class="form-control" type="datetime-local" v-model="task.date_open" name="date_open" />
                </div>
       
                <div class="form-gorup mb-2">
                    <label>Fecha fin</label><span class="text-danger">*</span>
                    <input class="form-control" type="datetime-local" v-model="task.date_close" name="date_close" />
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir Tarea</button>


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
const { value: description } = useField('description', null, { initialValue: '' });
const { value: date_open } = useField('date_open', null, { initialValue: '' });
const { value: date_close } = useField('date_close', null, { initialValue: '' });


const task = reactive({
    name,
    description,
    date_open,
    date_close
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/tasks/' + route.params.id)
    .then(response => {
        task.name = response.data.name;
        task.description = response.data.description;
        task.date_open = response.data.date_open;
        task.date_close = response.data.date_close;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveTask() {
    validate().then(form => {
        console.log('validate');
        if (form.valid){
            axios.post('/api/tasks/update/'+route.params.id, task)
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
