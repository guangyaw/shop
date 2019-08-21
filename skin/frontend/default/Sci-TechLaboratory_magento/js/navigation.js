function navigationmenu() {
( function() {
if (document.getElementById( 'navigationmenu' ) != null)
{
var button = document.getElementById( 'navigationmenu' ).getElementsByTagName( 'h3' )[0],
menuitems   = document.getElementById( 'navigationmenu' ).getElementsByTagName( 'ul' )[0];
if ( undefined === button )
return false;
if ( undefined === menuitems || ! menuitems.childNodes.length ) {
button.style.display = 'none';
return false;
}
button.onclick = function(e) {
var items = document.getElementById( 'navigationmenu' ).getElementsByTagName( 'ul' )[0];
if ( -1 != this.className.indexOf( 'toggled-on' ) ) {
this.className = this.className.replace( ' toggled-on', '' );
items.className = items.className.replace( ' toggled-on', '' );
} else {
this.className += ' toggled-on';
items.className += ' toggled-on';
}
e.stopPropagation();
};
if (window.getComputedStyle)
{
var x = window.getComputedStyle(button, null).getPropertyValue('display');
}
else if (button.currentStyle)
{
var x = button.currentStyle['display'];
}
if (x == 'none')
{
var menu = document.getElementsByClassName('ttr_menu_items');
for (var j=0; j < menu.length; j++)
{
var liChild = menu[j].getElementsByTagName('li');
for(var k=0; k < liChild.length; k++)
{
var childNode = jQuery(liChild[k]).find('ul');
if (childNode.length > 0)
{
liChild[k].onclick = function(e)
{
if (window.getComputedStyle)
{
var z = window.getComputedStyle(menu[0], null).getPropertyValue('z-index');
}
else if (menu[0].currentStyle)
{
var z = menu[0].currentStyle['zIndex'];
}
if (z == 500)
{
if ( -1 == this.className.indexOf( ' toggled-on' ) )
{
var toggleClass = jQuery(this.parentNode).find('.toggled-on');
for(var i=0; i<toggleClass.length; i++)
{
toggleClass[i].className = toggleClass[i].className.replace( ' toggled-on', '' );
}
}
if ( -1 != this.className.indexOf( ' toggled-on' ) )
{
var cssClass = document.getElementsByClassName('toggled-on');
for(var i=0; i<cssClass.length; i++)
{
cssClass[i].className = cssClass[i].className.replace( ' toggled-on', '' );
}
}
else
{
this.className += ' toggled-on';
jQuery(this).parent.className += ' toggled-on';
e.preventDefault();
}
}
e.stopPropagation();
}
}
}
}
jQuery(document).click(function(e)
{
var cssClass = document.getElementsByClassName('toggled-on');
for(var i=0; i<cssClass.length; i++)
{
cssClass[i].className = cssClass[i].className.replace( ' toggled-on', '' );
}
});
}
}
} )();
}
jQuery(document).ready(function(){
navigationmenu();
});
