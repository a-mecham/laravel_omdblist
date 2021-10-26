<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OMDB Favorites List
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <button @click="search()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Find Movie</button>
                    <table class="table-fixed w-full">
                        <tbody>
                        <tr v-for="row in data">
                            <td class="border px-4 py-2 w-60">
                                <img v-bind:src=row.Poster height="160px">
                                <br><strong>{{ row.Title }}</strong>
                                <br>Release Date: {{ row.Released }}
                                <br>Run Time: {{ row.Runtime }}
                            </td>
                            <td class="border px-4 py-2"><strong>{{ row.Title }}</strong> - {{ row.Year }}
                                <br>{{ row.Type }} - {{ row.Genre }}
                                <br>Writen By: {{ row.Writer }}<br>Director: {{ row.Director }}<br>
                                <p>{{ row.Plot }}</p>
                                <p>{{ row.Actors }}</p>
                                <p>{{ row.Awards }}</p>
                                Language: {{ row.Language }}
                                <!-- <div>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </div> -->
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from './../Layouts/AppLayout'
import Welcome from './../Jetstream/Welcome'
export default {
    components: {
        AppLayout,
        Welcome,
    },
    props: ['data', 'errors'],
    data() {
        return {

            form: {
                UID: null,
                IMDbID: null,
            },
        }
    },
    methods: {
        search: function () {
            this.$inertia.get('/search');
        },

        deleteRow: function (data) {
            data._method = 'DELETE';
            this.$inertia.post('/favorites/' + data.id, data)
        }
    }
}
</script>
