<template>
    <div class="row justify-content-center my-2">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="float-start">Categories</h5>
                    <router-link v-if="can('category-create')" :to="{ name: 'categories.create' }" class="btn btn-primary btn-sm float-end">
                        Create Category
                    </router-link>
                </div>
                <!-- <h1 style="color: black; font-size: 17px;">CATEGORIAS ---O{{ catsToFilt }}</h1>
                <h1 style="color: black; font-size: 17px;">SEARCH_GLOBAL---O{{ search_global }}</h1> -->

                <label for="buscar">Buscar:</label>
                <input type="text" id="buscar" @input="filterCategories()">

                <ul id="categoryListFilter"></ul>

                <div class="card-body shadow-sm">
                    <!-- <div class="mb-4">
                        <input v-model="search_global" type="text" placeholder="Search..."
                               class="form-control w-25">
                    </div> -->




                    <!-- INPUT DE JS -->
                    <!-- <input type="search" id="search_cats" @input="beginhere"> -->


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <!-- <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_id" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Filter by ID">
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_title" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Filter by Title">
                                </th>
                                <th class="px-6 py-3 text-start"></th>
                                <th class="px-6 py-3 text-start"></th>
                            </tr> -->
                            <!-- <tr>
                                <th class="px-6 py-3 text-start">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('id')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'id' }">
                                            ID
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'id',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'id',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('title')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'title' }">
                                            Title
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'title',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'title',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <div class="flex flex-row items-center justify-between cursor-pointer"
                                         @click="updateOrdering('created_at')">
                                        <div class="leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'created_at' }">
                                            Created at
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'created_at',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'created_at',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    Actions
                                </th>
                            </tr> -->
                            </thead>
                            <tbody id="body-table-data-container">
                            <tr v-for="post in categories.data" :key="post.id">
                                <td class="px-6 py-4 text-sm">
                                    {{ post.id }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.name }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.created_at }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <router-link v-if="can('category-edit')"
                                                 :to="{ name: 'categories.edit', params: { id: post.id } }"
                                                 class="badge bg-primary">Edit
                                    </router-link>
                                    <a href="#" v-if="can('category-delete')" @click.prevent="deleteCategory(post.id)"
                                       class="ms-2 badge bg-danger">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- <input type="search" id="js-cats-filter" @input="filterCats">
                {{ categories.data }}
                <ul v-for="post in categories.data" :key="post.id">
                    <li>{{ post.id }} {{ post.name }}</li>
                </ul> -->

                <div class="card-footer">
                    <Pagination :data="categories" :limit="3"
                                @pagination-change-page="page => getCategories(page, search_id, search_title, search_global, orderColumn, orderDirection)"
                                class="mt-4"/>
                </div>
            </div>
        </div>
    </div>

    <tbody id="body-table-data-container">
        <tr v-for="categoria in personasFiltradas" :key="categoria.id">
            <td class="px-6 py-4 text-sm">{{ categoria.id }}</td>
            <td class="px-6 py-4 text-sm">{{ categoria.name }}</td>
            <td class="px-6 py-4 text-sm">{{ categoria.created_at }}</td>
            <td class="px-6 py-4 text-sm">
                <router-link v-if="can('category-edit')"
                             :to="{ name: 'categories.edit', params: { id: categoria.id } }"
                             class="badge bg-primary">Edit
                </router-link>
                <a href="#" v-if="can('category-delete')" @click.prevent="deleteCategory(categoria.id)"
                    class="ms-2 badge bg-danger">Delete</a>
            </td>
        </tr>
    </tbody>
</template>

