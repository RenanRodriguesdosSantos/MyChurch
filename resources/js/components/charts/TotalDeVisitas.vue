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
  data: () => ({
    chartdata: {
      labels: Object.keys(this.totalVisitas),
      datasets: [
        {
          backgroundColor: '#0000ff, ',
          data: Object.values(this.totalVisitas),
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),

  mounted() {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>

<style>

</style>
