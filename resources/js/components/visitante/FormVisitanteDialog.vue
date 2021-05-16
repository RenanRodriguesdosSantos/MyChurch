<template>
  <v-dialog
      v-model="show"
      scrollable
      max-width="800px"
      transition="dialog-transition"
  >
  <v-card
      class=""
        elevation=""
        max-width=""
        >
        <v-card-title primary-title class="justify-end">
             <v-icon color="" right @click="show = false">mdi-close</v-icon>
        </v-card-title>
        <v-card-text>
            <form-visitante :isFromDialog="true" @saved="visitanteSaved()">
            </form-visitante>
        </v-card-text>

    </v-card>

  </v-dialog>
</template>

<script>
import FormVisitante from './FormVisitante.vue'
export default {
    props: ['value'],
    name: 'form-visitante-dialog',
    components: { FormVisitante },
    computed: {
        show: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        }
    },
    methods: {
        visitanteSaved() {
            this.$emit('saved');
            this.show = false;
        }
    },
}
</script>

<style>

</style>
