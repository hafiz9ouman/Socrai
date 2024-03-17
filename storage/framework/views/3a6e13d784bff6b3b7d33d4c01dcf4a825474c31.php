<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Create a stylish landing page for your business startup and get leads for the offered services with this HTML landing page template.">
    <meta name="author" content="Inovatik">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>Socrai x</title>

    <!-- Styles -->

    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('sucrai/assets/css/bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('sucrai/assets/css/fontawesome-all.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('sucrai/assets/css/magnific-popup.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('sucrai/assets/css/styles.css')); ?>" rel="stylesheet" >

    <!-- fontawesome -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!-- Favicon  -->
    <link rel="icon" href="<?php echo e(asset('sucrai/assets/images/favicon.png')); ?>">
</head>
<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <!-- Text Logo - Use this if you don't have a graphic logo -->
        <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Evolo</a> -->

        <!-- Image Logo -->
        <a class="navbar-brand logo-image" href=""><img src="<?php echo e(asset('sucrai/assets/images/logo.png')); ?>" alt="alternative"></a>

        <!-- Mobile Menu Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>
        <!-- end of mobile menu toggle button -->

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                                <!-- Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">Question socrai</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><span class="item-text">DropDown 2</span></a>
                        <div class="dropdown-items-divide-hr"></div>
                        <a class="dropdown-item" href="#"><span class="item-text">DropDown 1</span></a>
                    </div>
                </li>
                <!-- end of dropdown menu -->
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#">Covid-19</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="#">Contact us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle page-scroll login_drpdwn" href="#about" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">Login</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item"  href="" ><span class="item-text">Signup</span></a>
                        <div class="dropdown-items-divide-hr"></div>
                        <a class="dropdown-item" href=""><span class="item-text">Login</span></a>
                    </div>
                </li>
                <div class="single">
                    <div class="input-group">
                     <input type="email" class="form-control eef" placeholder="Enter Address">
                     <span class="input-group-btn">
                     <button class="btn btn-theme eeff" type="submit">Get Started</button>
                     </span>
                    </div>
                </div>
            </ul>
        </div>
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->


    <!-- Header -->
    <header id="header" class="header">
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                    </div> <!-- end of col -->
                    <div class="col-lg-6">
                        <div class="image-container">
                          <div class="text-container">
                            <h2>Sometime You Win <br> Sometimes You Learn</h2>
                            <h5>Get Already Access</h5>
                            <p>Be the first to know when the app becomes available</p>
                            <a class="btn-solid-lg page-scroll" href="#">join Now</a>
                         </div> <!-- end of text-container -->
                        </div> <!-- end of image-container -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of header-content -->
    </header> <!-- end of header -->
    <!-- end of header -->

    <main>

        <!-- start services -->

        <section class="services">
            <div class="container">
                <div class="main_title">
                    <h3>Check out what we can do!</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="serv_img">
                            <img src="<?php echo e(asset('sucrai/assets/images/serv_img.png')); ?>" alt="image" class="img-fluid">
                            <div class="img_position">
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/how.png')); ?>" class="how_img" alt=""></a>
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/where.png')); ?>" class="where_img" alt=""></a>
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/who.png')); ?>" class="who_img" alt=""></a>
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/why.png')); ?>" class="why_img" alt=""></a>
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/what.png')); ?>" class="what_img" alt=""></a>
                                <a href="javascript:void(0)"><img src="<?php echo e(asset('sucrai/assets/images/when.png')); ?>" class="when_img" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--  end services   -->

        <!-- start whysocrai -->

        <section class="why_scorai">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text_section">
                            <h3>Why Socrai</h3>
                            <p> <i class="fa fa-circle-o"></i> The digital revolution has done a lot of good for multiple sectors such as medicine (surgery), automotive, retail,… but also resulted in an explosion of information. Did you know that all of the information created since the dawn of mankind and 2003 (more than 5.000 years) is now created every two days and as a result more than 90% of today’s available information has been created in the past 2 years!</p>
                            <p> <i class="fa fa-circle-o"></i> But for some reason our education hasn’t benefited in the same way of this digital revolution
                            </p>
                            <p> <i class="fa fa-circle-o"></i> In the 1950’s the third industrial revolution, also called the DIGITAL REVOLUTION, started, once again transforming how people live, work, and communicate. Let’s have a look how this impacted two industries that have been performed for over 2.000 years: SURGERY and LEARNING. Let’s visualize it:
                            </p>
                            <p> <i class="fa fa-circle-o"></i> 70 years of evolution and the introduction of technology have revolutionized surgery. The introduction of technology in surgery has made significant contributions in its development (monitoring, robotics, individualized precision interventions, less human interaction/error) and the patient’s overall well-being. Compare this to the evolution in learning. Apart from the introduction of computers, tablets and smart-boards, things have moved very little… and learner’s well-being did not drastically improve. Education really means “leading forth” or develop.
                            </p>

                            <!-- intrested -->
                            <h3>WE ARE INTERESTED IN LEARNING MORE!</h3>
                            <p> <i class="fa fa-circle-o"></i> With the massive explosion of information coming to us, the underusage of the digital revolution and the fact we need to be lifelong learners, we decided it is time to revolutionize the learning experience. And so SOCRAI was created.
                            </p>
                            <p> <i class="fa fa-circle-o"></i> SOCRAI aims to be your companion to acquire a skill rapidly, shake out only the must have information and focus on practicing the skill as quickly as possible. We believe that with 20 hours of practice, you can acquire any skill you would like. Consider it acquiring the skill to have a conversation in a different language, instead of learning a language or to start playing an instrument instead of learning how to read music…
                            </p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="imgs_angles">
                            <div class="old_img">
                                <img src="<?php echo e(asset('sucrai/assets/images/old.png')); ?>" alt="" class="img-fluid">
                                <h2>Old</h2>
                            </div>
                            <div class="new_img">
                                <img src="<?php echo e(asset('sucrai/assets/images/today.png')); ?>" alt="" class="img-fluid" id="second_img">
                                <h2>New</h2>
                            </div>
                        </div>
                        <div class="imgs_angles second_angles">
                            <div class="old_img">
                                <img src="<?php echo e(asset('sucrai/assets/images/old2.png')); ?>" alt="" class="img-fluid">
                                <h2>Old</h2>
                            </div>
                            <div class="new_img">
                                <img src="<?php echo e(asset('sucrai/assets/images/today2.png')); ?>" alt="" class="img-fluid" id="second_img">
                                <h2>New</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end why socrai -->

        <!-- socrai -->

        <section class="robot">
            <div class="container">
                <div class="row add_mrgin">
                    <div class="col-md-6 pr-0">
                        <div class="robot_left">
                           <div class="robot_text">
                            <h3>What is socrai</h3>
                            <p> <i class="fa fa-circle-o"></i> SOCRAI can be best described as a rapid skill acquisition platform. It consists of two main building blocks: Limit the theory to only 20% of your time and use the Socratic method to learn (= you ask the questions, we answer them… this is how you acquired quick skills and wisdom as of the age of 2) Focus 80% of your time on the practice and do this via an online tribe. These are people that share the same motivation as you to acquire new skills. Inside the tribe your digital identity is key and it is your space. We do not share data with anyone. The goal is to acquire a skill in 20 hours of time.
                            </p>
                            <p> <i class="fa fa-circle-o"></i>
                            To start off, we will provide a minimum of 12 domains for free, as a gift to yourself. You will amongst others learn how to ask the right questions, how your brain works, what your mindset can do for you, how to better share wisdom through stories, how to un-dope your smartphone and many things more.
                            </p>
                            <p> <i class="fa fa-circle-o"></i>
                            The aim of SOCRAI is: To stop teaching to pass a test and start to learn to apply (= rapid skill acquisition) To stop benchmarking the average, but focus on you, as an individual. Your strengths, your learning style, your tribe… And finally close the gap. Access to information / education / knowledge… wisdom should be available for anyone. We will use SOCRAI to close this gap and make give people access to their digital identity and their personal skill acquisition. We will consider SOCRAI successful if We have given you an individual learning experience Increased your creativity, through tribe practicing Fueled innovation, by making you think critically And finally help build your dreams and dreams of those that currently do not have access to it…
                            </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 pl-0">
                        <img src="<?php echo e(asset('sucrai/assets/images/robot.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="row add_mrgin">
                    <div class="col-md-6 pr-0">
                        <img src="<?php echo e(asset('sucrai/assets/images/mobile.png')); ?>" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-6 pl-0">
                        <div class="mobile">
                            <div class="mobile_txt">
                              <h3>How is socrai</h3>
                              <p> <i class="fa fa-circle-o"></i>  SOCRAI interacts as a platform between a sensei - (s)he who knows a skill and the student - (s)he who want to acquire a skill. It uses questions both to the sensei and from the student and is artificially intelligent. It will answer all your questions, in the same manner the sensei answered SOCRAI. We will provide materials both as video, audio or text and most time will be spent on practicing your skill within your tribe.
                              </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row add_mrgin">
                    <div class="col-md-6 pr-0">
                        <div class="when_socrai">
                            <div class="when_socrai_txt">
                              <h3>How is socrai</h3>
                              <p> <i class="fa fa-circle-o"></i>  SOCRAI interacts as a platform between a sensei - (s)he who knows a skill and the student - (s)he who want to acquire a skill. It uses questions both to the sensei and from the student and is artificially intelligent. It will answer all your questions, in the same manner the sensei answered SOCRAI. We will provide materials both as video, audio or text and most time will be spent on practicing your skill within your tribe.
                              </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="<?php echo e(asset('sucrai/assets/images/robopeople.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <!-- end socrai -->

        <section class="install">
            <div class="container">
                <div class="install_data">
                    <h4>Where is SOCRAI</h4>
                    <h5>Initially SOCRAI Will Be Available As An App On IOS</h5>
                </div>
                <div class="install_imgs">
                    <img src="<?php echo e(asset('sucrai/assets/images/robopeople.png')); ?>" alt="">
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h2>How Is SOCRAI</h2>
                         <div class="row slider_mrgin">
                             <div class="col-md-6 d-flex align-items-center">
                                <div class="img_sec">
                                    <img class="" src="<?php echo e(asset('sucrai/assets/images/slider.png')); ?>" alt="">
                                    <div class="img_title">
                                        <p>Geert</p>
                                    <i class="fa fa-linkedin-square"><span>Linkedin</span></i>
                                    </div>
                                </div>
                             </div>
                             <div class="col-md-6 d-flex align-items-center">
                                 <p class="right_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                 consequat.</p>
                             </div>
                         </div>
                    </div>
                    <div class="carousel-item">
                        <h2>How Is SOCRAI 2</h2>
                         <div class="row slider_mrgin">
                             <div class="col-md-6 d-flex align-items-center">
                                <div class="img_sec">
                                    <img class="" src="<?php echo e(asset('sucrai/assets/images/w1.png')); ?>" alt="">
                                    <div class="img_title">
                                        <p>Geert</p>
                                    <i class="fa fa-linkedin-square"><span>Linkedin</span></i>
                                    </div>
                                </div>
                             </div>
                             <div class="col-md-6 d-flex align-items-center">
                                 <p class="right_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                 consequat.</p>
                             </div>
                         </div>
                    </div>
                    <div class="carousel-item">
                        <h2>How Is SOCRAI 3</h2>
                         <div class="row slider_mrgin">
                             <div class="col-md-6 d-flex align-items-center">
                                <div class="img_sec">
                                    <img class="" src="<?php echo e(asset('sucrai/assets/images/w2.png')); ?>" alt="">
                                    <div class="img_title">
                                        <p>Geert</p>
                                    <i class="fa fa-linkedin-square"><span>Linkedin</span></i>
                                    </div>
                                </div>
                             </div>
                             <div class="col-md-6 d-flex align-items-center">
                                 <p class="right_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                 consequat.</p>
                             </div>
                         </div>
                    </div>
                  </div>

                </div>
                <div class="arrows">
                      <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      </a>
                  </div>
            </div>
        </section>

        <section class="text_sec">
            <div class="container">
                <div class="start_text">
                    <p> <i class="fa fa-circle-o"></i> Following the Rwanda genocide in 1994, Egide ended up in Belgium in 1998, at the age of 16. All alone… his family was scattered around Kenya, France, USA,… Being in the local youth movement, Geert (at that time studying to be a school teacher in English, History and Economics) was asked to go and “help / integrate” our new community member as best as he could.
                    </p>
                    <p> <i class="fa fa-circle-o"></i> Since that date, now well over 20 years ago, we have been soul mates and brothers. During the past 20 years we have worked together on education projects, to better integrate refugees in their new communities (language courses, integration tracks,…). We noticed how both education systems in Belgium and Rwanda were completely different and how hard it was to continue the curriculum of Rwanda here in Belgium.
                    </p>
                    <p> <i class="fa fa-circle-o"></i> We also noticed that what you learn in theory (mostly here in Belgium) and what you learn from life (as Egide experienced) is completely different. The latter gives you a certain sense of wisdom. While Egide learned a lot to kick off his life in Belgium, Geert learned a lot of the real value of life, social contacts and friendship of Egide.
                    </p>
                    <p> <i class="fa fa-circle-o"></i> Having both 2 kids, they noticed that our education system has not been taking advantage of the digital revolution (not for children, not for adults) and our (e)learning plans were still very focused on information and knowledge transfer, not on a personalized learning experience to reach understanding. Being both continuous learners (Geert going from history teacher into cybersecurity and Egide ending up in the same discipline, after having worked in different public and private sectors for years) they noticed that tools and methods could be improved. Hence, SOCRAI was born….
                    </p>
                    <p> <i class="fa fa-circle-o"></i> We had the idea; we just needed some technical help to make the dream a reality. This is when we met Pieter during the Vibe Awards, an innovation initiative by Belgium’s the Cronos Group. During the kickoff weekend, we had to make a mood board… Pieter’s one stood out by a clean and well thought stylish design. He convinced us of his technical talent and attention for user centric delivery and so we hired him to develop our whole technical environment, resulting into the SOCRAI App.
                    </p>
                    <p> <i class="fa fa-circle-o"></i> We want to get rid of learning programs that teach to test (school, (IT) certifications,…) or solutions that can’t individualize. In our dream, everyone should have access to acquire skills at his own pace, order, learning style,… and the road to wisdom should be adapted for each and every one. The SOCRAI team will be working hard on achieving this… for those who have access today and create the opportunity for those who don’t. Let’s learn some skills and help close the gap while doing so…. Everyone deserves access to rapid skill acquisition!
                    </p>
                </div>
            </div>
        </section>

        <section class="contact_us">

            <div class="container">
                <div class="main_heading">
                <h2>Cotact US</h2>
                <p>Feel free to drop us a message if you require further information!</p>
            </div>
                <div class="row">
            <div class="col-md-6">
                <div id="googlemap" style="width:100%; height:500px;"></div>
            </div>
            <br />
            <div class="col-md-6">
                <form class="my-form">
                    <div class="form-group">
                        <label for="form-name">First Name</label>
                        <input type="email" class="form-control" id="form-name">
                    </div>
                    <div class="form-group">
                        <label for="form-email">Email Address</label>
                        <input type="email" class="form-control" id="form-email">
                    </div>
                    <div class="form-group">
                        <label for="form-subject">Phone No</label>
                        <input type="text" class="form-control" id="form-subject" >
                    </div>
                    <div class="form-group">
                        <label for="form-message">Message</label>
                        <textarea class="form-control" id="form-message" rows="5" ></textarea>
                    </div>
                    <div class="cntct_btn">
                        <button type="submit">Contact Us</button>
                    </div>
                </form>
            </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="footer_links">
                    <div class="footer_logo">
                        <img src="images/logo.png" alt="">
                        <p>Copyright © SOCRAI 2020.All rights reserved</p>
                    </div>
                    <div class="links">
                        <ul>
                            <li><a href="#"><img src="<?php echo e(asset('sucrai/assets/images/linkin.png')); ?>" alt="" class="img-fluid"></a></li>
                            <li><a href="#"><img src="<?php echo e(asset('sucrai/assets/images/fb.png')); ?>" alt="" class="img-fluid"></a></li>
                            <li><a href="#"><img src="<?php echo e(asset('sucrai/assets/images/tw.png')); ?>" alt="" class="img-fluid"></a></li>
                            <li><a href="#"><img src="<?php echo e(asset('sucrai/assets/images/insta.png')); ?>" alt="" class="img-fluid"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </main>


    <!-- Chat -->
                <div class="container">
  <div class="row">
   <div id="Smallchat">
    <div class="Layout Layout-open Layout-expand Layout-right">
      <div class="Messenger_messenger">
        <div class="Messenger_header">
          <div class="Messenger_prompt">
              <img src="<?php echo e(asset('sucrai/assets/images/robo_icon.png')); ?>" alt="">
              <div class="robo_chat">
                  <span>Operator</span>
              <p>Level3</p>
              </div>
          </div> <span class="chat_close_icon"><i class="fa fa-window-close" aria-hidden="true"></i></span>
        </div>
        <div class="Messenger_content">
            <div class="Messages">
                <div class="Messages_list">
                    <div class="messages">
                        <img src="<?php echo e(asset('sucrai/assets/images/robo_icon.png')); ?>" alt="">
                        <div class="list_msg">
                            <p>Hello! Finally found the time to write to you) I need your help.</p>
                            <p>Can i send you files</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!--===============CHAT ON BUTTON STRART===============-->
    <div class="chat_on"> <span class="chat_on_icon"><img src="<?php echo e(asset('sucrai/assets/images/down_arrow.png')); ?>" alt=""></span> </div>
    <!--===============CHAT ON BUTTON END===============-->
  </div>
  </div>
</div>
    <!-- End chat -->



    <!-- Scripts -->
    <script src="<?php echo e(asset('sucrai/assets/js/jquery.min.js')); ?>"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->

    <script src="<?php echo e(asset('sucrai/assets/js/bootstrap.min.js')); ?>"></script> <!-- Bootstrap framework -->
    <script src="<?php echo e(asset('sucrai/assets/js/jquery.easing.min.js')); ?>"></script> <!-- jQuery Easing for smooth scrolling between anchors -->

    <script src="<?php echo e(asset('sucrai/assets/js/jquery.magnific-popup.js')); ?>"></script> <!-- Magnific Popup for lightboxes -->

    <script src="<?php echo e(asset('sucrai/assets/js/scripts.js')); ?>"></script> <!-- Custom scripts -->

    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            // Google Maps setup
            var googlemap = new google.maps.Map(
                document.getElementById('googlemap'),
                {
                    center: new google.maps.LatLng(44.5403, -78.5463),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );
        });
    </script>

          <script>

                $(document).ready(function(){
                    $(".chat_on").click(function(){
                        $(".Layout").toggle();
                        $(".chat_on").hide(300);
                    });

                       $(".chat_close_icon").click(function(){
                        $(".Layout").hide();
                           $(".chat_on").show(300);
                    });

                });
                $(window, document, undefined).ready(function() {

  $('.input').blur(function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  });


$('#tab1').on('click' , function(){
    $('#tab1').addClass('login-shadow');
   $('#tab2').removeClass('signup-shadow');
});

$('#tab2').on('click' , function(){
    $('#tab2').addClass('signup-shadow');
   $('#tab1').removeClass('login-shadow');


});
            </script>


</body>
</html>
