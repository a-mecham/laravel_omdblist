<template>
    <div>
        <h3 class="text-center">Favorite Movies List</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>Title</th>
                <th>Year</th>
                <th>Release Date</th>
                <th>Runtime</th>
                <th>Genre</th>
                <th>Director</th>
                <th>Writer</th>
                <th>Plot</th>
                <th>Language</th>
                <th>Actors</th>
                <th>Awards</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="entry in data" :key="entry.IMDbID">
                <td>{{ entry.Poster }}</td>
                <td>{{ entry.Type }}</td>
                <td>{{ entry.Title }}</td>
                <td>{{ entry.Year }}</td>
                <td>{{ entry.Released }}</td>
                <td>{{ entry.Runtime }}</td>
                <td>{{ entry.Genre }}</td>
                <td>{{ entry.Director }}</td>
                <td>{{ entry.Writer }}</td>
                <td>{{ entry.Plot }}</td>
                <td>{{ entry.Language }}</td>
                <td>{{ entry.Actors }}</td>
                <td>{{ entry.Awards }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deletePost(entry.IMDbID)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            list:[],
            favorites: []
        }
    },
    created() {
        this.axios
            .get('http://localhost:8001/favorites')
            .then(response => {
                this.list = response.data;
            });
    },
    methods: {
        deletePost(id) {
            this.axios
                .delete(`http://localhost:8001/favorites/delete/${id}`)
                .then(response => {
                    let i = this.list.map(item => item.IMDbID).indexOf(id); // find index of your object
                    this.list.splice(i, 1)
                });
        }

    }
}
</script>
