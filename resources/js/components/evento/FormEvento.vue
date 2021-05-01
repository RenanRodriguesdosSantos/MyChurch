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
                <h3 v-if="id">Edição de Evento</h3>
                <h3 v-else>Cadastro de Evento</h3>
            </v-col>
          </v-row>
          <v-form ref="eventoForm">
            <v-row class="text-lg-center">
                <v-col lg="12" md="12" sm="12">
                    <v-row class="text-lg-center" >
                        <v-col lg="6" md="6" sm="12">
                            <v-text-field label="Nome do Evento" v-model="evento.nome" outlined :rules="[...requiredRule]" autocomplete="off"></v-text-field>
                        </v-col>
                         <v-col lg="2" md="2" sm="12">
                            <v-text-field type="datetime-local" id="" label="Data/Hora" v-model="evento.data" :rules="[...requiredRule]" outlined ></v-text-field>
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
import EventoService from './EventoService';

export default {
    name: 'cadastro-evento',
    props: ['id'],
    data() {
        return {
            eventoService: new EventoService(),
            evento: {
                nome: null,
                data:null
            },
            isLoading: null,
            requiredRule: [v => !!v || 'Este campo é obrigatório.'],
        };
    },
    methods: {
        async save() {
            if(this.$refs.eventoForm.validate()) {
                this.isLoading = true;
                const params = this.evento;
                let response = null
                try {
                    response = await this.eventoService.request('POST', 'cadastro', params).then(() => {
                        this.isLoading = false;
                        Vue.$toast.success('Operação realizada com sucesso');
                        this.$router.push('/evento/listar');
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
        async loadEvento() {
            this.isLoading = true;
            const params = {
                id: this.id,
            }
            await this.eventoService.request('GET', 'get-evento', null, { params }).then((response) => {
                this.evento = response.data;
                this.evento.data = this.evento.data_input;
                this.isLoading = false;
            });
        },
        clearFields() {
            this.evento = {
                nome: null,
                data:null,
            };
        },
    },
    mounted() {
        if (this.id) 
            this.loadEvento();
    },
}
</script>

<style scooped>

</style>
