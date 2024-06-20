<template>
  <div class="container-fluid mainHomeFluidCont d-flex justify-content-center">
      <div class="container m-0 p-0 homeContainer">
      <!-- VIDEO PRINCIPAL -->
      <div class="mainVideo principal">
        <video id="my-video" :key="randomFilm?.media[2]?.original_url" width="100%" class="my-video firstVideo vjs-default-skin" data-setup="{}" autoplay muted loop>
          <source :src="randomFilm?.media[2]?.original_url" type="video/mp4" />
        </video>
        <div class="mainReproducerBtn">
          <h1>{{ randomFilm.name }}</h1>
          <h2>{{ randomFilm.synopsis }}</h2>
          <div class="d-flex flex-wrap">
            <router-link v-if="randomFilm && randomFilm.id && checkSubscription(InfoSubsFilm) /*info_subscription_level.value?.suscripcion_id === InfoSubsFilm.suscripcion_id*/ /*&& info_subscription_level.value.user_id === InfoSubsFilm.value.suscripcion_id*/" :to="{ name: 'player-films', params: { id: randomFilm.id } }" class="mainReproducerBtn2 d-flex justify-content-center align-items-center">
              <img class="dark-btn-img" src="/images/playReproductorWhite.svg" alt="">
              Reproducir
            </router-link>
            <router-link v-else :to="{ name: 'subscriptions'}" class="mainReproducerBtn2 d-flex justify-content-center align-items-center">
              <img class="dark-btn-img" src="images\upgradePlan.svg" alt="">
              Mejora tú plan
            </router-link>
            <button @click="sendFavorites(randomFilm.id)" class="favourite">
              <img v-if="verifyFavorite(randomFilm.id)" class="favoriteIcon m-0" src="images\crossSave.svg" alt="">
              <img v-else class="favoriteIcon m-0" src="images\plusSave.svg" alt="">
            </button>
          </div>
        </div>
      </div>
      <!-- VIDEO SECUNDARIO -->
      <div class="secondaryVideo d-flex justify-content-center align-items-center secondary">
        <video id="my-video" :key="randomFilm?.media[2]?.original_url" width="100%" class="my-video firstVideo vjs-default-skin" data-setup="{}" autoplay muted loop>
          <source :src="randomFilm?.media[2]?.original_url" type="video/mp4" />
        </video>
        <h1>{{ randomFilm.name }}</h1>
        <div class="d-flex justify-content-center">
          <div class="btn-cont">
            <router-link v-if="randomFilm && randomFilm.id && checkSubscription(InfoSubsFilm) /*info_subscription_level.value?.suscripcion_id === InfoSubsFilm.suscripcion_id*/ /*&& info_subscription_level.value.user_id === InfoSubsFilm.value.suscripcion_id*/" :to="{ name: 'player-films', params: { id: randomFilm.id } }" class="button1">
              <img src="/images/playReproductorWhite.svg" alt="">
              Reproducir
            </router-link>
            <router-link v-else :to="{ name: 'subscriptions'}" class="button1">
              <img src="images\upgradePlan.svg" alt="">
              Mejora tú plan
            </router-link>
            <button @click="sendFavorites(randomFilm.id)" class="button2">
              <div v-if="verifyFavorite(randomFilm.id)">
                <img class="favoriteIcon m-0" src="images\crossSave.svg" alt="">
              </div>
              <div v-else>
                <img class="favoriteIcon m-0" src="images\plusSave.svg" alt="">
              </div>
            </button>
          </div>
        </div>
      </div>
      <!-- ÚLTIMAS NOVEDADES -->
      <div v-if="news.length > 0" class="row m-0 firstNewsRow">
        <h2>{{ $t('last_news')}}</h2>
        <Carousel :value="news" :numVisible="5" :numScroll="3" :responsiveOptions="responsiveOptions">
          <template #item="slotProps">
            <div class="last-news-container">
              <img @click="info(slotProps.data)" class="image-item large img-news new-last-cont" width="100%" height="100%" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  :src="slotProps.data.media && slotProps.data.media[1]?.original_url ? slotProps.data.media[1].original_url : '/images/placeholder.jpg'" :alt="slotProps.data.name">
            </div>
          </template>
        </Carousel>
      </div>
      <!-- SEGUIR VIENDO  -->
      <div v-if="allViewedUsersFilms.length > 0" v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row m-0 keepWatching">
        <h2>{{ $t('keep_watching')}}</h2>
        <Carousel :value="allViewedUsersFilms" :numVisible="5" :numScroll="3" :responsiveOptions="responsiveOptions">
          <template #item="slotProps">
            <div class="normal-size">
              <img @click="info(slotProps.data)" class="image-item large img-news normal-size"  data-bs-toggle="modal" data-bs-target="#staticBackdropForWatching" width="350" :src="slotProps.data.media && slotProps.data.media[0]?.original_url ? slotProps.data.media[0].original_url : '/images/placeholder.jpg'" :alt="slotProps.data.name" v-if="isInViewingSection">
            </div>
          </template>
        </Carousel>
      </div>
      <!-- FAVORITOS -->
      <div v-if="favoritesByUserId.length > 0" v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row m-0 myFavsContentList">
        <h2>{{ $t('my_list_home')}}</h2>
        <Carousel :value="favoritesByUserId" :numVisible="5" :numScroll="3">
          <template #item="slotProps">
            <div class="normal-size">
              <img @click="info(slotProps.data)" class="image-item large img-news normal-size"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="350" :src="slotProps.data.media && slotProps.data.media[0]?.original_url ? slotProps.data.media[0].original_url : '/images/placeholder.jpg'" :alt="slotProps.data.name">
            </div>
          </template>
        </Carousel>
      </div>
      <!-- CARRUSEL CATEGORIAS -->
      <div v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row m-0 contByCatsCarrousel" v-for="category in categoryList" :key="category.id">
        <h2>{{ $t('categories.' + category.name) }}</h2>
        <Carousel :value="category.films" :numVisible="5" :numScroll="3" :responsiveOptions="responsiveOptions">
          <template #item="slotProps">
            <div class="normal-size">
              <img @click="info(slotProps.data)" class="image-item large img-news normal-size" data-bs-toggle="modal" data-bs-target="#staticBackdrop" :src="getImageFilm(slotProps.data)" :alt="slotProps.data.name">
            </div>
          </template>
        </Carousel>
      </div>
      
    </div>
  </div>

  <!-- MODAL 1 -->
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
                <router-link v-if="film && film.id && checkSubscription(InfoSubsFilm) /*&& info_subscription_level.value.user_id === InfoSubsFilm.value.suscripcion_id*/" :to="{ name: 'player-films', params: { id: film.id } }" class="watch d-flex justify-content-center align-items-center">
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
              <!-- PANEL RESEÑAS -->
              <Panel header="¿Que te ha parecido?" toggleable collapsed>
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
    <!-- MODAL 2 -->
    <div class="modal fade" id="staticBackdropForWatching" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <router-link v-if="randomFilm && randomFilm.id && checkSubscription(InfoSubsFilm) /*&& info_subscription_level.value.user_id === InfoSubsFilm.value.suscripcion_id*/" :to="{ name: 'player-films', params: { id: randomFilm.id } }" class="watch d-flex justify-content-center align-items-center">
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
                <button @click="removeViewedFilm(film.id)" class="favourite">
                  <i class="pi pi-eye-slash p-0 pi-h1 favoriteIcon d-flex justify-content-center" style="font-size: 2rem"></i>
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
              <!-- PANEL RESEÑAS -->
              <Panel header="¿Que te ha parecido?" toggleable collapsed>
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
import { ref, inject, onMounted } from "vue";

