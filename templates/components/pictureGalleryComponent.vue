<template>
    <div>
        <div v-if="!updatingTags">
            <div class="content-page">
                <v-container class="border-secondary">
                    <v-row no-gutters class="col-content">
                        <v-col
                            :cols="this.$vuetify.breakpoint.lgAndUp ? 3 : 12"
                        >
                            <div class="center-div">
                                <v-btn
                                    text
                                    color="secondary"
                                    href="/add-pictures"
                                >
                                    <v-icon>
                                        mdi-camera-outline
                                    </v-icon>
                                    <p class="text-info">Ajouter des photos</p>
                                </v-btn>
                            </div>
                        </v-col>
                        <v-col>
                            <div v-if="value==false" class="center-div">
                                <v-btn
                                    v-if="userRoles.length > 0"
                                    text
                                    color="secondary"
                                    @click="managePictureSelection(value)"
                                >
                                    <v-icon>
                                        mdi-checkbox-outline
                                    </v-icon>
                                    <p class="text-info">Sélectionner des photos</p>
                                </v-btn>
                            </div>
                            <div v-else class="center-div">
                                <div v-if="this.$vuetify.breakpoint.lgAndUp">
                                    <v-btn
                                        text
                                        color="secondary"
                                        @click="managePictureSelection(value)"
                                    >
                                        <v-icon>
                                            mdi-checkbox-marked-outline
                                        </v-icon>
                                        <p class="text-info">Annuler la sélection</p>
                                    </v-btn>
                                    <v-btn
                                        v-if="allSelectedValue == false"
                                        text
                                        color="secondary"
                                        @click="selectAll(allSelectedValue)"
                                    >
                                        <v-icon>
                                            mdi-checkbox-multiple-outline
                                        </v-icon>
                                        <p class="text-info">Tout sélectionner</p>
                                    </v-btn>
                                    <v-btn v-else
                                        text
                                        color="secondary"
                                        @click="selectAll(allSelectedValue)"
                                    >
                                        <v-icon>
                                            mdi-checkbox-multiple-blank-outline
                                        </v-icon>
                                        <p class="text-info">Tout désélectionner</p>
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="secondary"
                                        @click="downloadImage()"
                                        :disabled="selectedImages.length === 0"
                                    >
                                        <v-icon>
                                            mdi-download
                                        </v-icon>
                                        <p class="text-info">Téléchager</p>
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="secondary"
                                        @click="updateImageVisibility()"
                                        :disabled="selectedImages.length === 0"
                                    >
                                        <v-icon>
                                            mdi-eye-check-outline
                                        </v-icon>
                                        <p class="text-info">Modifier la visibilité</p>
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="secondary"
                                        @click="updateImageTags()"
                                        :disabled="selectedImages.length === 0"
                                    >
                                        <v-icon>
                                            mdi-tag-outline
                                        </v-icon>
                                        <p class="text-info">Modifier les tags</p>
                                    </v-btn>
                                    <template>
                                        <v-dialog
                                        v-model="dialog"
                                        persistent
                                        max-width="290"
                                        >
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn
                                                    text
                                                    color="secondary"      
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :disabled="selectedImages.length === 0"
                                                >
                                                    <v-icon>
                                                        mdi-trash-can-outline
                                                    </v-icon>
                                                    <p class="text-info">Supprimer les photos</p>
                                                </v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title class="text-h5">
                                                    <p>Supprimer les images sélectionnées ?</p>
                                                </v-card-title>
                                                <v-card-text><p>Après validation, impossible de revenir en arrière...</p></v-card-text>
                                                <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="secondary"
                                                    text
                                                    @click="dialog = false"
                                                >
                                                    Annuler
                                                </v-btn>
                                                <v-btn
                                                    color="secondary"
                                                    text
                                                    @click="deletePicture()"
                                                >
                                                    Supprimer
                                                </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </template>
                                </div>
                                <div v-else>
                                    <v-row>
                                        <v-col class="center-div">
                                            <v-btn
                                                text
                                                color="secondary"
                                                @click="managePictureSelection(value)"
                                            >
                                                <v-icon>
                                                    mdi-checkbox-marked-outline
                                                </v-icon>
                                                <p class="text-info">Annuler la sélection</p>
                                            </v-btn>
                                        </v-col>
                                        <v-col class="center-div"
                                            cols="12"
                                        >
                                            <v-btn
                                            v-if="allSelectedValue == false"
                                            text
                                            color="secondary"
                                            @click="selectAll(allSelectedValue)"
                                            >
                                                <v-icon>
                                                    mdi-checkbox-multiple-outline
                                                </v-icon>
                                                <p class="text-info">Tout sélectionner</p>
                                            </v-btn>
                                            <v-btn v-else
                                                text
                                                color="secondary"
                                                @click="selectAll(allSelectedValue)"
                                            >
                                                <v-icon>
                                                    mdi-checkbox-multiple-blank-outline
                                                </v-icon>
                                                <p class="text-info">Tout désélectionner</p>
                                            </v-btn>
                                        </v-col>
                                        <v-col class="center-div"
                                            cols="12"
                                        >
                                            <v-btn
                                                text
                                                color="secondary"
                                                @click="downloadImage()"
                                                :disabled="selectedImages.length === 0"
                                            >
                                                <v-icon>
                                                    mdi-download
                                                </v-icon>
                                                <p class="text-info">Téléchager</p>
                                            </v-btn>

                                        </v-col>
                                        <v-col class="center-div" cols="12">
                                            <v-btn
                                                text
                                                color="secondary"
                                                @click="updateImageVisibility()"
                                                :disabled="selectedImages.length === 0"
                                            >
                                                <v-icon>
                                                    mdi-eye-check-outline
                                                </v-icon>
                                                <p class="text-info">Modifier la visibilité</p>
                                            </v-btn>
                                        </v-col>
                                        <v-col class="center-div" cols="12">
                                            <v-btn
                                                text
                                                color="secondary"
                                                @click="updateImageTags()"
                                                :disabled="selectedImages.length === 0"
                                            >
                                                <v-icon>
                                                    mdi-tag-outline
                                                </v-icon>
                                                <p class="text-info">Modifier les tags</p>
                                            </v-btn>

                                        </v-col>
                                        <v-col class="center-div">
                                            <template>
                                                <v-dialog
                                                v-model="dialog"
                                                persistent
                                                max-width="290"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn 
                                                            v-if="userRoles.length > 0"
                                                            text
                                                            color="secondary"      
                                                            v-bind="attrs"
                                                            v-on="on"
                                                            :disabled="selectedImages.length === 0"
                                                        >
                                                            <v-icon>
                                                                mdi-trash-can-outline
                                                            </v-icon>
                                                            <p class="text-info">Supprimer les photos</p>
                                                        </v-btn>
                                                    </template>
                                                    <v-card>
                                                        <v-card-title class="text-h5">
                                                            <p>Supprimer les images sélectionnées ?</p>
                                                        </v-card-title>
                                                        <v-card-text><p>Après validation, impossible de revenir en arrière...</p></v-card-text>
                                                        <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn
                                                            color="secondary"
                                                            text
                                                            @click="dialog = false"
                                                        >
                                                            Annuler
                                                        </v-btn>
                                                        <v-btn
                                                            color="secondary"
                                                            text
                                                            @click="deletePicture()"
                                                        >
                                                            Supprimer
                                                        </v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
                                            </template> 
                                        </v-col>
                                    </v-row>
                                </div>
                            </div>
                        </v-col>
                        <v-col
                            :cols="this.$vuetify.breakpoint.lgAndUp ? 3 : 12"
                        >
                            <div class="center-div">
                                <v-autocomplete
                                    ref="tagSearch"
                                    v-model="tagSearch"
                                    :items="tags"
                                    multiple
                                    clearable
                                    label="Rechercher par tag(s)"
                                    placeholder="Exemple"
                                >
                                    <template v-slot:append>
                                        <v-slide-x-reverse-transition>
                                            <v-icon
                                            @click="tagFilter(tagSearch)"
                                            >
                                                mdi-magnify
                                            </v-icon>
                                        </v-slide-x-reverse-transition>
                                    </template>
                                </v-autocomplete>
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </div>

            <v-alert
                v-if="showAlertBool"
                border="left"
                color="green"
                dismissible
                elevation="2"
                type="success"
                class="ma-10"
            >
                Vos photos ont bien été ajouté à l'album photos! Merci de votre contribution.
            </v-alert>
            
            <v-row class="mt-10 pr-10 pl-10">
                <v-col v-if="data.length === 0" class="d-flex justify-center">
                    <v-progress-circular indeterminate color="secondary"></v-progress-circular>
                </v-col>
                
                <v-col v-else-if="entries.length > 0 && !(userRoles.length > 0)"
                    v-for="(imageWithTag,index) in entries"
                    :key="index"
                    class="d-flex child-flex parent-content"
                    cols="6" md="4" lg="3"
                >
                    <v-img
                        v-if="imageWithTag.visibility === true"
                        :src="imageWithTag.img"
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                        <div v-if="imageWithTag.tags.length > 0" class="tags-content">
                            <p v-for="tag in imageWithTag.tags"><span> #{{ tag.name }}&nbsp; </span></p>
                        </div>
                    </v-img>
                    <div v-if="value === true" class="child-content without-visibility">
                        <v-checkbox
                        class="checkbox-style"
                        v-model="selectedImages"
                        :value="imageWithTag"
                        color="secondary"
                        ></v-checkbox>
                    </div>
                </v-col>
                <v-col v-else-if="!(userRoles.length > 0)"
                    v-for="item in data"
                    :key="item.id"
                    class="d-flex child-flex parent-content"
                    cols="6" md="4" lg="3"
                >
                    <v-img
                        v-if="item.visibility === true"
                        :src="item.img"
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                        <div v-if="item.tags.length > 0" class="tags-content">
                            <p v-for="tag in item.tags"><span> #{{ tag.name }}&nbsp; </span></p>
                        </div>
                    </v-img>
                    <div v-if="value === true" class="child-content without-visibility">
                        <v-checkbox
                        class="checkbox-style"
                        v-model="selectedImages"
                        :value="item"
                        color="secondary"
                        ></v-checkbox>
                    </div>
                </v-col>

                <v-col v-else-if="entries.length > 0 && userRoles.length > 0"
                    v-for="(imageWithTagandUser,findex) in entries"
                    :key="findex"
                    class="d-flex child-flex parent-content"
                    cols="6" md="4" lg="3"
                >
                    <v-img
                        :src="imageWithTagandUser.img"
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                        <div v-if="imageWithTagandUser.tags.length > 0" class="tags-content">
                            <p v-for="tag in imageWithTagandUser.tags"><span> #{{ tag.name }}&nbsp; </span></p>
                        </div>
                    </v-img>
                    <div v-if="value === true" class="child-content with-visibility">
                        <v-checkbox
                        class="checkbox-style"
                        v-model="selectedImages"
                        :value="imageWithTagandUser"
                        color="secondary"
                        ></v-checkbox>
                        <v-icon class="visibility-icon" v-if="imageWithTagandUser.visibility === true">
                            mdi-eye-outline
                        </v-icon>
                        <v-icon class="visibility-icon" v-else-if="imageWithTagandUser.visibility === false">
                            mdi-eye-off-outline
                        </v-icon>
                    </div>
                </v-col>
                <v-col v-else-if="userRoles.length > 0"
                    v-for="(item,i) in data"
                    :key="i"
                    class="d-flex child-flex parent-content"
                    cols="6" md="4" lg="3"
                >
                    <v-img
                        :src="item.img"
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                        <div v-if="item.tags.length > 0" class="tags-content">
                            <p v-for="tag in item.tags"><span> #{{ tag.name }}&nbsp; </span></p>
                        </div>
                    </v-img>
                    <div v-if="value === true" class="child-content with-visibility">
                        <v-checkbox
                        class="checkbox-style"
                        v-model="selectedImages"
                        :value="item"
                        color="secondary"
                        ></v-checkbox>
                        <v-icon class="visibility-icon" v-if="item.visibility === true">
                            mdi-eye-outline
                        </v-icon>
                        <v-icon class="visibility-icon" v-else-if="item.visibility === false">
                            mdi-eye-off-outline
                        </v-icon>
                    </div>
                </v-col>
            </v-row>

            <div class="mt-10 mb-10 center-div">
                <v-btn
                    color="secondary"
                    :loading="loadingNextPictures"
                    @click="getPictures(lastPictureId)"
                    v-if="this.data.length !== 0"
                >
                    Charger plus de photos
                </v-btn>
            </div>
        </div>
        <div v-else class="content-page">
            <div class="pa-10">
                <v-btn 
                    @click="updatingTags = false"
                    color="secondary" class="ma-auto mt-5"
                >
                    Retour
                </v-btn>
            </div>
            <div v-for="item in selectedImages">
                <div v-if="$vuetify.breakpoint.lgAndUp">
                    <v-row>
                        <v-col cols="6">
                            <div class="center-div">
                                <img width="300" aspect-ratio="16/9" cover :src="item.img" alt="Photo à ajouter"/>
                            </div>
                        </v-col>
                        <v-col cols="6">
                            <div class="center-div">
                                <v-textarea
                                v-model="item.newTags"
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
                                <img width="300" aspect-ratio="16/9" cover :src="item.img" alt="Photo à ajouter"/>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <div class="center-div">
                                <v-textarea
                                v-model="item.newTags"
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
                    @click="sendUpdateImageTags"
                    :loading="updatingTagsLoading"
                >
                    Modifier
                </v-btn>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "pictureGalleryComponent",
    props:['userRoles'],
    data() {
        return {
            data: [],
            lastPictureId: 0,
            loadingNextPictures: false,
            updatingTags: false,
            updatingTagsLoading: false,
            value: false,
            selectedImages: [],
            tags: [],
            tagSearch:"",
            entries:[],
            dialog:false,
            allSelectedValue : false,

            
            showAlertBool: false
        };
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
    mounted() {
        this.getPictures(this.lastPictureId);
    },
    methods: {
        getPictures(id) {
            const axios = require('axios');
            this.loadingNextPictures = true;

            axios.get('/get_pictures/' + id, {
                params: {
                    roles: this.userRoles
                }
            }).then((response) => {
                let responseData = JSON.parse(response.data);

                responseData.forEach(element => {
                    this.data.push(element);
                    this.lastPictureId = element.id;
                });

                this.loadingNextPictures = false;
                this.getAllTags();
            }).catch((error) => {
                console.log(error);
                this.loadingNextPictures = false;
            });
        },

        managePictureSelection(value){
            this.value = !value;
            this.selectedImages = [];
        },

        async downloadImage() {
            this.selectedImages.forEach(async selectedImage => {
                const blob = await (await fetch(selectedImage.img)).blob();
                const url = URL.createObjectURL(blob);
                Object.assign(document.createElement('a'), { href: url, download: 'claire-et-maxime-photo-'+selectedImage.id+'.jpg' })
                    .click();
                URL.revokeObjectURL(url);
            });

        },

        selectAll(allSelectedValue){
            this.allSelectedValue = !allSelectedValue;
            if(this.allSelectedValue){
                this.data.forEach(img => {
                if(!this.selectedImages.includes(img))
                    this.selectedImages.push(img);
                });
            }
            else{
                this.selectedImages = [];
            }
            console.log(this.selectedImages);
            
        },

        updateImageVisibility(){
            const axios = require('axios');
            
            this.selectedImages.forEach(selectedImage => {
                selectedImage.visibility = !selectedImage.visibility;
                
            });
            
            console.log(this.selectedImages);

            axios.put('/update_pictures_visibility', this.selectedImages)
            .then(function (response) {
                console.log(response);
            }).catch((error) => {
                this.errorData = error;
                console.log(error);
            });
        },

        updateImageTags(){
            this.selectedImages.forEach((element) => {
                let str = "";
                for (let i = 0; i < element.tags.length; i++) {
                    if (i === element.tags.length - 1) {
                        str += (element.tags[i].name);
                    } else {
                        str += (element.tags[i].name + ", ");
                    }
                }
                element.newTags = str;
            });

            this.updatingTags = true;
        },

        sendUpdateImageTags() {
            const axios = require('axios');

            this.updatingTagsLoading = true;

            axios.put('/update_pictures_tags', this.selectedImages)
            .then((response) => {
                this.updatingTagsLoading = false;
                window.location.href = "/pictures";
            }).catch((error) => {
                this.updatingTagsLoading = false;
                this.errorData = error;
                console.log(error);
            });
        },

        deletePicture() {
            const axios = require('axios');

            this.updatingTagsLoading = true;
            axios({
                method: 'delete',
                url: '/delete_pictures',
                data: this.selectedImages
            }).then((response) => {
                this.updatingTagsLoading = false;
                window.location.href = "/pictures";
            }).catch((error) => {
                this.updatingTagsLoading = false;
                this.errorData = error;
                console.log(error);
            });
        },

        getAllTags(){
            this.data.forEach(item => {
                if(item.tags.length > 0) {
                    item.tags.forEach(tag => {
                        if(!this.tags.includes(tag.name)){
                            this.tags.push(tag.name);
                        }
                    });
                }
            });
        },

        async tagFilter(tagSearch){
            this.selectedImages = [];
            this.entries = [];
            this.data.forEach(item => {
                if(item.tags.length > 0) {
                    item.tags.forEach(tag => {
                        if(tagSearch.includes(tag.name)){
                            this.entries.push(item);
                        }
                    });
                }
            });
        }
    },
    computed: {
        imgCols() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs':
                    return 2
                case 'sm':
                    return 2
                case 'md':
                    return 3
                case 'lg':
                    return 4
                case 'xl':
                    return 4
                default :
                    return 3
            }
        }
    }
}
</script>

