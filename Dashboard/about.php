<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-About</title>
    <style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #FAF8ED;
      color: #3B0000;
      overflow-x: hidden;
    }
      #chat-button {
        position: fixed;
        bottom: 24px;
        right: 50px;
        width: 60px;
        height: 60px;
        background-color: #7D0000;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
      }
      #chat-button img {
        width: 32px;
        height: 32px;
      }
      #chat-box {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 50px;
        width: 300px;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.2);
        z-index: 1000;
        flex-direction: column;
        font-family: Arial, sans-serif;
      }
      #chat-header {
        background: #3B0000;
        color: #fff;
        padding: 10px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
      }
      #chat-messages {
        padding: 10px;
        height: 200px;
        overflow-y: auto;
        background: #FAF8ED;
      }
      .message {
        margin-bottom: 8px;
        padding: 6px 10px;
        border-radius: 10px;
        max-width: 80%;
        font-size: 14px;
      }
      .bot {
        background: #E2D7BE;
        align-self: flex-start;
      }
      .user {
        background: #D9D9D9;
        align-self: flex-end;
        text-align: right;
      }
      #chat-input-area {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ccc;
      }
      #chat-input {
        flex: 1;
        padding: 6px;
        font-size: 14px;
      }
      #send-btn {
        background: #7D0000;
        color: white;
        border: none;
        padding: 6px 10px;
        cursor: pointer;
      }
      
  @media screen and (max-width: 1442px) {
    .centered-wrapper {
      transform: scale(calc(100vw / 1442));
      transform-origin: top left;
    }

    body {
      justify-content: flex-start; /* agar posisi tetap dari kiri atas saat diskalakan */
    }
  }
</style>

