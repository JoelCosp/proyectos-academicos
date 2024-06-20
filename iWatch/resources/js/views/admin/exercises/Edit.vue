<template>
    <form @submit.prevent="submitForm">
        <div class="row my-5">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="exercise-title" class="form-label"> Título</label>
                            <input v-model="exercise.title" id="exercise-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.title }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.title">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exercise-content" class="form-label">
                                Enunciado
                            </label>
                            <TextEditorComponent v-model="exercise.content" />
                            <div class="text-danger mt-1">
                                {{ errors.content }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.content">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mt-3">Categoria</h6>

                        <div class="mb-3">
                          
                            <MultiSelect v-model="exercise.categories" filter :options="categoryList" dataKey="id"
                                optionLabel="name" placeholder="Seleciona una categoría" display="chip"
                                class="w-full md:w-20rem">
                            </MultiSelect>

                            <div class="text-danger mt-1">
                                {{ errors.categories }}
                            </div>

                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.categories">
                                    {{ message }}
                                </div>
                            </div>

                        </div>

                        <div class="mb-3">
                            <h6 class="mt-3">Imagen</h6>

                            <DropZone v-model="exercise.thumbnail" />
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.thumbnail">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <button :disabled="isLoading" class="btn btn btn-primary me-2 w-100">
                                <div v-show="isLoading" class=""></div>
                                <span v-if="isLoading">Processing...</span>
                                <span v-else>Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import { onMounted, reactive, watchEffect } from "vue";
import { useRoute } from "vue-router";
import useCategories from "@/composables/categories";
import useExercises from "@/composables/exercises";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "@/validation/rules"
import TextEditorComponent from "@/components/TextEditorComponent.vue";
import DropZone from "@/components/DropZone.vue";
defineRule('required', required)
defineRule('min', min);

const schema = {
    title: 'required|min:5',
    content: 'required|min:50',
    categories: 'required'
}

const { validate, errors, resetForm } = useForm({ validationSchema: schema })
const { value: title } = useField('title', null, { initialValue: '' });
const { value: content } = useField('content', null, { initialValue: '' });
const { value: categories } = useField('categories', null, { initialValue: '', label: 'category' });
const { categoryList, getCategoryList } = useCategories()
const { exercise: exerciseData, getExercise, updateExercise, validationErrors, isLoading } = useExercises()
const exercise = reactive({
    title,
    content,
    categories,
    thumbnail: ''
})

const route = useRoute()
function submitForm() {
    validate().then(form => { if (form.valid) updateExercise(exercise) })
}

onMounted(() => {
    getExercise(route.params.id)
    getCategoryList()
})

watchEffect(() => {
    exercise.id = exerciseData.value.id
    exercise.title = exerciseData.value.title
    exercise.content = exerciseData.value.content
    exercise.thumbnail = exerciseData.value.original_image
    exercise.categories = exerciseData.value.categories
})
</script>
