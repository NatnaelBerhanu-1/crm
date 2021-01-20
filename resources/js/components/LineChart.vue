<script>
  //Importing Line class from the vue-chartjs wrapper
  import { Line } from 'vue-chartjs'

  //Exporting this so it can be used in other components
  export default {
    extends: Line,
    props: {
        color: String,
        data: Array,
        labels: Array,
        label: String
    },
    data () {
      return {
        datacollection: {
          //Data to be represented on x-axis
          labels: this.labels,
          datasets: [
            {
              label: this.label,
              backgroundColor: "#00000000",
              pointRadius: 0,
              borderWidth: 2,
              borderColor: "#3D68FF",
              backgroundColor: "#3D68FF10",
              //Data to be represented on y-axis
              data: this.data
            },
          ],

        },
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
      this.renderChart(this.datacollection, this.options)
    }
  }
</script>
