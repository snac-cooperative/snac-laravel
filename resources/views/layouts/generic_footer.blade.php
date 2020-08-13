    @if (env('SNAC_INTERFACE_VERSION') == "development")
    <div class="footer footer-development-version">
    @elseif (env('SNAC_INTERFACE_VERSION') == "demo")
    <div class="footer footer-demo-version">
    @else
    <div class="footer footer-inverse">
    @endif
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-content">
                    <p class="text-center">
                        <img src="{{env('SNAC_URL')}}/images/paper_dolls_art2.png"/><br/>
                    </p>
                    <h4 class="text-center">Social Networks and Archival Context</h4>
                    <p class="text-center" style="margin-top: 5px;">
                        <a href="https://twitter.com/snaccooperative" title="Visit us on Twitter">
                            <i class="fa fa-2x fa-twitter-square" style="vertical-align: middle" aria-hidden="true"></i></a>
                        <a href="{{env('SNAC_URL')}}/contact" title="Contact us"><span class="fa-stack fa-sm">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-envelope fa-stack-1x" style="color: #000"></i>
                            </span></a>
                        <a href="https://portal.snaccooperative.org/terms_and_privacy" title="Terms and Information"><span class="fa-stack fa-sm">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-life-ring fa-stack-1x" style="color: #000"></i>
                            </span></a>
                    </p>
                </div>
                <div class="col-md-4 footer-content">
                    <p style="font-size: medium; margin-top: 30px;">SNAC is a discovery service for persons, families, and organizations found within archival collections at cultural heritage institutions.</p>
                </div>
                <div class="col-md-4 footer-content">
                    <div class="row">
                        <h4 class="">Sponsors</h4>
                        <p>
                            <a href="https://www.mellon.org" target="_blank">The Andrew W. Mellon Foundation</a><br>
                            <a href="https://www.imls.gov" target="_blank">Institute of Museum and Library Services</a><br>
                            <a href="https://www.neh.gov" target="_blank">National Endowment for the Humanities</a>
                        </p>
                        <h4 class="">Hosts</h4>
                        <p>
                            <a href="https://library.virginia.edu" target="_blank">University of Virginia Library</a><br>
                            <a href="https://www.archives.gov" target="_blank">National Archives and Records Administration</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if (false && env('APP_DEBUG'))
{{ print ("debug")}}
@endif

@include ('layouts.accept_cookies')
