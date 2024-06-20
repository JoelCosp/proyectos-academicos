<template>
    <!-- BUSCADOR Y DROPDOWN DE FAVORITOS -->
    <div class="filter-search-pack d-flex">
      <input v-model="content_name" type="text" class="inline-block film-finder" placeholder="Introduce el título...">
      <Dropdown v-model="selectedFilter" @change="handleCategoryChange" :options="filters" option-label="label" option-value="value" placeholder="Categoría" class="w-full md:w-14rem no-border-dropdown" />
    </div>
    <!-- CONTENEDOR FAVORITOS -->
    <div class="container-fluid d-flex justify-content-center search-content-view">
      <div class="container m-0 p-0 homeContainer">
        <h1 class="px-2">{{ $t('my_list_view') }}</h1>
        <div class="container-fluid">
          <div v-if="films.length" class="row rowFilms d-flex justify-content-center align-items-center">
            <div v-for="(film, index) in films" :key="film.id" class="film-card p-0">
              <div>
                  <img @click="info(film)" class="image-item img-search-view" data-bs-toggle="modal" data-bs-target="#staticBackdrop" :src="film.media && film.media.length > 0 ? film.media[0].original_url : '/images/placeholder.jpg'" :alt="film.name">
              </div>
            </div>
          </div>
          <div v-else>
            <p class="text-center d-flex justify-content-center align-items-center no-favs"><i class="pi pi-info-circle pe-2 pi-h1" style="font-size: 3rem"></i>Aún no tienes favoritos!</p>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL DE FAVORITOS -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body p-0">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal"><i class="pi pi-times" style="color: white"></i></button>
            <div class="videoCont">
              <video :key="film?.media[2]?.original_url" id="my-video" class="my-video vjs-default-skin w-100" data-setup="{}" autoplay muted loop>
                <source  :src="film?.media[2]?.original_url" type="video/mp4" />
              </video>
            </div>
            <div class="pt-4 px-4 pb-4">
              <div class="info">
                <div class="firstBlock d-flex justify-content-between">
                  <h2>{{ film.name }}</h2>
                  <p class="m-0 text-right">{{ film.duration }}h</p>
                </div>
                <div class="firstRating w-100 d-flex justify-content-between align-items-center">
                  <p class="m-0">{{ film.director }}</p>
                  <Rating id="" v-model="filmPunct" readonly :cancel="false" :min="1" :max="5" />
                </div>
                <div class="d-flex justify-content-between align-items-start synopsis-paragraph">
                  <p>{{ film.synopsis }}</p>
                </div>
              </div>
              <hr class="mb-4 mt-4">
              <div class="buttons d-flex justify-content-between mb-4">
                <router-link v-if="checkSubscription(InfoSubsFilm) /*&& info_subscription_level.value.user_id === InfoSubsFilm.value.suscripcion_id*/" :to="{ name: 'player-films', params: { id: film.id } }" class="watch d-flex justify-content-center align-items-center">
                    <img class="dark-btn-img" src="/images/playReproductorWhite.svg" alt="">
                    Reproducir
                </router-link>
                <router-link v-else :to="{ name: 'subscriptions'}" class="watch d-flex justify-content-center align-items-center">
                  <img class="dark-btn-img" src="images\upgradePlan.svg" alt="">
                  Mejora tú plan
                </router-link>
                <button @click="sendFavorites(film.id)" class="favourite">
                  <img v-if="verifyFavorite(film.id)" class="favoriteIcon" src="images\crossSave.svg" alt="">
                  <img v-else class="favoriteIcon" src="images\plusSave.svg" alt="">
                </button>
              </div>
              <div v-if="film && film.type === 'serie'" class="serie-content">
                  <TabView :scrollable="true" :activeIndex="active" @update:activeIndex="active = $event">
                      <TabPanel v-for="(season, index) in filteredSeasons" :key="index" :header="season.label">
                        <div class="episodes-list">
                            <div class="episode d-flex justify-content-between mb-3" v-for="episode in getEpisodesBySeason(season.id)" :key="episode.id">
                              <div class="d-flex">
                                <div class="episode-miniature">
                                  <img :src="getMediaImageUrl(episode)" alt="">
                                </div>
                                <div class="episode-primary-info">
                                  <p id="episode_name">{{episode.episode_name}}</p>
                                  <p id="description">{{episode.description}}</p>
                                </div>
                              </div>
                              <div class="episode-secondary-info d-flex flex-column">
                                <p id="duration">{{episode.duration}} h</p>
                                <router-link :to="{ name: 'player-films', params: { id: film.id } }" class="btnPlayEpisode d-flex justify-content-center align-items-center">
                                    <img src="images\playReproductorWhite.svg" alt="">
                               </router-link>
                              </div>
                            </div>
                        </div>
                      </TabPanel>
                  </TabView>
              </div> 
              <!-- PANEL DE RESEÑAS -->
              <Panel header="Reseñas" toggleable collapsed>
                <form @submit.prevent="submitReview">
                <div class="form-group d-flex flex-column m-0">
                  <div class="selectRate d-flex align-items-center">
                    <p class="m-0 p-0">Puntuación: </p>
                    <div class="px-2">
                      <Rating class="reviews" id="review-stars-count" v-model="review.punctuation" :cancel="false" :min="1" :max="5" />
                    </div>
                  </div>
                  <div class="review-send d-flex justify-content-between">
                    <input id="review" v-model="review.description" class="form-control send-review" placeholder="Deja tú opinión"></input>
                    <button type="submit" class="btn btn-submit-review d-flex justify-content-center align-items-center"><img class="sendReviewIcon" src="/images/sendArrow.svg" alt=""></button>
                    <router-link v-if="film.id" :to="{ name: 'all.reviews', params: { id: film.id } }">
                      <button class="btn btn-primary btn-review btn-show-review"><img class="showReviewsIcon" src="/images/showReviews.svg" alt=""></button>
                  </router-link>
                  </div>
                  <input type="hidden" v-model="review.content_id" />
                </div>
                <div class="review-actions d-flex justify-content-between">
                </div>
              </form>
              </Panel>
          </div>
        </div>
      </div>
      </div>
    </div>
    <!-- LOADING SPINNER -->
    <div v-if="isLoading" class="loading-icon">
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
  </template>
  
  <script setup>
  import axios from "axios";
  import { ref, onMounted, watch, inject } from 'vue';
  import usePermissions from "@/composables/reviews";
  import {useAbility} from '@casl/vue';
  import { useRoute } from 'vue-router';
  import { useRouter } from 'vue-router';
  import useCategories from "@/composables/categories";
  import { useStore } from 'vuex';
  import { computed } from "vue";
  
  const isLoading = ref(true);
  const films = ref([]);
  const filters = ref([
    { label: 'Mostar todo', value: '0' },
    { label: 'Acción', value: '1' },
    { label: 'Aventura', value: '2' },
    { label: 'Comedia', value: '3' },
    { label: 'Drama', value: '4' },
    { label: 'Ciencia ficción', value: '5' },
    { label: 'Terror', value: '6' },
    { label: 'Thriller', value: '7' },
    { label: 'Romance', value: '8' },
    { label: 'Animación', value: '9' },
    { label: 'Documental', value: '10' },
    { label: 'Misterio', value: '11' }
  ]);
  
  const selectedFilter = ref('0');

  const content_name = ref('')
  const {permissions, getPermissions, deletePermission, getReviewsByContentId, getReviewsByContentName} = usePermissions()
  const {can} = useAbility()
  
  const fetchFilmsByCategory = (categoryId) => {
    isLoading.value = true;
    axios.get('/api/favorites/category/' + categoryId + `/` + store.state.auth.user.id)
      .then(response => {
        films.value = response.data;
        isLoading.value = false;
        console.log(response.data);
      })
      .catch(error => {
        console.error('Error fetching films:', error);
      });
  };
  
  const handleCategoryChange = () => {
    fetchFilmsByCategory(selectedFilter.value);
  };

  const getContentsByContentName = async (name) => {
        isLoading.value = true;
        axios.get(`/api/favorites/${name}`)
            .then(response => {
                films.value = response.data;
                isLoading.value = false;
            })
    }

  watch(content_name, (current, previous) => {
    console.log('Current value of content_name:', current);
    console.log('Previous value of content_name:', previous);

    if (current) {
        getContentsByContentName(current); // Si se usa el search, se filtran las pelis por el nombre 
    } else {
        fetchFilmsByCategory(selectedFilter.value);
    }
})

