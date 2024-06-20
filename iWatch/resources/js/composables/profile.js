import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import store from "../store";

export default function useProfile() {
    const profile = ref({
        name: '',
        email: '',
    })

    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getProfile = async () => {
        profile.value = store.getters["auth/user"]
        // axios.get('/api/user')
        //     .then(({data}) => {
        //         profile.value = data.data;
        //     })
    }

    /*function updateProfile(profile) {
        if (isLoading.value) return;
    
        isLoading.value = true;
        validationErrors.value = {};
    
        const formData = new FormData();
        // Agregar los campos del perfil al formData
        formData.append('name', profile.name);
        formData.append('email', profile.email);
        formData.append('apellido', profile.apellido);
        formData.append('phone', profile.phone);
        // Agregar la imagen de perfil al formData
        formData.append('profile_image', profile.profile_image);
        axios.put('/api/user', formData, {
            headers: {
                'Content-Type': 'multipart/form-data' // Importante establecer este encabezado para enviar archivos
            }
        })
        .then(response => {
            if (response.data.success) {
                swal({
                    icon: 'success',
                    title: 'Perfil actualizado exitosamente'
                });
            }
        })
        .catch(error => {
            if (error.response) {
                // Se produjo un error en la respuesta de la API
                console.error('Error de respuesta de la API:', error.response.data);
            } else if (error.request) {
                // La solicitud fue realizada pero no se recibió respuesta
                console.error('No se recibió respuesta de la API:', error.request);
            } else {
                // Se produjo un error al configurar la solicitud
                console.error('Error al configurar la solicitud:', error.message);
            }
            validationErrors.value = error.message; // Puedes mostrar este mensaje de error en tu interfaz de usuario si es necesario
        })
        .finally(() => isLoading.value = false);
    }*/

    function updateProfile(profile) {
        isLoading.value = true;
        validationErrors.value = {};
    
        // Crear un objeto con los datos del perfil a enviar a la API
        const profileData = {
            name: profile.name,
            email: profile.email,
            apellido: profile.apellido,
            phone: profile.phone,
        };
    
        axios.put('/api/user', profileData)
            .then(response => {
                swal({
                    icon: 'success',
                    title: 'Perfil actualizado!'
                });
                console.log("ACTUALIZADO");
            })
            .catch(error => {
                swal({
                    icon: 'error',
                    title: 'Error, vuelve a intentarlo!'
                });
                if (error.response) {
                    // Se produjo un error en la respuesta de la API
                    console.error('Error de respuesta de la API:', error.response.data);
                } else if (error.request) {
                    // La solicitud fue realizada pero no se recibió respuesta
                    console.error('No se recibió respuesta de la API:', error.request);
                } else {
                    // Se produjo un error al configurar la solicitud
                    console.error('Error al configurar la solicitud:', error.message);
                }
                validationErrors.value = error.message; // Puedes mostrar este mensaje de error en tu interfaz de usuario si es necesario
            })
            .finally(() => isLoading.value = false);
    }
    
    
    
    return {
        profile,
        getProfile,
        updateProfile,
        validationErrors,
        isLoading
    }
}