</head>
<body>
  <div class="responsive-wrapper">
  <div style="width: 1442px; height: 4143px; position: relative; background: white; overflow: hidden">
  <img style="width: 1442px; height: 687px; left: -11px; top: -13px; position: absolute" src="../image/dashboard.png" />
  <div style="width: 1442px; height: 708px; left: -80px; top: -14px; position: absolute; background: rgba(59.13, 0, 0, 0.68)"></div>
  <div style="left: 501px; top: 255px; position: absolute; color: white; font-size: 96px; font-family: Overthink; font-weight: 400; word-wrap: break-word">Seamless</div>
  <div style="width: 1442px; height: 565px; left: -88px; top: 2534px; position: absolute; background: #560202"></div>
  <div style="width: 1442px; height: 879px; left: 0px; top: 645px; position: absolute; background: #FAF8ED"></div>
  <div style="width: 1.86px; height: 1.98px; left: 285.49px; top: 84.44px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 1.36px; height: 1.35px; left: 285.58px; top: 84.90px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 2.62px; height: 2.79px; left: 285.03px; top: 83.51px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 3.06px; height: 3.36px; left: 285.14px; top: 82.37px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 2.80px; height: 3.08px; left: 285.06px; top: 82.58px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 2.26px; height: 2.42px; left: 285.11px; top: 83.13px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 2.72px; height: 2.19px; left: 284.99px; top: 83.32px; position: absolute; outline: 0.50px #3B0000 solid; outline-offset: -0.25px"></div>
  <div style="width: 154px; height: 42px; left: 702px; top: 382px; position: absolute; color: white; font-size: 28px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">About </div>
  <div style="width: 154px; height: 42px; left: 567px; top: 382px; position: absolute; color: white; font-size: 28px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Home   /</div>
  <!-- Wrapper section -->
    <div style="width: 1442px; height: 565px; left: 0px; top: 4559px; position: absolute; background: #560202"></div>

    <!-- Title -->
    <div style="width: 211px; height: 42px; left: 594px; top: 4642px; position: absolute; color: #E2CEB1; font-size: 25px; font-family: Montserrat; font-weight: 400;">
      HOW WE WORK
    </div>
    <div style="width: 1055px; height: 56px; left: 172px; top: 4678px; position: absolute; text-align: center; color: rgba(222, 209, 180, 0.87); font-size: 46px; font-family: Montserrat; font-weight: 600;">
      Curating the Fundamentals of Style
    </div>

    <!-- Items container -->
    <div style="position: absolute; top: 4780px; left: 80px; width: 1280px; display: flex; justify-content: space-between;">

      <!-- Item 1: Appointment -->
      <div style="text-align: center;">
        <div style="width: 90px; height: 90px; margin: 0 auto; background: #FAF8ED; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
          <img src="../image/appoitment.png" alt="Appointment Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div style="margin-top: 10px; color: white; font-size: 20px; font-family: Montserrat;">Appointment</div>
      </div>

      <!-- Item 2: Choose Style -->
      <div style="text-align: center;">
        <div style="width: 90px; height: 90px; margin: 0 auto; background: #FAF8ED; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
          <img src="../image/Choose style.png" alt="Choose Style Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div style="margin-top: 10px; color: white; font-size: 20px; font-family: Montserrat;">Choose Style</div>
      </div>

      <!-- Item 3: Sampling -->
      <div style="text-align: center;">
        <div style="width: 90px; height: 90px; margin: 0 auto; background: #FAF8ED; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
          <img src="../image/Sampling.png" alt="Sampling Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div style="margin-top: 10px; color: white; font-size: 20px; font-family: Montserrat;">Sampling</div>
      </div>

      <!-- Item 4: Production -->
      <div style="text-align: center;">
        <div style="width: 90px; height: 90px; margin: 0 auto; background: #FAF8ED; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
          <img src="../image/Product.png" alt="Production Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div style="margin-top: 10px; color: white; font-size: 20px; font-family: Montserrat;">Production</div>
      </div>

      <!-- Item 5: Final Result -->
      <div style="text-align: center;">
        <div style="width: 90px; height: 90px; margin: 0 auto; background: #FAF8ED; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
          <img src="../image/Final result.png" alt="Final Result Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div style="margin-top: 10px; color: white; font-size: 20px; font-family: Montserrat;">Final Result</div>
      </div>

    </div>
    <div style="width: 38px; height: 36px; left: 6px; top: 6px; position: absolute; outline: 4px #A3947D solid; outline-offset: -2px"></div>
  </div>
  <div data-size="48" style="width: 48px; height: 48px; left: 1175px; top: 2784px; position: absolute; overflow: hidden">
    <div style="width: 40px; height: 40px; left: 4px; top: 4px; position: absolute; outline: 4px #A3947D solid; outline-offset: -2px"></div>
  </div>
  <div style="width: 43px; height: 42px; left: 644px; top: 2793px; position: absolute; overflow: hidden">
    <div style="width: 26.88px; height: 36.75px; left: 8.06px; top: 2.62px; position: absolute; outline: 3px #A3947D solid; outline-offset: -1.50px"></div>
  </div>
  <div data-size="48" style="width: 48px; height: 48px; left: 381px; top: 2793px; position: absolute; overflow: hidden">
    <div style="width: 44px; height: 36px; left: 2px; top: 6px; position: absolute; outline: 4px #A3947D solid; outline-offset: -2px"></div>
  </div>
  <div data-property-1="Visi" style="width: 418px; height: 401px; left: 56px; top: 1622px; position: absolute; background: #EFEFEF; overflow: hidden">
    <div style="left: 122px; top: 120px; position: absolute; color: #3B0000; font-size: 32px; font-family: Montserrat; font-weight: 700; word-wrap: break-word">Our Vision</div>
    <div style="width: 309px; left: 54px; top: 181px; position: absolute; text-align: center; color: #3B0000; font-size: 25px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">To become the largest, most prominent, and most trusted global producer of textiles and garments.</div>
    <div style="width: 64px; height: 56px; left: 177px; top: 59px; position: absolute; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); overflow: hidden">
      <div style="width: 51.27px; height: 32.67px; left: 6.37px; top: 11.67px; position: absolute; outline: 4px #3B0000 solid; outline-offset: -2px"></div>
      <div style="width: 19px; height: 17px; left: 22px; top: 19px; position: absolute; background: #3B0000; outline: 2px #3B0000 solid; outline-offset: -1px"></div>
      <div style="width: 6px; height: 6px; left: 22px; top: 19px; position: absolute; background: #EFEFEF; outline: 2px #EFEFEF solid; outline-offset: -1px"></div>
    </div>
  </div>
  <img style="width: 418px; height: 401px; left: 474px; top: 1622px; position: absolute" src="https://placehold.co/418x401" />
  <div data-property-1="Visi" style="width: 418px; height: 401px; left: 892px; top: 1622px; position: absolute; background: #EFEFEF; overflow: hidden">
    <div style="left: 109px; top: 120px; position: absolute; color: #3B0000; font-size: 32px; font-family: Montserrat; font-weight: 700; word-wrap: break-word">Our Mission</div>
    <div style="width: 309px; left: 54px; top: 181px; position: absolute; text-align: center; color: #3B0000; font-size: 25px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">To provide the most innovative products that meet the needs and desires of consumers</div>
    <div style="width: 64px; height: 56px; left: 177px; top: 59px; position: absolute; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)"></div>
    <div style="width: 69px; height: 64px; left: 174px; top: 56px; position: absolute; overflow: hidden">
      <div style="width: 51.75px; height: 48px; left: 8.62px; top: 8px; position: absolute; background: #3B0000"></div>
    </div>
    <div data-property-1="ReadMore" style="padding: 10px; left: 120px; top: 328px; position: absolute; justify-content: center; align-items: center; gap: 10px; display: inline-flex">
      <div style="color: #3B0000; font-size: 25px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Read More →</div>
    </div>
  </div>
  <img style="width: 418px; height: 401px; left: 56px; top: 2024px; position: absolute" src="https://placehold.co/418x401" />
  <div data-property-1="Visi" style="width: 418px; height: 401px; left: 474px; top: 2024px; position: absolute; background: #EFEFEF; overflow: hidden">
    <div style="left: 135px; top: 120px; position: absolute; color: #3B0000; font-size: 32px; font-family: Montserrat; font-weight: 700; word-wrap: break-word">Our Goal</div>
    <div style="width: 309px; left: 54px; top: 181px; position: absolute; text-align: center; color: #3B0000; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">To become a leading player in the textile and garment industry, with a focus on enhancing professionalism, product quality, and competitiveness in both domestic and international markets.</div>
    <div style="width: 64px; height: 56px; left: 177px; top: 59px; position: absolute; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)"></div>
    <div style="width: 67px; height: 67px; left: 175px; top: 51px; position: absolute; overflow: hidden">
      <div style="width: 55.42px; height: 52.92px; left: 5.79px; top: 4.47px; position: absolute; background: #3B0000"></div>
    </div>
  </div>
  <img style="width: 418px; height: 401px; left: 892px; top: 2024px; position: absolute" src="https://placehold.co/418x401" />
  <div style="width: 52px; height: 41.81px; left: 905px; top: 2318.05px; position: absolute; background: #A3947D"></div>
  <div style="width: 13px; height: 2.85px; left: 911.50px; top: 2339.87px; position: absolute; background: #A3947D"></div>
  <div style="width: 13px; height: 2.85px; left: 911.50px; top: 2345.57px; position: absolute; background: #A3947D"></div>
  <div style="width: 13px; height: 2.85px; left: 911.50px; top: 2351.28px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 932.62px; top: 2341.29px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 932.62px; top: 2349.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 939.12px; top: 2341.29px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 939.12px; top: 2349.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 945.62px; top: 2341.29px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.25px; height: 4.28px; left: 945.62px; top: 2349.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 1442px; height: 538px; left: -47px; top: 3099px; position: absolute; background: #FAF8ED"></div>
  <img style="width: 185.35px; height: 78px; left: 543px; top: 3258px; position: absolute" src="https://placehold.co/185x78" />
  <div style="left: 495px; top: 3152px; position: absolute; color: black; font-size: 30px; font-family: Montserrat; font-weight: 500; word-wrap: break-word">Our Biggest Client</div>
  <img style="width: 131.93px; height: 87px; left: 145px; top: 3255px; position: absolute" src="https://placehold.co/132x87" />
  <img style="width: 84.28px; height: 84px; left: 370px; top: 3255px; position: absolute" src="https://placehold.co/84x84" />
  <img style="width: 357.21px; height: 64px; left: 769px; top: 3265px; position: absolute" src="https://placehold.co/357x64" />
  <img style="width: 349.14px; height: 135px; left: 48px; top: 3389px; position: absolute" src="https://placehold.co/349x135" />
  <img style="width: 240px; height: 70px; left: 704px; top: 3410px; position: absolute" src="https://placehold.co/240x70" />
  <img style="width: 242.39px; height: 116px; left: 982px; top: 3387px; position: absolute" src="https://placehold.co/242x116" />
  <img style="width: 316px; height: 316px; left: 381px; top: 3299px; position: absolute" src="https://placehold.co/316x316" />
  <div style="width: 1442px; height: 515px; left: -88px; top: 3638px; position: absolute; background: #3B0000"></div>
  <div style="width: 323px; left: 482px; top: 3726px; position: absolute"><span style="color: white; font-size: 24px; font-family: Montserrat; font-weight: 700; word-wrap: break-word">Visit Us<br/></span><span style="color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word"><br/>Jl. KH. Samanhudi 88, Jetis, Sukoharjo, Solo – Central Java  Indonesia  Phone: (62 – 271) 593188  Fax: (62 – 271) 593488, 591788</span></div>
  <div style="width: 323px; left: 878px; top: 3721px; position: absolute; color: white; font-size: 24px; font-family: Montserrat; font-weight: 700; word-wrap: break-word">Explore</div>
  <div style="width: 323px; left: 878px; top: 3773px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Home</div>
  <div style="width: 323px; left: 878px; top: 3829px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Services</div>
  <div style="width: 323px; left: 878px; top: 3855px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Contact Us</div>
  <div style="width: 323px; left: 878px; top: 3802px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">About</div>
  <div style="left: 73px; top: 3710px; position: absolute; color: #FAF8ED; font-size: 64px; font-family: Overthink; font-weight: 400; word-wrap: break-word">Seamless</div>
  <div style="width: 262px; left: 81px; top: 3794px; position: absolute; color: #FAF8ED; font-size: 20px; font-family: Montserrat; font-weight: 500; word-wrap: break-word">Crafting Confidence, Stitch by Stitch — Proven Designs. Trusted Quality. For You.</div>
  <div style="width: 1442px; height: 0px; left: 30px; top: 4063px; position: absolute; outline: 1px white solid; outline-offset: -0.50px"></div>
  <div style="left: 537px; top: 4090px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Copyright © 2025 - Eva & Syfa </div>
  <div style="width: 656px; left: 608px; top: 1077px; position: absolute; text-align: justify"><span style="color: #560202; font-size: 36px; font-family: Montserrat; font-style: italic; font-weight: 600; word-wrap: break-word"><br/></span><span style="color: #560202; font-size: 24px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Each piece is made with care to boost your confidence through quality stitching, reliable designs, and materials that last. Designed to meet your needs—because you deserve the best, every day.</span></div>
  <div style="width: 656px; height: 188px; left: 608px; top: 897px; position: absolute">
    <div style="width: 154px; height: 42px; left: 0px; top: 0px; position: absolute; color: #A3850B; font-size: 28px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">ABOUT US</div>
    <div style="width: 656px; left: 0px; top: 48px; position: absolute; text-align: justify; color: #560202; font-size: 36px; font-family: Montserrat; font-style: italic; font-weight: 600; word-wrap: break-word">Crafting Confidence, Stitch by Stitch — Proven Designs. Trusted Quality. For You.</div>
  </div>
  <img style="width: 474px; height: 500px; left: 91px; top: 835px; position: absolute" src="https://placehold.co/474x500" />
  <div style="width: 90px; height: 90px; left: 885px; top: 2765px; position: absolute; background: #FAF8ED; border-radius: 9999px"></div>
  <div style="width: 114px; height: 25px; left: 873px; top: 2884px; position: absolute; color: white; font-size: 20px; font-family: Montserrat; font-weight: 400; word-wrap: break-word">Production</div>
  <div style="width: 50px; height: 51.89px; left: 905px; top: 2784px; position: absolute; background: #A3947D"></div>
  <div style="width: 12.50px; height: 3.54px; left: 911.25px; top: 2811.08px; position: absolute; background: #A3947D"></div>
  <div style="width: 12.50px; height: 3.54px; left: 911.25px; top: 2818.17px; position: absolute; background: #A3947D"></div>
  <div style="width: 12.50px; height: 3.54px; left: 911.25px; top: 2825.25px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 931.56px; top: 2812.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 931.56px; top: 2823.48px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 937.81px; top: 2812.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 937.81px; top: 2823.48px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 944.06px; top: 2812.85px; position: absolute; background: #A3947D"></div>
  <div style="width: 3.12px; height: 5.31px; left: 944.06px; top: 2823.48px; position: absolute; background: #A3947D"></div>
  <<!-- Navbar Container -->
