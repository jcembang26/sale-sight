<template>
    <div class="dashboard-page">
      <h1>Dashboard</h1>
      <p>Welcome! Here are your insights:</p>
  
      <div class="insights">
        <div class="card" v-for="(insight, index) in insights" :key="index">
          <h2>{{ insight.title }}</h2>
          <p>{{ insight.value }}</p>
        </div>
      </div>
  
      <!-- <div class="charts">
        <div class="chart-card">
          <h2>Orders by Day</h2>
          <BarChart :chartData="ordersChartData" :chartOptions="chartOptions" />
        </div>
  
        <div class="chart-card">
          <h2>Product Type Distribution</h2>
          <PieChart :chartData="productTypeChartData" :chartOptions="chartOptions" />
        </div>
      </div> -->
  
      <router-link to="/settings" class="settings-link">Go to Settings</router-link>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import BarChart from '@/components/charts/BarChart.vue';
  import PieChart from '@/components/charts/PieChart.vue';
  
  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
  } from 'chart.js';
  
  ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
  );
  
  const insights = ref([]);
  const ordersChartData = ref({
    labels: [],
    datasets: [{
      label: 'Orders',
      backgroundColor: '#42A5F5',
      data: []
    }]
  });
  const productTypeChartData = ref({
    labels: [],
    datasets: [{
      label: 'Product Types',
      backgroundColor: [],
      data: []
    }]
  });
  const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  });
  
  const fetchDashboardData = async () => {
    try {
      const token = localStorage.getItem('token');
      const res = await axios.get('/api/dashboard-summary', {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      });
  
      const data = res.data;
  
      // Set insights
      insights.value = [
        { title: 'Total Products', value: data.totalProducts },
        { title: 'Total Product Types', value: data.totalProductTypes },
        { title: 'Total Orders', value: data.totalOrders },
        { title: 'Total Order Details', value: data.totalOrderDetails },
        { title: 'Active Users', value: data.activeUsers }
      ];
  
      // Orders per day chart
      const ordersPerDay = data.ordersPerDay || [];
      ordersChartData.value.labels = ordersPerDay.map(item => item.date);
      ordersChartData.value.datasets[0].data = ordersPerDay.map(item => item.order_count);
  
      // Product type distribution - since no breakdown, mock some data
      // Or if you have real distribution, map it here
      const totalTypes = data.totalProductTypes || 1;
      productTypeChartData.value.labels = ['Product Types'];
      productTypeChartData.value.datasets[0].data = [totalTypes];
      productTypeChartData.value.datasets[0].backgroundColor = ['#FF6384'];
  
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
    }
  };
  
  onMounted(() => {
    fetchDashboardData();
  });
  </script>
  
  <style scoped>
  .dashboard-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
  }
  
  .insights {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 30px;
  }
  
  .card {
    flex: 1 1 calc(20% - 16px);
    background-color: #f7f7f7;
    padding: 16px;
    text-align: center;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .charts {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
  }
  
  .chart-card {
    flex: 1 1 48%;
    background-color: #fafafa;
    padding: 20px;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    height: 300px;
  }
  
  .settings-link {
    display: inline-block;
    margin-top: 20px;
    color: #1976d2;
    text-decoration: underline;
    font-weight: bold;
  }
  </style>
  