<script setup>
    import {ref, onMounted, watch} from "vue";
    import useCategories from "../../../composables/categories";
    import {useAbility} from '@casl/vue'

    const catsToFilt = ref('');

    const search_id = ref('')
    const search_title = ref('')
    const search_global = ref('')
    const orderColumn = ref('created_at')
    const orderDirection = ref('desc')
    const {categories, getCategories, deleteCategory} = useCategories()
    const {can} = useAbility()
    const personasFiltradas = ref([]);












    // BUSCADOR DE CATEGORIAS

    // Ejemplo de lo que devuelve el axios paraobtener info de las cats

    // [
    //     {
    //         "id":1,
    //         "name":"Acción",
    //         "created_at":"2024-04-12 13:30:52",
    //         "updated_at":"2024-04-12 13:30:52"
    //     },
    //     {
    //         "id":2,
    //         "name":"Aventura",
    //         "created_at":"2024-04-12 13:30:52",
    //         "updated_at":"2024-04-12 13:30:52"
    //     }
    // ]

    // const personas = [
    //     { nombre: 'Accion', skills: ['JavaScript', 'HTML', 'CSS'] },
    //     { nombre: 'Aventura', skills: ['Python', 'PHP', 'Java'] },
    //     { nombre: 'Comedia', skills: ['Angular', 'React', 'Node.js'] },
    // ];

    // const catsArray = catsToFilt.value;

    // function filterCategories() {
    //     const inputBusqueda = document.getElementById('buscar').value.toLowerCase();
    //     const listaCategorias = document.getElementById('categoryListFilter');
    //     if (inputBusqueda === '') {
    //         listaCategorias.innerHTML = '';
    //         return;
    //     }
    //     const personasFiltradas = catsToFilt.value.filter(categoria => {
    //         const nombre = categoria.name.toLowerCase(); // Cambiar de 'nombre' a 'name'
    //         return nombre.includes(inputBusqueda);
    //     });
    //     listaCategorias.innerHTML = '';
    //     personasFiltradas.forEach(categoria => {
    //         const tableCatsAll = document.getElementById("body-table-data-container").innerHTML;
    //         const tr = document.createElement('tr');
    //         const td = document.createElement('td');
    //         p.textContent = `${categoria.name}`;
    //         listaCategorias.appendChild(p);
    //     });
    // }

    function filterCategories() {
    const inputBusqueda = document.getElementById('buscar').value.toLowerCase();
    const tbody = document.getElementById('body-table-data-container');

    if (inputBusqueda === '') {
        // Si el campo de búsqueda está vacío, mostrar todas las categorías de nuevo
        getCategories();
        return;
    }

    personasFiltradas.value = catsToFilt.value.filter(categoria => {
        const nombre = categoria.name.toLowerCase();
        return nombre.includes(inputBusqueda);
    });

    // Limpiar el contenido actual del cuerpo de la tabla
    tbody.innerHTML = '';

    // Para cada categoría filtrada, crear una nueva fila en la tabla y agregarla al cuerpo de la tabla
    /*personasFiltradas.forEach(categoria => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-6 py-4 text-sm">${categoria.id}</td>
            <td class="px-6 py-4 text-sm">${categoria.name}</td>
            <td class="px-6 py-4 text-sm">${categoria.created_at}</td>
            <td class="px-6 py-4 text-sm">
                <router-link v-if="can('category-edit')"
                             :to="{ name: 'categories.edit', params: { id: ${categoria.id} } }"
                             class="badge bg-primary">Edit
                </router-link>
                <a href="#" v-if="can('category-delete')" @click.prevent="deleteCategory(${categoria.id})"
                   class="ms-2 badge bg-danger">Delete</a>
            </td>
        `;
        tbody.appendChild(tr);
    });*/
}


    
    // function beginhere() {
        
    //     let srch_input = document.getElementById("search_cats").value;
        
    //     let tbody = document.querySelector('tbody');
    //     let hijos = tbody.children;

    //     let tableContent = tbody.innerHTML;
    //     console.log(tableContent); 
        
    //     for (let i = 0; i < catsToFilt.value.length; i++) {
    //         if (catsToFilt.value[i].name == srch_input) {
    //             console.log("correcto");
    //             while (tbody.firstChild) {
    //                 tbody.removeChild(tbody.firstChild);
    //             }
    //             return;
    //         }else{
    //             console.log("incorrecto");
    //             return;
    //         }
    //     }
    // }



    onMounted(() => {
        getCategories()

        axios.get('/api/categorias')
        .then(response => {
        catsToFilt.value = response.data;
        // console.log(response.data);
        })
        .catch(error => {
        console.error('Error fetching catsToFilt:', error);
        });
    })
    const updateOrdering = (column) => {
        orderColumn.value = column;
        orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
        getCategories(
            1,
            search_id.value,
            search_title.value,
            search_global.value,
            orderColumn.value,
            orderDirection.value
        );
    }
    watch(search_id, (current, previous) => {
        getCategories(
            1,
            current,
            search_title.value,
            search_global.value
        )
    })
    watch(search_title, (current, previous) => {
        getCategories(
            1,
            search_id.value,
            current,
            search_global.value
        )
    })
    watch(search_global, _.debounce((current, previous) => {
        getCategories(
            1,
            search_id.value,
            search_title.value,
            current
        )
    }, 200))
</script>
