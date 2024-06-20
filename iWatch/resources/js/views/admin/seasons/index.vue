<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las películas</h5>
                        <div>
                            <router-link :to="{ name: 'seasons.create' }" class="btn btn-success">Nueva temporada</router-link>
                        </div>
                    </div>
                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre de la temporada</th>
                                <th>Temporada</th>
                                <th>Serie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(season, index) in seasons" :key="season.id">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ season.season_name }}</td>
                                <td>{{ season.order }}</td>
                                <td>{{ seriesNames[season.content_id] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const seasons = ref([]);
const seriesNames = ref({}); 

onMounted(async () => {
    try {
        const response = await axios.get('/api/seasons');
        seasons.value = response.data;

        for (const season of seasons.value) {
            const seriesNameResponse = await axios.get('/api/series/names/' + season.content_id);
            seriesNames.value[season.content_id] = seriesNameResponse.data.name; 
        }
    } catch (error) {
        console.error('Error fetching seasons or series:', error);
    }
});
</script>
