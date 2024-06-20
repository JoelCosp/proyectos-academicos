<template>
<h1>PELICULAS</h1>

<div class="container-fluid homeFluidCont d-flex justify-content-center">
      <div class="container m-0 p-0 homeContainer">
        <select v-model="selectedFilter" @change="handleCategoryChange" class="selector md:w-14rem">
          <option class="selectorOption" v-for="filter in filters" :value="filter.value" :key="filter.value">{{ filter.label }}</option>
        </select>
        <input v-model="content_name" type="text" class="inline-block form-control find-review search-review" placeholder="Introduce el nombre de tú contenido..." readonly>
        <!-- <h1>Categoría seleccionada: {{ selectedFilter }}</h1> -->
        <div class="container-fluid">
          <div class="row rowFilms d-flex justify-content-center align-items-center">
            <div v-for="(film, index) in films" :key="film.id" class="film-card p-0">
              <!-- {{ film }} -->
              <div class="border-1 surface-border border-round m-2 p-3 miniature">
                  <img class="image-item" :src="film.media && film.media.length > 0 ? film.media[0].original_url : '/images/placeholder.jpg'" :alt="film.name">
              </div>
          </div>
          </div>
        </div>
      </div>
</div>
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

</template>

<script setup>
  import axios from "axios";
  import { ref, onMounted, watch } from 'vue';
  import usePermissions from "@/composables/reviews";
  import {useAbility} from '@casl/vue';
  import { useRoute } from 'vue-router';

  const route = useRoute();
  
  const isLoading = ref(true);
  const films = ref([]);
  const filters = ref([
    { label: 'All Movies', value: '0' },
    { label: 'Action', value: '1' },
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
    axios.get('/api/films/category/' + categoryId)
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
  
  onMounted(() => {
   setContentNameFromUrl();
  });

  const setContentNameFromUrl = () => {
        const searchQuery = route.query.search; // Obtener la query 'search' de la URL
        if (searchQuery) {
            content_name.value = decodeURIComponent(searchQuery); // Asignar el valor al campo de búsqueda
        }
  };

  const getContentsByContentName = async (name) => {
        isLoading.value = true;
        axios.get(`/api/films/${name}`)
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
</script>