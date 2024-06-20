<template>
    <section class="container-fluid mt-5 pt-5 d-flex justify-content-center align-items-center sub-container">
        <div class="row d-flex justify-content-center align-items-center filaSubs">
            <h1 class="p-0 mb-3"><i class="pi pi-verified pe-3" style="font-size: 2rem"></i>{{ $t('subs_title_1') }} <span class="remarkable">{{ $t('subs_title_2') }}</span> {{ $t('subs_title_3') }}</h1>
            <h2 class="p-0">{{ $t('subs_subtitle') }}</h2>
            <!-- <div v-for="sub in subscriptions" :key="sub.id"  class="container col-xs-12 col-sm-6 col-md-4 col-lg-3 suscripcion p-3 m-2">
                <div class="medal" :class="{ 'bronze-medal': sub.id === 1, 'silver-medal': sub.id === 2, 'gold-medal': sub.id === 3 }" ></div>
                <div class="infoCampo precio">
                    <p>{{ sub.price }}€ <span>/month</span> </p>
                </div>
                <p>{{ sub.name }}</p>
                <hr>
                <p>{{ sub.resolution }}</p>
                <hr>
                <p>{{ sub.duration }}</p>
                <hr>
                <p>{{ sub.quality }}</p>
                <button :id="'subscription-button-' + sub.id" class="buyBtn" :class="{ 'greenBtn': hasActiveSubscription(sub.id) }" @click="comprarSuscripcion(sub.id)">
                    {{ hasActiveSubscription(sub.id) ? 'Activo' : 'Upgrade plan' }}
                </button>
            </div> -->

            <div class="subsBoxes d-flex justify-content-center align-items-center flex-wrap">
                <div v-for="sub in subscriptions" :key="sub.id"  class="container col-xs-12 col-sm-6 col-md-4 col-lg-3 suscripcion p-4 m-2">
                    <p class="subscriptionsName mb-2">{{ sub.name }}</p>
                    <p class="subscriptionsDescription">{{ sub.description }}</p>
                    <p class="mt-4 p-inv">Duración: {{ sub.duration }}</p>
                    <p class="p-inv">Resolución: {{ sub.resolution }}</p>
                    <p class="p-inv">Calidad: {{ sub.quality }}</p>
                    <div class="infoCampo precio">
                        <p>{{ sub.price }}€</p>
                    </div>
                    <button :id="'subscription-button-' + sub.id" class="buyBtn" :class="{ 'greenBtn': selectedSubscription && selectedSubscription == sub.id }" @click="selectSubscription(sub.id)">
                        {{ selectedSubscription === sub.id ? 'Activo' : 'Upgrade plan' }}
                    </button>
                </div>
            </div>

            <h1 class="p-0 mb-3 resp-txt">{{ $t('compare_plans_title_1') }} <span class="remarkable">{{ $t('compare_plans_title_2') }}</span> {{ $t('compare_plans_title_3') }} <span class="remarkable">{{ $t('compare_plans_title_4') }}</span> {{ $t('compare_plans_title_5') }}</h1>
            <h2 class="p-0 resp-txt">{{ $t('compare_plans_description') }}</h2>
            <div class="sub-table p-0">
                <DataTable :value="subscriptions" class="w-100">
                    <Column field="name" header="Nombre"></Column>
                    <Column field="price" header="Precio"></Column>
                    <Column field="duration" header="Duración"></Column>
                    <Column field="resolution" header="Resolución"></Column>
                    <Column field="quality" header="Calidad"></Column>
                </DataTable>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from "axios";
import { ref, inject, onMounted, watchEffect } from "vue";
import { watch } from "vue";
import { useRouter } from 'vue-router';
import {useForm, useField, defineRule} from "vee-validate";
import {required, min} from "@/validation/rules";
import { useStore } from 'vuex';
const selectedSubscription = ref(null);

const swal = inject('$swal');

const store = useStore();
const userId = 1;
// Define una referencia para almacenar las suscripciones del usuario
const subscriptions = ref([]);
const userSubscriptions = ref([]);

function selectSubscription(subscriptionId) {
    selectedSubscription.value = subscriptionId;
    localStorage.setItem('selectedSubscription', subscriptionId);
    comprarSuscripcion(subscriptionId);
}

/* Función para verificar si el usuario tiene una suscripción activa
const hasActiveSubscription = (subscriptionId) => {
    // Filtra las suscripciones del usuario para encontrar la que coincida con el subscriptionId
    return userSubscriptions.value.suscripcion_id === subscriptionId;
};*/

// Mostrar suscripciones 
onMounted(() => {
  axios.get('/api/suscripciones')
    .then(response => {
        subscriptions.value = response.data;
      console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching subscriptionss:', error);
    });

    verificarSuscripcionActiva();

    const storedSubscription = localStorage.getItem('selectedSubscription');
    if (storedSubscription) {
        selectedSubscription.value = storedSubscription;
    }
});

// Función para comprar suscripción
function comprarSuscripcion(subscriptionId) {
    let days = 30;
    if(subscriptionId === 2){
        days = 60
    }else if(subscriptionId === 3){
        days = 90
    }
    axios.post(`/api/subscriptions/${subscriptionId}`,{days: days})
        .then(response => {
            swal({
                icon: 'success',
                title: 'Suscripcion comprada correctamente'
            });
            cargarSuscripciones();
        })
        .catch(error => {
            console.error('Error al comprar suscripción:', error);
        });
}

// Función para recargar la lista de suscripciones después de la compra
function cargarSuscripciones() {
    axios.get('/api/suscripciones')
        .then(response => {
            subscriptions.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching subscriptions:', error);
        });
}

function verificarSuscripcionActiva() {
    axios.get(`/api/subscriptions/userSub-info/${userId}`)
        .then(response => {
            userSubscriptions.value = response.data;
            console.log('User Subscriptions:', userSubscriptions.value);
        })
        .catch(error => {
            console.error('Error fetching user subscriptions:', error);
        });
}

/*watch(userSubscriptions, () => {
  // Itera sobre las suscripciones del usuario y actualiza el estado de los botones
  subscriptions.value.forEach((sub) => {
    // Obtener el ID de la suscripción del usuario
    const subscriptionId = sub.suscripcion_id;
    const isActive = hasActiveSubscription(subscriptionId);
    const button = document.getElementById(`subscription-button-${subscriptionId}`);
    if (button) {
      button.textContent = isActive ? 'Activo' : 'Upgrade plan';
      button.classList.toggle('greenBtn', isActive);
    }
  });
});*/

</script>

<style scoped>
    .bronze-medal {
        background-color: #CD7F32;
        /* Agrega cualquier otro estilo que desees */
    }

    .silver-medal {
        background-color: #C0C0C0;
        /* Agrega cualquier otro estilo que desees */
    }

    .gold-medal {
        background-color: #DAA520;
        /* Agrega cualquier otro estilo que desees */
    }

    .greenBtn {
        background: #02AAB0;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #00CDAC, #02AAB0);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #00CDAC, #02AAB0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        color: black;
    }

    .pi{
        filter: none;
    }
</style>