import useCategories from "@/composables/categories";
import FilmsCarousel from "@/components/FilmsCarousel.vue";

import { useStore } from 'vuex';
import { computed } from "vue";
import { useRouter } from 'vue-router';
import '@fortawesome/fontawesome-free/css/all.css';

const isInViewingSection = ref(true);

const isLoading = ref(true);
const route = useRouter();

const films = ref([]);
const randomFilm = ref({media:[]});
const news = ref([]);
const film = ref({media:[]});
const swal = inject('$swal');
const infoModal = ref(null);
const { categoryList, getCategoryList } = useCategories();
const store = useStore();
const user = computed(() => store.state.auth.user)
const filmPunct = ref([]);

const favorites = ref([]);
const favoritesByUserId = ref([]);
const allViewedUsersFilms = ref([]);

const selectedFilm = ref(null); // Variable para almacenar la película seleccionada
const seasonOptions = ref([]); // Lista de opciones para el menú desplegable

const seasons = ref([]);
const filteredSeasons = ref([]);
const filteredContent = ref([]);
const active = ref(0);
const episodesBySeason = ref([]);
const episodes = ref([]);
const review = ref({});
const reviews = ref([]);
const InfoSubsFilm = ref([]);
const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '450px',
        numVisible: 1,
        numScroll: 1
    }
]);

// Info del user en la tabla user_subscription
const info_subscription_level = ([]);

