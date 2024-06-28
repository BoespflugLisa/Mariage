<template>
    <div>
        <transition name="fade">
            <v-img v-if="show"
                contain
                :src="images[currentImage]"
                class="photo-display-mobile"
                :max-width="getImgSize()"
            />
        </transition>
    </div>
</template>

<script>
export default {
    name: "HomeCarouselComponent",
    data() {
        return {
            show: true,
            images: [
                "img/home/photo_m-c_faux_japon.jpg",
                "img/home/photo_m-c_caillou.jpg",
                "img/home/photo_m-c.png",
                "img/home/photo_m-c_neige.jpg",
                "img/home/photo_m-c_pacs.jpg",
            ],
            currentImage: 0,
        }
    },
    mounted() {
        setTimeout(() => {
            this.goNextImage()
        }, 6000);
    },
    methods: {
        goNextImage() {
            this.show = false;

            setTimeout(() => {
                if (this.currentImage + 1 == this.images.length) {
                    this.currentImage = 0;
                } else {
                    this.currentImage += 1;
                }
                this.show = true;
                setTimeout(() => {
                    this.goNextImage()
                }, 6000);
            }, 1000);
        },

        getImgSize() {
            if (this.$vuetify.breakpoint.xs) {
                return '300px';
            } else if(this.$vuetify.breakpoint.sm) {
                return '500px';
            } else {
                return '';
            }
        }
    },
}
</script>

<style scoped lang="scss">
.photo-display-mobile {
    height: 500px;
    width: 900px;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>