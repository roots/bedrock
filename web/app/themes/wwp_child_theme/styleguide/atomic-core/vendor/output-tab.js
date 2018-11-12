var $comp = $('.component');

$comp.wrapInner( '<div class="source"></div>');


$('.markup-display').append( '<div class="atoms-code-example"><pre><code class="dest language-markup"></code></pre></div>' );

var ls = $('.compWrap');
ls.each(function() {

    var source =	$(this).find('.source').html().replace(/<!--(.*?)-->/g, '').trim();



    var dest = 		$(this).find('.atomic-editor-output')

    dest.text(source);




});