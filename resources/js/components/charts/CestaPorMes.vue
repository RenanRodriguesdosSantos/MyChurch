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
  data() {
    return {
        chartdata: {
        labels: this.cestaPorMes.map(item => item.month),
        datasets: [
            {
                label: 'Cestas básicas',
                backgroundColor: '#303D46',
                data: this.cestaPorMes.map(item => item.qtde)
            }
        ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            }
        }
    }
  },
  mounted () {
    this.renderChart(this.chartdata, this.options);
  },
}
</script>

<style>

</style>
