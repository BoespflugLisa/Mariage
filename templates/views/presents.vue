<template>

    <v-app>
        <appbarcomponent :user-roles="userRoles"/>
        <div class="appbar-margin">
            <titlecomponent title="Liste des Cadeaux"/>
        </div>

        <v-alert
            v-if="showAlertBool"
            border="left"
            color="green"
            dismissible
            elevation="2"
            type="success"
            class="ml-10 mr-10"
        >
            Votre promesse de don a bien été prise en compte ! Merci pour votre participation.
        </v-alert>

        <v-data-table
            v-if="this.$vuetify.breakpoint.lgAndUp"
            :headers="headers"
            :items="availablepresents"
            class="footer-margin content-page">

            <template v-slot:item.img="{ item }">
                <div>
                    <img style="max-width:100px" :src="'img/presents/'+ item.img" :alt="'Photo du cadeau : ' + item.name"/>
                </div>
            </template>

            <template v-slot:item.name="{ item }">
                <div v-if="item.link !== null" class ="bold-text">
                    <a style="color: black;" :href="item.link" target="_blank">{{item.name}}</a>
                </div>
                <div v-else  class ="bold-text">
                    {{item.name}}
                </div>
            </template>

            <template v-slot:item.price="{ item }">
                <div>
                    {{item.price}} €
                </div>
            </template>

            <template v-slot:item.progression="{ item }">
                <div class="progress present-progressbar" role="progressbar" :aria-valuenow="item.totalAmount" aria-valuemin="0" aria-valuemax="100">
                    <div v-if="item.totalAmount === 0">
                        <div class ="bold-text" style="padding-left: 2%;">{{item.totalAmount}} €</div>
                    </div>
                    <div v-else style="height: 100%; position: relative;">
                        <div class ="progression-text">{{item.totalAmount}} €</div>
                        <div  class="progress-bar present-progression" :style="'width:' + item.progression + '%'"></div>
                    </div>
                </div>
            </template>

            <template v-slot:item.id="{ item }">
                <v-btn 
                    :disabled="item.totalAmount === item.price ? true : false" 
                    color="secondary" :href="'/presents/'+ item.id +'/donation-promise-form'" 
                    rounded outlined
                >
                    <v-icon color="secondary">
                        mdi-piggy-bank-outline
                    </v-icon>
                </v-btn>
            </template>
        </v-data-table>

        <div class="footer-margin content-page" v-else>
            <div>
                <v-autocomplete
                    v-model="categorySearch"
                    :items="allcategories"
                    outlined
                    label="Catégories"
                    multiple
                    clearable
                >
                    <template v-slot:append>
                        <v-slide-x-reverse-transition>
                            <v-icon
                                @click="filterByCategory(categorySearch)"
                            >
                                mdi-magnify
                            </v-icon>
                        </v-slide-x-reverse-transition>
                    </template>
                </v-autocomplete>
            </div>
            <div v-if="presesentsFiltered.length > 0 ">
                <div v-for="item in presesentsFiltered">
                    <v-col cols="12">
                        <div>
                            <img style="max-width:100%" :src="'img/presents/'+ item.img" :alt="'Photo du cadeau : ' + item.name"/>
                        </div>
                        <div class="center-div">
                            <div v-if="item.link !== null" class="bold-text">
                                <p>
                                    <a style="color: black;" :href="item.link" target="_blank">{{item.name}}</a> - Catégorie : {{ item.presentCategory !== null ? item.presentCategory.name : 'Divers' }}
                                </p>
                            </div>
                            <div v-else class="bold-text">
                                <p>{{item.name}} - {{ item.presentCategory !== null ? item.presentCategory.name : 'Divers' }}</p>
                            </div>
                        </div>

                        <div class="center-div">
                            <v-col cols="6">
                                <div class="progress present-progressbar-mobile" role="progressbar" :aria-valuenow="item.totalAmount" aria-valuemin="0" aria-valuemax="100">
                                    <div class="center-div" v-if="item.totalAmount === 0">
                                        <p class ="bold-text">{{item.totalAmount}} €</p>
                                    </div>
                                    <div v-else style="height: 100%; position: relative;">
                                        <div class ="progression-text-mobile"> <p>{{item.totalAmount}} €</p></div>
                                        <div  class="progress-bar present-progression" :style="'width:' + item.progression + '%'"></div>
                                    </div>
                                </div>
                            </v-col>
                            <v-col cols="6">
                                <div class="center-div">
                                    <p>{{item.price}} €</p>
                                </div>
                            </v-col>
                        </div>

                        <div class="center-div">
                            <v-btn 
                                :disabled="item.totalAmount === item.price ? true : false" 
                                color="secondary" :href="'/presents/'+ item.id +'/donation-promise-form'" 
                                rounded x-large outlined
                            >
                                <v-icon class="icon-size" color="secondary">
                                    mdi-piggy-bank-outline
                                </v-icon>
                            </v-btn>
                        </div>
                        <mobileDivider/>
                    </v-col>
                </div>
            </div>
            <div v-else>
                <div v-for="item in availablepresents">
                    <v-col cols="12">
                        <div class="center-div">
                            <img style="max-width:100%" :src="'img/presents/'+ item.img" :alt="'Photo du cadeau : ' + item.name"/>
                        </div>
                        <div class="center-div">
                            <div v-if="item.link !== null" class="bold-text">
                                <p>
                                    <a style="color: black;" :href="item.link" target="_blank">{{item.name}}</a> - Catégorie : {{ item.presentCategory !== null ? item.presentCategory.name : 'Divers' }}
                                </p>
                            </div>
                            <div v-else class="bold-text">
                                <p>{{item.name}} - {{ item.presentCategory !== null ? item.presentCategory.name : 'Divers' }}</p>
                            </div>
                        </div>

                        <div class="center-div">
                            <v-col cols="6">
                                <div class="progress present-progressbar-mobile" role="progressbar" :aria-valuenow="item.totalAmount" aria-valuemin="0" aria-valuemax="100">
                                    <div class="center-div" v-if="item.totalAmount === 0">
                                        <p class ="bold-text">{{item.totalAmount}} €</p>
                                    </div>
                                    <div v-else style="height: 100%; position: relative;">
                                        <div class ="progression-text-mobile"> <p>{{item.totalAmount}} €</p></div>
                                        <div  class="progress-bar present-progression" :style="'width:' + item.progression + '%'"></div>
                                    </div>
                                </div>
                            </v-col>
                            <v-col cols="6">
                                <div class="center-div">
                                    <p>{{item.price}} €</p>
                                </div>
                            </v-col>
                        </div>

                        <div class="center-div">
                            <v-btn 
                                :disabled="item.totalAmount === item.price ? true : false" 
                                color="secondary" :href="'/presents/'+ item.id +'/donation-promise-form'" 
                                rounded x-large outlined
                            >
                                <v-icon class="icon-size" color="secondary">
                                    mdi-piggy-bank-outline
                                </v-icon>
                            </v-btn>
                        </div>
                        <mobileDivider/>
                    </v-col>
                </div>
            </div>
        </div>

        <footercomponent/>
    </v-app>