<div style="width: 1016px; height: 72px; left: 50%; top: 41px; position: absolute; transform: translateX(-50%);">
  <!-- Background rounded -->
  <div style="width: 1016px; height: 72px; left: 0px; top: 0px; position: absolute; background: #FAF8EB; border-radius: 70px;"></div>

  <!-- Brand / Logo -->
  <div style="width: 153px; height: 18px; left: 40px; top: 27.5px; position: absolute; text-align: center; justify-content: center; display: flex; flex-direction: column; color: #3B0000; font-size: 24px; font-family: Overthink; font-weight: 400;">
    Seamless
  </div>

  <!-- Home link -->
  <a href="dashUtama.php" style="width: 65px; height: 29px; left: 307px; top: 22px; position: absolute; color: #3B0000; font-size: 20px; font-family: Poppins; font-weight: 600; text-decoration: none;">
    Home
  </a>

  <!-- About link -->
  <a href="#about" style="width: 66px; height: 29px; left: 450px; top: 22px; position: absolute; color: #3B0000; font-size: 20px; font-family: Poppins; font-weight: 600; text-decoration: underline; word-wrap: break-word;">
    About
  </a>

  <!-- Service link -->
  <a href="service.php" style="width: 80px; height: 29px; left: 595px; top: 22px; position: absolute; color: #3B0000; font-size: 20px; font-family: Poppins; font-weight: 600; text-decoration: none;">
    Service
  </a>

  <!-- Contact Us button -->
  <div style="width: 152px; left: 790px; top: 17px; position: absolute; display: flex; flex-direction: column; align-items: flex-start;">
    <div id="contact-bg" style="width: 152px; height: 39px; background: #3B0000; border-radius: 70px;"></div>
    <a href="#contact" 
       onmouseover="document.getElementById('contact-bg').style.background='#5c1a1a';" 
       onmouseout="document.getElementById('contact-bg').style.background='#3B0000';"
       style="color: #E2CEB1; font-size: 20px; font-family: Poppins; font-weight: 600; margin-top:-35px; margin-left: 25px; text-decoration: none;">
      Contact Us
    </a>
  </div>
