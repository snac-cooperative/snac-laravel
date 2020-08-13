    @if ( env('APP_GA') )
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', "{{ env('APP_GA') }}", 'auto');
            ga('send', 'pageview');
        </script>
    @endif

    <script>
        var snacUrl = "{{env('SNAC_URL')}}";
        var restUrl = "{{env('SNAC_REST_URL')}}";
    </script>

    @if (env('SNAC_INTERFACE_VERSION') == "development")
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-development-version">
    @elseif (env('SNAC_INTERFACE_VERSION') == "demo")
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-demo-version">
    @else
    <nav class="navbar navbar-inverse navbar-fixed-top">
    @endif
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand active" href="{{env('SNAC_URL')}}"><span class="snac-name-header">snac</span></a><!--<span class="snac-fullname-header"> | social networks and archival context</span>-->
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{env('SNAC_URL')}}/search"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
                <!-- {% if user.userName %} -->
                <li><a href="{{env('SNAC_URL')}}/browse"><i class="fa fa-book" aria-hidden="true"></i> Browse</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboards <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">CPF Dashboards</li>
                        <li><a href="{{env('SNAC_URL')}}/dashboard/explore"><i class="fa fa-fw fa-globe" aria-hidden="true"></i> Explore</a></li>
                        <li><a href="{{env('SNAC_URL')}}/dashboard/editor"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i> Editor</a></li>
                        @if (false) #(permissions.ChangeLocks)
                        <li><a href="{{env('SNAC_URL')}}/dashboard/reviewer"><i class="fa fa-fw fa-check-circle" aria-hidden="true"></i> Reviewer</a></li>
                        @endif
                        @if (false)#(permissions.EditResources or permissions.ViewVocabDashboard)
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">non-CPF Dashboards</li>
                        <li><a href="{{env('SNAC_URL')}}/vocab_administrator"><i class="fa fa-fw fa-link" aria-hidden="true"></i> Other Entities</a></li>
                        @endif
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">System Dashboards</li>
                        <li><a href="{{env('SNAC_URL')}}/reports/dashboard"><i class="fa fa-fw fa-pie-chart" aria-hidden="true"></i> Reporting</a></li>
                        @if (false) #(permissions.ViewAdminDashboard)
                        <li><a href="{{env('SNAC_URL')}}/administrator"><i class="fa fa-fw fa-cog" aria-hidden="true"></i> Administrator</a></li>
                        @endif
                    </ul>
                </li>
                <li class="navbar-hideable"><a href="{{env('SNAC_URL')}}/messages"><i class="fa fa-comments-o" aria-hidden="true"></i> Messages
                        @if (false) #(user.unreadMessageCount > 0)
                            <span class='badge'>{{ user.unreadMessageCount }}</span>
                        @endif
                    </a></li>
                <!-- {% endif %} -->
            </ul>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="https://portal.snaccooperative.org/about"><i class="fa fa-info-circle" aria-hidden="true"></i> About</a></li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-question-circle"></i> Help <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{env('SNAC_URL')}}/api_help"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Rest API Commands</a></li>
                    <!-- {% if user.userName %} -->
                        <li><a href="{{env('SNAC_URL')}}/api_test"><i class="fa fa-fw fa-terminal" aria-hidden="true"></i> Rest API Test Area</a></li>
                        <li><a href="{{env('SNAC_URL')}}/stats"><i class="fa fa-fw fa-bar-chart" aria-hidden="true"></i> SNAC Statistics</a></li>
                    <!-- {% endif %} -->
                        <li role="separator" class="divider"></li>
                        <li><a href="{{env('SNAC_URL')}}/contact"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> Contact Us</a></li>
                    </ul>
                    </li>

            <!-- {% if user.userName %} -->
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{\{ user.avatar }}" style="width:20px; height:20px; margin-right: 10px;"> {\{ "" #user.fullName }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{env('SNAC_URL')}}/profile"><i class="fa fa-fw fa-id-card-o" aria-hidden="true"></i> User Profile</a></li>
                        <li><a href="{{env('SNAC_URL')}}/messages"><i class="fa fa-fw fa-comments-o" aria-hidden="true"></i> Messaging Center</a></li>
                        <li><a href="{{env('SNAC_URL')}}/api_key"><i class="fa fa-fw fa-key" aria-hidden="true"></i> Rest API Key</a></li>
                        <li><a href="{{env('SNAC_URL')}}/logout"><i class="fa fa-fw fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                    </li>
            <!-- {% else %} -->
                <li><a href="{{env('SNAC_URL')}}/login?r={\{control.currentURL | url_encode}}"><i class="fa fa-sign-in"></i> Login</a></li>
            <!-- {% endif %}  -->
                </ul>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>
    @if (env('SNAC_INTERFACE_VERSION') == "development")
    <p class="snac-system-notice">This is the <b>development version</b>.  Edits made to these Constellations will not be permanent.</p>
    @elseif (env('SNAC_INTERFACE_VERSION') == "demo")
    <p class="snac-system-notice">This is the <b>demo version</b>.  Edits made to these Constellations will not be permanent.</p>
    @endif