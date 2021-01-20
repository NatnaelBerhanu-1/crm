<script>
  //Importing Line class from the vue-chartjs wrapper
  import { Line, mixins } from 'vue-chartjs'
  const {reactiveProp} = mixins

  //Exporting this so it can be used in other components
  export default {
    extends: Line,
    mixins: [reactiveProp],
    props: {
    },
    data () {
      return {
        //Chart.js options that controls the appearance of the chart
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
                ticks: {
                    display: false //this will remove only the label
                }
            }]
        }
        }
      }
    },
    mounted () {
      //renderChart function renders the chart with the datacollection and options object.
      this.renderChart(this.chartData, this.options)
    }
  }
</script>