</div>

  <<!-- Chat Button -->
<div id="chat-button">
  <img src="https://cdn-icons-png.flaticon.com/512/2462/2462719.png" alt="Chat" />
</div>

<!-- Chat Box -->
<div id="chat-box">
  <div id="chat-header">Chat Assistant</div>
  <div id="chat-messages">
    <div class="message bot">Halo! Ada yang bisa kami bantu?</div> <!-- Kasih alur kayak, ada pilihan mau tanya apa mau pesen -->
  </div>
</div>

  </div>
 <script>
  const chatButton = document.getElementById('chat-button');
  const chatBox = document.getElementById('chat-box');
  const chatMessages = document.getElementById('chat-messages');

  chatButton.addEventListener('click', () => {
    chatBox.style.display = chatBox.style.display === 'none' || chatBox.style.display === '' ? 'flex' : 'none';
  });

  function addMessage(text, sender) {
    const msg = document.createElement('div');
    msg.className = `message ${sender}`;
    msg.textContent = text;
    chatMessages.appendChild(msg);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  // Menambahkan input interaktif
  const chatInputArea = document.createElement('div');
  chatInputArea.id = 'chat-input-area';

  chatInputArea.innerHTML = `
    <input type="text" id="chat-input" placeholder="Ketik pesan..." />
    <button id="send-btn">Kirim</button>
  `;

  chatBox.appendChild(chatInputArea);

  document.getElementById('send-btn').addEventListener('click', handleUserInput);
  document.getElementById('chat-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      handleUserInput();
    }
  });

  function handleUserInput() {
    const input = document.getElementById('chat-input');
    const userMessage = input.value.trim();
    if (userMessage) {
      addMessage(userMessage, 'user');
      input.value = '';
      setTimeout(() => respondToUser(userMessage.toLowerCase()), 500);
    }
  }

  function respondToUser(message) {
    let response = "Maaf, saya tidak mengerti. Bisa ulangi?";
    if (message.includes("produk")) {
      response = "Kami menyediakan berbagai pakaian custom berkualitas. Apa kamu tertarik dengan produksi atau desain?";
    } else if (message.includes("layanan")) {
      response = "Kami menawarkan layanan produksi, pemotongan, pola, jahit, dan custom. Ingin tahu lebih lanjut?";
    } else if (message.includes("halo") || message.includes("hai")) {
      response = "Halo juga! Ada yang bisa kami bantu terkait produk, layanan, atau proyek kami?";
    } else if (message.includes("alamat")) {
      response = "Kami berlokasi di Jl. KH. Samanhudi 88, Jetis, Sukoharjo, Solo – Jawa Tengah.";
    }

    addMessage(response, 'bot');
  }
</script>
</div>
</body>
</html>
