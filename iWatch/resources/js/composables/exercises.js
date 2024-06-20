import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

export default function useExercises() {
    const exercises = ref({})
    const exercise = ref({
        title: '',
        content: '',
        category_id: '',
        thumbnail: ''
    })
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getExercises = async (
        page = 1,
        search_category = '',
        search_id = '',
        search_title = '',
        search_content = '',
        search_global = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        axios.get('/api/exercises?page=' + page +
            '&search_category=' + search_category +
            '&search_id=' + search_id +
            '&search_title=' + search_title +
            '&search_content=' + search_content +
            '&search_global=' + search_global +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                exercises.value = response.data;
            })
    }

    const getExercise = async (id) => {
        axios.get('/api/exercises/' + id)
            .then(response => {
                exercise.value = response.data.data;
            })
    }

    const storeExercise = async (exercise) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedExercise = new FormData()
        for (let item in exercise) {
            if (exercise.hasOwnProperty(item)) {
                serializedExercise.append(item, exercise[item])
            }
        }

        axios.post('/api/exercises', serializedExercise, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'exercises.index' })
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

    const updateExercise = async (exercise) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/api/exercises/update/' + exercise.id, exercise, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
        .then(response => {
            router.push({ name: 'exercises.index' })
            console.log(response);
            swal({
                icon: 'success',
                title: 'Exercise updated successfully'
            })
        })
        .catch(error => {
            if (error.response?.data) {
                validationErrors.value = error.response.data.errors
            }
        })
        .finally(() => isLoading.value = false)
    }

    const deleteExercise = async (id) => {
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/exercises/' + id)
                        .then(response => {
                            getExercises()
                            router.push({ name: 'exercises.index' })
                            swal({
                                icon: 'success',
                                title: 'Exercise deleted successfully'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })

    }

    return {
        exercises,
        exercise,
        getExercises,
        getExercise,
        storeExercise,
        updateExercise,
        deleteExercise,
        validationErrors,
        isLoading,
        router
    }
}
