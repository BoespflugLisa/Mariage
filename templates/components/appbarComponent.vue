<template>
    <div>
        <v-app-bar
        app
        elevation="4"
        color="white"
        prominent short
        id="app-bar"
        >
            <div v-if="$vuetify.breakpoint.xs" style="width: 48px;"></div>
            <div v-else style="width: 52px;"></div>
            <div class="d-flex justify-center ma-auto" style="width: 100%">
                <countdown v-if="showTimer" :time="time">
                    <template slot-scope="props">
                        <div class="d-flex justify-center">
                            <timecard :time="props.days" longtext="Jours" shorttext="J"/>
                            <timecard :time="props.hours" longtext="Heures" shorttext="H"/>
                            <timecard :time="props.minutes" longtext="Minutes" shorttext="M"/>
                            <timecard :time="props.seconds" longtext="Secondes" shorttext="S"/>
                        </div>
                    </template>
                </countdown>
                
            </div>
            
            <v-btn icon @click="dialog = !dialog" :x-large="!$vuetify.breakpoint.xs" class="ma-auto">
                <v-icon>
                    mdi-menu
                </v-icon>
            </v-btn>
        </v-app-bar>

        <div>
            <v-dialog
                v-model="dialog"
                max-width="100%"
                >
                <v-card class="nav-bar">
                    <v-card-text>
                        <v-list class="nav-bar">
                            <v-list-item-group v-if="this.$vuetify.breakpoint.lgAndUp"
                            >
                                <v-list-item>
                                    <v-list-item-title><p><a href="/">ACCUEIL</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-title><p><a href="/presents">LISTE DES CADEAUX</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-title><p><a href="/pictures">ALBUM PHOTOS</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="userRoles.includes('ROLE_SUPERADMIN') || userRoles.includes('ROLE_ADMIN')">
                                    <v-list-item-title><p><a href="/admin">ADMINISTRATION</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="userRoles.includes('ROLE_SUPERADMIN') || userRoles.includes('ROLE_ADMIN')">
                                    <v-list-item-title><p><a href="/logout">DÉCONNEXION</a></p></v-list-item-title>
                                </v-list-item>
                            </v-list-item-group>

                            <v-list-item-group v-else
                            >
                                <v-list-item class="list-items">
                                    <v-list-item-title><p><a href="/">ACCUEIL</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item class="list-items">
                                    <v-list-item-title><p><a href="/presents">LISTE DES CADEAUX</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item class="list-items">
                                    <v-list-item-title><p><a href="/pictures">ALBUM PHOTOS</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item class="list-items" v-if="userRoles.includes('ROLE_SUPERADMIN') || userRoles.includes('ROLE_ADMIN')">
                                    <v-list-item-title><p><a href="/admin">ADMINISTRATION</a></p></v-list-item-title>
                                </v-list-item>

                                <v-list-item class="list-items" v-if="userRoles.includes('ROLE_SUPERADMIN') || userRoles.includes('ROLE_ADMIN')">
                                    <v-list-item-title><p><a href="/logout">DÉCONNEXION</a></p></v-list-item-title>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                    </v-card-text>
                    
                </v-card>
            </v-dialog>
        </div>
    </div>
    
</template>

<script>
export default {
    name: "AppbarComponent",
    props:['userRoles'],
    data() {
        return {
            time: null,
            showTimer: false,
            dialog: false,
        };
    },
    created() {
        const now = new Date();
        const wendingDate = new Date('May 11, 2024 15:00:00');
        if (now < wendingDate) {
            this.time = wendingDate - now;
            this.showTimer = true;
        }
    },
}
</script>
        
<style scoped>
.v-application a {
    color: white!important;
}

.v-application p {
    margin-bottom: 0px !important;
}
.nav-bar {
    background-color: #ACCCBD !important;
    text-align: center !important;
}


.list-items.v-list-item{
    padding: 5% 0% !important;
}

</style>