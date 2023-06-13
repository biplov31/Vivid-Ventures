<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/event.css">
</head>
<body>
  <?php include('../templates/header.php') ?>

  <div class="event-container">
    <section class="event-info-section">
        <div class="image-container">
          <img src="../public/assets/images/neha-maheen-mahfin-cK6fjg5YJEA-unsplash.jpg" alt="">
          <div class="event-info">
            <h3>Bandipur</h3>
            <ul>
              <li>9-day trip</li>
              <li>Per head Rs 15000</li>
              <li>Total spots: 12</li>
            </ul>
          </div>
        </div>
        <div class="event-description">
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe porro, dolor itaque suscipit totam molestias tempora impedit. Facilis, dolorem doloremque aut quam id odio fugiat, vero dolorum at enim atque. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusantium, quasi enim laboriosam sint ipsam dicta, corporis sit blanditiis quas ab unde, facere possimus architecto fugiat praesentium harum incidunt magnam voluptatibus?</p>
          <button class="register-btn confirmation-btn">Register now</button>   
        </div>            
    </section>
    <div class="form-overlay">
      <div class="registration-form-container">
        <p>Confirm registration with following details?</p>
        <form action="" class="registration-form">    
          <label>Name: <input type="text" name="name" id="name"></label>
          <label>Mobile number: <input type="text" name="contact" id="contact"></label>
          <label>Email: <input type="email" name="email" id="email"></label>
          <div class="form-buttons">
            <button class="submit-btn" type="submit">Confirm</button>             
            <button class="cancel-btn" type="button">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include('../templates/footer.php') ?>


  <script src="../publicscripts/main.js"></script>
</body>
</html>