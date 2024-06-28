<template>
    <v-footer
        color="primary"
        padless absolute
    >
        <v-row
            justify="center"
            no-gutters
            class="mb-4"
        >
            <v-col
                class="primary py-4 text-center white--text"
                cols="12"
            >
                <p><strong>Contact : Maxime et Claire</strong></p>
            </v-col>

            <v-col
                class="primary text-center white--text d-flex justify-center py-4"
                xl="4"
                lg="4"
                md="12"
                sm="12"
                xs="12"
            >
                <v-icon dark x-large class="mr-5">mdi-home</v-icon>
                <div class="text-center">
                    <p class="ma-0">17 rue André Malraux 57190</p>
                    <p class="ma-0">Florange</p>
                </div>
            </v-col>

            <v-col
                class="primary text-center white--text d-flex justify-center py-4"
                xl="4"
                lg="4"
                md="12"
                sm="12"
                xs="12"
            >
                <v-icon dark x-large class="mr-5">mdi-phone</v-icon>
                <div class="d-flex justify-center">
                    <p class="my-auto">06.49.69.18.35</p>
                </div>
            </v-col>

            <v-col
                class="primary text-center white--text d-flex justify-center py-4"
                xl="4"
                lg="4"
                md="12"
                sm="12"
                xs="12"
            >
                <v-icon dark x-large class="mr-5">mdi-email</v-icon>
                <div class="d-flex justify-center">
                    <p class="my-auto">schumengc@gmail.com</p>
                </div>
            </v-col>
        </v-row>
    </v-footer>
</template>

<script>
export default {
    name: "FooterComponent",
    
}
</script>

<style lang="scss">

</style>