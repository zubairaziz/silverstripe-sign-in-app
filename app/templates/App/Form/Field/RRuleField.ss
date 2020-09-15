<div id="RRuleField" class="rrulefield">
  <input style="width:300px" id="{$ID}" type="text" name="$Name" value="$Value">

  <div class="control-fields">
    <div class="frequency-wrapper field-wrapper">
      <label class="wrapper-label">Frequency</label>

      <ul class="optionset">
        <li><label><input class="radio" name="frequency" type="radio" value="DAILY"> Daily</label></li>
        <li><label><input class="radio" name="frequency" type="radio" value="WEEKLY"> Weekly</label></li>
      </ul>
    </div>

    <div class="interval-wrapper field-wrapper">
      <label class="wrapper-label">Every</label>

      <select name="interval" class="dropdown">
        <option value="1" selected="selected">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
      </select>

      <div class="interval-label">days</div>
    </div>

    <div class="bydays-wrapper field-wrapper">
      <label class="wrapper-label">On these days</label>

      <ul class="optionset checkboxset">
        <li><label><input type="checkbox" class="checkbox" name="byday" value="SU"> SU</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="MO"> MO</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="TU"> TU</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="WE"> WE</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="TH"> TH</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="FR"> FR</label></li>
        <li><label><input type="checkbox" class="checkbox" name="byday" value="SA"> SA</label></li>
      </ul>
    </div>

        <div class="repeatby-wrapper field-wrapper">
          <label class="wrapper-label">Repeat By</label>

          <ul class="optionset">
            <li><label><input type="radio" name="repeatby" class="radio" value="bymonthday"> day of the month</label></li>
            <li><label><input type="radio" name="repeatby" class="radio" value="byweekday"> day of the week</label></li>
          </ul>
        </div>

        <div class="until-wrapper field-wrapper">
          <label class="wrapper-label">Stops repeating</label>

          <ul class="optionset">
            <li><label><input type="radio" name="until" class="radio" value="never"> Never</label></li>
            <li><label><input type="radio" name="until" class="radio" value="date"> On <input type="text" class="until-date"></label></li>
          </ul>
        </div>
  </div>

  <div class="rrule-summary"></div>

</div>
