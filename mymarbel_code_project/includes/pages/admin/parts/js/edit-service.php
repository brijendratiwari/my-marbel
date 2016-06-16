<script id="service_input">
  <div class="service_item">
    <div class="row-fluid">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="col-md-12">
            <select name="service_name_%length%">
              <option value="">Please select a service option</option>
              <option value="replace_drive_system">Replaced Drive System</option>
              <option value="deck_replaced">Deck Replaced $350.00</option>
              <option value="nose_replaced">Nose Replaced $99</option>
              <option value="rear_bumper_replaced">Rear Bumper Replaced $15</option>
              <option value="griptape_replaced">Griptape Replaced $29.99</option>
              <option value="electronic_circut_replaced">Marbel Electronic Circuit Replaced $340.00</option>
              <option value="battery_system_replaced">Battery System Replaced $320.00</option>
              <option value="phase_wire_repair">Phase Wire Check/Repair $29.99</option>
              <option value="drive_system_tuned">Drive System Tuned $29.99</option>
              <option value="full_drive_system_replaced">Full Drive System Replaced $195</option>
              <option value="drive_belt_replaced">Drive Belt Replaced $15</option>
              <option value="motor_replaced">Motor Replaced $85.00</option>
              <option value="motor_position_sensor_replaced">Motor Position Sensor Replaced $45.00</option>
              <option value="belt_cover_replaced">Belt Cover Replaced $29.99</option>
              <option value="fan_cap_check_repaired">Fan Cap Check/Repaired $0</option>
              <option value="76mm_wheel_replaced">76mm Wheel Replaced (single) $12.50</option>
              <option value="100mm_wheel_replaced">100mm Wheel Replaced (single) $18.75</option>
              <option value="bearings_replaced">Bearings Replaced $24.95</option>
              <option value="spacers_replaced">Spacers Replaced $2</option>
              <option value="remote_repaired">Remote Repaired $49.99</option>
              <option value="remote_replaced">Remote Replaced $99.99</option>
              <option value="remote_firmware_update">Remote Firmware Update $0</option>
              <option value="labor">Labor $75</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="col-md-4">
            <div class="col-md-5">Qty:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_qty_%length%" /></div>
          </div>  
          <div class="col-md-4">
            <div class="col-md-5">Rate:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_rate_%length%" /></div>
          </div>  
          <div class="col-md-4">
            <div class="col-md-5">Amount:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_amt_%length%" /></div>
          </div>  
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="col-md-12" style="margin: 10px 0 20px 0;">
        <div class="col-md-6">
          <div class="col-md-12">
            <input type="text" name="service_description_%length%" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="col-md-4">
            <div class="col-md-5">Discount:</div><div class="col-md-7"><input class="col-md-12" type="text" name="service_discount_%length%" /></div>
          </div>
          <div class="col-md-8">
            <div class="col-md-4">Finish</div><div class="col-md-12"><input type="checkbox" name="service_finish_%length%" /></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="application/javascript">
  $(document).ready(function () {
    $('#add_service_item').click(function() {
      console.log("clicked the add service item")
      var text = $("#service_input").html().replace(/\%length%/g, $('#service_items').children().size()); 
      $('#service_items').append(text);
      $('#service_item_count').val($('#service_items').children().size());
    });
  });
</script>