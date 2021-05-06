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
          <h3 v-if="id">Edição de Visita</h3>
          <h3 v-else>Cadastro de Visita</h3>
        </v-col>
      </v-row>
      <v-form ref="visitaForm">
        <v-row class="text-lg-center">
          <v-col cols="12" lg="6" md="6">
            <v-text-field
              type="date"
              label="Data da visita"
              v-model="visita.data"
              outlined
              :rules="requiredRule"
            ></v-text-field>
          </v-col>
          <v-col cols="12" lg="6" md="6">
            <v-text-field
              type="time"
              label="Hora da visita"
              v-model="visita.hora"
              outlined
              :rules="requiredRule"
            ></v-text-field>
          </v-col>
          <v-col cols="12" lg="6" md="6">
            <v-autocomplete
              item-text="name"
              item-value="id"
              :items="usuarios"
              label="Responsável"
              v-model="visita.responsavel_id"
              outlined
            ></v-autocomplete>
          </v-col>
          <v-col cols="12" lg="6" md="6">
            <v-text-field
              label="Endereço"
              v-model="visita.endereco"
              hint="Endereço completo: Bairro, rua, número e complemento"
              outlined
              :rules="requiredRule"
            ></v-text-field>
          </v-col>
          <v-col lg="6" md="6" cols="12">
            <v-textarea
              label="Descrição da visita"
              type="text"
              hint="Descreva o que deve ser reaizado na visita"
              v-model="visita.descricao"
              outlined
              :rules="requiredRule"
            ></v-textarea>
          </v-col>
        </v-row>
      </v-form>

      <v-row class="text-lg-left">
        <v-col lg="12" md="12" cols="12">
          <v-btn elevation="1" large dark color="blue" @click="save()"
            >Salvar</v-btn
          >
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import UsuarioService from "../usuario/UsuarioService";
import VisitaService from "./VisitaService";
import moment from "moment";

export default {
  name: "agendar-visita",
  props: ["id"],
  data() {
    return {
      usuarioService: new UsuarioService(),
      visitaService: new VisitaService(),
      visita: {
        data_visita: null,
        data: null,
        hora: null,
        endereco: null,
        descricao: null,
        responsavel_id: null,
      },
      usuarios: [],
      isLoading: null,
      requiredRule: [(v) => !!v || "Este campo é obrigatório."],
    };
  },
  methods: {
    async save() {
      if (this.$refs.visitaForm.validate()) {
        this.isLoading = true;
        const params = this.visita;
        params.data_visita = this.visita.data + ' ' + this.visita.hora;
        let response = null;
        try {
          response = await this.visitaService
            .request("POST", "agendar", params)
            .then(() => {
              this.isLoading = false;
              Vue.$toast.success("Operação realizada com sucesso");
              this.$router.push({ name: "listar-visitas" });
            });
        } catch (error) {
          this.isLoading = false;
          // if(error.response.data.message) {
          //     Vue.$toast.error(error.response.data.message);
          // } else {
          //     Vue.$toast.error('Ocorreu um problema ao salvar o registro');
          // }
          console.log(error);
        }
      }
    },
    async fetchUsuarios() {
      this.isLoading = true;
      await this.usuarioService
        .request("GET", "get-all-users")
        .then((response) => {
          this.usuarios = response.data;
          this.isLoading = false;
        });
    },
    clearFields() {
      this.visita = {
        data_visita: null,
        data: null,
        hora: null,
        responsavel_id: null,
        endereco: null,
        descricao: null,
      };
    },
    async loadVisita() {
      this.isLoading = true;
      const params = {
        id: this.id,
      };
      await this.visitaService
        .request("GET", "get-visita", null, { params })
        .then((response) => {
          let dados = response.data;
          this.visita = {
            ...dados,
            data: moment(dados.data_visita).format("YYYY-MM-DD"),
            hora: new Date(dados.data_visita).toLocaleTimeString(),
            responsavel_id: dados.responsavel
          };
          this.isLoading = false;
        });
    },
  },
  mounted() {
    this.fetchUsuarios();
    this.clearFields();
    if (this.id) {
      this.loadVisita();
    }
  },
};
</script>

<style scooped>
.img-profile {
  height: 200px;
  width: auto;
}
</style>
 