<template>
    <v-app>
        <appbarcomponent :user-roles="userRoles"/>
        <div :style="cssVar">
            <titlecomponent title="Ajouter des Photos"/>
        </div>

        <div class="pa-10 content-page">
            <v-btn 
                href="/pictures"
                color="secondary" class="ma-auto mt-5"
            >
                Retour
            </v-btn>
        </div>

        <div class="pa-10 d-flex flex-column footer-margin content-page" v-if="formVisibility">
            <v-form v-model="isFormValid">

                <v-text-field
                    label="Nom Prénom"
                    :rules="nameRules"
                    hide-details="auto"
                    v-model="data.publisher"
                    prepend-icon="mdi-account"
                    color="secondary"
                ></v-text-field>

                <v-file-input
                    class="mt-5"
                    accept="image/*"
                    label="Photos"
                    :rules="picturesRules"
                    chips
                    counter
                    multiple
                    v-model="chosenFiles"
                    color="secondary"
                ></v-file-input>

            </v-form>

            <v-btn 
                :disabled="!isFormValid" 
                :loading="loading"
                @click="importImages" 
                color="secondary" class="ma-auto mt-5"
            >
                Suivant
            </v-btn>
        </div>

        <div v-else class="footer-margin content-page">
            <div v-for="item in data.pictures">
                <div v-if="$vuetify.breakpoint.lgAndUp">
                    <v-row>
                        <v-col cols="6">
                            <div class="center-div">
                                <img width="300" aspect-ratio="16/9" cover :src="item.image" alt="Photo à ajouter"/>
                            </div>
                        </v-col>
                        <v-col cols="6">
                            <div class="center-div">
                                <v-textarea
                                v-model="item.tags"
                                color="secondary"
                                >
                                    <template v-slot:label>
                                        <div>
                                            Tags <small>(optionel)</small>
                                        </div>
                                    </template>
                                </v-textarea>
                            </div>
                        </v-col>
                    </v-row>
                </div>
                <div v-else> 
                    <v-row>
                        <v-col cols="12">
                            <div class="center-div">
                                <img width="300" aspect-ratio="16/9" cover :src="item.image" alt="Photo à ajouter"/>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <div class="center-div">
                                <v-textarea
                                v-model="item.tags"
                                color="secondary"
                                >
                                    <template v-slot:label>
                                        <div>
                                            Tags <small>(optionel)</small>
                                        </div>
                                    </template>
                                </v-textarea>
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </div>
            <div class="mt-10 center-div">
                <v-btn
                    color="secondary"
                    class="color-button"
                    @click="sendData"
                    :loading="sendDataLoading"
                >
                    Envoyer
                </v-btn>

                <div class="mt-10">
                    <p>{{ errorData }}</p>
                </div>
            </div>
            
        </div>
        
        <footercomponent/>
    </v-app>
</template>

<script>
export default {
    name: "addPicturesView",
    props:['userRoles'],
    data() {
        return {
            nameRules: [
                value => !!value || 'Requis.',
            ],
            picturesRules: [
                value => value.length <= 5 || 'Maximum 5 photos.',
            ],
            isFormValid: false,
            formVisibility: true,
            loading: false,
            sendDataLoading: false,
            errorData: "",
            chosenFiles: null,
            data: {
                publisher: "",
                pictures: []
            },
        };
    },
    computed: {
        cssVar() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs':
                    return {
                    'padding-top': 200 + 'px',
                    }
                case 'sm':
                    return {
                    'padding-top': 200 + 'px',
                    }
                case 'md':
                    return {
                    'padding-top': 150 + 'px',
                    }
                case 'lg':
                    return {
                    'padding-top': 100 + 'px',
                    }
                case 'xl':
                    return {
                    'padding-top': 100 + 'px',
                    }
                default :
                    return {
                    'padding-top': 100 + 'px',
                    }
            }
        }
    },
    methods: {
        async importImages() {
            if (this.chosenFiles !== null && this.chosenFiles.length > 0) 
            {
                this.loading = true;
                console.log("Nb img : " + this.chosenFiles.length)
                for (let i = 0; i < this.chosenFiles.length; i++) {
                    this.readFile(this.chosenFiles[i]).then((res) => {
                        let obj = { image : res, tags: "" }
                        this.data.pictures.push(obj);
                    })
                }
                this.formVisibility = false;
                this.loading = false;
            }
        },

        readFile(file) {
            return new Promise((resolve, reject) => {
                var reader = new FileReader();
                
                reader.onload = () => {
                    resolve(reader.result);
                }

                reader.onerror = reject;

                reader.readAsDataURL(file);
            })
        },

        sendData() {
            this.sendDataLoading = true;
            const axios = require('axios');

            console.log(this.data);

            axios.post('/post_pictures', this.data)
            .then(function (response) {
                console.log(response);
                window.location.href = "/pictures?status=success";
            }).catch((error) => {
                this.sendDataLoading = false;
                this.errorData = error;
                console.log(error);
            });
        }
    }
}
</script>

<style lang="scss">

.v-application p {
    margin-bottom: 0px !important;
}

.color-button {
    color: white !important;
}

</style>