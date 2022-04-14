<template>
  <div id="app">
    <nav-bar></nav-bar>
    <router-view class="router"/>
  </div>
</template>
<script>
  import NavBar from "./components/NavBar";

  export default {
    name: "App",
    components: {NavBar},
    created() {
      if (location.search.indexOf('?user') != -1) {
        let loginUser = JSON.parse(decodeURIComponent(location.search.replace('?user=', '')));
        this.$store.commit('setLoginUser', loginUser)
        //设置cookie
        this.$cookies.set('loginUser', JSON.stringify(loginUser))
      }
      if (this.$cookies.get('loginUser')) {
        let loginUser = this.$cookies.get('loginUser')
        this.$store.commit('setLoginUser', loginUser)
      }
    },
  }
</script>
<style lang="scss">
  #app {

  }

  .router {
    padding: 30px;
  }
</style>
