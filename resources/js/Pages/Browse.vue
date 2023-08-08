<script setup>
import { defineProps, ref, computed, watch, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PluginList from '../Components/PluginList.vue';

const { plugins, categories } = defineProps({
  plugins: { type: Object },
  categories: { type: Array },
});

const limit = ref(20);
const searchQuery = ref('');
const suggestions = ref([]);
const selectedOrdering = ref('download_count');
const selectedTargeting = ref([]);
const selectedCategories = ref([]);
const loading = ref(false);
const displayedPlugins = computed(() => {
  return orderedPlugins.value.slice(0, limit.value);
});
const loadingMore = ref(false);
const showSuggestions = ref(false);
const filteredPlugins = computed(() => {
  return plugins.filter(plugin => {
    if (searchQuery.value && !plugin.name.toLowerCase().includes(searchQuery.value.toLowerCase())) return false;
    if (selectedTargeting.value.length > 0 && !selectedTargeting.value.includes(plugin.targeting)) return false;

    const pluginCategories = Array.isArray(plugin.categories) ? plugin.categories.map(item => item.id) : [];
    if (selectedCategories.value.length > 0 && !selectedCategories.value.some(cat => pluginCategories.includes(cat))) return false;
    return true;
  });
});

const orderedPlugins = computed(() => {
  const orderKey = selectedOrdering.value;
  return filteredPlugins.value.slice().sort((a, b) => b[orderKey] - a[orderKey]);
});

const updateDisplayedPlugins = () => {
  loading.value = true;

  setTimeout(() => {
    displayedPlugins.value = orderedPlugins.value.slice(0, limit.value);
    loading.value = false;
  }, 500);
};


watch(orderedPlugins, updateDisplayedPlugins);
updateDisplayedPlugins();
watch(searchQuery, (newQuery) => {
  if (newQuery) {
    suggestions.value = plugins.filter(plugin => plugin.name.toLowerCase().includes(newQuery.toLowerCase())).slice(0, 5);
    showSuggestions.value = suggestions.value.length > 0;
  } else {
    suggestions.value = [];
    showSuggestions.value = false;
  }
});

const onClickOutside = (event) => {
  const searchInput = document.getElementById('simple-search'); if (searchInput && !searchInput.contains(event.target)) showSuggestions.value = false;
};

onMounted(() => window.addEventListener('click', onClickOutside));
onUnmounted(() => window.removeEventListener('click', onClickOutside));

const hideSuggestions = () => showSuggestions.value = false;
const selectSuggestion = (suggestion) => { searchQuery.value = suggestion.name; hideSuggestions(); };
const clearSearch = () => { searchQuery.value = ''; };
const clearTargeting = () => { selectedTargeting.value = []; };
const clearFilters = () => { selectedCategories.value = []; clearSearch(); clearTargeting(); };
const updateTargeting = (value, checked) => checked ? selectedTargeting.value.push(value) : selectedTargeting.value = selectedTargeting.value.filter(item => item !== value);
const loadMore = () => {
  loadingMore.value = true;
  setTimeout(() => { limit.value += 5; loadingMore.value = false; }, 1000);
};
</script>

<template>
  <AppLayout>

    <Head title="Plugin Browser" />


    <div class="max-w-screen-xl mx-auto p-4">
      <h1 class="text-3xl font-bold uppercase text-center mt-4">Find your favorite plugins</h1>
      <h2 class="text-xl text-center mb-2">Hangar allows you to find the best Paper, Velocity, or Waterfall
        plugins for your Minecraft server.</h2>

      <div class="flex">
        <!-- Left Column: Search and Filters -->
        <div class="flex-none w-1/4 p-4">
          <!-- Search Bar -->
          <form class="flex items-center" @submit.prevent="clearSearch">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full ">
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none ">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
              </div>
              <input v-model="searchQuery" type="text" id="simple-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md  focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5"
                placeholder="Search plugins" required @input="onSearchInput">
              <!-- Suggestions Dropdown -->
              <div v-if="showSuggestions"
                class="absolute z-10 mt-2 w-full bg-white border border-gray-300 rounded shadow-lg">
                <div v-for="suggestion in suggestions" @click="selectSuggestion(suggestion)"
                  class="p-2 hover:bg-gray-100 cursor-pointer">
                  {{ suggestion.name }}
                </div>
              </div>
            </div>
          </form>
          <div class="background-default border shadow-md rounded-md p-4 overflow-hidden border-gray-300 transition-all cursor-pointer mt-8">
            <div class="flex flex-col space-y-4">
              <label for="ordering" class="block text-sm font-medium text-gray-700">Order:</label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <select id="ordering" v-model="selectedOrdering"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 hover:bg-gray-100">
                  <option value="updated_at">Updated At</option>
                  <option value="download_count">Download Count</option>
                  <option value="view_count">View Count</option>
                </select>
              </div>
            </div>

            <div class="flex flex-col space-y-4 mt-4">
              <label for="ordering" class="block text-sm font-medium text-gray-700">Clear fliters</label>
              <button @click="clearSearch"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-1 hover:bg-gray-100">
                Clear Search
              </button>
              <button @click="clearTargeting"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-1 hover:bg-gray-100">
                Clear Target
              </button>
              <button @click="clearFilters"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-gray-500 focus:border-gray-500 block w-full p-1 hover:bg-gray-100">
                Clear Filters
              </button>

            </div>
          </div>




          <div
            class="background-default border shadow-md rounded-md p-4 overflow-hidden border-gray-300 transition-all cursor-pointer mt-8">
            <h4 class="text-lg font-bold text-gray-600">Platform</h4>
            <div class="pt-6 space-y-4">
              <div class="flex flex-col space-y-1">
                <div class="flex items-center" v-for="target in ['web', 'bancho']">
                  <input :id="`filter-target-${target}`" type="checkbox" :value="target" v-model="selectedTargeting"
                    class="h-4 w-4 rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                  <label :for="`filter-target-${target}`" class="ml-3 text-sm text-gray-600">{{ target }}</label>
                </div>
              </div>
            </div>
          </div>



          <div
            class="background-default border shadow-md rounded-md p-4 overflow-hidden border-gray-300 transition-all cursor-pointer mt-8">
            <h4 class="text-lg font-bold text-gray-600">Categories</h4>
            <div class="pt-6 space-y-4">
              <div class="flex flex-col space-y-2">
                <div class="flex items-center" v-for="category in categories">
                  <input :id="`filter-category-${category.id}`" type="checkbox" :value="category.id"
                    v-model="selectedCategories"
                    class="h-4 w-4 rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                  <label :for="`filter-category-${category.id}`" class="ml-3 text-sm text-gray-600">{{ category.name
                  }}</label>
                </div>
              </div>
            </div>
          </div>







        </div>

        
        <div class="flex flex-col items-center md:items-start space-y-4 p-4 w-full md:min-w-[600px] mx-auto">

          <div v-if="loading" style="width: 100%;">
            
            <div
              class="background-default border dark:border-gray-800 shadow-md rounded-md p-4 overflow-hidden !border-gray-300 !dark:border-gray-700 border-1px hover:bg-gray-100 dark:hover:bg-gray-300 transition-all cursor-pointer h-auto">
              <div class="flex space-x-4 h-full">
                <div class="flex-shrink-0">
                  <div class="rounded-lg h-20 md:h-24">
                    <img class="rounded-lg w-full h-full object-cover"
                      src="https://www.dockhunt.com/_next/image?url=https%3A%2F%2Fdockhunt-images.nyc3.cdn.digitaloceanspaces.com%2Fplaceholder.png&w=256&q=75"
                      alt="Loading...">
                  </div>
                </div>
                <div class="overflow-hidden min-w-0 flex-grow">
                  <h2 class="text-lg font-bold text-gray-600 hover:underline">
                    Loading...
                  </h2>
                  <span class="text-sm font-normal overflow-hidden">by <span
                      class="font-bold color-primary hover:underline overflow-hidden">Author</span></span>
                  <h3 class="mb-1 text-sm truncate-3-lines w-full md:min-w-[600px] mx-auto">Description loading...</h3>
                  
                  <div class="plugin-categories flex">
                  
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div v-else>
            <PluginList :plugins="displayedPlugins" />
          </div>
          <div v-if="loadingMore" style="width: 100%;">
            <div
              class="background-default border dark:border-gray-800 shadow-md rounded-md p-4 overflow-hidden !border-gray-300 !dark:border-gray-700 border-1px hover:bg-gray-100 dark:hover:bg-gray-300 transition-all cursor-pointer h-auto mw-auto ">
              <div class="flex space-x-4 h-full">
                <div class="flex-shrink-0">
                  <div class="rounded-lg h-20 md:h-24">
                    <img class="rounded-lg w-full h-full object-cover"
                      src="https://www.dockhunt.com/_next/image?url=https%3A%2F%2Fdockhunt-images.nyc3.cdn.digitaloceanspaces.com%2Fplaceholder.png&w=256&q=75"
                      alt="Loading...">
                  </div>
                </div>
                <div class="overflow-hidden min-w-0 flex-grow">
                  <h2 class="text-lg font-bold text-gray-600 hover:underline">
                    Loading...
                  </h2>
                  <span class="text-sm font-normal overflow-hidden">by <span
                      class="font-bold color-primary hover:underline overflow-hidden">Author</span></span>
                  <h3 class="mb-1 text-sm truncate-3-lines w-full md:min-w-[600px] mx-auto ">Description loading...</h3>
                </div>
              </div>
          </div>
        </div>


        <button @click="loadMore" class="p-2 rounded bg-teal-600 text-white" style="align-items: center;">
          Load More
        </button>
      </div>





    </div>
  </div>
</AppLayout></template>
