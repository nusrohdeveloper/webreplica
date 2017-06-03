<script type="text/javascript">
$(function(){
    var $page = document.location.href.match(/[^\/]+$/)[0];
    if ($page.indexOf('?') > 0){
      $page = $page.substring(0, $page.indexOf('?'));
    }
    $('li.nav-item a').each(function(){
        var $href = $(this).attr('href');
        if ( ($href == $page) || ($href == '') ) {
            $(this).parent().addClass(' start active open');
            $(this).add( "<span class = 'selected'></span>" ).appendTo(this);
            var parentLi = $(this).closest('ul.sub-menu').parent();
            parentLi.addClass(' start active open');
            parentLi.children('a').add( "<span class = 'selected'></span>" );
            // $(this).closest('ul.sub-menu').parent().children('a').add( "<span class = 'selected'></span>" );
        } else {
        }
    });

});
</script>