const route = useRouter();

const film = ref({media:[]});
const swal = inject('$swal');
const infoModal = ref(null);
const { categoryList, getCategoryList } = useCategories();
const store = useStore();
const user = computed(() => store.state.auth.user)
const filmPunct = ref([]);

const favorites = ref([]);
const favoritesByUserId = ref([]);

const selectedFilm = ref(null); 
const seasonOptions = ref([]); 

const seasons = ref([]);
const filteredSeasons = ref([]);
const filteredContent = ref([]);
const active = ref(0);
const episodesBySeason = ref([]);
const episodes = ref([]);
const review = ref({});
const reviews = ref([]);
const InfoSubsFilm = ref([]);

// Info del user en la tabla user_subscription
const info_subscription_level = ([]);

onMounted(() => {

  selectedFilter.value = '0'; // Establecer el valor predeterminado del filtro
    fetchFilmsByCategory(selectedFilter.value);
  // Obtener solo favoritos
   axios.get(`/api/favorites-only/${store.state.auth.user.id}`)
     .then(response => {
     isLoading.value = false;
       films.value = response.data;
      //  console.log(response.data);
     })
     .catch(error => {
       isLoading.value = false;
       console.error('Error fetching films:', error);
     });

     axios.get('/api/cats')
     .then(response => {
     isLoading.value = false;
     categoryList.value = response.data;
      //console.log('CATEGORY LIST:', categoryList);
      //  console.log(response.data);
     })
     .catch(error => {
       isLoading.value = false;
       console.error('Error fetching filteredContent:', error);
     });

    axios.get('/api/favoriteFilms')
    .then(response => {
      favorites.value = response.data.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching favorites:', error);
    });

    axios.get(`/api/favoritesByUser/${store.state.auth.user.id}`)
    .then(response => {
      favoritesByUserId.value = response.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching favorites by user:', error);
    });

  getAllSeasons();
  getInfoUserSub();
  getEpisodes();
  getEpsBySeasonId();
  getReviews();
});



