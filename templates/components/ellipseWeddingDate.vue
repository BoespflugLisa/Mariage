<template>
    <div class="ellipse-parent" style="display: block;">
        <div class="ellipse d-flex flex-column align-center ma-auto">
            <p class="the-smile-regular ellipse-text text-center ma-auto">Samedi 11 mai 2024</p>
        </div>

        <v-img
            src="img/green-removebg-preview-left.png"
            contain
            class="ellipse-img-left"
        />
        <v-img
            src="img/green-removebg-preview-right.png"
            contain
            class="ellipse-img-right"
        />
    </div>
</template>

<script>
export default {
    name: "EllipseWeddingDate",
}
</script>

<style lang="scss">
.ellipse-parent {
    height: 250px;
    width: 325px;
    position: relative;
}

.ellipse {
    height: 250px;
    width: 325px;
    clip-path: ellipse(closest-side farthest-side);
    background-color: rgba(235, 229, 220, 0.56);
}

.ellipse-text {
    font-size: 35px!important;
    color: #9F9377;
}

.ellipse-img-left {
    position: absolute; 
    top: 0; 
    left: 0;
}

.ellipse-img-right {
    position: absolute; 
    bottom: 0; 
    right: 0;
}
</style>