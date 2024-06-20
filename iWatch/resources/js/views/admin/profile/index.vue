<template>
    <div class="card border-0">
        <div class="card-header bg-transparent">
            <h5 class="float-start">Profile</h5>
        </div>
        {{ profile }}
        <div class="card-body">
            <form @submit.prevent="submitForm">
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Foto de perfil</label>
                    <input type="file" class="form-control" id="profile_image" @change="onFileChange($event)">
                    <div class="text-danger mt-1">
                        {{ errors.profile_image }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.profile_image">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" v-model="profile.name" class="form-control" id="name">
                    <div class="text-danger mt-1">
                        {{ errors.name }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.name">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Apellido</label>
                    <input type="text" v-model="profile.apellido" class="form-control" id="apellido">
                    <div class="text-danger mt-1">
                        {{ errors.apellido }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.apellido">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Teléfono</label>
                    <input type="text" v-model="profile.phone" class="form-control" id="phone">
                    <div class="text-danger mt-1">
                        {{ errors.phone }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.phone">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" v-model="profile.email" class="form-control" id="email">
                    <div class="text-danger mt-1">
                        {{ errors.email }}
                    </div>
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.email">
                            {{ message }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button :disabled="isLoading" class="btn btn-primary">
                        <div v-show="isLoading" class=""></div>
                        <span v-if="isLoading">Procesando...</span>
                        <span v-else>Actualizar datos</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, watchEffect } from "vue";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "@/validation/rules"
import useProfile from "@/composables/profile";
defineRule('required', required)
// defineRule('email', email)
defineRule('min', min);

    const schema = {
        name: 'required|min:3',
        email: 'required',
    }
    // Create a form context with the validation schema
    const { validate, errors } = useForm({ validationSchema: schema })
    // Define actual fields for validation
    const { value: name } = useField('name', null, { initialValue: '' });
    const { value: email } = useField('email', null, { initialValue: '' });
    const { value: apellido } = useField('apellido', null, { initialValue: '' });
    const { value: phone } = useField('phone', null, { initialValue: '' });
    const { value: profile_image } = useField('profile_image', '', { initialValue: '' });
    const { profile: profileData, getProfile, updateProfile, validationErrors, isLoading } = useProfile()
    const profile = reactive({
        name,
        email,
        apellido,
        phone,
        profile_image
    })
    function submitForm() {
        validate().then(form => { if (form.valid) updateProfile(profile) })
    }
    

    function onFileChange(event) {
    const file = event.target.files[0]; // Obtener el archivo seleccionado
    const formData = new FormData();
    formData.append('profile_image', file);

    // Envía la imagen al backend utilizando Axios
    axios.post('/api/user', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
        // Maneja la respuesta del backend
        console.log('Imagen cargada exitosamente:', response.data.url);
        profile.profile_image = response.data.url; // Actualiza la URL de la imagen en el formulario
    })
    .catch(error => {
        console.error('Error al cargar la imagen:', error);
    });
}

    onMounted(() => {
        getProfile()
    })

    watchEffect(() => {
        profile.name = profileData.value.name
        profile.email = profileData.value.email
        profile.apellido = profileData.value.apellido
        profile.phone = profileData.value.phone
        profile.profile_image = profileData.value.profile_image
    })
</script>
