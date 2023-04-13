<!DOCTYPE html>
<html lang="en">
<script src="https://use.fontawesome.com/cf867411c8.js"></script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="2_style.css">
</head>

<body>
    <div class="main">
        <div class="navbar">
            <div class="logo"><i class="fa fa-globe"></i>Trade</div>
            <div class="menu">
                <ul>
                    <li><a href="1_main_page.php" target="bl">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="4_login.php">Add Items</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="4_login.php">Registration</a></li>
                </ul>
            </div>
        </div>
        <div class="image">
            <img class="img" src="pic.jpg" alt="">
        </div>
        <section class="sec">
            <div class="heading">
                <p>Register for your IEC</p>
            </div>
            <div class="description">
                <p>The Importer -Exporter Code (IEC) is a key business identification number which is mandatory for
                    Exports or Imports. No
                    person shall make any import or export except under an IEC Number granted by the DGFT. In case of
                    import or export of
                    services or technology, the IEC shall be required only when the service or technology provider is
                    taking benefits under
                    the Foreign Trade Policy or is dealing with specified services or technologies<br><br>
                    The nature of the firm obtaining an IEC may be any of the follows- "Proprietorship, Partnership,
                    LLP, Limited Company,
                    Trust, HUF and Society." Consequent upon introduction of GST, IEC number is the same as the PAN of
                    the firm. The IEC
                    would be separately issued by DGFT.</p>
            </div>
            <div class="btn">
                <button class="btn1"><a href="https://www.dgft.gov.in/CP/complaintssuggestion">IEC Help & FAQ's</a></button>
                <button class="btn2"><a href="5_signUp.php">Apply for IEC</a></button>
            </div>
        </section>
    </div>
    <section class="ques1">
        <div class="ques2">
            <p>Are you an importer or an exporter?</p>
        </div>
        <div class="ques3">
            <input class="radio1" name="uselect" type="radio" value="imported" id="importer" required><label
                for="importer" class="label1">Importer</label>
            <input class="radio2" name="uselect" type="radio" value="exported" id="emporter" required><label
                for="exporter" class="label2">Exporter</label>
            <!-- <input name="uselect" type="radio" value="both" id="both" required><label for="both">Both</label> -->
            <div class="discover"><button type="submit"><a href="4_login.php">Discover</a></button></div>
        </div>
    </section>
    <div class="ser">SERVICES</div>
    <div class="services">
        <div class="iec">
            <h2>Importer Exporter Code (IEC)</h2>
            <div class="info1">An Importer-Exporter Code (IEC) is a key business identification number which mandatory
                for export from India or Import
                to India. Click to explore the IEC services offered by DGFT.</div>
            <span><button><a href="#">View More</a></button></span>
        </div>
        <div class="import">
            <h2>Import Management System</h2>
            <div class="info2">Import License for Restricted Items, Steel Import Monitoring System (SIMS), Import
                License for Tariff Rate Quota (TRQ),
                Registration Certificates. Click to explore the services offered under the scheme</div>
            <span><button><a href="#">View More</a></button></span>
        </div>
        <div class="export">
            <h2>Emport Management System</h2>
            <div class="info3">Export licences for Restricted Items, SCOMET Items, License under Indo US Memorandum,
                License under Indo EU besides
                others. Click to explore the services offered by DGFT under the scheme.</div>
            <span><button><a href="#">View More</a></button></span>
        </div>
        <div class="epcg">
            <h2>EPCG</h2>
            <div class="info4">The objective of the Export Promotion Capital Goods (EPCG) Scheme is to facilitate import
                of capital goods for producing
                quality goods & services. Click to explore the services offered under the scheme.</div>
            <span><button><a href="#">View More</a></button></span>
        </div>
    </div>

    <?php require "footer.php"?>
</body>
</html>