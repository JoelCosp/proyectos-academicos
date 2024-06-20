<template>
    <!-- <div class="card border-0 bg-primary mainBox d-flex justify-content-center flex-row flex-wrap">
        <div class="imgPercent">
            <div class="film-review-image">
                <img class="" v-if="dataImgReview && dataImgReview.media && dataImgReview.media.length > 0" :src="dataImgReview.media[1].original_url" :alt="dataImgReview.name">
            </div>
            <div class="film-rate mt-4 p-4 d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center global-content">
                    <img src="/images/reviewStarIcon.svg" alt="">
                    <p class="film-average">{{ filmPunct }}</p>
                </div>
                <p class="num-votes">{{ numAllReviews }} reseñas</p>
            </div>
            <div class="film-info-review mt-4 p-4">
                <h1>{{ dataImgReview.name }}</h1>
                <p>{{ dataImgReview.synopsis }}</p>
                <p>{{ dataImgReview.duration }}</p>
                <p>{{ dataImgReview.director }}</p>
                <p>{{ categoryNames.join(', ') }}</p>
            </div>
        </div>
        <div class="review-pack pt-0 ms-4">
            <div v-for="post in permissions" :key="post.id" class="mb-4 user-review p-4 pb-3">
                <div class="info d-flex mb-2">
                    <img class="avatarImg" :src="post.profile_image" alt="">
                    <div class="userRating ps-3">
                        <p class="font-bold m-0">{{ post.name }} {{ post.apellido }}</p>
                        <Rating v-model="post.punctuation" readonly :cancel="false" class="d-flex flex-wrap align-content-start" :min="1" :max="5" />
                    </div>
                </div>
                <p class=" m-0">{{ post.description }}</p>
            </div>
        </div>
        <hr>
    </div> -->

    <div class="card border-0 mainBox d-flex justify-content-center align-items-center flex-column n-rev">
        <h1><i class="pi pi-thumbs-up-fill pe-3 pi-h1" style="font-size: 2rem"></i>Críticas</h1>
        <div class="movie-banner mb-4">
            <div class="inf-movie-review">
                <p class="r-title">{{ dataImgReview.name }}</p>
                <!-- <p class="r-synopsis">{{ dataImgReview.synopsis }}</p> -->
                <!-- <p>{{ dataImgReview.director }}</p> -->
                <p class="mb-2">{{ categoryNames.join(', ') }}</p>
                <Rating id="" v-model="filmPunct" readonly :cancel="false" :min="1" :max="5" />
            </div>
            <div class="banner-gradient"></div>
            <img class="img-new-rev-section" v-if="dataImgReview && dataImgReview.media && dataImgReview.media.length > 0" :src="dataImgReview.media[0].original_url" :alt="dataImgReview.name">
        </div>
        <div class="inferior-reviews-content d-flex justify-content-center flex-column align-items-center">
            <div v-for="post in permissions" :key="post.id" class="u-review p-4 pb-3 mb-4">
                <div class="d-flex mb-2">
                    <img class="avatarImg" :src="post.profile_image" alt="">
                    <div class="userRating ps-3">
                        <p class="font-bold m-0 mb-1">{{ post.name }} {{ post.apellido }}</p>
                        <Rating v-model="post.punctuation" readonly :cancel="false" class="d-flex flex-wrap align-content-start" :min="1" :max="5" />
                        <p class=" m-0 mt-3">{{ post.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>






</template>

<script setup>
  import {ref, onMounted, watch} from "vue";
  import usePermissions from "@/composables/reviews";
  import {useAbility} from '@casl/vue';
  import { useRoute } from 'vue-router';

const route = useRoute();

  const search_id = ref('')
  const search_title = ref('')
  const search_global = ref('')
  const orderColumn = ref('created_at')
  const orderDirection = ref('desc')

  const id = ref('')
  const description = ref('')
  const punctuation = ref('')
  const user_id = ref('')
  const content_id = ref('')
  const name = ref('');

  const dataImgReview = ref('')

  const {permissions, getPermissions, deletePermission, getReviewsByContentId, getReviewsByContentName} = usePermissions()
  const {can} = useAbility()

  const categoryNames = ref([]);

  const filmPunct = ref([]);
  const numAllReviews = ref([]);

  onMounted(() => {
    getPermissions()
    getReviewsByContentId(route.params.id)

    axios.get(`/api/getContentById/${route.params.id}`)
      .then(response => {
        dataImgReview.value = response.data;
        // console.log("DATA: "+response.data);
        // Obtener categorias de la peli
        categoryNames.value = response.data.categories.map(category => category.name);
        getPunctuation(route.params.id);
        // console.log("ID PELI: "+route.params.id);
        getNumCountAllReviews(route.params.id);
    })
      .catch(error => {
        console.error('Error fetching dataImgReview:', error);
    });
    // console.log("ID A PASAR: "+dataImgReview.id);
  })

  // Obtener la puntuacion de la pelicula/serie
    const getPunctuation = (film_id) => {
        axios.get(`/api/film-punctuation/${film_id}`)
        .then(response => {
            filmPunct.value = Math.round(response.data);
            // console.log("NOTA PELI: "+filmPunct.value);
        })
        .catch(error => {
            console.error('Error fetching filmPunct:', error);
        });
    }

    const getNumCountAllReviews = (cont_id) => {
        axios.get(`/api/conuntReviews/${cont_id}`)
        .then(response => {
            numAllReviews.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching numAllReviews:', error);
        });
    }

  const updateOrdering = (column) => {
      orderColumn.value = column;
      orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
      getPermissions(
          1,
          id.value,
          description.value,
          punctuation.value,
          user_id.value,
          content_id.value,
          name.value
      );
  }

  watch(content_id, (current, previous) => {
      if (current) {
         getReviewsByContentName(current); // Llamar a getReviewsByContentId solo si content_id no es vacío
      } else {
          getPermissions(); // Llamar a getPermissions para obtener todas las reseñas cuando content_id es vacío
      }
  })


  // watch(content_id, (current, previous) => {
  //     getPermissions(
  //         1,
  //         current,
  //         description.value,
  //         punctuation.value
  //     )
  // })
  
  // watch(search_title, (current, previous) => {
  //     getPermissions(
  //         1,
  //         search_id.value,
  //         current,
  //         search_global.value
  //     )
  // })
  // watch(search_global, _.debounce((current, previous) => {
  //     getPermissions(
  //         1,
  //         search_id.value,
  //         search_title.value,
  //         current
  //     )
  // }, 200))

</script>

<style scoped>

</style>
