<template>
  <div class="container-fluid homeFluidCont d-flex justify-content-center">
    <div class="container m-0 p-0 homeContainer d-flex justify-content-center align-items-center flex-column playlist-content">
      <h1 class="p-visible"><i class="pi pi-list pe-3" style="font-size: 2rem"></i>{{ $t('playlist_title_1') }} <span class="remarkable">{{ $t('playlist_title_2') }}</span> {{ $t('playlist_title_3') }}</h1>
      <div class="s-text w-100 d-flex justify-content-start">
        <h1 class="s-visible"><i class="pi pi-list pe-3" style="font-size: 2rem"></i>Playlist</h1>
      </div>
      <TabView>
          <!-- CREAR PLAYLIST -->
          <TabPanel header="Crea y comparte tú playlist">
              <div class="films-playlist-list">
                <div v-for="movie in allFilms" :key="movie.id" class="">
                  <div class="d-flex flex-row justify-content-between align-items-center pl-cont">
                    <div class="info-content d-flex">
                      <div class="img-playlist-info">
                        <img :src="movie?.media[0]?.original_url" alt="">
                      </div>
                      <div class="mov-inf d-flex flex-column justify-content-center align-items-start px-3">
                        <h2 class="m-0">{{ movie?.name }}</h2>
                        <h3 class="m-0">{{ movie?.synopsis }}</h3>
                      </div>
                    </div>
                    <div class="add-remove d-flex">
                      <button class="py-2 px-3 m-1" @click="addMovieToPlaylist(movie?.id, movie?.name, movie?.synopsis , movie?.media[0]?.original_url)" :class="{ 'add-button-active': isMovieInPlaylist(movie.id) }"><i class="pi pi-plus" style="font-size: 0.7rem"></i></button>
                      <button class="py-2 px-3 m-1" @click="removeMovieFromPlaylist(movie?.id)"><i class="pi pi-minus" style="font-size: 0.7rem"></i></button>
                    </div>
                  </div>
                  <hr class="my-5 hr-playlist">
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between inp-actions-playlist">
                <input v-model="playlistName" type="text" placeholder="Añade el nombre de tu playlist">
                <button @click="addPlaylist(newPlaylist)" class="btn-firebase m-0">Crear lista</button>
              </div>
          </TabPanel>
          <!-- MUNDO IWATCH -->
          <TabPanel header="Mundo iWatch">
            <div v-if="allData">
              <Panel v-for="(playlist, key) in allData" :key="key" :header="playlist.playlist_name" toggleable collapsed>
                <template #header>
                  <div class="panel-header d-flex justify-content-between align-items-center">
                      <span>{{ playlist.playlist_name }}</span>
                      <button @click="addMyPlaylist(playlist.movies, playlist.playlist_name)" class="icon-button">
                          <img src="images/heartIcon.svg" alt="Heart Icon" width="15" height="auto">
                      </button>
                  </div>
                </template>
                  <div v-if="playlist.movies && playlist.movies.length">
                      <div v-for="movieId in playlist.movies" :key="movieId">
                        <div class="info-content d-flex">
                          <div class="img-playlist-info">
                            <img :src="movieId.img" alt="">
                          </div>
                          <div class="mov-inf d-flex flex-column justify-content-center align-items-start px-3">
                            <h2 class="m-0">{{ movieId.nombre }}</h2>
                            <h3 class="m-0">{{ movieId.synopsis }}</h3>
                          </div>
                        </div>
                        <hr class="hr-playlist">
                      </div>
                  </div>
                  <div v-else>
                      <p>No hay películas en esta playlist.</p>
                  </div>
              </Panel>
            </div>
            <div v-else>
              <p class="text-center"><i class="pi pi-info-circle pe-2 pi-h1" style="font-size: 1rem"></i>Aún no hay ninguna playlist.</p>
            </div>
          </TabPanel>
          <!-- MIS PLAYLIST -->
          <TabPanel header="Mis playlists">
            <div v-if="filteredUserPlaylists.length">
              <Panel v-for="(playlist, key) in filteredUserPlaylists" :key="key" :header="playlist.playlist_name" toggleable collapsed>
                <template #header>
                  <div class="panel-header d-flex justify-content-between align-items-center">
                      <span>{{ playlist.playlist_name }}</span>
                      <!-- Botón con el icono SVG -->
                      <button @click="deletePlaylist(playlist)" class="icon-button">
                          <img src="images/delete.svg" alt="Delete Icon" width="20" height="auto" class="delete-img">
                      </button>
                  </div>
                </template>
                  <div v-if="playlist.movies && playlist.movies.length">
                    <div v-for="movieId in playlist.movies" :key="movieId">
                          <div class="info-content d-flex">
                            <div class="img-playlist-info">
                              <img :src="movieId.img" alt="">
                            </div>
                            <div class="mov-inf d-flex flex-column justify-content-center align-items-start px-3">
                              <h2 class="m-0">{{ movieId.nombre }}</h2>
                              <h3 class="m-0">{{ movieId.synopsis }}</h3>
                            </div>
                          </div>
                          <hr class="hr-playlist">
                    </div>
                  </div>
                  <div v-else>
                      <p>No hay películas en esta playlist.</p>
                  </div>
              </Panel>
            </div>
            <div v-else>
              <p class="text-center"><i class="pi pi-info-circle pe-2 pi-h1" style="font-size: 1rem"></i>No tienes ninguna playlist guardada.</p>
            </div>
          </TabPanel>
      </TabView>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, inject } from "vue";
import { datab } from "@/composables/firebase";
import { ref as reff, set, remove, onValue } from "firebase/database";
import { computed } from "vue";

import { useStore } from 'vuex';

