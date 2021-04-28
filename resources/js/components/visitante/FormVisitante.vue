<template>
  <div>
       <v-container class="">
           <v-overlay :value="isLoading">
            <v-progress-circular
                indeterminate
                color="primary"
                size="64"
            ></v-progress-circular>
            </v-overlay>
           <v-row class="mb-6">
            <v-col lg="12" md="12" sm="12">
                <h3 v-if="id">Edição de Visitante</h3>
                <h3 v-else>Cadastro de Visitante</h3>
            </v-col>
          </v-row>
          <v-form ref="visitanteForm">
            <v-row class="text-lg-center">
                <v-col lg="12" md="12" sm="12">
                    <v-row class="text-lg-center" >
                        <v-col lg="8" md="8" sm="12">
                            <v-text-field label="Nome" v-model="visitante.nome" outlined :rules="[...lengthRule, ...requiredRule]"></v-text-field>
                        </v-col>
                        <v-col lg="4" md="4" sm="12">
                            <v-text-field label="Telefone" v-model="visitante.telefone" outlined :rules="[...lengthRuleTelefone, ...requiredRule]" ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
          </v-form>

        <v-row class="text-lg-left">
            <v-col lg="12" md="12" sm="12">
                <v-btn elevation="1" large dark color="blue" @click="save()">Salvar</v-btn>
            </v-col>
        </v-row>


        </v-container>
  </div>
</template>

<script>
import VisitanteService from './VisitanteService';

export default {
    name: 'cadastro-visitante',
    props: ['id'],
    data() {
        return {
            visitanteService: new VisitanteService(),
            visitante: {
                nome: null,
                telefone: null,
            },
            isLoading: null,
            requiredRule: [v => !!v || 'Este campo é obrigatório.'],
            lengthRule: [v => (v && v.length >= 3) || 'Esta campo deve conter 3 ou mais caracteres.'],
            lengthRuleTelefone: [v => (v && v.length === 11 ) || 'Telefone está em formato incorreto.'],
        };
    },
    methods: {
        async save() {
            if(this.$refs.visitanteForm.validate()) {
                this.isLoading = true;
                const params = this.visitante;
                let response = null
                try {
                    response = await this.visitanteService.request('POST', 'cadastro', params).then(() => {
                        this.isLoading = false;
                        Vue.$toast.success('Operação realizada com sucesso');
                        this.$router.push('/visitante/listar');
                        
                    });
                } catch(error) {
                    this.isLoading = false;
                    if(error.response.data.message) {
                        Vue.$toast.error(error.response.data.message);
                    } else {
                        Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                    }
                }
            }
        },
        async loadVisitante() {
            this.isLoading = true;
            const params = {
                id: this.id,
            }
            await this.visitanteService.request('GET', 'get-visitante', null, { params }).then((response) => {
                this.visitante = response.data;
                this.isLoading = false;
            });
        },
        clearFields() {
            this.visitante = {
                nome: null,
                telefone: null,
            };
        },

    },
    mounted() {
        this.clearFields();
        if (this.id) {
            this.loadVisitante();
        }
    },
}
</script>

<style scooped>


</style>
