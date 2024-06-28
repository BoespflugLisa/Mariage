<template>
    <v-app>
        <appbarcomponent :user-roles="userRoles"/>
        <div class="d-flex justify-center align-center content-page main-img appbar-margin">
            <v-img 
                contain
                src="img/logo.png"
                width="100%"
                max-width="500px"
            />
        </div>

        <div class="d-flex flex-wrap pt-5 pb-5 content content-page space-container"> 
            
            <homecarouselcomponent/>
            
            <div class="d-flex flex-column align-center mt-auto mb-auto pt-10 pb-10 text-display">
                
                <p>Chers amis, familles et bien-aimés,</p>
                <p class="mt-5 text-center">
                    C'est avec un immense plaisir que nous vous invitons à partager un moment de joie - notre mariage. 
                    Un chapitre d'amour, de complicité et de bonheur qui se dessine, et nous sommes ravis de vous avoir à nos côtés pour célébrer notre union.
                </p>
                <p class="mt-5 text-center">
                    En explorant ce site, vous découvrirez tous les détails, les informations pratiques et notre liste de mariage pour préparer cette fête. 
                </p>
                <p class="mt-5 mb-5 text-center">
                    Dans un second temps nous rendrons disponible une galerie photo ou tout le monde pourra venir partager ses meilleurs clichés.
                </p>
                <v-img 
                    src="img/plant_line.png"
                    contain
                    :max-width="$vuetify.breakpoint.mdAndUp ? '300px' : '250px'"
                />
            </div>
        </div>

        <titlecomponent v-if="showMosaique" title="Mosaïque"/>

        <div v-if="showMosaique" class="pt-5 pb-5 content content-page space-container">
            <v-img
                src="img/mosaique.jpg"
                contain
            />
            <p class="mb-0 mt-5">Pour télécharger la mosaïque cliquez <span class="dowload-btn" @click="downloadMosaique">ici</span>. Attention le fichier est volumineux! (51 Mo)</p>
        </div>

        <titlecomponent title="Cèrèmonie"/>

        <v-row no-gutters class="content content-page">
            <v-col 
                class="d-flex justify-center" 
                sm="12" md="6" lg="4"
            >
                <ellipseweddingdate class="ma-5"/> 
            </v-col>
            <v-col 
                class="d-flex justify-center"
                sm="12" md="6" lg="4"
            >
                <div class="ma-5" style="display: block;">
                    <v-img
                        src="img/eglise.jpg"
                        contain 
                        width="300"
                        class="ma-auto"
                    />
                    <maplinkcomponent placeName="Eglise St Pierre aux liens" city="Moulins-lès-Metz" link="https://maps.app.goo.gl/pZUTrFUhW1jWirdMA"/>
                </div>
            </v-col>
            <v-col 
                class="d-flex justify-center align-center"
                md="12" lg="4"
            >
                <p class="hour-text text-shadow-10">15H</p>
            </v-col>
        </v-row>
        
        <titlecomponent title="Cocktail"/>

        <div class="pt-5 pb-5 footer-margin content-page">
            <v-img
                src="img/salle.png"
                contain 
                width="300"
                class="ml-auto mr-auto"
            />
            <maplinkcomponent placeName="Salle Sophie de Bar" city="Mousson" link="https://maps.app.goo.gl/b9kTueqsepLDFmtKA"/>
        </div>

        <footercomponent/>
    </v-app>
</template>
    
<script>
export default {
    name: "Home",
    props:['userRoles'],
    data() {
        return {
            showMosaique: false,
        };
    },
    created() {
        const now = new Date();
        const showMosaiqueDate = new Date('May 11, 2024 00:00:01');

        if (now > showMosaiqueDate)
            this.showMosaique = true;
    },
    methods: {
        downloadMosaique() {
            var imageUrl = 'img/mosaique_hd.jpg';
            var a = document.createElement('a');
            a.href = imageUrl;
            a.download = 'mosaique_hd.jpg';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    }
};
</script>
    
<style scoped lang="scss">
.main-img {
    height: 90vh;
}
.content {
    margin-bottom: 5%;
}
.space-container {
    justify-content: space-around;
}

.text-display {
    @media screen and (min-width: 1264px) {
        max-width: 500px;
    }
}


.hour-text {
    font-family: 'the_smileregular'!important;
    color: #9F9377;
    font-weight: 100;
    font-size: 8rem;
}

.text-shadow-10 {
    text-shadow: 10px 10px rgba(159, 147, 119, 0.5);
}

.dowload-btn {
    color: #ACCCBD;
    text-decoration: underline;
    transition: color .5s;
}

.dowload-btn:hover {
    cursor: pointer;
    color: #5ca885;
}

</style>