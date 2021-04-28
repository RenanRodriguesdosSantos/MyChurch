<template>
    <v-row justify="center" class="pt-md-12">
      <v-col md="5">
          <v-img max-height="400" max-width="500" :src="imagemLogo"></v-img><br/>
          <h1 class="text-center">Bem Vindo!</h1>
      </v-col>
    </v-row>
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
