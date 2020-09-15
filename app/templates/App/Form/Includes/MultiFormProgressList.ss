<ul class="nav nav-tabs donation-form__tab">
  <% loop AllStepsLinear %>
  <li
    class="nav-item step<% if $LinkingMode %> $LinkingMode<% end_if %><% if $FirstLast %> $FirstLast<% end_if %><% if $ExtraClasses %> $ExtraClasses<% end_if %>">
    <% if $LinkingMode = current %>
    <div class="nav-link inner">
      <% else %>
      <% if $ID %>
      <a href="$Link" class="nav-link inner">
        <% else %>
        <div class="nav-link inner">
          <% end_if %>
          <% end_if %>
          <span class="title">
            $Title
          </span>

          <% if $LinkingMode = current %>
        </div>
        <% else %>
        <% if $ID %></a><% else %></div><% end_if %>
    <% end_if %>
  </li>
  <% end_loop %>
</ul>
