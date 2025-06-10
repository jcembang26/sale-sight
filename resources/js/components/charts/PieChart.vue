<template>
    <Pie :data="chartData" :options="chartOptions" />
  </template>
  
  <script setup>
  import { Pie } from 'vue-chartjs';
  import { defineProps } from 'vue';
  
  defineProps({
    chartData: {
      type: Object,
      required: true
    },
    chartOptions: {
      type: Object,
      required: false,
      default: () => ({})
    }
  });
  </script>
  