<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bulk QR Generator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-card {
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-control {
      font-size: 0.9rem;
      padding: 0.375rem 0.75rem;
    }
    .form-label {
      font-size: 0.85rem;
    }
    input[readonly] {
      background-color: #f0f0f0 !important;
    }

    /* Remove number input arrows for Chrome, Safari, Edge, Opera */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* For Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }    
  </style>
</head>
<body>

  <div class="card form-card">

    <div class="text-center mb-3"> 
      <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="MCGM Deonar Abattoir Software" height="100" class="lohimg"> 
    </div>

    <form autocomplete="off" action="<?= base_url('Qrcodegenerator/create_bulk_qrimage') ?>" method="get" onsubmit="validateFormAndReset()" target="_blank">
      <h5 class="text-center mb-3">Generate Bulk QR Codes</h5>

      <div class="row mb-2">
        <div class="col-6">
          <label for="qr_digit" class="form-label">QR Digit</label>
          <input type="number" class="form-control" id="qr_digit" name="qr_digit"
                 value="<?php echo $printing_qrcode_digit; ?>" readonly disabled>
            <em style="font-size:10px">E.g 000001</em>
        </div>
        <div class="col-6 mb-2">
          <label for="qr_version" class="form-label">QR Version</label>
          <input type="number" class="form-control" id="qr_version" name="qr_version"
                 value="<?php echo $printing_qrcode_version; ?>" readonly disabled>
            <em style="font-size:10px">E.g <?php echo $printing_qrcode_version; ?>000001</em>
        </div>
      </div>   

      <div class="mb-2">
        <label for="bookno" class="form-label">Book No</label>
        <input type="text" class="form-control" id="bookno" name="bookno" autocomplete="off" required>
      </div>

<div class="row mb-2">
  <div class="col-6">
    <label for="start" class="form-label">Start</label>
    <input 
    type="number" 
    step="1"
    class="form-control" 
    id="start" 
    name="start"
    onwheel="this.blur()" 
    onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"
    oninput="enforceSixDigitLimit(this)" autocomplete="off" required>
  </div>
  <div class="col-6 mb-2">
    <label for="end" class="form-label">End</label>
    <input 
    type="number" 
    step="1"
    class="form-control" 
    id="end" 
    name="end"
    onwheel="this.blur()" 
    onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"           
    oninput="enforceSixDigitLimit(this)" autocomplete="off" required>
  </div>
</div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-sm">Generate</button>
      </div>
    </form>
  </div>

<script>
  function validateFormAndReset() {
    const startInput = document.getElementById("start");
    const endInput = document.getElementById("end");
    const booknoInput = document.getElementById("bookno");

    const start = parseInt(startInput.value, 10);
    const end = parseInt(endInput.value, 10);

    // Check if start and end are valid numbers
    if (isNaN(start) || isNaN(end)) {
      alert("Please enter valid start and end numbers.");
      event.preventDefault();
      return false;
    }

    // Validate that end is greater than start
    if (end <= start) {
      alert("End number must be greater than Start number.");
      event.preventDefault();
      return false;
    }

    // Submit form and then reset only certain fields after a brief delay
    setTimeout(() => {
      //booknoInput.value = "";
      //startInput.value = "";
      //endInput.value = "";
    }, 100);

    return true;
  }
</script>
<script>
function enforceSixDigitLimit(input) {
  const limit = "<?php echo $printing_qrcode_digit; ?>";
  if (input.value.length > limit) {
    input.value = input.value.slice(0, limit);
  }
}
</script>
</body>
</html>