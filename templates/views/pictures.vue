<template>
    <v-app>
        <appbarcomponent :user-roles="userRoles"/>
        <div class="appbar-margin">
            <titlecomponent title="Album Photos"/>
        </div>

        <picturegallerycomponent class="footer-margin" :user-roles="userRoles"/>

        <footercomponent/>
    </v-app>
</template>

<script>
export default {
    name: "pictures",
    props:['userRoles'],
}
</script>

<style lang="scss">

</style>