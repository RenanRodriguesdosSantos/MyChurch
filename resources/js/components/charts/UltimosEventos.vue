<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  name: 'ultimos-eventos',
  props: {
    eventos: {
        required: true,
    },
  },
  data() {
    return {
        chartdata: {
        labels: this.eventos.map(item => `${item.descricao} -  ${item.data}`),
        datasets: [
            {
                label: 'Frequencia ultimos eventos',
                backgroundColor: '#303D46',
                data: this.eventos.map(item => item.frequencia)
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
