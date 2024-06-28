<template>
    <v-app>
        <appbarcomponent :user-roles="userRoles"/>
        <div :style="cssVar">
            <titlecomponent title="Promesse de don"/>
        </div>
        <div class="pa-10" v-if="this.$vuetify.breakpoint.lgAndUp">
            <v-btn
            href="/presents"
            color="secondary"
            >
                Retour
            </v-btn>
            <div class="flex-column">
                <p class="center-div text-p">Vous souhaitez faire une promesse de don pour le cadeau <strong style="font-weight: bold; padding-left:5px;"> "{{ present.name }}"</strong>.</p>
                <p class="center-div text-p">Il reste encore une somme de <strong style="font-weight: bold; padding: 0px 5px;"> {{ new Intl.NumberFormat('fr-FR').format(present.price - present.totalAmount) }} euros </strong> à verser en don.</p>
            </div>
        </div>

        <div v-else class="content-page">
            <v-btn
            href="/presents"
            color="secondary"
            class="mt-5 mb-5"
            >
                Retour
            </v-btn>
            <div class="center-div" style="flex-flow: column nowrap;">
                <p style="">Vous souhaitez faire une promesse de don pour le cadeau <strong style="font-weight: bold; padding-left:5px;"> "{{ present.name }}"</strong>.</p>
                <p style="">Il reste encore une somme de <strong style="font-weight: bold; padding: 0px 5px;"> {{ new Intl.NumberFormat('fr-FR').format(present.price - present.totalAmount) }} euros </strong> à verser en don.</p>
            </div>
        </div>

        <div  v-if="this.$vuetify.breakpoint.lgAndUp" class="pa-10 d-flex flex-column footer-margin content-page">
            <v-form v-model="isFormValid">
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="6" class="center-div">
                            <img style="max-width:300px" :src="`${publicPath}/img/presents/`+ present.img" :alt="'Photo du cadeau : ' + present.name"/>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                label="Nom, Prénom"
                                :rules="nameRules"
                                hide-details="auto"
                                v-model="data.name"
                                prepend-icon="mdi-account"
                                color="secondary"
                            ></v-text-field>
                            <v-text-field
                                label="Email"
                                :rules="emailRules"
                                hide-details="auto"
                                v-model="data.email"
                                prepend-icon="mdi-email"
                                color="secondary"
                            ></v-text-field>
                            <v-text-field
                                label="Montant du don"
                                :rules="donationAmountRules"
                                hide-details="auto"
                                v-model="data.donationAmount"
                                prepend-icon="mdi-currency-eur"
                                color="secondary"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                
                <v-textarea
                v-model="data.message"
                prepend-icon="mdi-text-box-outline"
                color="secondary"
                >
                    <template v-slot:label>
                        <div>
                            Message <small>(optionel)</small>
                        </div>
                    </template>
                </v-textarea>
            </v-form>
            <v-btn 
                :disabled="!isFormValid" 
                :loading="loading"
                @click="sendData" 
                color="secondary" class="ma-auto mt-5"
            >
                Envoyer
            </v-btn>
        </div>

        <div v-else class="footer-margin content-page">
            <v-form v-model="isFormValid">
                <div class="mt-5">
                    <img style="max-width:100%" :src="`${publicPath}/img/presents/`+ present.img" :alt="'Photo du cadeau : ' + present.name"/>
                </div>
                <v-text-field
                    label="Nom, Prénom"
                    :rules="nameRules"
                    hide-details="auto"
                    v-model="data.name"
                    prepend-icon="mdi-account"
                    color="secondary"
                ></v-text-field>
                <v-text-field
                    label="Email"
                    :rules="emailRules"
                    hide-details="auto"
                    v-model="data.email"
                    prepend-icon="mdi-email"
                    color="secondary"
                ></v-text-field>
                <v-text-field
                    label="Montant du don"
                    :rules="donationAmountRules"
                    hide-details="auto"
                    v-model="data.donationAmount"
                    prepend-icon="mdi-currency-eur"
                    color="secondary"
                ></v-text-field>
                <v-textarea
                v-model="data.message"
                prepend-icon="mdi-text-box-outline"
                color="secondary"
                >
                    <template v-slot:label>
                        <div>
                            Message <small>(optionel)</small>
                        </div>
                    </template>
                </v-textarea>
            </v-form>
            <v-btn 
                :disabled="!isFormValid" 
                :loading="loading"
                @click="sendData" 
                color="secondary" class="ma-auto mt-5 center-div"
            >
                Envoyer
            </v-btn>
        </div>
        <footercomponent/>
    </v-app>
</template>
<script>
export default {
    name: "donationPromiseForm",
    
    props:['present', 'userRoles'],
    data() {
        return {
            publicPath: window.location.origin,
            nameRules: [
                value => !!value || 'Requis.',
            ],
            emailRules: [
                value => {
                if (value) return true

                return 'E-mail Requis.'
                },
                value => {
                if (/.+@.+\..+/.test(value)) return true

                return 'E-mail invalide.'
                },
            ],
            limitDonation: this.present.price - this.present.totalAmount,
            donationAmountRules: [
                value => value => /^[0-9]+$/.test(value) || 'Entrez uniquement des chiffres',
                value => {
                if (value <= this.limitDonation) return true

                return 'Donation trop élevée.'
                },
            ],
            isFormValid: false,
            loading: false,
            data: {
                name: "",
                email: "",
                donationAmount: "",
                message: "",
                presentId: null,
            },
        };
    },
    methods: {
        sendData() {
            const axios = require('axios');
            this.loading = true;

            this.data.presentId = this.present.id;

            axios.post('/post_donationpromise', this.data)
            .then((response) => {
                this.loading = false;
                window.location.href = "/presents?status=success";
            }).catch(function (error) {
                console.log(error);
            });
        }
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
}
</script>

<style lang="scss">

.text-p {
    margin-bottom: 0px !important;
}

.color-button {
    color: white !important;
}

</style>
