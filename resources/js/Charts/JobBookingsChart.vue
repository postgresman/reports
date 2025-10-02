<script setup>
import axios from 'axios';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Multiselect from 'vue-multiselect';
</script>

<template>
  <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg bg-gainsboro">
    <div class="p-12 text-gray-900">
      <div>
        <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
      </div>
      <div class="pb-20">
        <div class="float-right ml-5">
          <InputLabel for="jobBookingsMarket" value="Markets:" />
          <multiselect v-if="availableMarkets" v-model="chart.filter.selectedMarkets" :options="availableMarkets" open-direction="top" label="name" track-by="id" multiple></multiselect>
        </div>
        <div class="float-right ml-5">
          <InputLabel for="jobBookingEndDate" value="To:" />
          <TextInput id="jobBookingEndDate" type="date" v-model="chart.filter.endDate" />
        </div>
        <div class="float-right ml-5">
          <InputLabel for="jobBookingStartDate" value="From:" />
          <TextInput id="jobBookingStartDate" type="date" v-model="chart.filter.startDate" />
        </div>
        <br>
        <PrimaryButton @click="updateChart">
          Generate Chart
        </PrimaryButton>
        <SecondaryButton @click="exportToCSV" class="ml-2">
          Export to CSV
        </SecondaryButton>
        <InputError class="mt-2 absolute" :message="message" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'job-bookings-report',
  props: {
    availableMarkets: {
      type: Array,
      required: false,
      default: null,
    }
  },
  data() {
    const date = new Date();
    return {
      chart: {
        width: '100%',
        height: 600,
        filter: {
          endDate: date.toISOString().slice(0,10),
          startDate: (new Date(date.setDate(date.getDate() - 30))).toISOString().slice(0,10),
          selectedMarkets: [],
        },
        options: {
          chart: {
            id: 'job_bookings_chart',
            toolbar: {
              show: false,
            },
          },
          xaxis: {
            categories: [], 
            type: 'datetime',
            labels: {
              format: 'dd MMM yy'
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'smooth'
          },
          title: {
            text: 'Job Bookings Over Time',
            align: 'center'
          },
          colors: [],
        },
        series: [], 
      },
      message: null,
      token: localStorage.getItem('auth_token'),
    };
  },
  methods: {
    async updateChart() {
      this.chart.series = [];
      try {
        const response = await axios.post(route('api.report.job-bookings'), {
            startDate: this.chart.filter.startDate,
            endDate: this.chart.filter.endDate,
            markets: this.chart.filter.selectedMarkets.map(market => market.id),
          },{
            headers: {
              'Authorization': `Bearer ${this.getToken()}`
            }
          });

        if (!response.data || response.data.length === 0) {
          this.showMessage('No data available for the selected criteria.');
          return;
        }

        this.chart.series = response.data;
      } catch (error) {
        if(error.response.status === 401) {
          this.clearToken();
          this.$router.push({ name: 'Login' });
          return;
        }

        this.showMessage(error.response?.data?.message || 'Failed to load chart data.');
      }
    },
    async exportToCSV() {
      try {
        if (!this.chart.series || this.chart.series.length === 0) {
          this.showMessage('No data available to export. Please generate the chart first.');
          return;
        }

        const headers = ['Market', 'Date', 'Bookings'].join(',');
        const rows = this.chart.series.map(item => [
          item.name,
          item.data[0][0],
          item.data[0][1]
        ].join(','));

        this.downloadCSV(this.chart.options.chart.id, headers, rows);
      } catch (error) {
        this.showMessage(error.response?.data?.message || 'Failed to export data.');
      }
    },
  },
};
</script>