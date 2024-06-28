<template>
    <a class="d-flex justify-center align-center mt-2 map-link" :href="link" target="_blank">
        <v-img 
            src="img/google-map-icon.png"
            class="mr-2"
            contain
            :max-height="imgSize"
            :max-width="imgSize"
        />
        <div class="ml-2">
            <p class="text-center pt-2 ma-0">{{ placeName }}</p>
            <p class="text-center pt-2">{{ city }}</p>
        </div>
    </a>
</template>

<script>
export default {
    name: "MapLinkComponent",
    props: ['placeName', 'city', 'link'],
    computed: {
        imgSize() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs':
                    return 50;
                case 'sm':
                    return 50;
                case 'md':
                    return 50;
                case 'lg':
                    return 50;
                case 'xl':
                    return 50;
                default :
                    return 50;
            }
        }
    }
}
</script>

<style lang="scss">
.map-link {
    color: black!important;; 
    font-weight: bold;
}
</style>