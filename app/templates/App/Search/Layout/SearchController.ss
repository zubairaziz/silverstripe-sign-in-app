<article class="search-results">
  <div class="container text-center">
    <div class="search-results__header">
      <div>
        <h1 class="search-results__title">Search Results</h1>
        <div class="search-results__query">
          Search results for: <strong>$Term</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="search-results__content">
    <div class="container">
      <% if NoResults %>
      <div class="search-results__empty">No results found. Please try a different search.</div>
      <% else %>
      <ul class="search-results__list list-unstyled">
        <% if PageResults.Count %>
        <li class="search-results__list-item">
          <div>
            <div>
              <% with PageResults %>
              <% include SearchResults %>
              <% end_with %>
            </div>
          </div>
        </li>
        <% end_if %>
      </ul>
      <% end_if %>
      <% if PageResults.Count %>
      <% if PageResults.MoreThanOnePage %>
      <% with PageResults %>
      <% include PaginatedListNav ResultType="page" %>
      <% end_with %>
      <% end_if %>
      <% end_if %>
    </div>
  </div>
</article>
