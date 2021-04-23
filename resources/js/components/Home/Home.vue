<template>
  <div >
    <div class="d-flex justify-center pt-md-12">
        <v-img max-width="600" max-height="350" :src="imagemLogo" />
    </div>
    <div class="d-flex justify-center">
        <h1>Bem Vindo!</h1>
    </div>
  </div>
</template>

<script>

export default {
  data(){
    return{
      imagemLogo: '../images/logo.png'
    }
  }

}
</script>

<style>

</style>
