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
          <h3>Realização de Visita</h3>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <v-flex>
            Criado por: <b>{{ visita.criadoPor }}</b>
          </v-flex>
          <v-flex>
            Data e Hora: <b>{{ dataVisita }}</b>
          </v-flex>
          <v-flex>
            Descrição: <b>{{ visita.descricao }}</b>
          </v-flex>
          <v-flex>
            Endereço: <b>{{ visita.endereco }}</b>
          </v-flex>
          <v-form ref="visitarForm">
            <v-row class="text-lg-center">
              <v-col cols="12" lg="6" md="6">
                <v-textarea
                  label="Observação da Visita"
                  type="text"
                  hint="Descreva o que foi realizado na visita"
                  v-model="visita.observacao"
                  outlined
                  :rules="requiredRule"
                ></v-textarea>
              </v-col>
              <v-col cols="12" lg="6" md="6">
                <v-autocomplete
                  v-model="participantes"
                  :items="usuarios"
                  outlined
                  chips
                  color="blue-grey lighten-2"
                  label="Selecione Participantes"
                  item-text="name"
                  item-value="id"
                  multiple
                >
                  <template v-slot:selection="data">
                    <v-chip
                      v-bind="data.attrs"
                      :input-value="data.selected"
                      close
                      @click="data.select"
                      @click:close="removeParticipante(data.item)"
                    >
                      {{ data.item.name }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </v-col>

            </v-row>
            <v-row>
                <v-col cols="12" lg="6" md="6">
                    <v-checkbox label="Teve doação de cestas básicas ?" v-model="cestaBasicas"></v-checkbox>
                </v-col>
                <v-col cols="12" lg="6" md="6">
                    <v-text-field
                        type="number"
                        v-if="cestaBasicas"
                        label="Quantidade"
                        outlined
                        v-model="visita.qtde_cesta_basicas"
                    ></v-text-field>
                </v-col>
            </v-row>
          </v-form>
        </v-col>
      </v-row>
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
import VisitaService from "./VisitaService";
import moment from "moment";
import UsuarioService from "../usuario/UsuarioService";

export default {
  name: "form-visitar",
  props: ["id"],
  data() {
    return {
      visitaService: new VisitaService(),
      usuarioService: new UsuarioService(),
      visita: {
        observacao: null,
        qtde_cesta_basicas: 0,
      },
      isLoading: false,
      requiredRule: [(v) => !!v || "Este campo é obrigatório."],
      usuarios: [],
      participantes: [],
      cestaBasicas: false,
    };
  },
  methods: {
    async save() {
      if (this.$refs.visitarForm.validate()) {
        this.isLoading = true;
        const params = {...this.visita, participantes: this.participantes};
        let response = null;
        try {
          response = await this.visitaService
            .request("POST", "realizar", params)
            .then(() => {
              this.isLoading = false;
              Vue.$toast.success("Operação realizada com sucesso");
              this.$router.push({ name: "listar-visitas" });
            });
        } catch (error) {
          this.isLoading = false;
          if (error.response.data.message) {
            Vue.$toast.error(error.response.data.message);
          } else {
            Vue.$toast.error("Ocorreu um problema ao salvar o registro");
          }
        }
      }
    },
    clearFields() {
      this.visita = {
        observacao: null,
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
          this.visita = {
            ...response.data,
            criadoPor: response.data.criado_por.name,
          };
          this.visita.observacao = this.visita.observacao
            ? this.visita.observacao
            : null;
          this.isLoading = false;
        });
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
    removeParticipante(item) {
      const index = this.participantes.indexOf(item.id)
      if (index >= 0) this.participantes.splice(index, 1)
    },
  },
  mounted() {
    this.clearFields();
    this.loadVisita();
    this.fetchUsuarios();
  },
  computed: {
    dataVisita() {
      return moment(this.visita.data_visita).format("DD/MM/YYYY HH:mm");
    },
  },
};
</script>

<style scooped>
.img-profile {
  height: 200px;
  width: auto;
}
</style>
