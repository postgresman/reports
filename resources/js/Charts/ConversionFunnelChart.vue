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
      <div class="pb-10">
        <div class="float-right ml-5">
          <InputLabel for="conversionFunnelMarket" value="Markets:" />
          <multiselect v-if="availableMarkets" v-model="chart.filter.selectedMarkets" :options="availableMarkets" open-direction="top" label="name" track-by="id" multiple></multiselect>
        </div>
        <div class="float-right ml-5">
          <InputLabel for="conversionFunnelEndDate" value="To:" />
          <TextInput id="conversionFunnelEndDate" type="date" v-model="chart.filter.endDate" />
        </div>
        <div class="float-right ml-5">
          <InputLabel for="conversionFunnelStartDate" value="From:" />
          <TextInput id="conversionFunnelStartDate" type="date" v-model="chart.filter.startDate" />
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
  name: 'conversion-funnel-report',
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
        height: 400,
        filter: {
          endDate: date.toISOString().slice(0,10),
          startDate: (new Date(date.setDate(date.getDate() - 30))).toISOString().slice(0,10),
          selectedMarkets: [],
        },
        type: 'bar',
        options: {
          chart: {
            id: 'conversion_funnel_chart',
            toolbar: {
              show: false,
            },
          },
          title: {
            text: 'Conversion Funnel Report',
            align: 'center',
          },
          plotOptions: {
            bar: {
              borderRadius: 4,
              borderRadiusApplication: 'end',
              horizontal: true,
            }
          },
          dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val + "%";
            },
          },
          yaxis: {
            labels: {
              trim: false,
              align: 'left',
            },
          },
          xaxis: {
            categories: [],
            labels: {
              formatter: function (value) {
                return value + "%"; 
              }
            },
          },
          tooltip: {
            y: {
              formatter: function (value) {
                return value + "%"; 
              }
            },
          },
        },
        series: [{
          name: 'Conversion Rate',
          data: []
        }], 
      },
      message: null,
      token: localStorage.getItem('auth_token'),
      exportData: [],
    };
  },
  methods: {
    async updateChart() {
      this.chart.options.xaxis.categories.length = 0;
      this.chart.series[0].data.length = 0;

      try {
        const response = await axios.post(route('api.report.conversion-funnel'), {
          startDate: this.chart.filter.startDate,
          endDate: this.chart.filter.endDate,
          markets: this.chart.filter.selectedMarkets.map(market => market.id),
        },{
          headers: {
            'Authorization': `Bearer ${this.getToken()}`
          }
        });

        if (response.data.length === 0) {
          this.showMessage('No data available for the selected criteria.');
          return;
        }
        
        this.exportData = response.data;

        const data = [];
        this.exportData.forEach(item => {
          if (data[item.event_order]) {
            data[item.event_order]['count'] += item.count;
          } else {
            data[item.event_order] = { 'name': item.event_name, 'count': item.count };
          }
        });

        let previous = null;
        data.forEach((item) => {
          this.chart.options.xaxis.categories.push([item.name, `(${item.count})`]);
          this.chart.series[0].data.push(previous === null ? 100 : Math.round((item.count / previous.count) * 10000) / 100);
          previous = item;
        });
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
        if (this.exportData.length === 0) {
          this.showMessage('No data available to export. Please generate the chart first.');
          return;
        }

        const headers = ['Market Name', 'Event Name', 'Conversation Total', 'Conversation Percentage'].join(',');
        const rows = this.exportData.map(item => [
          item.market_name,
          item.event_name,
          item.count,
          item.percentage + '%'
        ].join(','));

        this.downloadCSV(this.chart.options.chart.id, headers, rows);
      } catch (error) {
        this.showMessage('Failed to export CSV.');
      }
    },
  },
};
</script>