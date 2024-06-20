<style scope>

</style>

<template>
      <div id="scrollCont" class="scrolling-container p-0">
          <div class="scrolling-card" v-for="film in peliculas" :key="film.id">
            <img @click="handleImageClick(film.id)" :id="film.id" class="image-item"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="350" :src="film.media.length > 0 ? film.media[0].original_url : '/images/placeholder.jpg'" :alt="film.name" style="max-height: 100px;">
          </div>
      </div>

      <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <video id="my-video" class="my-video vjs-default-skin w-100" data-setup="{}" autoplay muted>
              <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4" />
            </video>
            <div class="buttons d-flex">
              <button>Reproducir</button>
              <button>Guardar</button>
            </div>
            <div class="info">
              <p id="description"></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  peliculas: Array // o el tipo adecuado para las películas
});

function handleImageClick(id) {
  addInfoModal(id);
}

// Función para mostrar la información de la imagen seleccionada en el modal
function addInfoModal(id) {
  const descripcion = document.getElementById("description");
  descripcion.innerHTML = peliculas.value[id];
}

</script>