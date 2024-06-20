import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

const storeExercise = async (film) => {
    if (isLoading.value) return;

    isLoading.value = true
    validationErrors.value = {}

    let serializedFilm = new FormData()
    for (let item in film) {
        if (film.hasOwnProperty(item)) {
            serializedFilm.append(item, film[item])
        }
    }

    axios.post('/api/films', serializedFilm, {
        headers: {
            "content-type": "multipart/form-data"
        }
    })
        .then(response => {
            router.push({ name: 'films.indexFilms' })
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