const swal = inject('$swal');

const store = useStore();
const user = computed(() => store.state.auth.user)

const allFilms = ref([]);
const newPlaylist = ref([]);
const playlistName = ref('');
const allData = ref([]);
const filmFromPlayList = ref([]);

const isMovieInPlaylist = (movieId) => {
  return newPlaylist.value.some(item => item.id === movieId);
};

// Leer datos de la bbdd
const listener = reff(datab, 'playlists/')
onValue(listener, (snapshot) => {
  const data = snapshot.val();
  allData.value = data;
  // console.log('FIREBASE dataaa:', allData);   
});

const userPlaylists = ref([]);

const listener2 = reff(datab, 'mis-playlists/')
onValue(listener2, (snapshot) => {
  const data = snapshot.val();
  userPlaylists.value = data ? Object.values(data) : [];
})

const filteredUserPlaylists = computed(() => {
  return userPlaylists.value.filter(playlist => playlist.user_id === user.value.id);
});

// Crear nueva playlist
const addPlaylist = (array) => {
  if(array.length > 0){
    console.log("LARGO BIEN");
    const newPlaylist = {
      playlist_name: playlistName.value,
      movies: array,
      user_id: 1,
    };
    set(reff(datab, `playlists/${newPlaylist.playlist_name}`),  newPlaylist);
    swal({
      allowOutsideClick: true,
      timer: 2000,
      timerProgressBar: true,
      customClass: {
        timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
      },
      position: "top-end",
      icon: 'success',
      title: 'Playlist creada!',
      showConfirmButton: false
    });
  }else{
    swal({
      allowOutsideClick: true,
      timer: 2000,
      timerProgressBar: true,
      customClass: {
        timerProgressBar: 'error-progress-bar' // Clase personalizada para el temporizador de progreso
      },
      position: "top-end",
      icon: 'error',
      title: 'Añade la información necesaria!',
      showConfirmButton: false
    });
  }
};

//Funcion para crear mi playlist utilizando el set
const addMyPlaylist = (array, playlistName) => {
  if(array.length > 0){
    console.log("LARGO BIEN");
    const newPlaylist = {
      playlist_name: playlistName,
      movies: array,
      user_id: user.value.id,
    };
    set(reff(datab, `mis-playlists/${newPlaylist.playlist_name}`),  newPlaylist);
    swal({
      allowOutsideClick: true,
      timer: 2000,
      timerProgressBar: true,
      customClass: {
        timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
      },
      position: "top-end",
      icon: 'success',
      title: 'Playlist añadida a favoritos!',
      showConfirmButton: false
    });
  }else{
    swal({
      allowOutsideClick: true,
      timer: 2000,
      timerProgressBar: true,
      customClass: {
        timerProgressBar: 'error-progress-bar' // Clase personalizada para el temporizador de progreso
      },
      position: "top-end",
      icon: 'error',
      title: 'No se ha podido añadir',
      showConfirmButton: false
    });
  }
};

//Funcion para eliminar la playlist
const deletePlaylist = (playlist) => {
  const playlistRef = reff(datab, `mis-playlists/${playlist.playlist_name}`);
  remove(playlistRef)
    .then(() => {
      // console.log(`Playlist "${playlist.playlist_name}" eliminada correctamente.`);
      swal({
        allowOutsideClick: true,
        timer: 2000,
        timerProgressBar: true,
        customClass: {
          timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
        },
        position: "top-end",
        icon: 'success',
        title: 'Playlist eliminada de Mis playlist!',
        showConfirmButton: false
      });
    })
    .catch((error) => {
      console.error(`Error al eliminar la playlist "${playlist.playlist_name}":`, error);
      swal({
        allowOutsideClick: true,
        timer: 2000,
        timerProgressBar: true,
        customClass: {
          timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
        },
        position: "top-end",
        icon: 'error',
        title: 'Error!',
        showConfirmButton: false
      });
    });
};

const getFilmInfo = (cont_id) => {
  axios.get(`/api/filmsPlayer/${cont_id}`)
    .then(response => {
      filmFromPlayList.value = response.data;
      // console.log(allFilms.value);
    })
    .catch(error => {
      console.error('Error fetching filmFromPlayList:', error);
    });
}

onMounted( () => {
  // Obtener todas las pelis de la bbdd mysql
  axios.get('/api/films')
    .then(response => {
      allFilms.value = response.data;
      // console.log(allFilms.value);
    })
    .catch(error => {
      console.error('Error fetching allFilms:', error);
    });
});

// Comprobar si existe la movie en el array de pelis añadidas
function addMovieToPlaylist(movie_id, movie_name, movie_synopsis , movie_img){
  // console.log(movie_id);
  const existingMovie = newPlaylist.value.findIndex(movie => movie.id === movie_id);

  if (existingMovie === -1) {
    newPlaylist.value.push({ id: movie_id, nombre: movie_name, synopsis: movie_synopsis, img: movie_img });
    console.log("Añadido a la lista de reproducción:", { id: movie_id, nombre: movie_name });
  } else {
    console.log("La película ya está en la lista de reproducción:", movie_id, movie_name);
  }
}

// ELiminar pelicula del array al crear la playlist
function removeMovieFromPlaylist(movie_id) {
  const index = newPlaylist.value.findIndex(movie => movie.id === movie_id);
  if (index !== -1) {
    newPlaylist.value.splice(index, 1);
    console.log("Película eliminada de la lista de reproducción:", movie_id);
  } else {
    console.log("La película no se encuentra en la lista de reproducción:", movie_id);
  }
}


</script>

<style>
  .btn-firebase{
      margin-top: 80px;
  }

  .delete-img{
    filter: invert(1);
  }

</style>