<template>
    <div class="settings-page">
    
        <!-- Dashboard link -->
    <div style="text-align: left; margin-bottom: 20px;">
      <router-link to="/dashboard" class="dashboard-link">
        Go to Dashboard
      </router-link>
    </div>

      <h1>CSV Uploader (Frontend Processing)</h1>
  
      <form @submit.prevent="uploadData">
        <div>
          <label for="uploadType">Select Upload Target:</label>
          <select v-model="uploadType" id="uploadType" required>
            <option disabled value="">-- Please select --</option>
            <option v-for="option in uploadOptions" :key="option.value" :value="option">
              {{ option.label }}
            </option>
          </select>
        </div>
  
        <div>
          <label for="csvFile">Choose CSV File:</label>
          <input type="file" id="csvFile" @change="handleFileUpload" accept=".csv" required />
        </div>
  
        <button type="submit" :disabled="loading">
          {{ loading ? 'Uploading...' : 'Upload Data' }}
        </button>
      </form>
  
      <!-- Progress / Loading Info -->
      <div v-if="loading && currentChunkInfo" style="margin-top: 10px;">
        Uploading chunk {{ currentChunkInfo.current }} of {{ currentChunkInfo.total }}...
      </div>
  
      <div v-if="parsedData.length">
        <h3>Preview:</h3>
        <table border="1">
          <thead>
            <tr>
              <th v-for="header in headers" :key="header">{{ header }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in parsedData.slice(0, 5)" :key="index">
              <td v-for="header in headers" :key="header">{{ row[header] }}</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <div v-if="message" :class="{ success: isSuccess, error: !isSuccess }" style="margin-top: 10px;">
        {{ message }}
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Papa from 'papaparse';
  import axios from 'axios';
  
  // State
  const uploadType = ref({});
  const uploadOptions = ref([
    { value: 'product', label: 'Product', url: '/api/products/store' },
    { value: 'product_type', label: 'Product Type', url: '/api/store-product-types' },
    { value: 'order', label: 'Order', url: '/api/store-orders' },
    { value: 'order_details', label: 'Order Details', url: '/api/store-order-details' },
  ]);
  
  const selectedFile = ref(null);
  const parsedData = ref([]);
  const headers = ref([]);
  const message = ref('');
  const isSuccess = ref(false);
  const loading = ref(false); // loading state
  const currentChunkInfo = ref(null); // track current chunk progress
  
  // config
  const MAX_CHUNKS_ALLOWED = 30; // Limit upload to 10 chunks
  
  // Handle file upload and parse CSV
  const handleFileUpload = (event) => {
    selectedFile.value = event.target.files[0];
  
    if (selectedFile.value) {
      Papa.parse(selectedFile.value, {
        header: true,
        skipEmptyLines: true,
        complete: (results) => {
          parsedData.value = results.data;
          headers.value = results.meta.fields;
        },
        error: (err) => {
          console.error(err);
          message.value = 'Error parsing CSV.';
          isSuccess.value = false;
        },
      });
    }
  };
  
  // Helper: chunk array into smaller arrays of given size
  const chunkArray = (array, chunkSize) => {
    const chunks = [];
    for (let i = 0; i < array.length; i += chunkSize) {
      chunks.push(array.slice(i, i + chunkSize));
    }
    return chunks;
  };
  
  // Upload data with chunking + limiter
  const uploadData = async () => {
    if (!uploadType.value.url || !parsedData.value.length) {
      message.value = 'Please select target and upload valid CSV.';
      isSuccess.value = false;
      return;
    }
  
    const token = localStorage.getItem('token');
  
    // Step 1: process data
    const processed = processData({
      type: uploadType.value,
      data: parsedData.value,
    });
  
    // Step 2: chunk processed data
    const chunks = chunkArray(processed, 50);
  
    loading.value = true;
    message.value = '';
    isSuccess.value = false;
    currentChunkInfo.value = {
      current: 0,
      total: Math.min(chunks.length, MAX_CHUNKS_ALLOWED), // total only up to MAX_CHUNKS_ALLOWED
    };
  
    try {
      // Step 3: upload each chunk (but stop at MAX_CHUNKS_ALLOWED)
      for (let i = 0; i < chunks.length && i < MAX_CHUNKS_ALLOWED; i++) {
        currentChunkInfo.value.current = i + 1;
  
        await axios.post(uploadType.value.url, {
          data: chunks[i],
        }, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
  
        console.log(`Uploaded chunk ${i + 1} of ${chunks.length}`);
  
        // Optional: short delay between chunks (simulate slow upload)
        // await new Promise(resolve => setTimeout(resolve, 500));
      }
  
      // If we stopped early due to limit:
      if (chunks.length > MAX_CHUNKS_ALLOWED) {
        message.value = `Stopped after ${MAX_CHUNKS_ALLOWED} chunks. (Limiter active)`;
      } else {
        message.value = 'All data uploaded successfully!';
      }
  
      isSuccess.value = true;
    } catch (error) {
      console.error(error);
      message.value = 'Error uploading data.';
      isSuccess.value = false;
    } finally {
      loading.value = false;
      currentChunkInfo.value = null;
    }
  };
  
  // Process CSV data depending on upload type
  const processData = ({ type = null, data = [] }) => {
    if (!type || !data || data.length === 0) {
      return [];
    }
  
    let res = [];
  
    switch (type.value) {
      case 'product':
        res = data.map(el => {
          return {
            id: el.pizza_id,
            productTypeId: el.pizza_type_id,
            size: el.size,
            price: el.price,
          };
        });
        break;
  
      case 'product_type':
        res = data.map(el => {
          const ingredients = el.ingredients.split(',').map(item => item.trim());
          return {
            productTypeId: el.pizza_type_id,
            name: el.name,
            category: el.category,
            ingredients,
          };
        });
        break;
  
      case 'order':
        res = data.map(el => {
          return {
            id: el.order_id,
            date: el.date,
            time: el.time,
          };
        });
        break;
  
      case 'order_details':
        res = data.map(el => {
          return {
            id: el.order_details_id,
            orderId: el.order_id,
            productId: el.pizza_id,
            quantity: el.quantity,
          };
        });
        break;
  
      default:
        break;
    }
  
    return res;
  };
  </script>
  
  <style scoped>
  .settings-page {
    max-width: 600px;
    margin: 50px auto; /* center horizontally */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #333;
  }
  
  .settings-page h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #444;
  }
  
  .settings-page form {
    display: flex;
    flex-direction: column;
  }
  
  .settings-page form > div {
    margin-bottom: 15px;
  }
  
  .settings-page label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .settings-page select,
  .settings-page input[type="file"],
  .settings-page button {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
  }
  
  .settings-page button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  
  .settings-page button:hover:not(:disabled) {
    background-color: #45a049;
  }
  
  .settings-page button:disabled {
    background-color: #999;
    cursor: not-allowed;
  }
  
  .settings-page .success {
    color: green;
    text-align: center;
    margin-top: 10px;
  }
  
  .settings-page .error {
    color: red;
    text-align: center;
    margin-top: 10px;
  }
  
  .settings-page table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }
  
  .settings-page table th,
  .settings-page table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
  }
  
  .settings-page table th {
    background-color: #f0f0f0;
  }
  </style>
  
  