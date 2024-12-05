<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Post a Ride</title>
  </head>
  <style>
    /* Resetting default margin and padding */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
}

/* Header styles */
header {
  background-color: #333;
  color: #fff;
  padding: 20px 0;
}
/* Main styles */
main {
  padding: 20px 0;
}

.post-ride {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-bottom: 20px;
}

form {
  margin-bottom: 20px;
}

label {
  font-weight: bold;
}

select,
input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  padding: 10px 20px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #870b0b;
}

  </style>
  <body>
  
    <header>
      <div class="container">
      <?php include '../includes/header.php';?>
      </div>
    </header>

    <main>
      <div class="container">
        <section class="post-ride">
          <h2>Offer a Ride</h2>
          <form action="post.php" method="post">
            <label for="departure">Departure:</label><br />
            <select id="departure" name="departure" required>
              <option value="">Select Departure</option>
              <option value="Ariyalur">Ariyalur</option>
    <option value="Chennai">Chennai</option>
    <option value="Coimbatore">Coimbatore</option>
    <option value="Cuddalore">Cuddalore</option>
    <option value="Dharmapuri">Dharmapuri</option>
    <option value="Dindigul">Dindigul</option>
    <option value="Erode">Erode</option>
    <option value="Kanchipuram">Kanchipuram</option>
    <option value="Kanyakumari">Kanyakumari</option>
    <option value="Karur">Karur</option>
    <option value="Krishnagiri">Krishnagiri</option>
    <option value="Madurai">Madurai</option>
    <option value="Nagapattinam">Nagapattinam</option>
    <option value="Namakkal">Namakkal</option>
    <option value="Nilgiris">Nilgiris</option>
    <option value="Perambalur">Perambalur</option>
    <option value="Pudukkottai">Pudukkottai</option>
    <option value="Ramanathapuram">Ramanathapuram</option>
    <option value="Salem">Salem</option>
    <option value="Sivaganga">Sivaganga</option>
    <option value="Tenkasi">Tenkasi</option>
    <option value="Thanjavur">Thanjavur</option>
    <option value="Theni">Theni</option>
    <option value="Thoothukudi">Thoothukudi</option>
    <option value="Tiruchirappalli">Tiruchirappalli</option>
    <option value="Tirunelveli">Tirunelveli</option>
    <option value="Tirupattur">Tirupattur</option>
    <option value="Tiruppur">Tiruppur</option>
    <option value="Tiruvallur">Tiruvallur</option>
    <option value="Tiruvannamalai">Tiruvannamalai</option>
    <option value="Tiruvarur">Tiruvarur</option>
    <option value="Vellore">Vellore</option>
    <option value="Viluppuram">Viluppuram</option>
    <option value="Virudhunagar">Virudhunagar</option>
              <!-- Add more options here --></select
            ><br />
            <label for="destination">Destination:</label><br />
            <select id="destination" name="destination" required>
            <option value="">Select Departure</option>
            <option value="Ariyalur">Ariyalur</option>
    <option value="Chennai">Chennai</option>
    <option value="Coimbatore">Coimbatore</option>
    <option value="Cuddalore">Cuddalore</option>
    <option value="Dharmapuri">Dharmapuri</option>
    <option value="Dindigul">Dindigul</option>
    <option value="Erode">Erode</option>
    <option value="Kanchipuram">Kanchipuram</option>
    <option value="Kanyakumari">Kanyakumari</option>
    <option value="Karur">Karur</option>
    <option value="Krishnagiri">Krishnagiri</option>
    <option value="Madurai">Madurai</option>
    <option value="Nagapattinam">Nagapattinam</option>
    <option value="Namakkal">Namakkal</option>
    <option value="Nilgiris">Nilgiris</option>
    <option value="Perambalur">Perambalur</option>
    <option value="Pudukkottai">Pudukkottai</option>
    <option value="Ramanathapuram">Ramanathapuram</option>
    <option value="Salem">Salem</option>
    <option value="Sivaganga">Sivaganga</option>
    <option value="Tenkasi">Tenkasi</option>
    <option value="Thanjavur">Thanjavur</option>
    <option value="Theni">Theni</option>
    <option value="Thoothukudi">Thoothukudi</option>
    <option value="Tiruchirappalli">Tiruchirappalli</option>
    <option value="Tirunelveli">Tirunelveli</option>
    <option value="Tirupattur">Tirupattur</option>
    <option value="Tiruppur">Tiruppur</option>
    <option value="Tiruvallur">Tiruvallur</option>
    <option value="Tiruvannamalai">Tiruvannamalai</option>
    <option value="Tiruvarur">Tiruvarur</option>
    <option value="Vellore">Vellore</option>
    <option value="Viluppuram">Viluppuram</option>
    <option value="Virudhunagar">Virudhunagar</option>
              <!-- Add more options here --></select><br />
            <label for="seats_available">Seats Available:</label><br />
            <input
              type="number"
              id="seats_available"
              name="seats_available"
              min="1"
              required
            /><br />
            <label for="price">Price:</label><br />
            <input
              type="number"
              id="price"
              name="price"
              min="0"
              step="0.01"
              required
            /><br />
            <label for="date">Date:</label><br />
            <input type="date" id="date" name="date" required /><br />
            <button type="submit">Save Details</button>
          </form>
        </section>
      </div>
    </main>
  </body>
</html>