// Obtener info suscripcion de la peli seleccionada
const getSubscriptionsFilms = (filmId) => {
  axios.get(`/api/suscripcionsFilms/${filmId}`)
    .then(response => {
      InfoSubsFilm.value = response.data;
      console.log('SUSCRIPCIONES FILMS INFO:', InfoSubsFilm.value);
    })
    .catch(error => {
      console.error('Error fetching reviews:', error);
    });
}

const checkSubscription = (infoSubMovie) => {
    if (!infoSubMovie || !infoSubMovie.length) {
        return false; 
    }

    const userSubscriptionId = info_subscription_level.value?.suscripcion_id; 

    // Verificar si alguno de los suscripcion_id coincide con el del usuario
    return infoSubMovie.some(subs => subs.suscripcion_id === userSubscriptionId);
}


// Obtener info de la suscripcion que ha comprado el usuario que ha iniciadio sesion
const getInfoUserSub = () => {
  axios.get(`/api/subscriptions/userSub-info/${store.state.auth.user.id}`)
    .then(response => {
      info_subscription_level.value = response.data;
      console.log("INFO suscripcion comprada por el USER: "+info_subscription_level.value.suscripcion_id);
    })
    .catch(error => {
      console.error('Error fetching seasons:', error);
    });
}

const getPunctuation = (film_id) => {
  axios.get(`/api/film-punctuation/${film_id}`)
    .then(response => {
      filmPunct.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching filmPunct:', error);
    });
}

const info = (selectedFilm) => {
  film.value = selectedFilm;
  getSubscriptionsFilms(film.value.id)
  getPunctuation(film.value.id)
  // Filtrar temporadas según el content_id de la película seleccionada
  if (selectedFilm && selectedFilm.type === 'serie') {
    // Limpiar el array antes de agregar nuevas temporadas
    filteredSeasons.value = [];
    seasons.value.forEach(season => {
      if (season.content_id === selectedFilm.id) {
        filteredSeasons.value.push({ 
          id: season.season_id,
          label: season.season_name });
      }
    });
    filteredContent.value = films.value.filter(film => film.categoria_id === selectedFilm.categoria_id);
    // Establecer la temporada activa en la primera temporada
    active.value = 0;
    // Imprimir los valores de filteredSeasons en la consola
    //console.log('Filtered Seasons:', filteredSeasons.value);
  }
}


const getEpisodesBySeason = (seasonId) => {
    return episodes.value.filter(episode => episode.season_id === seasonId);
};

const getImageFilm = (film) => {
  return film.media[0].original_url;
};
// Función para filtrar las películas por categoría
const getContentByCategory = (categoryId) => {
  return films.value.filter(film => film.categoria_id === categoryId);
};

