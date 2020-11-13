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
    <nav class="navbar bg-info navbar-expand-lg navbar-dark fixed-top navbar-development-version">
    @elseif (env('SNAC_INTERFACE_VERSION') == "demo")
    <nav class="navbar navbar-toggleable-sm navbar-dark fixed-top navbar-demo-version">
    @else
    <nav class="navbar navbar-toggleable-sm navbar-dark fixed-top">
    @endif
    <div class="container">
        <div >
            <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="navbar-toggler-icon"></span>
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand active" href="{{env('SNAC_URL')}}"><span class="snac-name-header">snac</span></a><!--<span class="snac-fullname-header"> | social networks and archival context</span>-->
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="{{env('SNAC_URL')}}/search"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
            @auth
                <li class="nav-item"><a class="nav-link" href="{{env('SNAC_URL')}}/browse"><i class="fa fa-book" aria-hidden="true"></i> Browse</a></li>
                <li class="dropdown nav-item">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboards <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">CPF Dashboards</li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/dashboard/explore"><i class="fa fa-fw fa-globe" aria-hidden="true"></i> Explore</a></li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/dashboard/editor"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i> Editor</a></li>
                        @if (false) #(permissions.ChangeLocks)
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/dashboard/reviewer"><i class="fa fa-fw fa-check-circle" aria-hidden="true"></i> Reviewer</a></li>
                        @endif
                        @if (false)#(permissions.EditResources or permissions.ViewVocabDashboard)
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">non-CPF Dashboards</li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/vocab_administrator"><i class="fa fa-fw fa-link" aria-hidden="true"></i> Other Entities</a></li>
                        @endif
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">System Dashboards</li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/reports/dashboard"><i class="fa fa-fw fa-pie-chart" aria-hidden="true"></i> Reporting</a></li>
                        @if (false) #(permissions.ViewAdminDashboard)
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/administrator"><i class="fa fa-fw fa-cog" aria-hidden="true"></i> Administrator</a></li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item navbar-hideable"><a class="nav-link" href="{{env('SNAC_URL')}}/messages"><i class="fa fa-comments-o" aria-hidden="true"></i> Messages
                        @if (false) #(user.unreadMessageCount > 0)
                            <span class='badge'>{{ user.unreadMessageCount }}</span>
                        @endif
                    </a></li>
                <!-- {% endif %} -->
                @endauth
            </ul>
            <div class="navbar-nav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a  class="nav-link" href="https://portal.snaccooperative.org/about"><i class="fa fa-info-circle" aria-hidden="true"></i> About</a></li>
                    <li class="nav-item dropdown">
                    <a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-question-circle"></i> Help <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/api_help"><i class="fa fa-fw fa-list" aria-hidden="true"></i> Rest API Commands</a></li>
                    @auth
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/api_test"><i class="fa fa-fw fa-terminal" aria-hidden="true"></i> Rest API Test Area</a></li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/stats"><i class="fa fa-fw fa-bar-chart" aria-hidden="true"></i> SNAC Statistics</a></li>
                    @endauth
                        <li role="separator" class="divider"></li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/contact"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> Contact Us</a></li>
                    </ul>
                    </li>
            @auth
                    <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ "#user.avatar" }}" style="width:20px; height:20px; margin-right: 10px;"> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/profile"><i class="fa fa-fw fa-id-card-o" aria-hidden="true"></i> User Profile</a></li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/messages"><i class="fa fa-fw fa-comments-o" aria-hidden="true"></i> Messaging Center</a></li>
                        <li><a class="dropdown-item" href="{{env('SNAC_URL')}}/api_key"><i class="fa fa-fw fa-key" aria-hidden="true"></i> Rest API Key</a></li>
                        <li>
                            <a class="dropdown-item" href="/logout/all"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-sign-out" aria-hidden="true"></i> Logout
                            </a>
                            <form id="logout-form" action="/logout/all" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    </li>
                @else
                <li class="nav-item"><a class="nav-link" href="/login/google"><i class="fa fa-sign-in"></i> Login</a></li>
                @endauth
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
