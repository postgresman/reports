<script setup>
import axios from 'axios';
import { Head, Link } from '@inertiajs/vue3';
import JobBookingsChart from '@/Charts/JobBookingsChart.vue';
import ConversionFunnelChart from '@/Charts/ConversionFunnelChart.vue';
</script>

<template>
  <Head title="Dashboard" />
  <div class="py-12">
    <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
      <div class="float-right">
        <Link @click="logout()">
        Log out
        </Link>
      </div>
      <div>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Reports Dashboard</h2>
      </div>
      <div class="mb-6">
        <JobBookingsChart :availableMarkets="availableMarkets"/>
      </div>
      <div class="mb-6">
        <ConversionFunnelChart :availableMarkets="availableMarkets" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      availableMarkets: null,
    };
  },
  created() {
    if (!this.getToken()) {
      this.$router.push({ name: 'Login' });
    }
  },
  mounted() {
    this.getMarkets();
  },
  methods: {
    async logout() {
      try {
        await axios.post(route('api.auth.logout'), {}, {
          headers: {
            'Authorization': `Bearer ${this.getToken()}`
          }
        });
        console.log('Logout successful');
      } catch (error) {
        console.log('Logout error:', error?.response?.data?.message || error.message);
      } finally {
        this.clearToken();
        this.$router.push({ name: 'Login' });
      }
    },
    async getMarkets() {
      await axios.get(route('api.market.list'), {
        headers: {
          'Authorization': `Bearer ${this.getToken()}`
        }
      }).then((response) => {
        this.availableMarkets = response.data.data;
      }).catch((error) => {
        if(error.response.status === 401) {
          this.clearToken();
          this.$router.push({ name: 'Login' });
          return;
        }

        this.showMessage(error.response?.data?.message || 'Failed to load markets.');
      });
    },
  }
};
</script>