<style lang="scss">

.border-secondary {
    border: 2px solid #9F9377;
}

.col-content {
    align-items: baseline;
}

.v-autocomplete .v-input__slot {
    width: 60%;
    margin-right: auto;
    margin-left: auto;
    margin-top: 0px;
}

.text-info {
    color: #9F9377;
    padding-left: 5%;
}

.parent-content {
    position: relative;
}

.tags-content{
    position: absolute;
    width: 100%;
    height: 50px;
    background-color: rgb(0,0,0,60%);
    color: white;
    margin-top: 90%;
    display: flex;
    justify-content: center;

    @media screen and (max-width: 960px) {
        height: 80px;
        margin-top: 80%;
        font-size: small;
    }
    
}

.parent-content .child-content {
    position: absolute;
    display: flex;
    justify-content:center;
    background-color: white;
    height: 35px;
}

.parent-content .child-content .with-visibility {
    width: 110px;
}

.parent-content .child-content .without-visibility {
    width: 50px;
    border-radius: 4px;
}

.visibility-icon{
    margin-left: 10%;
    font-size: 40px !important;
    color: #9F9377 !important;
    margin-bottom: 8%;
}

.v-input--checkbox .v-icon {
    font-size: 50px;
    color: #9F9377;
    margin-left: 2px;
}

.v-input--selection-controls{
    margin-top: 0px !important;
}

.v-autocomplete .v-icon {
    color: #9F9377;
}

.margin-page {
    margin: 0px 8%;
}

</style>