<template>
  <div>
    <div v-if="isLoading" class="loading-icon">
      <!--<i class="fas fa-spinner fa-spin"></i> Cargando...-->
      <svg class="loading" width="100%" height="100%" viewBox="0 0 773 778" fill="none" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0_83_15" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="773" height="826">
        <path d="M773 0H0V826H773V0Z" fill="white"/>
        </mask>
        <g mask="url(#mask0_83_15)">
        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M386.5 72.5009C303.214 72.5009 223.339 105.601 164.446 164.519C105.554 223.438 72.4688 303.348 72.4688 386.671C72.4688 469.994 105.554 549.905 164.446 608.824C223.339 667.742 303.214 700.842 386.5 700.842C469.786 700.842 549.661 667.742 608.554 608.824C667.446 549.905 700.531 469.994 700.531 386.671C700.531 303.348 667.446 223.438 608.554 164.519C549.661 105.601 469.786 72.5009 386.5 72.5009ZM0 386.671C0 284.119 40.7204 185.768 113.203 113.253C185.686 40.7384 283.993 0 386.5 0C489.007 0 587.314 40.7384 659.797 113.253C732.279 185.768 773 284.119 773 386.671C773 489.223 732.279 587.574 659.797 660.089C587.314 732.604 489.007 773.343 386.5 773.343C283.993 773.343 185.686 732.604 113.203 660.089C40.7204 587.574 0 489.223 0 386.671Z" fill="url(#paint0_linear_83_15)"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M350.266 36.2504C350.266 26.6362 354.083 17.4158 360.878 10.6175C367.674 3.81923 376.89 0 386.5 0C489.007 0 587.314 40.7384 659.797 113.253C732.279 185.768 773 284.119 773 386.671C773 396.286 769.182 405.506 762.387 412.304C755.592 419.102 746.376 422.922 736.766 422.922C727.155 422.922 717.939 419.102 711.145 412.304C704.349 405.506 700.531 396.286 700.531 386.671C700.531 303.348 667.446 223.438 608.554 164.519C549.661 105.601 469.786 72.5009 386.5 72.5009C376.89 72.5009 367.674 68.6816 360.878 61.8834C354.083 55.0851 350.266 45.8646 350.266 36.2504Z" fill="white"/>
        </g>
        <defs>
        <linearGradient id="paint0_linear_83_15" x1="386.5" y1="0" x2="386.5" y2="773.343" gradientUnits="userSpaceOnUse">
        <stop stop-color="white"/>
        <stop offset="1" stop-color="#666666"/>
        </linearGradient>
        </defs>
      </svg>
    </div>
    <div v-else>
      <div v-if="film">
        <div v-if="film.media && film.media.length > 0">
          <!-- Elemento de video con ref -->
          <div class="video-container">
            <!-- <h1>USER_ID: {{ store.state.auth.user.id }}</h1>
            <h1>FILM_ID: {{ film.id }}</h1> -->
            <video ref="videoPlayer" @pause="onPause" controls autoplay @play="registerViewedContent(store.state.auth.user.id, film.id)">
              <source :src="film.media[2].original_url" type="video/mp4">
            </video>
            <router-link :to="{ name: 'Home'}" class="btn-volver">
              <div class="icon-text-container">
                <img src="/images/registerArrow.svg" width="15" height="auto" alt="Volver a la home">
                <h1>{{ film.name }}</h1>
              </div>
            </router-link>
           <!--<router-link to="/Home" class="btn btn-primary btn-volver">Volver</router-link>-->
          </div>
        </div>
        <div v-else>
          <p>No se encontró ningún video para esta película.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

import { useStore } from 'vuex';
import { computed } from "vue";
import 'primeicons/primeicons.css';


const store = useStore();
const user = computed(() => store.state.auth.user)

const route = useRoute();
const film = ref(null);
const isLoading = ref(false);
const isPlaying = ref(false);
const isMuted = ref(false);
const videoPlayer = ref(null); // Ref para el elemento de video

const storedViewedFilm = ref([]);

// const togglePlayback = () => {
//   if (isPlaying.value) {
//     videoPlayer.value.pause();
//   } else {
//     videoPlayer.value.play();
//   }
//   isPlaying.value = !isPlaying.value;
// };

// const onPlay = () => {
//   isPlaying.value = true;
// };

// const onPause = () => {
//   isPlaying.value = false;
// };

// const toggleFullScreen = () => {
//   if (videoPlayer.value.requestFullscreen) {
//     videoPlayer.value.requestFullscreen();
//   } else if (videoPlayer.value.mozRequestFullScreen) { /* Firefox */
//     videoPlayer.value.mozRequestFullScreen();
//   } else if (videoPlayer.value.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
//     videoPlayer.value.webkitRequestFullscreen();
//   } else if (videoPlayer.value.msRequestFullscreen) { /* IE/Edge */
//     videoPlayer.value.msRequestFullscreen();
//   }
// };

// const toggleMute = () => {
//   videoPlayer.value.muted = !videoPlayer.value.muted;
//   isMuted.value = videoPlayer.value.muted;
// };
//Obtener pelicula usando la id pasada por parametro 
const loadFilmData = async () => {
  try {
    isLoading.value = true;
    const response = await axios.get('/api/filmsPlayer/' + route.params.id);
    film.value = response.data;
    console.log(response.data);

  } catch (error) {
    console.error('Error fetching film data:', error);
  } finally {
    isLoading.value = false;
  }
};

  const registerViewedContent = (user_id, film_id) => {
    console.log('/store/' + user_id + '/' + film_id)
    axios.post('/api/store/' + user_id + '/' + film_id)
     .then(response => {
    //  storedViewedFilm.value = response.data;
    //    console.log("STORED VIEWED FILM: "+response.data);
    console.log("PELICULA VISTA");
     })
     .catch(error => {
       console.error('Error fetching storedViewedFilm:', error);
     });
  }

onMounted(() => {
  loadFilmData();
});
</script>

<style scoped>

  /*video{
    height: 605px;
    margin-left: 250px;
  }*/

.video-container {
  width: 100%; /* Establece el ancho del contenedor al 100% del contenedor padre */
  height: 100vh; /* Establece el ancho máximo del contenedor */
  margin: 0 auto; /* Centra el contenedor horizontalmente */
  overflow: hidden; /* Oculta cualquier parte del video que se desborde del contenedor */
}

.video-container video {
  width: 100%;
    /* height: auto; */
  display: block;
  height: 100%;
  object-fit: cover;
}

/* Estilo del boton para volver a la home*/
  .btn-volver{
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 1000; 
    width: auto !important; 
    height: auto; 
  }

  /*.btn-volver:hover{
    background-color: #0056b3;
  }*/

  .icon-text-container {
    display: flex;
    align-items: center;
  }

  .icon-text-container img {
    margin-right: 10px; 
  }

  .icon-text-container h1{
    margin: 21px 0 !important;
  }
</style>
