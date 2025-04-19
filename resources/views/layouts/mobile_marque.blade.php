<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     
    <title>FabHub | Online Shopping</title>
    <!-- Font Awesome for Icons -->
    
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    
    <!-- Bootstrap's JS and CSS (you can use a CDN link) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--Bootstrap Carausel-->
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <style>
    
        .main-body{
            margin-top: 90px;
            background-color: black;
            color: white;
        }
        .circle-icon {
            display: inline-flex;
            flex-direction: column;
            /* Stack the icon and text vertically */
            align-items: center;
            /* Center both the icon and text */
            justify-content: center;
            /* Center the content inside the circle */
            text-align: center;
            position: relative;
            width: 60px;
            /* Adjust the size of the circle */
            height: 60px;
            /* Adjust the size of the circle */
            border-radius: 50%;
            /* Make it a circle */
            /*background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(150, 19, 17, 1) 35%, rgba(150, 19, 17, 1) 100%);*/
            background: radial-gradient(at right center, #D7CCB7, #EFC475);

            margin-right: -5px;
            overflow: hidden;
        }

        .circle-icon i {
            font-size: 30px;
            /* Icon size */
            color: black;
            /* Icon color */
            animation: blink 1s infinite;
            /* Blinking animation */
        }

        .circle-icon span {
            font-size: 12px;
            /* Adjust text size */
            color: black;
            /* Text color */
        }

        /* Blinking animation */
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .circle-icon:hover {
            background: linear-gradient(45deg, #ffcc00, #ff6f61, #66ff66, #66ccff);
            /* Hover effect */
        }

        .slideimg {
            height: 600px;
        }
        .footer{
            font-family: sans-serif;
        }
        .footer a {
            text-decoration: none;
            color: #000;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        
        .footer h6 {
            font-weight: bold;
            color: #000;
        }
        
        .footer ul {
            padding: 0;
            list-style: none;
        }
        
        .footer ul li {
            margin-bottom: 5px;
        }
                        
        .footer button{
            color: white;
            background: #961311;
        }
        
        .footer-img img{
            width: 111px;
            height: 60px;
        }
    </style>
    
    
    <!--Modal Style -->
    
    <style>
        /* Modal Styles */
        .modal {
            display: flex; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
        }
    </style>

    <style>
        .mobile-input-wrapper {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px;
    }
    
    .country-code {
        display: flex;
        align-items: center;
        padding: 5px;
        /*background-color: #f5f5f5;*/
        border-right: 1px solid #ccc;
    }
    
    .flag-icon {
        width: 20px;
        height: 14px;
        margin-right: 5px;
    }
    
    .mobile-input-wrapper input[type="text"] {
        flex: 1;
        border: none;
        padding: 5px;
        outline: none;
    }
    
    </style>


<style>
        /* Styling for the toggle bar and footer */
        #toggle-bar {
            
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            cursor: pointer;
            z-index: 1050;
        }

        #footer {
            display: none;
            background-color: #f1f1f1;
            padding: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
    
    <!--Accordian -->
    <style>
        .accordion-header {
          background-color: black;
          color: white;
          padding: 15px;
          border: none;
          width: 100%;
          text-align: left;
          font-size: 16px;
          cursor: pointer;
          outline: none;
          display: flex;
          align-items: center;
          justify-content: space-between;
          transition: background-color 0.2s ease;
        }
        
        .accordion-header:focus {
          outline: none;
        }
        
        .accordion-header:active {
          transform: none; /* Prevent zoom effect */
        }
        
        .accordion-content {
          display: none;
          /*padding: 15px;*/
          background-color: black;
          /*border-top: 1px solid #ddd;*/
        }
        
        .accordion-content.open {
          display: block;
        }
        
        .accordion i {
          transition: transform 0.2s ease;
        }
        
        .accordion i.rotate {
          transform: rotate(90deg); /* Rotate to simulate arrow down */
        }

    </style>
    <style>
        body{
        /*padding:0% 3% 10% 3%;*/
        text-align:center;
        }
        h1{
        color: #32a852;
        margin-top:30px;
        }
    
        /*button{*/
        /*    cursor: pointer;*/
        /*    border: 1px solid #555;*/
        /*    text-align: center;*/
        /*    padding: 5px;*/
        /*    margin-left: 8px; */
        /*}*/
        .dark{
            background-color: #222;
            color: #e6e6e6;
        }
        .dark .cat-text, h5
        {
            color:white;
        }
        
    </style>
</head>

<body>
    
    <!--Information Slider -->
<!-- <marquee class="marq" direction="left" >-->
<!--            ðŸ›’ Try before you buy at just â‚¹99 &nbsp;&nbsp;&nbsp;&nbsp; âš¡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; ðŸ’¸  Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;-->
<!--            ðŸ›’ Try before you buy at just â‚¹99 &nbsp;&nbsp;&nbsp;&nbsp; âš¡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; ðŸ’¸  Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;-->
<!--            ðŸ›’ Try before you buy at just â‚¹99 &nbsp;&nbsp;&nbsp;&nbsp; âš¡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; ðŸ’¸  Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;-->
<!--</marquee>-->

<!--    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="position:fixed; margin-top: 30px;">-->
<!--        <a class="navbar-brand" href="#">-->
<!--            <img src="{{ asset('public/assets/images/logo/logo_showloom.png') }}" class="logoimg" alt="Shoes">-->
<!--        </a>-->

        <!-- Icons (without gaps and without boldness) -->
<!--        <div class="d-flex ml-auto align-items-center">-->
<!--            <a href="#" class="text-dark" style="font-size: 24px; font-weight: normal; margin-right: 10px;">-->
<!--                <i class="fas fa-search"></i>-->
<!--            </a>-->
<!--            <a href="#" class="text-dark" style="font-size: 24px; font-weight: normal; margin-right: 10px;">-->
<!--                <i class='far fa-heart'></i>-->
<!--            </a>-->
<!--            <a href="#" class="text-dark" style="font-size: 24px; font-weight: normal;">-->
<!--                <i class="fa fa-shopping-bag"></i>-->
<!--            </a>-->
<!--        </div>-->
<!--    </nav>-->

    <div class="fixed-top-container">
      <!-- Information Slider -->
      <marquee class="marq" direction="left">
        🛍️ Try before you buy at just ₹99 &nbsp;&nbsp;&nbsp;&nbsp; ⚡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; 💰 Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;
        🛍️ Try before you buy at just ₹99 &nbsp;&nbsp;&nbsp;&nbsp; ⚡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; 💰 Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;
        🛍️ Try before you buy at just ₹99 &nbsp;&nbsp;&nbsp;&nbsp; ⚡ Get Delivery Within 48 Hours &nbsp;&nbsp;&nbsp;&nbsp; 💰 Save big with every click &nbsp;&nbsp;&nbsp;&nbsp;
      </marquee>
    
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg" style="margin-top: -5px;">
        <a class="navbar-brand" href="#">
          <img src="{{ asset('public/assets/images/logo/logo_showloom.png') }}" class="logoimg" alt="Shoes">
        </a>
    
        <!-- Icons -->
        <div class="d-flex ml-auto align-items-center">
            <!--<button onclick="myFunction()">Switch Mode</button>-->
          <a href="#" class="text-light" style="font-size: 24px; font-weight: normal; margin-right: 5px;">
            <!--<i class="fas fa-search"></i>-->
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
              <circle cx="20" cy="20" r="9" stroke="white" stroke-width="2"/>
              <line x1="26" y1="26" x2="34" y2="34" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </a>
          <a href="#" class="text-light" style="font-size: 24px; font-weight: normal; margin-right: 20px;">
            <i class="far fa-heart"></i>
          </a>
          <a href="#" class="text-light" style="font-size: 24px; font-weight: normal;">
            <i class="fa fa-shopping-bag"></i>
          </a>
        </div>
      </nav>
    </div>



    <div class="main-body">
      @yield('content')
      
    </div>


    <div class="bottom-navbar">
        <ul>
            &nbsp;
            <li>
                <a href="#home">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#search">
                    <i class="fa fa-shopping-cart"></i>
                    Shop
                </a>
            </li>
            <li>
                <a href="#orders" class="circle-icon">
                    <i class="fas fa-shirt"></i>
                    <span>Tryout</span>
                </a>
            </li>
            <li>
                <a href="/explore">
                    <!--<i class="fas fa-shopping-cart"></i>-->
                     <i class="fas fa-search"></i>
                    Explore
                </a>
            </li>
            <li>
                <a href="{{ url('/account') }}">
                    <i class="fas fa-user"></i>
                    Profile
                </a>
            </li>
            &nbsp;
        </ul>

    </div>
    


        <div class="accordion" style="margin-bottom:69px;">
            <div class="accordion-item">
              <button class="accordion-header d-flex justify-content-between" style="margin-left-20px">
                Know More About Fabhub
                <i class="fa-solid fa-angles-right fs-1"></i>
              </button>
              <div class="accordion-content">
                
           

                <footer class="footer" > 
                  
        
                    <div class="container" style="background-color:black; color:white;">
                        <div class="row" style="margin-bottom: 70px;">
                            <div class="col-md-4 text-md-start mb-2">
                                <h5 class="mt-2" style="font-weight:bold;">SHOP FOR</h5>
                                <div class="social-links d-flex flex-column">
                                    <span style="color: white;">Explore | Men | Women | Kids | Try Out</span>
                                </div>
                            </div>
                           
        
                            <div class="col-md-4 text-md-start mb-2">
                                 <br>
                                <h5 class="mt-2" style="font-weight:bold;">CONNECT WITH US</h5>
                                <div class="social-links d-flex flex-column">
                                     <span style="color: white;"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Facebook_logo_%28square%29.png/600px-Facebook_logo_%28square%29.png" style="height:24px;"> 
                                     <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/X_logo.jpg/600px-X_logo.jpg" style="height:24px;">  
                                     <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Instagram_logo_2022.svg/150px-Instagram_logo_2022.svg.png" style="height:24px;">   
                                     <img src="https://i.pinimg.com/736x/6b/ab/30/6bab3017350ca04c6fa05569672bd31e.jpg" style="height:24px;">  </span>
                                </div>
                            </div>
                         
                            <div class="col-md-4 text-md-start mb-2">
                             
                                <h5 class="mt-2" style="font-weight:bold;">CUSTOMER SERVICES</h5>
                                <div class="social-links d-flex flex-column">
                                    <span style="color: white;">Terms & Conditions  |  Privacy Policy | Return & Replacement | Seller Policy
                                    | Return Policy | FAQ | Shipping Policy | </span>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-4 text-md-start mb-2">
                                <br>
                                <h5 class="mt-2" style="font-weight:bold;">USEFUL LINKS</h5>
                                <div class="social-links d-flex flex-column">
                                    <span style="color: white;">About Us  |  Contact Us | Blog | Site Map</span>
                                </div>
        
                            </div>
        
                             @if (Auth::check())
                                <br>
                                <div class="col-md-4 text-md-start mb-2">
                                    <br>
                                    
                                    <h5 class="mt-2" style="font-weight:bold;">MY ACCOUNT  </h5>
                                    <div class="social-links d-flex flex-column">
                                        <span style="color: white;">Logout  | Order History | My Wishlist | Track Order</span>
                                    </div>
                                    
                                </div>
                            @endif
                                <br>
                                <div class="col-md-12 text-md-start mb-2 text-center">
                                    <br>
                                    
                                    <h5 class="mt-2"><i style="font-size:14px" class="fa">&#xf1f9;</i> 2025 www.showloom.com All rights reserved</h5>
                                    
                                    
                                </div>
                                <hr>
                                <br>
                                
                                
                                <div class="col-md-12 text-md-start mb-2">
                                    <br>
                                    
                                    <h5 class="mt-2" style="font-weight:bold;">POPULAR SEARCHES  </h5>
                                    <div class="social-links d-flex flex-column">
                                        <span style="color: white;">Makeup | Dresses For Girls | T-Shirts | Sandals | Headphones | Babydolls | Blazers For Men | Handbags | Ladies Watches | Bags  
                                        | Sport Shoes | Reebok Shoes | Puma Shoes | Boxers | Wallets | Tops | Earrings | Fastrack Watches | Kurtis | Nike | Smart Watches | Titan Watches | Designer Blouse |
                                        Gowns | Rings </span>
                                    </div>
                                    
                                </div>
                                
                               <br>
                                <div class="col-md-12 text-md-start mb-2">
                                    <br>
                                    
                                    <h5 class="mt-2" style="font-weight:bold;">POPULAR SEARCHES  </h5>
                                    <div class="social-links d-flex flex-column">
                                        <span>ONLINE SHOPPING MADE EASY AT FabHub
                    If you would like to experience the best of online shopping for men, women and kids in India, you are at the right place. FabHubis the ultimate destination for fashion and lifestyle, being host to a wide array of merchandise including clothing, footwear, accessories, jewellery, personal care products and more. It is time to redefine your style statement with our treasure-trove of trendy items. Our online store brings you the latest in designer products straight out of fashion houses. You can shop online at FabHubfrom the comfort of your home and get your favourites delivered right to your doorstep.
                    
                    BEST ONLINE SHOPPING SITE IN INDIA FOR FASHION
                    Be it clothing, footwear or accessories, FabHuboffers you the ideal combination of fashion and functionality for men, women and kids. You will realise that the sky is the limit when it comes to the types of outfits that you can purchase for different occasions.
                    
                    Smart men’s clothing - At FabHubyou will find myriad options in smart formal shirts and trousers, cool T-shirts and jeans, or kurta and pyjama combinations for men. Wear your attitude with printed T-shirts. Create the back-to-campus vibe with varsity T-shirts and distressed jeans. Be it gingham, buffalo, or window-pane style, checked shirts are unbeatably smart. Team them up with chinos, cuffed jeans or cropped trousers for a smart casual look. Opt for a stylish layered look with biker jackets. Head out in cloudy weather with courage in water-resistant jackets. Browse through our innerwear section to find supportive garments which would keep you confident in any outfit.
                    Trendy women’s clothing - Online shopping for women at FabHubis a mood-elevating experience. Look hip and stay comfortable with chinos and printed shorts this summer. Look hot on your date dressed in a little black dress, or opt for red dresses for a sassy vibe. Striped dresses and T-shirts represent the classic spirit of nautical fashion. Choose your favourites from among Bardot, off-shoulder, shirt-style, blouson, embroidered and peplum tops, to name a few. Team them up with skinny-fit jeans, skirts or palazzos. Kurtis and jeans make the perfect fusion-wear combination for the cool urbanite. Our grand sarees and lehenga-choli selections are perfect to make an impression at big social events such as weddings. Our salwar-kameez sets, kurtas and Patiala suits make comfortable options for regular wear.
                    Fashionable footwear - While clothes maketh the man, the type of footwear you wear reflects your personality. We bring you an exhaustive lineup of options in casual shoes for men, such as sneakers and loafers. Make a power statement at work dressed in brogues and oxfords. Practice for your marathon with running shoes for men and women. Choose shoes for individual games such as tennis, football, basketball, and the like. Or step into the casual style and comfort offered by sandals, sliders, and flip-flops. Explore our lineup of fashionable footwear for ladies, including pumps, heeled boots, wedge-heels, and pencil-heels. Or enjoy the best of comfort and style with embellished and metallic flats.
                    Stylish accessories - FabHubis one of the best online shopping sites for classy accessories that perfectly complement your outfits. You can select smart analogue or digital watches and match them up with belts and ties. Pick up spacious bags, backpacks, and wallets to store your essentials in style. Whether you prefer minimal jewellery or grand and sparkling pieces, our online jewellery collection offers you many impressive options.
                    Fun and frolic - Online shopping for kids at FabHubis a complete joy. Your little princess is going to love the wide variety of pretty dresses, ballerina shoes, headbands and clips. Delight your son by picking up sports shoes, superhero T-shirts, football jerseys and much more from our online store. Check out our lineup of toys with which you can create memories to cherish.
                    Beauty begins here - You can also refresh, rejuvenate and reveal beautiful skin with personal care, beauty and grooming products from ShowLoom. Our soaps, shower gels, skin care creams, lotions and other ayurvedic products are specially formulated to reduce the effect of aging and offer the ideal cleansing experience. Keep your scalp clean and your hair uber-stylish with shampoos and hair care products. Choose makeup to enhance your natural beauty.
                    FabHubis one of the best online shopping sites in India which could help transform your living spaces completely. Add colour and personality to your bedrooms with bed linen and curtains. Use smart tableware to impress your guest. Wall decor, clocks, photo frames and artificial plants are sure to breathe life into any corner of your home.
                    
                    AFFORDABLE FASHION AT YOUR FINGERTIPS
                    FabHubis one of the unique online shopping sites in India where fashion is accessible to all. Check out our new arrivals to view the latest designer clothing, footwear and accessories in the market. You can get your hands on the trendiest style every season in western wear. You can also avail the best of ethnic fashion during all Indian festive occasions. You are sure to be impressed with our seasonal discounts on footwear, trousers, shirts, backpacks and more. The end-of-season sale is the ultimate experience when fashion gets unbelievably affordable.
                    
                    FabHubINSIDER
                    Every online shopping experience is precious. Hence, a cashless reward-based customer loyalty program called FabHubInsider was introduced to enhance your online experience. The program is applicable to every registered customer and measures rewards in the form of Insider Points.
                    
                    There are four levels to achieve in the program, as the Insider Points accumulate. They are - Insider, Select, Elite or Icon. Apart from offering discounts on FabHuband partner platform coupons, each tier comes with its own special perks.
                    
                    Insider
                    
                    Opportunity to master any domain in fashion with tips from celebrity stylists at FabHubMasterclass sessions.
                    Curated collections from celeb stylists.
                    Elite
                    
                    VIP access to special sale events such as the End of Reason Sale (EORS) and product launches.
                    Exclusive early access to Limited Edition products
        
        
        
                    </span>
                                    </div>
                                    
                                </div>
                            
                            
                        </div>
                    </div>
                </footer>

     
              </div>
            </div>
            
          </div>


    
   
   

</body>

<!--<script src='https://cdn.jotfor.ms/s/umd/latest/for-embedded-agent.js'></script>-->
<!--<script>-->
<!--  window.addEventListener("DOMContentLoaded", function() {-->
<!--    window.AgentInitializer.init({-->
<!--      agentRenderURL: "https://agent.jotform.com/01950473a55071d782dba30df7dafab13b1b",-->
<!--      rootId: "JotformAgent-01950473a55071d782dba30df7dafab13b1b",-->
<!--      formID: "01950473a55071d782dba30df7dafab13b1b",-->
<!--      queryParams: ["skipWelcome=1", "maximizable=1"],-->
<!--      domain: "https://www.jotform.com",-->
<!--      isDraggable: false,-->
<!--      background: "linear-gradient(180deg, #C8CEED 0%, #C8CEED 100%)",-->
<!--      buttonBackgroundColor: "#0a1551",-->
<!--      buttonIconColor: "#fff",-->
<!--      variant: false,-->
<!--      customizations: {-->
<!--        "greeting": "Yes",-->
<!--        "greetingMessage": "Hi! How can I assist you?",-->
<!--        "openByDefault": "No",-->
<!--        "pulse": "Yes",-->
<!--        "position": "right",-->
<!--        "autoOpenChatIn": "0"-->
<!--      },-->
<!--      isVoice: undefined-->
<!--    });-->
<!--  });-->
<!--</script>-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nav = document.querySelector('nav');
        const body = document.body;

        if (nav) {
            body.classList.add('has-nav');
        } else {
            body.classList.remove('has-nav');
        }
    });
