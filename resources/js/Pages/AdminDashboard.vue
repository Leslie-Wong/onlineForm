<template>
    <jetin-layout :title="__('Dashboard')">
        <div class="flex flex-wrap mt-4">
                  <!--                <inertia-button v-if="withSidebar" @click.native.prevent="toggleSidebarMin" pill style="z-index: 100"
                                  class="absolute text-white bg-gray-800 h-11 w-11 -top-2 -left-3 md:-top-1 md:-left-8 focus:outline-none focus:ring-0">
                      <i class="fas" :class="{'fa-angle-left': !minSidebar,'fa-angle-right': minSidebar}"></i>
                  </inertia-button>-->
                  <div class="w-full px-1 mx-auto mb-4 lg:px-10">
                      <div>
                          <!-- Card stats -->
                          <!-- <div class="flex flex-wrap">
                              <slot name="header">
                                  <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
                                      <div
                                          class="relative flex flex-col min-w-0 mb-6 break-words bg-white rounded shadow-lg  xl:mb-0"
                                      >
                                          <div class="flex-auto p-4">
                                              <div class="flex flex-wrap">
                                                  <div
                                                      class="relative flex-1 flex-grow w-full max-w-full pr-4 "
                                                  >
                                                      <h5
                                                          class="text-xs font-bold text-gray-500 uppercase "
                                                      >
                                                          Traffic
                                                      </h5>
                                                      <span
                                                          class="text-xl font-semibold text-gray-800 "
                                                      >
                                                          350,897
                                                      </span>
                                                  </div>
                                                  <div
                                                      class="relative flex-initial w-auto pl-4 "
                                                  >
                                                      <div
                                                          class="inline-flex items-center justify-center w-12 h-12 p-3 text-center text-white bg-red-500 rounded-full shadow-lg "
                                                      >
                                                          <i
                                                              class=" far fa-chart-bar"
                                                          ></i>
                                                      </div>
                                                  </div>
                                              </div>
                                              <p
                                                  class="mt-4 text-sm text-gray-500 "
                                              >
                                                  <span
                                                      class="mr-2 text-green-500"
                                                  >
                                                      <i
                                                          class="fas fa-arrow-up"
                                                      ></i>
                                                      3.48%
                                                  </span>
                                                  <span
                                                      class="whitespace-no-wrap"
                                                  >
                                                      Since last month
                                                  </span>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
                                      <div
                                          class="relative flex flex-col min-w-0 mb-6 break-words bg-white rounded shadow-lg  xl:mb-0"
                                      >
                                          <div class="flex-auto p-4">
                                              <div class="flex flex-wrap">
                                                  <div
                                                      class="relative flex-1 flex-grow w-full max-w-full pr-4 "
                                                  >
                                                      <h5
                                                          class="text-xs font-bold text-gray-500 uppercase "
                                                      >
                                                          New users
                                                      </h5>
                                                      <span
                                                          class="text-xl font-semibold text-gray-800 "
                                                      >
                                                          2,356
                                                      </span>
                                                  </div>
                                                  <div
                                                      class="relative flex-initial w-auto pl-4 "
                                                  >
                                                      <div
                                                          class="inline-flex items-center justify-center w-12 h-12 p-3 text-center text-white bg-orange-500 rounded-full shadow-lg "
                                                      >
                                                          <i
                                                              class=" fas fa-chart-pie"
                                                          ></i>
                                                      </div>
                                                  </div>
                                              </div>
                                              <p
                                                  class="mt-4 text-sm text-gray-500 "
                                              >
                                                  <span class="mr-2 text-red-500">
                                                      <i
                                                          class=" fas fa-arrow-down"
                                                      ></i>
                                                      3.48%
                                                  </span>
                                                  <span
                                                      class="whitespace-no-wrap"
                                                  >
                                                      Since last week
                                                  </span>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
                                      <div
                                          class="relative flex flex-col min-w-0 mb-6 break-words bg-white rounded shadow-lg  xl:mb-0"
                                      >
                                          <div class="flex-auto p-4">
                                              <div class="flex flex-wrap">
                                                  <div
                                                      class="relative flex-1 flex-grow w-full max-w-full pr-4 "
                                                  >
                                                      <h5
                                                          class="text-xs font-bold text-gray-500 uppercase "
                                                      >
                                                          Sales
                                                      </h5>
                                                      <span
                                                          class="text-xl font-semibold text-gray-800 "
                                                      >
                                                          924
                                                      </span>
                                                  </div>
                                                  <div
                                                      class="relative flex-initial w-auto pl-4 "
                                                  >
                                                      <div
                                                          class="inline-flex items-center justify-center w-12 h-12 p-3 text-center text-white bg-pink-500 rounded-full shadow-lg "
                                                      >
                                                          <i
                                                              class="fas fa-users"
                                                          ></i>
                                                      </div>
                                                  </div>
                                              </div>
                                              <p
                                                  class="mt-4 text-sm text-gray-500 "
                                              >
                                                  <span
                                                      class="mr-2 text-orange-500"
                                                  >
                                                      <i
                                                          class=" fas fa-arrow-down"
                                                      ></i>
                                                      1.10%
                                                  </span>
                                                  <span
                                                      class="whitespace-no-wrap"
                                                  >
                                                      Since yesterday
                                                  </span>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="w-full px-4 lg:w-6/12 xl:w-3/12">
                                      <div
                                          class="relative flex flex-col min-w-0 mb-6 break-words bg-white rounded shadow-lg  xl:mb-0"
                                      >
                                          <div class="flex-auto p-4">
                                              <div class="flex flex-wrap">
                                                  <div
                                                      class="relative flex-1 flex-grow w-full max-w-full pr-4 "
                                                  >
                                                      <h5
                                                          class="text-xs font-bold text-gray-500 uppercase "
                                                      >
                                                          Performance
                                                      </h5>
                                                      <span
                                                          class="text-xl font-semibold text-gray-800 "
                                                      >
                                                          49,65%
                                                      </span>
                                                  </div>
                                                  <div
                                                      class="relative flex-initial w-auto pl-4 "
                                                  >
                                                      <div
                                                          class="inline-flex items-center justify-center w-12 h-12 p-3 text-center text-white bg-blue-500 rounded-full shadow-lg "
                                                      >
                                                          <i
                                                              class=" fas fa-percent"
                                                          ></i>
                                                      </div>
                                                  </div>
                                              </div>
                                              <p
                                                  class="mt-4 text-sm text-gray-500 "
                                              >
                                                  <span
                                                      class="mr-2 text-green-500"
                                                  >
                                                      <i
                                                          class="fas fa-arrow-up"
                                                      ></i>
                                                      12%
                                                  </span>
                                                  <span
                                                      class="whitespace-no-wrap"
                                                  >
                                                      Since last month
                                                  </span>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                              </slot>
                          </div> -->
                      </div>
                  </div>
            <div class="w-full px-4 mb-12 xl:w-8/12 xl:mb-0">
                <div class="relative flex flex-col w-full min-w-0 mb-6 break-words bg-white rounded shadow-lg">
                    <!-- <div class="px-4 py-3 mb-0 border-0 rounded-t">
                        <div class="flex flex-wrap items-center">
                            <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                                <h3 class="text-base font-semibold text-gray-800">
                                    Page visits
                                </h3>
                            </div>
                            <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
                                <button
                                    class="px-3 py-1 mb-1 mr-1 text-xs font-bold text-white uppercase bg-indigo-500 rounded outline-none active:bg-indigo-600 focus:outline-none"
                                    type="button"
                                    style="transition:all .15s ease"
                                >
                                    See all
                                </button>
                            </div>
                        </div>
                    </div> -->
                    <div class="block w-full overflow-x-auto">
                        <!-- Projects table -->
                        <!-- <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Page name
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Visitors
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Unique users
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Bounce rate
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    /argon/
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    4,569
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    340
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <i class="mr-4 text-green-500 fas fa-arrow-up"></i>
                                    46,53%
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    /argon/index.html
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    3,985
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    319
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <i class="mr-4 text-orange-500 fas fa-arrow-down"></i>
                                    46,53%
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    /argon/charts.html
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    3,513
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    294
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <i class="mr-4 text-orange-500 fas fa-arrow-down"></i>
                                    36,49%
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    /argon/tables.html
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    2,050
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    147
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <i class="mr-4 text-green-500 fas fa-arrow-up"></i>
                                    50,87%
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    /argon/profile.html
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    1,795
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    190
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <i class="mr-4 text-red-500 fas fa-arrow-down"></i>
                                    46,53%
                                </td>
                            </tr>
                            </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
            <div class="w-full px-4 xl:w-4/12">
                <div class="relative flex flex-col w-full min-w-0 mb-6 break-words bg-white rounded shadow-lg">
                    <!-- <div class="px-4 py-3 mb-0 border-0 rounded-t">
                        <div class="flex flex-wrap items-center">
                            <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                                <h3 class="text-base font-semibold text-gray-800">
                                    Social traffic
                                </h3>
                            </div>
                            <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
                                <button
                                    class="px-3 py-1 mb-1 mr-1 text-xs font-bold text-white uppercase bg-indigo-500 rounded outline-none active:bg-indigo-600 focus:outline-none"
                                    type="button"
                                    style="transition:all .15s ease"
                                >
                                    See all
                                </button>
                            </div>
                        </div>
                    </div> -->
                    <div class="block w-full overflow-x-auto">
                        <!-- Projects table -->
                        <!-- <table class="items-center w-full bg-transparent border-collapse">
                            <thead class="thead-light">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Referral
                                </th>
                                <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid">
                                    Visitors
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase whitespace-no-wrap align-middle bg-gray-100 border border-l-0 border-r-0 border-gray-200 border-solid"
                                    style="min-width:140px"
                                ></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    Facebook
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    1,480
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <div class="flex items-center">
                                        <span class="mr-2">60%</span>
                                        <div class="relative w-full">
                                            <div class="flex h-2 overflow-hidden text-xs bg-red-200 rounded">
                                                <div
                                                    style="width:60%"
                                                    class="flex flex-col justify-center text-center text-white bg-red-500 shadow-none whitespace-nowrap"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    Facebook
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    5,480
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <div class="flex items-center">
                                        <span class="mr-2">70%</span>
                                        <div class="relative w-full">
                                            <div class="flex h-2 overflow-hidden text-xs bg-green-200 rounded">
                                                <div
                                                    style="width:70%"
                                                    class="flex flex-col justify-center text-center text-white bg-green-500 shadow-none whitespace-nowrap"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    Google
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    4,807
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <div class="flex items-center">
                                        <span class="mr-2">80%</span>
                                        <div class="relative w-full">
                                            <div class="flex h-2 overflow-hidden text-xs bg-purple-200 rounded">
                                                <div
                                                    style="width:80%"
                                                    class="flex flex-col justify-center text-center text-white bg-purple-500 shadow-none whitespace-nowrap"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    Instagram
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    3,678
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <div class="flex items-center">
                                        <span class="mr-2">75%</span>
                                        <div class="relative w-full">
                                            <div class="flex h-2 overflow-hidden text-xs bg-blue-200 rounded">
                                                <div
                                                    style="width:75%"
                                                    class="flex flex-col justify-center text-center text-white bg-blue-500 shadow-none whitespace-nowrap"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="p-4 px-6 text-xs text-left whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    twitter
                                </th>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    2,645
                                </td>
                                <td class="p-4 px-6 text-xs whitespace-no-wrap align-middle border-t-0 border-l-0 border-r-0">
                                    <div class="flex items-center">
                                        <span class="mr-2">30%</span>
                                        <div class="relative w-full">
                                            <div class="flex h-2 overflow-hidden text-xs bg-orange-200 rounded">
                                                <div
                                                    style="width:30%"
                                                    class="flex flex-col justify-center text-center text-white bg-green-500 shadow-none whitespace-nowrap"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
        </div>
    </jetin-layout>
  </template>
  <script>
  import JetinLayout from "@/Layouts/JetinLayout.vue";
  export default {
    name: "dashboard-page",
    components: {
        JetinLayout,
    },
    data() {
      return {
        date: new Date().getFullYear(),
          showModal: false,
      }
    }
  };
  </script>
  