onMounted(() => {
   // Obtener películas
   axios.get('/api/films/')
     .then(response => {
     isLoading.value = false;
       films.value = response.data;
      //  console.log(response.data);
     })
     .catch(error => {
       isLoading.value = false;
       console.error('Error fetching films:', error);
     });
     // Obtener películas por categorias
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
    // Obtener películas favoritas
    axios.get('/api/favoriteFilms')
    .then(response => {
      favorites.value = response.data.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching favorites:', error);
    });
    // Obtener favoritos del usuario
    axios.get(`/api/favoritesByUser/${store.state.auth.user.id}`)
    .then(response => {
      favoritesByUserId.value = response.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching favorites by user:', error);
    });
    // Obtener películas vistas
    axios.get(`/api/viewed-films/${store.state.auth.user.id}`)
    .then(response => {
      allViewedUsersFilms.value = response.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching allViewedUsersFilms:', error);
    });
    // Obtener novedades
    axios.get('/api/news')
    .then(response => {
      news.value = response.data;
      // console.log(response.data);
    })
    .catch(error => {
      console.error('Error fetching news:', error);
    });
    // Obtener película random
    axios.get('/api/random-film')
    .then(response => {
      randomFilm.value = response.data;
      // console.log("RANDOM FILM: "+response.data);
    })
    .catch(error => {
      console.error('Error fetching randomFilm:', error);
    });

  getAllSeasons();
  getInfoUserSub();
  getEpisodes();
  getEpsBySeasonId();
  getReviews();
});


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

const getRandomFilmMediaUrl = () => {
    if (randomFilm && randomFilm.media && randomFilm.media[2] && randomFilm.media[2].original_url) {
        return randomFilm.media[2].original_url;
    } else {
        return ''; // O alguna otra URL de respaldo o mensaje de error
    }
};

// Obtener info suscripcion de la peli seleccionada
const getSubscriptionsFilms = (filmId) => {
  axios.get(`/api/suscripcionsFilms/${filmId}`)
    .then(response => {
      InfoSubsFilm.value = response.data;
      // console.log('SUSCRIPCIONES FILMS INFO:', InfoSubsFilm.value);
    })
    .catch(error => {
      console.error('Error fetching reviews:', error);
    });
}

// Función para comprobar la suscripción
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
      // console.log("INFO suscripcion comprada por el USER: "+info_subscription_level.value.suscripcion_id);
    })
    .catch(error => {
      console.error('Error fetching seasons:', error);
    });
}
// Obtener puntuación de la pelicula
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
// Obtener episodios por temporada
const getEpsBySeasonId = (seasonId) => {
  axios.get(`/api/episodesBySeason/${seasonId}`)
    .then(response => {
      episodesBySeason.value = response.data;
      // console.log("INFO EPISODES: "+response.data.id);
    })
    .catch(error => {
      console.error('Error fetching episodes:', error);
    });
}
// Obtener episodios
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
//Obtener temporadas
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
// Guardar en favoritos
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
            timerProgressBar: 'succes-progress-bar'
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
// Eliminar de películas vistas
const removeViewedFilm = (filmId) => {
  axios.delete(`/api/viewedFilms/${filmId}`)
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
          title: 'Ya no estas viendo esta pelicula!',
          showConfirmButton: false
        });
      });
}

// Función para verificar si una película con el ID especificado está en la lista de favoritos
const verifyFavorite = (movieId) => {
  return favorites.value.some(favorite => favorite.film_id === movieId);
}


</script>


<style>
    /* ESTILOS FORMULARIO DE RESEÑAS */
    .btn-review{
      margin-top: 10px;
    }

    .reviews{
      margin-top: 10px;
    }

    #review{
      margin-top: 10px;
    }

    .data-review{
      margin-top: 10px;
    }

    video{
        width: 100%;
    }

    .scrolling-container {
    display: flex;
    flex-wrap: nowrap;
    scroll-behavior: smooth;
    overflow-x: hidden;
    }

    .scrolling-card {
    background-color: white;
    flex: 0 0 auto;
    margin: 5px;
    width: 300px;
    height: 190px;
    text-align: center;
    overflow: hidden;
    border-radius: 5px;
    }

    .image-item{
        border-radius: 5px;
        width: 100%;
    }

    h3{
        margin: 0;
        text-align: left;
        display: none;
        color: white;
    }

    .scrolling-card:hover{
        transform: scale(1.05);
        transition: transform 0.6s cubic-bezier(0, 0.55, 0.45, 1);
        cursor: pointer;
    }

    .scrolling-card:hover h3{
        transition: 0.5s;
        display: block;
    }

    .scrolling-container::-webkit-scrollbar {
    display: none;
    }

    .scrolling-buttons-container {
    display: flex;
    justify-content: space-between;
    font-size: 25px;
    margin-left: 25px;
    margin-right: 25px;
    }

    /* ESTILOS DE LA BARRA DE SCROLL */
    /* width */
    ::-webkit-scrollbar {
    width: 0;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px transparent; 
    border-radius: 10px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: transparent; 
    border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: transparent; 
    }

</style>