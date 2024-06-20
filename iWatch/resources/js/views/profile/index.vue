<template>
    <div class="card border-0 bg-primary mainBox">
        <div class="card-body">
            <form @submit.prevent="submitForm" class="d-flex justify-content-center align-items-center">
                <div class="group">
                    <h1 class="title-profile"><i class="pi pi-user pe-3" style="font-size: 2rem"></i>{{ $t('my_profile') }}</h1>
                    <div class="all d-flex justify-content-between align-items-start">
                        <div class="mb-3 profileImageEdit px-2 d-flex flex-column align-items-start">
                            <!-- BOTON MODAL IMAGENES DE PERFIL -->
                            <img :src="imageProfile" alt="Imagen de perfil">
                            <button type="button" class="edit-prodileImg-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="pi pi-pencil"></i>
                            </button>
                        </div>
                        <div class="mb-3 px-2">
                            <div class="mb-3 users d-flex">
                                <div class="me-3">
                                    <input type="text" v-model="profile.name" class="form-control reqInfo" id="name" placeholder="Nombre">
                                    <div class="text-danger">
                                        {{ errors.name }}
                                    </div>
                                    <div class="text-danger">
                                        <div v-for="message in validationErrors?.name">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="text" v-model="profile.apellido" class="form-control reqInfo" id="apellido" placeholder="Apellido">
                                    <div class="text-danger">
                                        {{ errors.apellido }}
                                    </div>
                                    <div class="text-danger">
                                        <div v-for="message in validationErrors?.apellido">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" v-model="profile.phone" class="form-control reqInfo" id="phone" placeholder="Teléfono">
                                <div class="text-danger">
                                    {{ errors.phone }}
                                </div>
                                <div class="text-danger">
                                    <div v-for="message in validationErrors?.phone">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="email" v-model="profile.email" class="form-control reqInfo" id="email" placeholder="Correo electrónico">
                                <div class="text-danger">
                                    {{ errors.email }}
                                </div>
                                <div class="text-danger">
                                    <div v-for="message in validationErrors?.email">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                            <div class="profile-btns">
                                <button :disabled="isLoading" class="accion mb-3 createAccountAction">
                                    <div v-show="isLoading" class=""></div>
                                    <span v-if="isLoading">Procesando...</span>
                                    <span v-else>{{ $t('save_password') }}</span>
                                </button>
                                <button @click="deleteAccount" class="accion deleteAccountAction reqInfo">
                                    <span>{{ $t('delete_account') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- MODAL IMAGENES DE PERFIL -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content gallery-cont">
            <p class="modal-title m-2 ml-0 text-center">Selecciona tu foto de perfil:</p>
            <div class="modal-body d-flex align-items-center flex-wrap user-profile-img">
                <div class="gallery d-flex flex-wrap justify-content-between">
                    <button v-for="(image, index) in imageUrls" :key="image" @click="handleImageClick(image)" class="btn-gallery d-flex flex-column align-items-center mb-3" data-bs-dismiss="modal">
                        <img :src="image" class="gallery-image mb-2" :style="{ border: image === selectedImageUrl ? '2px solid white' : 'none' }" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>
import { onMounted, reactive, watchEffect, ref, computed, inject } from "vue";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "@/validation/rules"
import useProfile from "@/composables/profile";
import 'primeicons/primeicons.css';
const strError = ref();
const strSuccess = ref();
const imageProfile = ref();
const selectedImageUrl = ref(null);
import { useStore } from 'vuex';
const swal = inject('$swal');
const store = useStore();
const user = computed(() => store.state.auth.user);

const imageUrls = ref([
    '/images/rojo.svg',
    '/images/amarillo.svg',
    '/images/verde.svg',
    '/images/azul.svg',
    '/images/naranja.svg',
    '/images/morado.svg',
]);

// const profImageNames = ref([
   // 'Rojo',
   // 'Amarillo',
   // 'Verde',
   // 'Azul',
   // 'Naranja',
   // 'Morado',
// ]);

const handleImageClick = (imageUrl) => {
    // Llamada a la API para poder actualizar la imagen en el campo profile_image de la bbdd
    console.log('Imagen seleccionada:', imageUrl);

    //Utilizacion de localStorage para guardar la imagen seleccionada
    selectedImageUrl.value = imageUrl;
    localStorage.setItem(`selectedImageUrl_${user.value.id}`, imageUrl);

    axios.put('/api/user-image', { profile_image_url: imageUrl })
        .then(response => {
            console.log('URL de la imagen de perfil actualizada correctamente:', response.data);
        })
        .catch(error => {
            console.error('Error al actualizar la imagen de perfil:', error);
        });
}



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
    const { profile: profileData, getProfile, updateProfile, validationErrors, isLoading } = useProfile()
    const profile = reactive({
        name,
        email,
        apellido,
        phone,
    })
    function submitForm() {
        validate().then(form => { if (form.valid) updateProfile(profile) })
    }

    /*function updateProfile() {
    validate().then((success) => {
        if (success) {
            const formData = new FormData();
            formData.append('name', profile.value.name);
            formData.append('email', profile.value.email);
            formData.append('apellido', profile.value.apellido);
            formData.append('phone', profile.value.phone);
            formData.append('profile_image', profile.value.profile_image);

            axios.put('/api/user', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then(response => {
                console.log(response);
                strSuccess.value = response.data.success;
                strError.value = "";
            }).catch(error => {
                console.log(error);
                strSuccess.value = "";
                strError.value = error.response.data.message;
            });
        }
    });
}*/
    

    function onFileChange(event) {
        const file = event.target.files[0]; // Obtener el archivo seleccionado
        const formData = new FormData();
        formData.append('profile_image', file);

        // Envía la imagen al backend utilizando Axios
        axios.put('/api/user', formData, {
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

const deleteAccount = () => {
    const userId = user.value.id;


    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará tu cuenta permanentemente.',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma la eliminación, enviar la solicitud DELETE al servidor
            axios.delete(`/api/delete-user/${userId}`)
                .then(response => {
                    swal.fire({
                        icon: 'success',
                        title: 'Usuario eliminado',
                        showConfirmButton: false,
                        timer: 2000
                    });
                })
                .catch(error => {
                    swal.fire({
                        icon: 'error',
                        title: 'Error al eliminar el usuario'
                    });
                });
        }
    });
} 

    onMounted(() => {
        getProfile()

        axios.get('/api/user-data')
        .then(response => {
            imageProfile.value = response.data.user.profile_image;
        })
        .catch(error => {
            // Manejar el error en caso de que ocurra
            console.error('Error al obtener los datos del usuario:', error);
        });

        //Obtener imagen seleccionada para poder insertarle el borde
        const storedImageUrl = localStorage.getItem(`selectedImageUrl_${user.value.id}`);
        if (storedImageUrl) {
            selectedImageUrl.value = storedImageUrl; 
        }
    })

    watchEffect(() => {
        profile.name = profileData.value.name
        profile.email = profileData.value.email
        profile.apellido = profileData.value.apellido
        profile.phone = profileData.value.phone
    })

    const menu = ref();
    const items = ref([
  {
    label: 'Options',
    items: [
      {
        label: 'Img 1',
        template: `
        <img src="/images/Netflix-avatar.png" alt="Imagen 1" width="24" height="24" class="p-mr-2">
        `,
        command: () => console.log('Hacer algo con la imagen 1')
      },
      {
        label: 'Img 2',
        template: `
        <img src="/images/Netflix-avatar.png" alt="Imagen 1" width="24" height="24" class="p-mr-2">
        `,
        command: () => console.log('Hacer algo con la imagen 2')
      }
    ]
  }
]);

const toggle = (event) => {
    menu.value.toggle(event);
};
</script>

<style scoped>
/*.gallery {
  display: flex;
  flex-wrap: wrap;
  margin-left: 50px;
}*/

.gallery-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin: 5px;
}

.btn-gallery{
    background: transparent;
    border: none;
    flex-basis: calc(33.33% - 10px);
    margin-bottom: 20px;
    text-align: center;
}

.gallery-img[selected] {
    border: 2px solid white;
}

</style>