<div class="footer">
    <a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up fa-2x" aria-hidden="true"></i></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <h3>© KarloServices 2017 <small>Website 1.0.0</small></h3>

                <ul>
                    <li><a href="{{route('about')}}"><i class="fa fa-users" aria-hidden="true"></i></i> Nosotros</a></li>
                    <li><a href="/location"><i class="fa fa-map-marker" aria-hidden="true"></i> Ubicación</a></li>
                    <li><a href="/terms"><i class="fa fa-book" aria-hidden="true"></i> T&eacute;rminos y condiciones</a></li>
                    <li><a href="/privacy"><i class="fa fa-user-secret" aria-hidden="true"></i> Avisos de privacidad</a></li>
                    <li><a href="/guarantee"><i class="fa fa-certificate" aria-hidden="true"></i> Politicas de Garant&iacute;a</a></li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    })
});
</script>