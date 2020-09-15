<article>
  <% include DigitalClock %>
  <div class="button-toolbar-center">
    <button data-custom-open="modal-1" role="button" class="button button-primary">Sign In</a>
  </div>
</article>

<%-- Sign In Modal --%>
<div id="modal-1" aria-hidden="true">
  <div tabindex="-1" data-micromodal-close>
    <div role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header>
        <h2 id="modal-1-title">
          Modal Title
        </h2>
        <button aria-label="Close modal" data-micromodal-close></button>
      </header>

      <div id="modal-1-content">
        Modal Content
      </div>

    </div>
  </div>
</div>
