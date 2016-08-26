var $comp = $('.component');

$comp.wrapInner( '<div class="source"></div>');

//$('#home').wrap( "<div class='atoms-group'></div>" );

$('.markup-display').append( '<div class="atoms-code-example"><pre><code class="dest language-markup"></code></pre></div>' );
	
var ls = $('.compWrap');
ls.each(function() {
	
var source =	$(this).find('.source').html();
var dest = 		$(this).find('.dest')

dest.text(source);

});	

$(document).ready(function () {
    $('.dest').each(function () {
        // Get the text to be copied to the clipboard
        var text = $(this).text().replace(/<!--(.*?)-->/g, '');
        var text = text.trim();
        // Create the copy button
        var $copyBtn = $('<div class="copyBtn"><a class="icon-file icon-white">Copy</a></div>')
            .attr('data-clipboard-text', text) // set the text to be copied
            .insertBefore(this); // insert copy button before <pre>
        new ZeroClipboard($copyBtn);
    });
    
    
    $('.language-css').each(function () {
        // Get the text to be copied to the clipboard
        var text = $(this).text().replace(/\/\*(.*?)\*\//g, '');
        var text = text.trim();
        // Create the copy button
        var $copyBtn = $('<div class="copyBtn"><a class="icon-file icon-white">Copy</a></div>')
            .attr('data-clipboard-text', text) // set the text to be copied
            .insertBefore(this); // insert copy button before <pre>
        new ZeroClipboard($copyBtn);
    });

});