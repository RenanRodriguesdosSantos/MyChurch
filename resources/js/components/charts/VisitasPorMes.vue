<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  name: 'visitas-por-mes',
  props: {
    visitasPorMes: {
        required: true,
    },
  },
  data() {
    return {
        chartdata: {
        labels: this.visitasPorMes.map(item => item.month),
        datasets: [
            {
                label: 'Visitas',
                backgroundColor: '#4285F4',
                data: this.visitasPorMes.map(item => item.qtde)
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
                        beginAtZero: true
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
