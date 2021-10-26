<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Search
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <form  onsubmit="return false;">
                        <fieldset>
                            <legend>Search for Movies</legend>
                        </fieldset>
                        <div>
                            <label class="control-label" for="t">Movie Title: </label>
                            <input type="text" id="t" name="t" class="input-small py-2 px-4 rounded" v-model="form.t">&nbsp;
                            <button @click="search(form.p)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>&nbsp;
                            <button @click="reset()" class="bg-red-500  hover:bg-red-700  text-white font-bold py-2 px-4 rounded">Reset</button>
                        </div>
                    </form>
                </div>
                <div><br></div>
                <div id="r" class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" v-if="isOpen">
                    <strong>Results:</strong> {{ results }}
                    <table class="table-fixed w-full">
                        <tbody>
                        <tr v-for="row in rdata">
                            <td class="border px-4 py-2 w-20">
                                <img v-bind:src=row.Poster height="20px">
                            </td>
                            <td class="border px-4 py-2"><strong>{{ row.Title }}</strong> - {{ row.Year }}
                                <br>{{ row.Type }}
                                <br>{{ row.Plot }}
                                <div>
                                    <button @click="addFav(row.imdbID)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Favorite</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button @click="backTen()"    class="bg-blue-300 hover:bg-grey-400 text-white font-bold py-2 px-4 rounded right" v-bind:disabled="b10"> &ll; </button>
                                <button @click="back()"       class="bg-blue-300 hover:bg-grey-400 text-white font-bold py-2 px-4 rounded right" v-bind:disabled="b"> &lt; </button>
                                {{ form.p }} of {{ pages }}
                                <button @click="forward()"    class="bg-blue-300 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded right" v-bind:disabled="f"> &gt; </button>
                                <button @click="forwardTen()" class="bg-blue-300 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded right" v-bind:disabled="f10"> &gg; </button>
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
import axios from "axios";
import Vue from 'vue';
export default {
    components: {
        AppLayout,
        Welcome,
    },
    props: ['data', 'errors'],
    data() {
        return {
            isOpen: false,
            b10: true,
            b: true,
            f: true,
            f10: true,
            pages:null,
            results: null,
            rdata: [],
            form: {
                t: null,
                p: '1',
            },
        }
    },
    methods: {
        openRes: function (){
            this.isOpen = true;
            this.$forceUpdate();
        },
        reset: function(){
            this.form = {
                t: null,
                p: '1',
            };
            this.pages = null;
            this.results = null;
            this.isOpen = false;
            this.rdata = false;
        },
        addFav: function(id){
            let currentObj = this;
            console.log(id);
            axios.post('/search/fav/',{imdbID: id})
                .then((res) => console.log(res.data))
                .catch((err) => console.log(err));
        },
        search: function (page) {
            let currentObj = this;
            this.form.p = page;
            axios.get('/search/'+this.form.t+'/'+this.form.p, this.form
            ).then( function(res){
                currentObj.form.p  = res.data['page'];
                currentObj.results = res.data['totalResults'];
                currentObj.rdata   = res.data['Search'];
                currentObj.pages   = res.data['pages'];
                currentObj.openRes();
                if(currentObj.form.p > 1){
                    currentObj.b = false;
                } else {
                    currentObj.b = true;
                }
                if(currentObj.form.p > 11 ) {
                    currentObj.b10 = false;
                }else {
                    currentObj.b10 = true;
                }
                if(currentObj.form.p < currentObj.pages){
                    currentObj.f = false;
                } else{
                    currentObj.f = true;
                }
                if(currentObj.form.p < currentObj.pages-10){
                    currentObj.f10 = false;
                } else{
                    currentObj.f10 = true;
                }


            });
        },
        backTen: function (){
            if(this.form.p > 11) {
                this.form.p = parseInt(this.form.p) - 10;
                this.b10 = false;
            } else {
                this.form.p = 1;
                //disable button
                this.b10 = true;
            }
            this.search(this.form.p);

        },
        back: function (){
            if(this.form.p > 1){
                this.form.p = parseInt(this.form.p)-1;
                this.b = false;
            } else {
                this.form.p = 1;
                //disable button
                this.b = true;
            }
            this.search(this.form.p);
        },
        forward: function (){
            if(this.form.p < parseInt(this.pages)){
                this.form.p = parseInt(this.form.p)+1;
                this.f = false;
            } else {
                this.form.p = parseInt(this.pages);
                //disable button
                this.f = true;
            }
            this.search(this.form.p);

        },
        forwardTen: function (){
            if(this.form.p < parseInt(this.pages)-10){
                this.form.p =  parseInt(this.form.p)+10;
                this.f10 = false;
            } else {
                this.form.p = parseInt(this.pages);
                //disable button
                this.f10 = true;
            }
            this.search(this.form.p);
        },
    },
}
</script>