const submitReview = () => {
  review.value.content_id = film.value.id;

  const userId = store.state.auth.user.id;
  review.value.user_id = userId;

  // Enviar reseñas
  axios.post('/api/reviews', review.value)
    .then(response =>{
      // console.log(response);
      swal({
          allowOutsideClick: true,
          timer: 2000,
          timerProgressBar: true,
          customClass: {
            timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
          },
          position: "top-end",
          icon: 'success',
          title: 'Reseña enviada!',
          showConfirmButton: false
        });
    }).catch(error =>{
      swal({
          icon: 'error',
          title: 'Error al enviar la reseña'
      });
    });
}

const getReviews = () => {
  axios.get('/api/reviews')
    .then(response => {
      reviews.value = response.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching reviews:', error);
    });
}

const getEpsBySeasonId = (seasonId) => {
  axios.get(`/api/episodesBySeason/${seasonId}`)
    .then(response => {
      episodesBySeason.value = response.data;
      //console.log("INFO EPISODES: "+response.data.id);
    })
    .catch(error => {
      console.error('Error fetching episodes:', error);
    });
}

const getEpisodes = () => {
  axios.get('/api/episodes')
    .then(response => {
      const episodesData = response.data;
      episodes.value = episodesData;
      // Asociar cada episodio con su temporada correspondiente
      episodesData.forEach(episode => {
        const seasonId = episode.season_id;
        // Encontrar la temporada correspondiente en la lista de temporadas
        const season = seasons.value.find(s => s.id === seasonId);
        if (season) {
          // Agregar la temporada al episodio
          episode.season = season;
        }
      });
      episodes.value = episodesData.flat(1);
      //console.log("Episodios:", episodes.value);
    })
    .catch(error => {
      console.error('Error fetching episodes:', error);
    });
}

const getAllSeasons = () => {
  axios.get('/api/seasons')
    .then(response => {
      seasons.value = response.data;
      getEpisodes();
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching seasons:', error);
    });
}

const sendFavorites = (filmId) => {
  if (verifyFavorite(filmId)) {
    // Si la película ya está marcada como favorita, eliminarla
    axios.delete(`/api/favorites/${filmId}`)
      .then(response => {
        // console.log(response.data);
        swal({
          allowOutsideClick: true,
          timer: 2000,
          timerProgressBar: true,
          customClass: {
            timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
          },
          position: "top-end",
          icon: 'success',
          title: 'Eliminada de Mi lista!',
          showConfirmButton: false
        });
        // Actualizar la lista de favoritos eliminando el favorito
        favorites.value = favorites.value.filter(favorite => favorite.film_id !== filmId);
      })
      .catch(error => {
        console.error('Error removing favorite:', error);
        swal({
          icon: 'error',
          title: 'Error al eliminar de favoritos'
        });
      });
  } else {
    // Si la película no está marcada como favorita, agregarla como favorita
    axios.post('/api/favorites', {
      user_id: store.state.auth.user.id,
      film_id: filmId
    })
    .then(response => {
      // console.log(response.data);
      swal({
          allowOutsideClick: true,
          timer: 2000,
          timerProgressBar: true,
          customClass: {
            timerProgressBar: 'succes-progress-bar' // Clase personalizada para el temporizador de progreso
          },
          position: "top-end",
          icon: 'success',
          title: 'Guardada en Mi lista!',
          showConfirmButton: false
        });
      // Agregar el favorito a la lista de favoritos
      favorites.value.push(response.data.data);
    })
    .catch(error => {
      console.error('Error adding favorite:', error);
      swal({
        icon: 'error',
        title: 'Error al guardar en favoritos'
      });
    });
  }
}


// Función para verificar si una película con el ID especificado está en la lista de favoritos
const verifyFavorite = (movieId) => {
  return favorites.value.some(favorite => favorite.film_id === movieId);
}


//Funcion para obtener imagen del episodio
const getMediaImageUrl = (episode) => {
  if (episode.media && episode.media.length > 0) {
            // Iterar sobre la matriz de medios y encontrar el tipo de imagen
            for (let i = 0; i < episode.media.length; i++) {
                if (episode.media[i].mime_type === 'image/png' || episode.media[i].mime_type === 'image/jpeg') {
                    // Devolver la URL de la imagen
                    return episode.media[i].original_url;
                }
            }
  } else{
    return '/images/placeholder.jpg';
  }
}

</script>
  
  <style>
  .cont-principal {
    background-color: black;
  }
  .texto-1 {
    color: white;
    font-size: 25px;
  }

  .p-dropdown-trigger-icon{
    color: black !important;
  }
  </style>
  