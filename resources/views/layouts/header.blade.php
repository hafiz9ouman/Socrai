
    <div id="site-shadow" class="SiteBlock-shadow"></div>
    <header class="HeaderBlock jsHeader ">


        <div class="Header jsHeader">

            <a href="#" class="MenuMobileButton MenuMobileButton--hideDesktop u-noBorder u-noMargin" data-toggle="menu">
                <span class="MenuMobileButton-icon"></span>
            </a><div style="display: none;"><a href="#" id="ubbfccwz" rel="file"></a></div>

            <div class="Container">
                <div class="Header-logoDesktop">
                    <a href="{{url('/')}}" class="Logo">
                        <img class="Logo-image" src="{{asset('assets/masterFrontend/img/lgo.png   ')}}">
                    </a>
                </div>

                <div class="Header-mWebBox jsMobileNavbar">
                    <nav class="navbar navbar-default visible-xs-block visible-sm-block navbar-fixed-top jsMobileNavbar u-width--full">
                        <div class="container-fluid hide-print">
                            <div class="Logo">
                                <a href="#">

                                    <img class="Logo-image" src="{{asset('assets/masterFrontend/img/lgo.png')}}">
                                </a>
                            </div>


                            <ul class="nav navbar-nav navbar-right">

                            </ul>


                        </div>
                    </nav>


                </div>

                <ul class="Header-nav">
                    <li class="Header-navListItem">
                        <a href="#"
                           class="Header-navText">
                            Work With Us
                        </a>
                    </li>
                    <li class="Header-navListItem">
          <span class="Header-navText jsGoogleOneTap"  data-toggle="modal" data-target=".animate" data-ui-class="a-zoomDown">
            Sign In / Register
          </span>

                    </li>
                </ul>
            </div>
        </div>


        <div id="site-menu" class="SiteBlock-menu">

            <div class="MainNav">
                <div class="Container">
                    <ul class="MainNav-list isHoverable">
                        <li class="MainNav-listItem isTrackingMenuItem" data-trending-id="1461204" data-type="Sales">
{{--                            --}}
{{--                            --}}
                            <a class="MainNav-text hover" data-toggle="nav_popup" href="{{url('/UserSales')}}">Sales</a>
                            <div class="MainNav-popup">
                                <div class="Container">
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">
                                            Areas
                                        </h6>

                                        <ul class="MainNav-popupList">

                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">Manhattan</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">Brooklyn</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">Queens</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">Bronx</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">Staten Island</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">New Jersey</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales" class="MainNav-popupColumnLink" href="#">All NYC + NJ</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--last">
                                        <h6 class="MainNav-popupTitle">Popular neighborhoods</h6>
                                        <ul class="MainNav-popupList">
                                            @foreach($data[0] as $datum)
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    {{$datum->title}}
                                                </a>
                                            </li>
                                            @endforeach
                                                <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Sales"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    View All
                                                </a>
                                            </li>

                                        </ul>

                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--ads">

                                        <div class="MostViewedItem">
                                            <div class="MostViewedItem-imgBox">
                                                <a data-gtm-header-listing-id="1465122" data-gtm-header-listing-type="sale" href="#"><img alt="125 East 12th #5H" class="MostViewedItem-img" src="{{asset('assets/masterFrontend/img/apartment.png')}}" /></a>
                                            </div>
                                            <div class="MostViewedItem-content">
                                                <a class="MostViewedItem-titleLink" data-gtm-header-listing-id="1465122" data-gtm-header-listing-type="sale" href="#">125 East 12th #5H</a>
                                                <div>

        <span class="MostViewedItem-price">
          $1,780,000
        </span>
                                                    <span class="MostViewedItem-for">
          for sale
        </span>
                                                </div>

                                                <div>2 beds<span class='MostViewedItem-bullet'>&bullet;</span>2 baths</div>
                                                <div>Condo in <a href="#">East Village</a></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="MainNav-listItem isTrackingMenuItem"
                            data-trending-id="3025820"
                            data-type="Rentals">
                            <a class="MainNav-text on_active" data-toggle="nav_popup" href="{{url('/UserRentals')}}">Rentals</a>
                            <div class="MainNav-popup">
                                <div class="Container">
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">
                                            Areas
                                        </h6>
                                        <ul class="MainNav-popupList">
                                            @foreach($data[1] as $row)
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Rentals" href="#">{{$row->title}}</a>
                                            </li>
                                            @endforeach

                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Rentals" href="#">All NYC + NJ</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--last">
                                        <h6 class="MainNav-popupTitle">Popular neighborhoods</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Tribeca
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Upper East Side
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Upper West Side
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    East Village
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Williamsburg
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Astoria
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"    class="MainNav-popupColumnLink">
                                                    Hoboken
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Jersey City
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Rentals"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    View All
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--ads">

                                        <div class="MostViewedItem">
                                            <div class="MostViewedItem-imgBox">
                                                <a data-gtm-header-listing-id="2986137" data-gtm-header-listing-type="rental" href="#"><img alt="50 Franklin Street" class="MostViewedItem-img" src="{{asset('assets/masterFrontend/img/apartment.png')}}" /></a>
                                            </div>
                                            <div class="MostViewedItem-content">
                                                <a class="MostViewedItem-titleLink" data-gtm-header-listing-id="2986137" data-gtm-header-listing-type="rental" href="#">50 Franklin Street</a>
                                                <div>
                                                    <span>↓</span>
                                                    <span class="MostViewedItem-price">
          $4,350
        </span>
                                                    <span class="MostViewedItem-for">
          for rent
        </span>
                                                </div>

                                                <div>Furnished<span class='MostViewedItem-bullet'>&bullet;</span>1 bed<span class='MostViewedItem-bullet'>&bullet;</span>1 bath<span class='MostViewedItem-bullet'>&bullet;</span>719 ft&sup2;</div>
                                                <div>Condo in <a href="#">Tribeca</a></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="MainNav-listItem isTrackingMenuItem"
                            data-trending-id="110"
                            data-type="Buildings">
                            <a class="MainNav-text" data-toggle="nav_popup" href="{{url('/UserBuilding')}}">Buildings</a>
                            <div class="MainNav-popup">
                                <div class="Container">
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">Browse</h6>
                                        <ul class="MainNav-popupList MainNav-popupList--paddingBottom">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    New Developments
                                                </a>
                                            </li>
                                        </ul>
                                        <h6 class="MainNav-popupTitle">
                                            Areas
                                        </h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Manhattan
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Brooklyn
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Queens
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Bronx
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Staten Island
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" href="#">New Jersey</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Buildings" href="#">All NYC + NJ</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">Popular buildings</h6>

                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    15 Hudson Yards
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    The Rheingold
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    432 Park Avenue
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    PLG
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    11 Hoyt
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    111 Murray Street
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    American Copper Buildings
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    50 West Street
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    View All
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--lastShort">
                                        <h6 class="MainNav-popupTitle">New developments</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    15 Hudson Yards
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    21 West End Ave
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Madison Square Park Tower
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    1 West End
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    365 Bond
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    The Margo
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    88 Lexington Avenue
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Oosten
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Buildings"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    View All
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--adsShort">
                                        <div class="MostViewedItem">
                                            <div class="MostViewedItem-img">
                                                <a href="#"><img srcset="{{asset('assets/masterFrontend/img/apartment.png')}}" alt="new developments" src="{{asset('assets/masterFrontend/img/apartment.png')}}" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="MainNav-listItem isTrackingMenuItem" data-type="Resourses">
                            <span class="MainNav-text" data-toggle="nav_popup">Resources</span>
                            <div class="MainNav-popup">
                                <div class="Container">
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">Browse</h6>
                                        <ul class="MainNav-popupList MainNav-popupList--paddingBottom">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    No-fee Apartments
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Pet-Friendly Rentals
                                                </a>
                                            </li>
                                        </ul>
                                        <h6 class="MainNav-popupTitle">Guides</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" href="#">NYC Real Estate Guides</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" href="#">Neighborhood Guides</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" href="#">Moving to NYC Guide</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">Mortgage</h6>
                                        <ul class="MainNav-popupList MainNav-popupList--paddingBottom">
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" rel="nofollow" href="#">Mortgage Rates</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" href="#">Mortgage Calculator</a>
                                            </li>
                                        </ul>
                                        <h6 class="MainNav-popupTitle">Tools</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    CoZmo-web Forums
                                                </a>
                                            </li>
                                            <li name="open_house_planner" class="MainNav-popupListItem">
                                                <a data-modal-class="modal-signin" data-gtm-login-required="true" data-gtm-rendered-from="site_nav" data-gtm-origin="open_house" data-gtm-track="resources-menu" data-gtm-header-menu="Resources" class="MainNav-popupColumnLink" data-toggle="modal" data-modal-source="/nyc/user/register_dialog?return_to=%2Fnyc%2Fopen_house_planner&origin=open_house" href="#">Open House Planner</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Agent Resource Center
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a href="#">
                                                    Data Dashboard
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--lastShort">
                                        <h6 class="MainNav-popupTitle">Market Data</h6>
                                        <ul class="MainNav-popupList MainNav-popupList--paddingBottom">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Market Reports
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a onclick="window.gon.state.analyticsData = {&#39;source&#39;:&#39;comparables_report&#39;};window.gon.state.triggerScenario(&#39;EmailCapture&#39;, { redirectTo: &#39;/my/comparables&#39; });" data-modal-class="modal-signin" data-gtm-login-required="true" data-gtm-rendered-from="site_nav" data-gtm-origin="comparables_report" data-gtm-track="resources-menu" data-gtm-header-menu="Resources" class="MainNav-popupColumnLink" href="#">Comparables Reports</a>
                                            </li>
                                        </ul>
                                        <h6 class="MainNav-popupTitle">Q&A</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    Should You Rent or Buy?
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    What are Maintenance Fees
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    How Much Rent Can You Afford?
                                                </a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a data-gtm-header-menu="Resources"
                                                   href="#"
                                                   class="MainNav-popupColumnLink">
                                                    How to Find a Roommate
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--adsShort">
                                        <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" data-gtm-header-resource-ad="true" href="#"><img srcset="" src="{{asset('assets/masterFrontend/img/apartment.png')}}" /></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="MainNav-listItem isTrackingMenuItem" data-type="Blog">
                            <a class="MainNav-text" data-toggle="nav_popup" href="{{url('/UserBlog')}}">Blog</a>
                            <div class="MainNav-popup">
                                <div class="Container">
                                    <div class="MainNav-popupColumn">
                                        <h6 class="MainNav-popupTitle">Browse</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Trends &amp; Data</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Good Deals</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">NYC Living</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Tips &amp; Advice</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">NYC Guides</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--lastLong">
                                        <h6 class="MainNav-popupTitle">The latest</h6>
                                        <ul class="MainNav-popupList MainNav-popupList--paddingBottom">
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">5 Virtual Home Tours to Take From Your Sofa</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Here&#39;s What $1.5M Gets You in NYC Right Now</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">NYC Apartments for $2400: What You Can Rent Right Now</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">A Stylish Kips Bay Duplex for $465K</a>
                                            </li>
                                        </ul>

                                        <h6 class="MainNav-popupTitle">Most popular</h6>
                                        <ul class="MainNav-popupList">
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Finished Netflix? 15 Ideas for What New Yorkers Should Watch Next!</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">A Quintessential Prewar UWS 1BR Asks $2,650</a>
                                            </li>
                                            <li class="MainNav-popupListItem">
                                                <a class="MainNav-popupColumnLink" data-gtm-header-menu="Blog" href="#">Your Guide to NYC Laundry Services (Plus COVID Tips!)</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="MainNav-popupColumn MainNav-popupColumn--adsShort">
                                        <a class="MainNav-popupColumnLink" data-gtm-header-menu="Resources" data-gtm-header-resource-ad="true" href="#"><img srcset="" src="{{asset('assets/masterFrontend/img/apartment.png')}}" /></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="MainNav-search">
                        <form class="Search" onSubmit="SE.analytics.submitTextSearch(this)" action="/search" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="&#x2713;" />
                            <input type="text" name="search" placeholder="e.g. address, building, agent" class="Search-input DefaultField" />
                            <button name="commit" type="submit" value="" class="fa fa-search Search-button"></button>
                        </form>      </div>
                </div>
            </div>

            <div class="MainNav MainNav--mWeb jsMenuMobile" id="navbar_block">
                <div id="navbar_menu" class="MainNav-search">
                    <form class="Search Search--mWebMenu" action="/search" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="&#x2713;" />
                        <input type="text" name="search" id="search" placeholder="Search" class="Search-input Search-input--big DefaultField" />
                        <button name="commit" type="submit" value="" class="Search-button Search-button--icon Search-button--big"></button>
                    </form>
                    <ul class="MainNav-mainMenu">
                        <li class="MainNav-mainMenuItem">
                            <a class="MainNav-textMobile MainNav-textMobile--big" href="">Sales</a>
                        </li>
                        <li class="MainNav-mainMenuItem">
                            <a class="MainNav-textMobile MainNav-textMobile--big" href="">Rentals</a>
                        </li>
                        <li class="MainNav-mainMenuItem">
                            <a class="MainNav-textMobile MainNav-textMobile--big" href="#">Buildings</a>
                        </li>
                        <li class="MainNav-mainMenuItem">
          <span class="MainNav-textMobile MainNav-textMobile--big isWithArrow" data-toggle="submenu">
            Resources
          </span>
                            <div class="MainNav-subMenuPopup">
                                <div class="MainNav-subMenuHeader">Main Menu</div>
                                <h6 class="MainNav-subMenuTitle">Browse</h6>
                                <ul class="MainNav-subMenuList">
                                    <li>
                                        <a href="#" class="MainNav-textMobile MainNav-textMobile--small">
                                            CoZmo-web Blog
                                        </a>
                                    </li>
                                </ul>
                                <h6 class="MainNav-subMenuTitle">Guides</h6>
                                <ul class="MainNav-subMenuList">
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">NYC Real Estate Guides</a>
                                    </li>
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">Neighborhood Guides</a>
                                    </li>
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">Moving to NYC Guide</a>
                                    </li>
                                </ul>
                                <h6 class="MainNav-subMenuTitle">Tools</h6>
                                <ul class="MainNav-subMenuList">
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">Market Reports</a>
                                    </li>
                                    <li>
                                        <a onclick="window.gon.state.analyticsData = {&#39;source&#39;:&#39;comparables_report&#39;};window.gon.state.triggerScenario(&#39;EmailCapture&#39;, { redirectTo: &#39;/my/comparables&#39; });" class="MainNav-textMobile MainNav-textMobile--small" data-modal-class="modal-signin" data-gtm-login-required="true" data-gtm-rendered-from="site_nav" data-gtm-origin="comparables_report" href="#">Comparables Reports</a>
                                    </li>
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">CoZmo-web Forums</a>
                                    </li>
                                    <li>
                                        <a class="MainNav-textMobile MainNav-textMobile--small" href="#">Agent Resource Center</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="MainNav-textMobile MainNav-textMobile--small">
                                            Data Dashboard
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>



                    </ul>


                    <ul class="MainNav-signinMenu" id="singin-menu">
                        <li>
                            <a class="MainNav-textMobile MainNav-textMobile--signIn jsGoogleOneTap" onclick="window.gon.state.analyticsData = {&#39;source&#39;:&#39;nav&#39;}; window.gon.state.triggerScenario(&#39;EmailCapture&#39;); return false;" data-toggle="menu" href="#">Sign In / Register</a>
                        </li>
                    </ul>

                </div>
            </div>

        </div>

    </header>

{{--    @include('layouts.flashmessage')--}}
    <script>
        $(document).ready(function(){

            $('.hover').tooltip({
                title: fetchData,
                html: true,
                placement: 'right'
            });
            function fetchData()
            {
                var fetch_data = '';
                var element = $(this);
                var id = element.attr("id");
                $.ajax({
                    url:"fetch.php",
                    method:"POST",
                    async: false,
                    data:{id:id},
                    success:function(data)
                    {
                        fetch_data = data;
                    }
                });
                return fetch_data;
            }
        });
        // $('.on_active').click(function () {
        //     $('.top_active').addClass('isCurrent');
        // });
    </script>

