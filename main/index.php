<?php include '../includes/header.php';?>
    <div class="position-relative">
            <div class="home-banner"></div>
        <div class="input-search-container">
            <form class="d-md-flex justify-content-center" action="search.php" method="post">
                <div class="d-inline-block position-relative">
                    <span class="inputIcon"><i class="far fa-building"></i></span>
                    <label class="inputLabel-default" for="input-label-from">FROM</label>
                    <input id="input-label-from" class="inputForm" type="text" list="input-from-list" name="departure" required />
                    <datalist id="input-from-list" name="departure" required>
                    <option value="">Select District</option>
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
                    </datalist>
                </div>

                <div class="d-inline-block position-relative">
                    <span class="inputIcon"><i class="far fa-building"></i></span>
                    <label class="inputLabel-default" for="input-label-to">TO</label>
                    <input id="input-label-to" class="inputForm" type="text" list="input-to-list" name="destination" required />
                    <datalist id="input-to-list" name="destination">
                    <option value="">Select District</option>
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
                    </datalist>
                </div>

                <div class="d-inline-block position-relative">
                    <span class="inputIcon"><i class="fas fa-calendar-alt"></i></span>
                    <label class="inputLabel-default" for="input-label-onward-date" name="date">ONWARD DATE</label>
                    <input id="input-label-onward-date" class="inputForm" type="text" name="date" required />
                </div>

                <div class="d-inline-block position-relative">
                    <input class="btn btn-danger rounded-0 pl-3 pr-3 pb-2" type="submit" value="Search Rides" />
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/app.js"></script>
    <?php include '../includes/footer.php';?>
     