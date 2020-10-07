<div class="pt-4 mx-auto max-w-screen-xl" x-data="loadEmployees()">
  <div class="relative group text-gray-600">
    <input x-ref="searchField" x-model="search" x-on:keydown.window.prevent.slash="$refs.searchField.focus()"
      placeholder="Search for an employee..." type="search"
      class="relative group block w-full bg-gray-200 focus:outline-none focus:bg-white focus:shadow text-gray-600 rounded-lg px-4 py-3" />
  </div>
  <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4 h-full">
    <template x-for="item in filteredEmployees" :key="item">
      <div class="employee-badge grid place-content-center text-center rounded shadow p-3">
        <figure class="group relative grid place-content-center mb-2">
          <img :src="`${item.profile_image}`" alt=""
            :class="`relative inline-block h-24 w-24 rounded-full text-white mx-auto is-${item.employee_status_color}`">
          <div
            :class="`absolute w-4 h-4 bg-${item.employee_status_color}-500 border border-${item.employee_status_color}-700 rounded-full bottom-0 right-0 transform -translate-y-1 -translate-x-2`">
          </div>
        </figure>
        <div class="text-sm">
          <p class="text-gray-800 text-lg leading-none my-1" x-text="item.employee_name"></p>
          <p :class="`px-2 py-1 text-xs rounded-full bg-${item.employee_status_color}-200 text-${item.employee_status_color}-800`"
            x-text="item.employee_status"></p>
        </div>
      </div>
    </template>
  </div>
</div>
<script>
  function loadEmployees() {
    return {
      search: "",
      employeeData: sourceData,
      get filteredEmployees() {
        if (this.search === "") {
          return this.employeeData;
        }
        return this.employeeData.filter((item) => {
          return item.employee_name
            .toLowerCase()
            .includes(this.search.toLowerCase());
        });
      },
    };
  }

  var sourceData = [
    <% loop AllEmployees %>
    {
      id: "$ID",
      employee_name: "{$FullName}",
      employee_status_color: "{$CurrentStatusColor}",
      employee_status: "{$CurrentStatus}",
      profile_image: "{$Image.FocusFill(300, 300).AbsoluteURL}",
    },
    <% end_loop %>
  ]
</script>
