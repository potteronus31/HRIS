<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>emailtemp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Avenir%20LT%20Std.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700,800">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<style>

    #container1
    {
        width: 60%;
    }

#columnheader {
  background-color: #F7F7F7;
  padding-top: 40px;
  padding-bottom: 40px;
  text-align: center;
  margin-left: 0;
  margin-right: 0;
}

#columnfooter {
  background: #F7F7F7;
  padding-bottom: 40px;
  padding-top: 40px;
  text-align: center;
  margin-left: 0;
  margin-right: 0;
}

#columncopyright {
  padding-top: 10px;
  padding-bottom: 20px;
  text-align: center;
  background-color: #303030;
  color: white;
  margin-left: 0;
  margin-right: 0;
}

#followtxt {
  margin-top: 15px;
  margin-bottom: 15px;
  font-family: 'Montserrat', sans-serif;
  font-size: 15px;
  color: #666666;
  letter-spacing: 0;
  text-align: center;
}

#copyrighttxt {
  font-family: 'Montserrat', sans-serif;
  font-size: 15px;
  color: #f7f7f7;
  letter-spacing: 0;
  margin-top: 15px;
  text-align: center;
}

#icon2, #icon3, #icon4 {
  margin-left: 10px;
}

#headingtitle {
  text-align: center;
  font-weight: 600;
  font-size: 3em;
}

#columnbody {
  padding-top: 40px;
  padding-bottom: 40px;
  text-align: center;
}

p {
  text-align: left;
  font-size: 1em;
  width: 90%;
  margin: 0 auto;
}

#button {
  font-family: 'Montserrat', sans-serif;
  width: 210px;
  height: 63px;
  text-align: center;
  border-radius: 0;
  border-color: transparent;
  outline-color: transparent;
  background: linear-gradient(236.5deg, #386C5F -6.22%, #02894B 100%);
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}

#p1 {
  margin-top: 30px;
  margin-bottom: 20px;
}

#p3 {
  margin-top: 20px;
  margin-bottom: 30px;
}

#p4 {
  margin-bottom: 30px;
  margin-top: 20px;
}

#button:hover {
  background: #33A463;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  transition: 1s;
}

#p1, #p2, #p3, #p4 {
  font-family: 'Montserrat', sans-serif;
}


</style>
<body>
    <div class="container-fluid" id="container1">
        <div class="row">
            <div class="col" id="columnheader">
                <div id="header">
                    <div><img class="img-fluid" id="lnslogo" src="https://sample.hris.livewire365.com/LEENTech%20Official%20Logo%202.png"></div>
                </div>
            </div>
        </div>
       <div class="row">
            <div class="col" id="columnbody">
                <h1 id="headingtitle" style="font-family: 'Montserrat';">Lorem Ipsum Shortlist</h1>
                Applicant name: {{$getname}} <br> Position: {{$getjobtitle}}
            </div>
        </div>
           <div class="row">
            <div class="col" id="columnfooter">
                <div>
                    <div><img class="img-fluid" src="https://sample.hris.livewire365.com/LNS-Icon-White-m%201.png"></div>
                    <div>
                        <p id="followtxt">Follow us on social media</p>
                    </div>
                    <div>
                         <a href="https://www.facebook.com/LEENTechNetworkSolutions/" target="_blank"><img id="icon1" src="https://sample.hris.livewire365.com/Facebook_white.png"></a>
                        <a href="https://www.instagram.com/leentechsystems/" target="_blank"><img id="icon2" src="https://sample.hris.livewire365.com/Instagram_white.png"></a>
                        <a href="https://www.messenger.com/t/145991878752363" target="_blank"><img id="icon4" src="https://sample.hris.livewire365.com/Messenger_white.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col" id="columncopyright">
                <div>
                    <p id="copyrighttxt"> © LEENTech Network Solutions Inc. All Rights Reserved 2020<br></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>