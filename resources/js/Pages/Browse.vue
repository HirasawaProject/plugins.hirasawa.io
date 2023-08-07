<script setup>
import { defineProps, ref, computed, reactive } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PluginList from './Plugins/PluginList.vue';

const { plugins, categories } = defineProps({
  plugins: {
    type: Object,
  },
  categories: {
    type: Array,
  },
});

const limit = ref(2);

const displayedPlugins = computed(() => {
  return plugins.slice(0, limit.value);
});

const loadMore = async () => {
  limit.value += 2;
};
</script>

<template>

    <AppLayout>
        
        <Head title="Plugin Browser"/>
        

        <div class="max-w-screen-xl mx-auto p-4">
            <h1 class="text-3xl font-bold uppercase text-center mt-4">Find your favorite plugins</h1>
            <h2 class="text-xl text-center mb-2">Hangar allows you to find the best Paper, Velocity, or Waterfall
                plugins for your Minecraft server.</h2>

            <div class="flex">
                <!-- Left Column: Search and Filters -->
                <div class="flex-none w-1/4 p-4">
                    <!-- Search Bar -->
                    <div class="relative rounded-md shadow-md mb-4">
                        <input value="" class="rounded-md p-4 w-full bg-gray-700 dark:bg-gray-700" type="text"
                            placeholder="Search plugins">
                    </div>
                    <!-- Filters (if any) will go here -->

                    <div
                        class="mt-8 rounded-md p-4 border border-indigo-300 rounded-2xl hover:shadow-xl hover:shadow-indigo-50 flex flex-col items-left">
                        <h4 class="font-bold">Platform</h4>
                        <div class="pt-6 space-y-4" id="filter-section-2">
                            <div id="categoriesFilter" class="space-y-1">

                                <div id="categoriesFilter">

                                    <div class="flex items-left">
                                        <input id="filter-size-5" name="categories[]" type="checkbox"                                            value="web" checked
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-size-5" class="ml-3 text-sm text-gray-600">Web</label>
                                    </div>

                                    <div class="flex items-left">
                                        <input id="filter-size-5" name="categories[]" type="checkbox" value="bancho" checked
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-size-5" class="ml-3 text-sm text-gray-600">Bancho</label>
                                    </div>

                                    <div class="flex items-left">
                                        <input id="filter-size-5" name="categories[]" type="checkbox" value="both" checked
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-size-5" class="ml-3 text-sm text-gray-600">Both</label>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                    <div
                        class="mt-8 rounded-md p-4 border border-indigo-300 rounded-2xl hover:shadow-xl hover:shadow-indigo-50 flex flex-col items-left">
                        <h4 class="font-bold">Categories</h4>
                        <div class="pt-6 space-y-4" id="filter-section-2">
                            <div id="categoriesFilter" class="space-y-2">

                                <div id="categoriesFilter">
                                    <div class="flex items-left" v-for="category in categories">
                                        <input id="filter-size-5" name="categories[]" value="40l" type="checkbox"
                                            :value="category.id" checked
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-size-5" class="ml-3 text-sm text-gray-600">{{ category.name }}</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>






                </div>

                <!-- Right Column: List of Plugins -->
                <div class="flex-grow p-4">
                    <PluginList :plugins="displayedPlugins" />
                    <button @click="loadMore" class="p-2 rounded bg-teal-600 text-white">
                        Load More
                      </button>
                    <!-- load more button -->
                    <a href="#_" id="load-more-button" style="align-items: center"
                        class="inline-flex items-center justify-center h-16 px-10 py-0 text-xl font-semibold text-center text-gray-200 no-underline align-middle transition-all duration-300 ease-in-out bg-transparent border-2 border-gray-600 border-solid rounded-full cursor-pointer select-none hover:text-white hover:border-white focus:shadow-xs focus:no-underline">
                        Load More Plugins
                    </a>
                    <!-- load more button end -->
                    <!-- load more loading screen -->
                    <div class="ajax-load text-center relative " style="display:none">
                        <div class="block max-w-550px opacity-50">
                            <div
                                class="background-default border dark:border-gray-800 shadow-md rounded-md p-4 overflow-hidden !border-gray-300 !dark:border-gray-700 border-1px h-auto md:h-36">
                                <div class="flex space-x-4 h-full">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-lg w-20 h-20 md:w-24 md:h-24 bg-gray-200"></div>
                                        <!-- Placeholder for Image -->
                                    </div>
                                    <div class="overflow-hidden min-w-0 flex-grow">
                                        <h2 class="text-lg font-bold text-gray-400 flex items-center">
                                            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
                                                role="status">
                                                <span
                                                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                                            </div>
                                            Loading...
                                        </h2>
                                        <h3 class="mb-1 text-sm text-gray-400 truncate">Loading description...</h3>
                                        <!-- Placeholder for Description -->
                                        <div class="flex space-x-4 text-sm">
                                            <span class="inline-flex items-center text-gray-400">
                                                Loading... <!-- Placeholder for Targeting -->
                                            </span>
                                            <span class="inline-flex items-center text-gray-400">
                                                Loading... <!-- Placeholder for Downloads -->
                                            </span>
                                            <span class="inline-flex items-center text-gray-400">
                                                Loading... <!-- Placeholder for Version -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout >
</template>