</script>
<script>
    let slideIndex = 0;
    showSlides();

    // Auto-scroll functionality
    function showSlides() {
        let slides = document.getElementsByClassName("mySlides");
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 5000); // Change slide every 5 seconds
    }

    // Manual slide control
    function plusSlides(n) {
        showManualSlides(slideIndex += n);
    }

    function showManualSlides(n) {
        let slides = document.getElementsByClassName("mySlides");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "block";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<!--Modal Js -->

<script>

// JavaScript to handle modal behavior
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("pageLoadModal");
    modal.style.display = "flex"; // Show modal on page load
});

function closeModal() {
    const modal = document.getElementById("pageLoadModal");
    modal.style.display = "none"; // Hide modal on close button click
}
</script>
<script>
        // JavaScript for toggle functionality
        const toggleBar = document.getElementById('toggle-bar');
        const footer = document.getElementById('footer');
        const toggleIcon = document.getElementById('toggle-icon');

        toggleBar.addEventListener('click', () => {
            const isFooterVisible = footer.style.display === 'block';

            // Toggle footer visibility
            footer.style.display = isFooterVisible ? 'none' : 'block';

            // Change icon direction
            toggleIcon.classList.toggle('bi-chevron-down', isFooterVisible);
            toggleIcon.classList.toggle('bi-chevron-up', !isFooterVisible);
        });
    </script>
    
    
    <script>
        
        // Accordian 
        
        document.addEventListener("DOMContentLoaded", () => {
          const accordionHeaders = document.querySelectorAll(".accordion-header");
        
          accordionHeaders.forEach(header => {
            header.addEventListener("click", () => {
              const content = header.nextElementSibling;
              const icon = header.querySelector("i");
        
              // Toggle content visibility
              const isVisible = content.style.display === "block";
              content.style.display = isVisible ? "none" : "block";
        
              // Toggle icon rotation
              icon.classList.toggle("rotate", !isVisible);
            });
          });
        });
    </script>
    
     <script>
    //     function myFunction() {
    //         let element = document.body;
    //         element.classList.toggle("dark");
    //     }
    </script>
</html>
