<script>
  //Importing Line class from the vue-chartjs wrapper
  import { Line } from 'vue-chartjs'

  //Exporting this so it can be used in other components
  export default {
    extends: Line,
    props: {
        color: String,
        data: Array,
        label: String
    },
    data () {
      return {
        datacollection: {
          //Data to be represented on x-axis
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: this.label,
              backgroundColor: this.color,
              pointRadius: 0,
              borderWidth: 2,
              borderColor: "#3D68FF",
              //Data to be represented on y-axis
              data: this.data
            }
          ]
        },
        //Chart.js options that controls the appearance of the chart
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              },
              gridLines: {
                display: false
              }
            }],
            xAxes: [ {
              gridLines: {
                display: false
              }
            }]
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    mounted () {
      //renderChart function renders the chart with the datacollection and options object.
      this.renderChart(this.datacollection, this.options)
    }
  }
</script>
