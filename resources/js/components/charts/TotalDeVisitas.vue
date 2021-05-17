<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  name: 'total-de-visitas',
  props: {
    totalVisitas: {
        required: true,
    },
  },
  data() {
    return {
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    }
  },
  methods: {
      chartdata() {
            return { labels: this.totalVisitas.map(item => item.descricao),
                datasets: [
                    {
                    backgroundColor: ['#bc37a7', '#28bf65'],
                    data: this.totalVisitas.map(item => item.qtde),
                    }
                ]
            }
        },
  },
  watch: {
    totalVisitas() {
      this.renderChart(this.chartdata(), this.options);
    },
  },
  mounted() {
    this.renderChart(this.chartdata(), this.options);
  },
}
</script>

<style>

</style>
