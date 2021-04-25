<template>
  <div class="text-center">
    <v-dialog
      v-model="show"
      width="500"
    >
    <v-overlay :value="isLoading">
      <v-progress-circular
        indeterminate
        color="primary"
        size="64"
      ></v-progress-circular>
    </v-overlay>
    <v-card >
        <v-card-title primary-title>
            Alterar esforço
        </v-card-title>
        <v-card-text>
            Tem certeza que deseja excluir?
        </v-card-text>
        <v-card-actions>
                <v-btn small elevation="1" color="success">Confirmar</v-btn>
                <v-btn small elevation="1" color="error">Cancelar</v-btn>
        </v-card-actions>
    </v-card>


    </v-dialog>
  </div>
</template>
<script>
import MembresiaService from './MembresiaService';

  export default {
    props: ['item', 'value'],
    data() {
        return {
            membresiaService: new MembresiaService(),
            dialog: null,
            isLoading: false,
        }
    },
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
        async updateEsforco() {
            const params = {
                id: this.iteracaoFase,
                esforco: this.newEsforco,
            };
            this.isLoading = true;
            await this.iteracaoFasesService.request('POST', 'update-esforco', params).then((response)=>{
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                }
                this.isLoading = false;
                this.show = false;
            });
        },
    },
  }
</script>
