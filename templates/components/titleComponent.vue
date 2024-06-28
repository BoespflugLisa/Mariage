<template>
    <div class="d-flex flex-column justify-center align-center pa-5">
        <h2 class="mb-0 main-title-font">
            {{ title }}
        </h2>
        <div v-if="$vuetify.breakpoint.mdAndUp" class="d-flex">
            <div class="pr-7">
                <v-img 
                    :src="`${publicPath}/img/title_border_left.png`"
                    max-width="300px"
                    contain
                />
            </div>
            <div class="pl-7">
                <v-img 
                    :src="`${publicPath}/img/title_border_right.png`"
                    max-width="300px"
                    contain
                />
            </div>
        </div>

        <div v-else class="d-flex">
            <div class="pr-5">
                <v-img 
                    :src="`${publicPath}/img/little_title_border_left.png`"
                    max-width="150px"
                />
            </div>
            <div class="pl-5">
                <v-img 
                    :src="`${publicPath}/img/little_title_border_right.png`"
                    max-width="150px"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TitleComponent",
    props: ['title'],
    data() {
        return {
            publicPath: window.location.origin,
        }
    },
    computed: {
        imgWidth() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs':
                    return 100
                case 'sm':
                    return 100
                case 'md':
                    return 100
                case 'lg':
                    return 250
                case 'xl':
                    return 250;
                default :
                    return 250;
            }
        }
    }
}
</script>

<style scoped>

</style>