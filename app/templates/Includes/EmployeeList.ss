<div class="max-w-screen-xl pt-4 mx-auto" x-data="loadEmployees()">
  <div class="relative text-gray-600 group">
    <input x-ref="searchField" x-model="search" x-on:keydown.window.prevent.slash="$refs.searchField.focus()"
      placeholder="Search for an employee..." type="search"
      class="relative block w-full px-4 py-3 text-gray-600 bg-gray-200 rounded-lg group focus:outline-none focus:bg-white focus:shadow" />
  </div>
  <div class="grid h-full grid-cols-2 gap-4 mt-4 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8">
    <template x-for="item in filteredEmployees" :key="item">
      <div class="grid p-3 text-center bg-gray-100 rounded shadow employee-badge place-content-center">
        <figure class="relative grid mb-2 group place-content-center">
          <img :src="`${item.profile_image}`" alt=""
            :class="`relative inline-block h-24 w-24 rounded-full text-white mx-auto is-${item.employee_status_color}`">
          <div
            :class="`status-indicator is-${item.employee_status_color} border absolute w-4 h-4 rounded-full bottom-0 right-0 transform -translate-y-1 -translate-x-2`">
          </div>
        </figure>
        <div class="text-sm">
          <p class="my-1 text-lg leading-none text-gray-800" x-text="item.employee_name"></p>
          <p :class="`status-text is-${item.employee_status_color} px-2 py-1 text-xs rounded-full`"
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
      profile_image: "<% if Image %>{$Image.FocusFill(300, 300).AbsoluteURL}<% else %>{$Asset('images/default-image.svg')}<% end_if %>",
    },
    <% end_loop %>
  ]
</script>