</template>


<script>
export default{
    name:"Present",
    props:['availablepresents', 'allcategories', 'userRoles'],
    data(){
        return {
            headers: [
                { text: 'Cadeau', align: 'center', value: 'img' },
                { text: 'Information', align: 'center', value: 'name' },
                { text: 'Prix', align: 'center', value: 'price' },
                { text: 'Cagnotte', align: 'center', value: 'progression' },
                { text: 'Catégorie', align: 'center', value: 'presentCategory.name' },
                { text: 'Participer ?', align: 'center', value: 'id' },
                ],

            categorySearch:"",
            presesentsFiltered: [],
            showAlertBool: false
        }
    },
    created() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if (urlParams.has('status')) {
            if (urlParams.get('status') === 'success') {
                this.showAlertBool = true;
            }
        } else {
            this.showAlertBool = false;
        }
    },
    methods: {
        async filterByCategory(categorySearch) {
            this.presesentsFiltered = [];
            this.availablepresents.forEach(present => {
                if(categorySearch.includes(present.presentCategory.name)){
                    this.presesentsFiltered.push(present);
                }
            });
        },
    },
    computed: {
    }
}
</script>

<style lang="scss">

.present-progressbar {
    height:30px !important;
    border-radius:15px !important;
    background-color:#fff !important;
    font-size:14px !important;
    border: 2px solid #8671BA !important;
}

.present-progressbar-mobile {
    height:30px !important;
    border-radius:25px !important;
    background-color:#fff !important;
    font-size:14px !important;
    border: 2px solid #8671BA !important;
}

.present-progression {
    border-radius:18px !important;
    position: absolute !important;
    height:100% !important;
    background-color: rgba(134,113,186,0.5) !important;
    padding-left:2% !important;
    color:black !important;
    border: 0px !important;
}


.progression-text{
    font-weight: bold !important;
    position: absolute !important;
    z-index: 1 !important;
    width:100% !important;
    padding: 2%;
}

.progression-text-mobile{
    font-weight: bold !important;
    position: absolute !important;
    z-index: 1 !important;
    width:100% !important;
    text-align: center;
}


.bold-text{
    font-weight: bold !important;
}

.icon-size{
    font-size: 32px !important;
}
</style>