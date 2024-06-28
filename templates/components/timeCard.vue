<template>
    <v-card
        dark
        class="ma-1"
        :width="cardSize"
    >
        <div class="text-center pa-2 pb-0 pt-1 timecard-head">
            {{ time }}
        </div>
        <div class="text-center pa-2 pb-1 pt-1 timecard-text">
            {{ $vuetify.breakpoint.xs? shorttext : longtext }}
        </div>
    </v-card>
</template>
        
<script>
export default {
    name: "TimeCard",
    props: ['time', 'longtext', 'shorttext'],
    computed: {
        cardSize() {
            switch (this.$vuetify.breakpoint.name) {
                case 'xs':
                    return 50
                case 'sm':
                    return 75
                case 'md':
                    return 75
                case 'lg':
                    return 100
                case 'xl':
                    return 100
                default :
                    return 100
            }
        }
    },
};
</script>
        
<style scoped lang="scss">
.timecard-head {
    font-size: 1.25rem!important;
}

.timecard-text {
    font-size: 0.75rem!important;
}
</style>