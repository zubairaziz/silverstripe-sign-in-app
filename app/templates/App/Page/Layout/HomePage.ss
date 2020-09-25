<%-- $Debug --%>

<article>
  <% include DigitalClock %>
  <% if IsLoggedIn %>
  <h2>Logged In</h2>
  <div class="button-toolbar-center">
    $SignOutForm
  </div>
  <% else %>
  <div class="button-toolbar-center">
    <button data-custom-open="modal-1" role="button" class="button button-primary">Sign In</a>
  </div>
  $SignInForm
  <% end_if %>
</article>


<%-- Sign In Modal --%>
<%-- <div id="modal-1" aria-hidden="true">
  <div tabindex="-1" data-micromodal-close>
    <div role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header>
        <h2 id="modal-1-title">
          Sign In
        </h2>
        <button aria-label="Close modal" data-micromodal-close></button>
      </header>


      <div id="modal-1-content">
        <form method="POST" action="$AbsoluteURL" autocomplete="off" class="form" data-form-ajax>
          <div class="fields">
            <input type="number" name="PIN" id="pin" min="1000" max="9999" placeholder="Insert 4 digit employee number"
              required>
            <input type="hidden" name="SignedIn" value="true">
            <input class="button button-primary" type="submit" value="Sign In">
          </div>
          <div class="form-error-message"></div>
        </form>
      </div>

    </div>
  </div>
</div> --%>
