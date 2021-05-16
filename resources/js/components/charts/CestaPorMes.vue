<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  name: 'cesta-por-mes',
  props: {
    cestaPorMes: {
        required: true,
    },
  },
  data: () => ({
    chartdata: {
      labels: Object.keys(this.cestaPorMes),
      datasets: [
        {
          label: 'Cestas básicas',
          backgroundColor: ['#bc37a7', '#ededed'],
          data: Object.values(this.cestaPorMes),
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),

  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>

<style>

</style>
