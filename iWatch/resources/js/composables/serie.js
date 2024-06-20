import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

const storeExercise = async (serie) => {
    if (isLoading.value) return;

    isLoading.value = true
    validationErrors.value = {}

    let serializedSerie= new FormData()
    for (let item in serie) {
        if (serie.hasOwnProperty(item)) {
            serializedSerie.append(item, serie[item])
        }
    }

    axios.post('/api/series', serializedSerie, {
        headers: {
            "content-type": "multipart/form-data"
        }
    })
        .then(response => {
            router.push({ name: 'series.indexSeries' })
            swal({
                icon: 'success',
                title: 'Exercise saved successfully'
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
        })
        .finally(() => isLoading.value = false)
}